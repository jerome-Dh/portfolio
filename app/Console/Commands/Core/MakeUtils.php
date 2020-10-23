<?php

namespace App\Console\Commands\Core;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

/**
 * Class MakeModel
 *
 * @package App\Console\Commands\Core
 * @author Jerome Dh <jdieuhou@gmail.com>
 * @date 06/10/2020
 */
class MakeUtils extends Command
{
    /**
     * Trait des utilitaires
     *
     * Trait Helpers
     */
    use Helpers;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'core:utils
                            {--t|type=all : Generated all the utils}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generated the utils for all project such as config/custum';

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
     * @return int
     */
    public function handle()
    {
        $dirname = database_path('migrations');
        try {
            //Retrieve the argument value
            $type = $this->option('type');
            $reader = new Reader($dirname);

            if ($type == 'all') {
                // Comment
                $this->checkBeforeWrite(config_path('custum.php'), $this->getCustumConfigContent());
            }
            else
            {
                switch($type)
                {
                case 'config':
                    $this->checkBeforeWrite(config_path('custum.php'), $this->getCustumConfigContent());
                    break;

                default:
                    $this->info('Unknown option !');
                    break;
                }
            }

        } catch (\RuntimeException $e) {
            $this->error($e->getMessage());
        }

        return 0;
    }

    /**
     * Get content of custum config
     *
     * @return string
     */
    protected function getCustumConfigContent()
    {
        return '<?php


return [

    /**
     * The users roles
     */
    \'user_role\' => [
        \'visitor\' => 0,
        \'reader\' => 1,
        \'admin\' => 2,
    ],

];';
    }
}
