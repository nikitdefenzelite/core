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
        Schema::create('user_configs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('deploy_config_id')->comment('deploy_config_id');                       
            $table->bigInteger('project_register_id')->comment('project_register_id');                       
            $table->boolean('status')->default(1)->comment('status');   
            $table->longText('payload')->comment('payload');   
            $table->bigInteger('hq_user_id');   
            $table->string('hq_user_name');   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_configs');
    }
};
