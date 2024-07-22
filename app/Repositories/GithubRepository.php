<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;

class GithubRepository implements GithubRepositoryInterface
{
    private string $api_url;

    private string $template_repository;

    private $client;

    public function __construct()
    {
        $this->api_url = config("services.github.api_url");
        $this->template_repository = config("services.github.template_repository");
    }

    public function get_github_repository(
        string $github_account_access_token,
        string $github_account_username,
        string $github_repository_name
    ) {
        $get_repository_url = "repos/{$github_account_username}/{$github_repository_name}";

        $this->client = Http::withToken($github_account_access_token)->baseUrl($this->api_url);

        $response = $this->client->get($get_repository_url);

        $status = $response->status();

        $data = $response->json();

        if ($status === 404) {
            return null;
        } else {
            return ['status' => $status, 'data' => $data];
        }
    }

    public function create_github_repository(
        string $github_account_access_token,
        string $github_repository_name
    ) {
        $create_repository_url = "repos/{$this->template_repository}/generate";

        $this->client = Http::withToken($github_account_access_token)->baseUrl($this->api_url);

        $payload = ["name" => $github_repository_name, "private" => true];

        $response = $this->client->post($create_repository_url, $payload);

        $status = $response->status();

        $data = $response->json();

        if ($response->status() === 201) {
            return ['status' => $status, 'data' => $data];
        } else {
            return ['status' => $status, 'errors' => $data["errors"]];
        }
    }

    public function get_or_create_github_repository(
        string $github_account_access_token,
        string $github_account_username,
        string $github_repository_name
    ) {
        $exists = $this->get_github_repository(
            $github_account_access_token,
            $github_account_username,
            $github_repository_name,
        );

        if ($exists) {
            return $exists;
        } else {
            return $this->create_github_repository(
                $github_account_access_token,
                $github_repository_name,
            );
        }
    }
}
