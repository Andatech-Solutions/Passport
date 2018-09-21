<?php

namespace Andatech\Passport\Console;

use Illuminate\Console\Command;
use Andatech\Passport\ClientRepository;

class ClientCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passport:client
            {--database= : Specify the database name for which you are trying to install}
            {--connection= : Specify the connection name to connect with your database}
            {--personal : Create a personal access token client}
            {--password : Create a password grant client}
            {--name= : The name of the client}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a client for issuing access tokens';

    /**
     * Execute the console command.
     *
     * @param  \Andatech\Passport\ClientRepository $clients
     * @return void
     */
    public function handle(ClientRepository $clients)
    {
        $connection = $this->option('connection') ?: env('DB_CONNECTION');
        $clients->updateConnection($connection);

        if ($this->option('database')) {
            config()->set("database.connections.{$connection}.database", $this->option('database'));
        }

        if ($this->option('personal')) {
            return $this->createPersonalClient($clients);
        }

        if ($this->option('password')) {
            return $this->createPasswordClient($clients);
        }

        $this->createAuthCodeClient($clients);
    }

    /**
     * Create a new personal access client.
     *
     * @param  \Andatech\Passport\ClientRepository $clients
     * @return void
     */
    protected function createPersonalClient(ClientRepository $clients)
    {
        $name = $this->option('name') ?: $this->ask(
            'What should we name the personal access client?',
            config('app.name') . ' Personal Access Client'
        );

        $client = $clients->createPersonalAccessClient(
            null, $name, 'http://localhost'
        );

        $this->info('Personal access client created successfully.');
        $this->line('<comment>Client ID:</comment> ' . $client->id);
        $this->line('<comment>Client Secret:</comment> ' . $client->secret);
    }

    /**
     * Create a new password grant client.
     *
     * @param  \Andatech\Passport\ClientRepository $clients
     * @return void
     */
    protected function createPasswordClient(ClientRepository $clients)
    {
        $name = $this->option('name') ?: $this->ask(
            'What should we name the password grant client?',
            config('app.name') . ' Password Grant Client'
        );

        $client = $clients->createPasswordGrantClient(
            null, $name, 'http://localhost'
        );

        $this->info('Password grant client created successfully.');
        $this->line('<comment>Client ID:</comment> ' . $client->id);
        $this->line('<comment>Client Secret:</comment> ' . $client->secret);
    }

    /**
     * Create a authorization code client.
     *
     * @param  \Andatech\Passport\ClientRepository $clients
     * @return void
     */
    protected function createAuthCodeClient(ClientRepository $clients)
    {
        $userId = $this->ask(
            'Which user ID should the client be assigned to?'
        );

        $name = $this->option('name') ?: $this->ask(
            'What should we name the client?'
        );

        $redirect = $this->ask(
            'Where should we redirect the request after authorization?',
            url('/auth/callback')
        );

        $client = $clients->create(
            $userId, $name, $redirect
        );

        $this->info('New client created successfully.');
        $this->line('<comment>Client ID:</comment> ' . $client->id);
        $this->line('<comment>Client secret:</comment> ' . $client->secret);
    }
}