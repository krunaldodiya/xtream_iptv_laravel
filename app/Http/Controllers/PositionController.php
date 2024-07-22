<?php

namespace App\Http\Controllers;

use App\Events\PositionUpdated;
use App\Http\Requests\EnterPositionRequest;
use App\Http\Requests\ExitPositionRequest;
use App\Models\AlgoSession;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function get_positions(Request $request)
    {
        $algo_session = AlgoSession::query()->where(['key' => $request->algo_session_key])->first();

        $positions = Position::query()
            ->with(['broker_symbol.base_symbol', 'risk_reward'])
            ->where('algo_session_id', $algo_session->id)
            ->where('user_id', $algo_session->user_id)
            ->where('created_at', '>=', now()->today())
            ->whereHas('broker_symbol', function($query) {
                return $query->where('expiry_date', '<=', now()->today());
            })
            ->get();

        return response()->json(['positions' => $positions], 200);
    }

    public function enter_position(EnterPositionRequest $request)
    {
        $data = $request->all();

        $position = $this->get_position($data['position_id'], $data['algo_session_id']);

        if (!$position) {
            $position = Position::create([...$data, 'user_id' => auth()->id()]);
        } else {
            $position->quantities = $data['quantities'];

            $position->exit_price = $data['exit_price'];

            $position->status = $data['status'];

            $position->save();

            $position->refresh();
        }

        $position->load(['broker_symbol.base_symbol', 'risk_reward']);

        PositionUpdated::broadcast($position);

        return response()->json(['position' => $position]);
    }

    public function exit_position(ExitPositionRequest $request)
    {
        $data = $request->all();

        $position = $this->get_position($data['position_id'], $data['algo_session_id']);

        $position->quantities = $data['quantities'];

        $position->exit_price = $data['exit_price'];

        $position->status = $data['status'];

        $position->save();

        $position->refresh();

        $position->load(['broker_symbol.base_symbol', 'risk_reward']);

        PositionUpdated::broadcast($position);

        return response()->json(['position' => $position]);
    }

    protected function get_position(string $position_id, int $algo_session_id)
    {
        return Position::query()
            ->where(['position_id' => $position_id, 'algo_session_id' => $algo_session_id])
            ->first();
    }
}
