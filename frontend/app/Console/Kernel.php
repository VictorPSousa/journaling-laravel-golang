<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule){
        // $schedule->command('inspire')->hourly();
        // agendar verificação da validade do token (para um único usuário ao fazer login)
        // https://pt.stackoverflow.com/questions/249173/como-criar-um-cron-no-laravel
        // https://www.cloudways.com/blog/laravel-cron-job-scheduling/
        // https://laravel.io/forum/how-to-run-a-functioncontroller-every-minute-task-scheduling
        // https://stackoverflow.com/questions/42062633/laravel-cron-jobs-controller-function
        // https://laracasts.com/discuss/channels/general-discussion/run-a-method-of-controller-with-cron-and-scheduling-closures
        // https://vrsoftcoder.com/how-to-call-a-method-of-controller-with-cron-in-laravel/
        // https://laravel.com/docs/8.x/scheduling
        // $schedule->job(checa a validade do token JWT)->everyFiveMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(){
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
