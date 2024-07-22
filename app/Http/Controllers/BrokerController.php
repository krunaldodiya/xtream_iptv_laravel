<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddBrokerRequest;
use App\Models\AvailableBroker;
use App\Models\Broker;
use Illuminate\Http\Request;

class BrokerController extends Controller
{
    public function list(Request $request)
    {
        $available_brokers = AvailableBroker::all();

        $brokers = Broker::query()
            ->with('available_broker')
            ->where('user_id', auth()->id())
            ->get();

        return inertia('Brokers/List', [
            'available_brokers' => $available_brokers,
            'brokers' => $brokers,
        ]);
    }

    public function configure(Request $request)
    {
        $available_broker = AvailableBroker::find($request->route('broker_id'));

        $configurable_broker = config("brokers.{$available_broker->title}");

        return inertia($configurable_broker, [
            'available_broker' => $available_broker,
        ]);
    }

    public function store(AddBrokerRequest $request)
    {
        $available_broker = AvailableBroker::find($request->route('broker_id'));

        $app_url = config('app.url');

        Broker::updateOrCreate([
            'user_id' => auth()->id(),
            'available_broker_id' => $available_broker->id,
        ], [
            'broker_uid' => $request->uid,
            'broker_title' => $available_broker->title,
            'broker_name' => $available_broker->name,
            'broker_config' => [
                ...$request->all(),
                "redirect_url" => "{$app_url}/brokers/{$available_broker->title}/callback",
            ],
        ]);

        return redirect()->route('brokers.list');
    }

    public function delete(Request $request)
    {
        Broker::whereId($request->route("broker_id"))->delete();

        return redirect()->route('brokers.list');
    }
}
