<?php

namespace App\Repositories;

interface GithubRepositoryInterface
{
    public function get_github_repository(
        string $github_account_access_token,
        string $github_account_username,
        string $github_repository_name,
    );

    public function create_github_repository(
        string $github_account_access_token,
        string $github_repository_name,
    );

    public function get_or_create_github_repository(
        string $github_account_access_token,
        string $github_account_username,
        string $github_repository_name,
    );
}
