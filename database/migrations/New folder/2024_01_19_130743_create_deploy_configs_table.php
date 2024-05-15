/**
 * Class DeployConfigsTable
 *
 * @category  zStarter
 *
 * @ref  zCURD
 * @author    Defenzelite <hq@defenzelite.com>
 * @license  https://www.defenzelite.com Defenzelite Private Limited
 * @version  <zStarter: 1.1.0>
 * @link        https://www.defenzelite.com
 */
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeployConfigsTable extends Migration
{ 
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('deploy_configs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('name');                       
            $table->bigInteger('project_register_id')->comment('project_register_id');                       
            $table->boolean('status')->default(0)->comment('status');   
            $table->longText('payload')->comment('payload');        
            $table->timestamps();
            $table->softDeletes();            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('deploy_configs');
    }
}
