<?php

namespace App\Http\Controllers;

use App\Models\GithubAccount;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GithubAccountController extends Controller
{
    public function get_access_token(Request $request)
    {
        $github_account = GithubAccount::query()
            ->where([
                'user_id' => auth()->id(),
                'id' => $request->route('github_account_id')
            ])
            ->first();

        if (!$github_account) {
            return response()->json(["error" => "Invalid Github Account.", "status" => 404], 404);
        }

        return ['access_token' => $github_account->access_token];
    }

    public function list(Request $request)
    {
        $github_accounts = GithubAccount::query()
            ->where('user_id', auth()->id())
            ->get();

        return inertia('Github/Accounts/List', [
            'github_accounts' => $github_accounts,
        ]);
    }

    public function delete(Request $request)
    {
        $github_account_id = $request->route('github_account_id');

        GithubAccount::whereId($github_account_id)->delete();

        return redirect()->route('github-accounts.list');
    }

    public function code(Request $request)
    {
        $url = Socialite::driver('github')
            ->scopes(['user', 'repo', 'delete_repo'])
            ->redirect()
            ->getTargetUrl();

        return inertia()->location($url);
    }

    public function callback(Request $request)
    {
        $user = Socialite::driver('github')->user();

        GithubAccount::updateOrCreate([
            'user_id' => auth()->id(),
            'account_id' => $user->id,
        ], [
            'account_id' => $user->id,
            'type' => $user->user['type'],
            'name' => $user->name,
            'email' => $user->email,
            'username' => $user->user['login'],
            'access_token' => $user->token,
        ]);

        return redirect()->route('github-accounts.list');
    }
}
