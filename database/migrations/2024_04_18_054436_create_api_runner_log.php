<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_runner_log', function (Blueprint $table) {
            $table->id();                  
            $table->bigInteger('group_id')->comment('Group Id');                                
            $table->bigInteger('user_id')->comment('User Id');                                
            $table->bigInteger('api_runner_id')->comment('Api Runner Id');                                
            $table->json('payload')->comment('Payload');                                        
            $table->enum('status',["Running","Fail","Completed"])->default('Running')->comment('"Running","Fail","Completed"') ;                              
            $table->enum('result',["Pass","Fail"])->comment('"Pass","Fail"') ;            
            $table->timestamps();     
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_runner_log');
    }
};
