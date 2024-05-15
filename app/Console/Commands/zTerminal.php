<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;

class zTerminal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:terminal {module} {action?} {file_name?} ';
    public $host_url, $ftp_host, $ftp_user, $ftp_password, $ftp_port, $ftp_folder, $host;


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {


        echo "
            _______                  _             _ 
           |__   __|                (_)           | |
           ___| | ___ _ __ _ __ ___  _ _ __   __ _| |
          |_  / |/ _ \ '__| '_ ` _ \| | '_ \ / _` | |
           / /| |  __/ |  | | | | | | | | | | (_| | |
          /___|_|\___|_|  |_| |_| |_|_|_| |_|\__,_|_| v1
                                                     
                                                     
         ";

        echo "\n";
        echo "\n";

        switch ($this->argument('module')) {
            case 'deploy':
                 $action = $this->argument('action');
                \Artisan::call('deploy', ['action' => $action]);
                break;
            case 'rollback':
                $action = $this->argument('action');
                $file_name = $this->argument('file_name') ?? null;
                \Artisan::call('rollback', ['action' => $action, 'file_name' => $file_name]);
                break;
            case 'download':
                $action = $this->argument('action');
                $file_name = $this->argument('file_name') ?? null;
                \Artisan::call('download', ['action' => $action, 'file_name' => $file_name]);
                break;
            case 'htaccess':
                \Artisan::call('htaccess');
                break;
            case 'dependencies':
                $action = $this->argument('action');
                \Artisan::call('dependencies', ['action' => $action]);
                break;
            case 'symbolic':
                $action = $this->argument('action');
                \Artisan::call('symbolic', ['action' => $action]);
                break;
            case 'permission':
                $action = $this->argument('action');
                $file_name = $this->argument('file_name') ?? null;

                // Use correct Artisan::call format
                \Artisan::call('permission', [
                    'action' => $action,
                    'file_name' => $file_name,
                ]);
                break;
            case 'optimize':
                \Artisan::call('optimize');
                break;
            case 'formate':
                $action = $this->argument('action');
                \Artisan::call('formate', ['action' => $action]);
                break;
            case 'help':
                echo "\033[1mCommand Help:\033[0m\n";
                echo "\033[1;34m1. Deployer:\033[0m\n";
                echo "\033[1;36ma. Deploy Project Folders:\033[0m 'php artisan z:terminal deploy'\n\n";
                
                echo "\033[1;34m2. Rollback:\033[0m\n";
                echo "\033[1;36mb. Rollback Backup File List:\033[0m 'php artisan z:terminal rollback l'\n";
                echo "\033[1;36mc. Rollback Backup File:\033[0m 'php artisan z:terminal rollback r'\n\n";
               
                echo "\033[1;34m3. Dependencies:\033[0m\n";
                echo "\033[1;36ma. Composer Install:\033[0m 'php artisan z:terminal dependencies i'\n";
                echo "\033[1;36mb. Composer Update:\033[0m 'php artisan z:terminal dependencies u'\n\n";
                
                echo "\033[1;34m4. Htaccess:\033[0m\n";
                echo "\033[1;36ma. Htaccess Server File:\033[0m 'php artisan z:terminal htaccess'\n\n";
                
                echo "\033[1;34m5. Symbolic Link:\033[0m\n";
                echo "\033[1;36ma. Symbolic Local:\033[0m 'php artisan z:terminal symbolic l'\n\n";
                echo "\033[1;36ma. Symbolic Server:\033[0m 'php artisan z:terminal symbolic r'\n\n";
                
                echo "\033[1;34m6. Optimize Code:\033[0m\n";
                echo "\033[1;36ma. Optimize Server Code:\033[0m 'php artisan z:terminal optimize'\n\n";
                
                echo "\033[1;34m7. Permission:\033[0m\n";
                echo "\033[1;36ma. All Files & Directory:\033[0m 'php artisan z:terminal permission l'\n";
                echo "\033[1;36mb. Fix all Files and Directory Permissions:\033[0m 'php artisan z:terminal permission f'\n\n";


                echo "\033[1;34m8. Formater:\033[0m\n";
                echo "\033[1;36ma. Formate Files & Directory Code:\033[0m 'php artisan z:terminal formate php'\n\n";
                break;

            default:
                # code...
                break;
        }

        return Command::SUCCESS;
    }


    


   
}
