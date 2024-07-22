<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddGithubRepositoryRequest;
use App\Models\GithubAccount;
use App\Models\GithubRepository;
use App\Repositories\GithubRepositoryInterface;
use Illuminate\Http\Request;

class GithubRepositoryController extends Controller
{
    public function __construct(public GithubRepositoryInterface $githubRepositoryInterface)
    {
        //
    }

    public function list(Request $request)
    {

        $github_accounts = GithubAccount::query()
            ->where('user_id', auth()->id())
            ->get();

        $github_repositories = GithubRepository::query()
            ->where('user_id', auth()->id())
            ->get();

        return inertia('Github/Repositories/List', [
            'github_accounts' => $github_accounts,
            'github_repositories' => $github_repositories,
        ]);
    }

    public function store(AddGithubRepositoryRequest $request)
    {
        $github_account = GithubAccount::query()
            ->where(['account_id' => $request->github_account_id])
            ->first();

        $response = $this->githubRepositoryInterface->get_or_create_github_repository(
            $github_account->access_token,
            $github_account->username,
            $request->repository_name,
        );

        if ($response['data']) {
            GithubRepository::updateOrCreate([
                'user_id' => auth()->id(),
                'github_account_id' => $github_account->id,
                'repository_name' => $request->repository_name
            ], [
                'repository_id' => $response['data']['id'],
                'repository_owner' => $response['data']['owner']['login'],
                'repository_full_name' => $response['data']['full_name'],
                'repository_ssh_url' => $response['data']['ssh_url'],
            ]);
        }

        return redirect()->route('github-repositories.list');
    }

    public function delete(Request $request)
    {
        $github_repository_id = $request->route('github_repository_id');

        GithubRepository::whereId($github_repository_id)->delete();

        return redirect()->route('github-repositories.list');
    }
}
