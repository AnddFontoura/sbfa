<?php

namespace App\Console\Commands;

use App\City;
use App\Team;
use App\User;
use Illuminate\Console\Command;

class FakeTeamsForTestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:make-fake-team-for-test {amount}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make fake teams to test application';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (env('APP_ENV') != 'dev') {
            $this->info('Apenas rode esse comando em ambiente de desenvolvimento, em banco de desenvolvimento');
            die();
        }

        $amount = $this->argument('amount');
        $progressBar = $this->output->createProgressBar($amount);
        $progressBar->start();

        for($i = 0; $i < $amount; $i++) {
            $progressBar->advance();
            $userId = User::all()->random(5)->first();
            $city = City::all()->random(5)->first();

            Factory(Team::class)->create([
                'owner_id' => $userId->id,
                'city_id' => $city->id,
            ]);
        }

        $progressBar->finish();
    }
}
