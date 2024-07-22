<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\EditProjectRequest;
use App\Models\AlgoSession;
use App\Models\Broker;
use App\Models\GithubRepository;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function list(Request $request)
    {
        $projects = Project::query()
            ->with(['owner', 'broker', 'data_broker', 'github_repository.github_account'])
            ->where('user_id', auth()->id())
            ->get();

        return inertia('Projects/List', [
            'projects' => $projects,
        ]);
    }

    public function create(Request $request)
    {
        $brokers = Broker::query()
            ->with('available_broker')
            ->where('user_id', auth()->id())
            ->get();

        $data_brokers = Broker::query()
            ->with('available_broker')
            ->where('user_id', auth()->id())
            ->whereHas('available_broker', function ($query) {
                return $query->where('support_data', true);
            })
            ->get();

        $github_repositories = GithubRepository::query()
            ->with('github_account')
            ->where('user_id', auth()->id())
            ->get();

        return inertia('Projects/Create', [
            'brokers' => $brokers,
            'data_brokers' => $data_brokers,
            'github_repositories' => $github_repositories,
        ]);
    }

    public function store(CreateProjectRequest $request)
    {
        if (auth()->user()->user_plan->is_expired()) {
            return redirect()->back()
                ->withErrors(['title' => "Your plan is expired."])
                ->withInput($request->all());
        }

        if (auth()->user()->projects->count() >= auth()->user()->user_plan->plan->maximum_projects) {
            return redirect()->back()
                ->withErrors(['title' => "Maximum projects limit reached."])
                ->withInput($request->all());
        }

        $project = Project::create([
            'user_id' => auth()->id(),
            'broker_id' => $request->broker_id,
            'data_broker_id' => $request->data_broker_id,
            'github_repository_id' => $request->github_repository_id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        collect(['Paper', 'Live'])->each(function ($mode) use ($project) {
            $algo_session = AlgoSession::create([
                'user_id' => auth()->id(),
                'project_id' => $project->id,
                'mode' => $mode,
                'key' => Str::random(8),
                'secret' => Str::random(32),
            ]);
        });

        return redirect()->route('projects.list');
    }

    public function edit(Request $request)
    {
        $project = Project::find($request->route('project_id'));

        $brokers = Broker::query()
            ->with('available_broker')
            ->where('user_id', auth()->id())
            ->get();

        $data_brokers = Broker::query()
            ->with('available_broker')
            ->where('user_id', auth()->id())
            ->whereHas('available_broker', function ($query) {
                return $query->where('support_data', true);
            })
            ->get();

        $github_repositories = GithubRepository::query()
            ->with('github_account')
            ->where('user_id', auth()->id())
            ->get();

        return inertia('Projects/Edit', [
            'project' => $project,
            'brokers' => $brokers,
            'data_brokers' => $data_brokers,
            'github_repositories' => $github_repositories,
        ]);
    }

    public function update(EditProjectRequest $request)
    {
        $project = Project::find($request->route("project_id"));

        $project->title = $request->title;

        $project->description = $request->description;

        $project->save();

        return redirect()->route('projects.detail', ['project_id' => $project->id]);
    }

    public function detail(Request $request)
    {
        $project = Project::query()
            ->with(['broker', 'data_broker', 'github_repository.github_account', 'algo_sessions'])
            ->where('id', $request->route('project_id'))
            ->first();

        return inertia('Projects/Detail', [
            'project' => $project,
        ]);
    }

    public function delete(Request $request)
    {
        $project = Project::find($request->route('project_id'));

        $project->delete();

        return redirect()->route('projects.list');
    }

    public function toggle_status(Request $request)
    {
        $project = Project::find($request->route('project_id'));

        if ($project->status == "Active") {
            $project->status = "Inactive";
        } else {
            $project->status = "Active";
        }

        $project->save();

        return redirect()->back();
    }
}
