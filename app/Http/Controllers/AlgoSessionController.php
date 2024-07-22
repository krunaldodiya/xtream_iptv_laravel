<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlgoSessionTokenRequest;
use App\Models\AlgoSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AlgoSessionController extends Controller
{
    public function algo_session_overview(Request $request)
    {
        $algo_session = AlgoSession::query()
            ->with(['user', 'project.broker', 'project.data_broker', 'project.github_repository.github_account'])
            ->where(['id' => $request->route('algo_session_id')])
            ->first();

        return inertia('AlgoSessions/Overview', [
            'algo_session' => $algo_session,
        ]);
    }

    public function algo_session_orders(Request $request)
    {
        $algo_session = AlgoSession::query()
            ->with(['user', 'project.broker', 'project.data_broker', 'project.github_repository.github_account'])
            ->where(['id' => $request->route('algo_session_id')])
            ->first();

        return inertia('AlgoSessions/Overview', [
            'algo_session' => $algo_session,
        ]);
    }

    public function algo_session_positions(Request $request)
    {
        $algo_session = AlgoSession::query()
            ->with(['user', 'project.broker', 'project.data_broker', 'project.github_repository.github_account'])
            ->where(['id' => $request->route('algo_session_id')])
            ->first();

        return inertia('AlgoSessions/Overview', [
            'algo_session' => $algo_session,
        ]);
    }

    public function regenerate_secret(Request $request)
    {
        $algo_session = AlgoSession::find($request->route('algo_session_id'));

        $algo_session->secret = Str::random(32);

        $algo_session->save();

        return redirect()->back();
    }

    public function get_info(AlgoSessionTokenRequest $request)
    {
        $algo_session = AlgoSession::query()
            ->with(['user', 'project.broker', 'project.data_broker', 'project.github_repository.github_account'])
            ->where(['key' => $request->algo_session_key, 'secret' => $request->algo_session_secret])
            ->first();

        if (!$algo_session) {
            return response()->json(["error" => "Invalid Algo Session.", "status" => 404], 404);
        }

        if ($algo_session->user->user_plan->is_expired()) {
            return response()->json(["error" => "Plan Expired.", "status" => 401], 401);
        }

        if ($algo_session->project->status == "Inactive") {
            return response()->json(["error" => "Project Inactive.", "status" => 401], 401);
        }

        if ($algo_session->mode == "Live" && !$algo_session->user->user_plan->plan->can_live_trade) {
            return response()->json(["error" => "Not allowed to trade Live.", "status" => 401], 401);
        }

        return response()->json([
            'algo_session' => $algo_session,
            'token' => $algo_session->user->createToken("token")->plainTextToken,
        ]);
    }
}
