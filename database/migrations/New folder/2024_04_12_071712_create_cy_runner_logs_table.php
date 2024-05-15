<?php /** * Class CyRunnerLogsTable * * @category ZStarter * * @ref zCURD *
    @author  Defenzelite <hq@defenzelite.com>
 * @license https://www.defenzelite.com Defenzelite Private Limited
 * @version <zStarter: 1.1.0>
 * @link    https://www.defenzelite.com
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCyRunnerLogsTable extends Migration
{ 
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cy_runner_logs', function (Blueprint $table) {
            $table->id();                  
            $table->bigInteger('group_id')->comment('Group Id');                                
            $table->bigInteger('user_id')->comment('User Id');                                
            $table->json('payload')->comment('Payload');                                        
            $table->enum('status',["Running","Fail","Completed"])->default('Running')->comment('"Running","Fail","Completed"') ;                              
            $table->enum('result',["Pass","Fail"])->comment('"Pass","Fail"') ;            
    $table->timestamps();         $table->softDeletes();
    
    });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
    Schema::dropIfExists('cy_runner_logs');
    }
    }
