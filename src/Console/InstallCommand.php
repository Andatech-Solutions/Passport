<?php

namespace Andatech\Passport\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passport:install
                            {--database= : Specify the database name for which you are trying to install}
                            {--connection= : Specify the connection name to connect with your database}
                            {--force : Overwrite keys if they already exist}
                            {--name= : The name of the client}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run the commands necessary to prepare Passport for use';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('passport:keys', [ '--force' => $this->option('force') ]);

        $this->call('passport:client', [
            '--personal'   => true,
            '--database'   => $this->option('database'),
            '--connection' => $this->option('connection'),
            '--name'       => $this->option('name') ?: null,
        ]);

        $this->call('passport:client', [
            '--password'   => true,
            '--database'   => $this->option('database'),
            '--connection' => $this->option('connection'),
            '--name'       => $this->option('name') ?: null,
        ]);
    }
}
