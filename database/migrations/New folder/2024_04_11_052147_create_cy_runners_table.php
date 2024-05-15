<?php
/**
 * Class CyRunnersTable
 *
 * @category ZStarter
 *
 * @ref zCURD
 * @author  Defenzelite <hq@defenzelite.com>
 * @license https://www.defenzelite.com Defenzelite Private Limited
 * @version <zStarter: 1.1.0>
 * @link    https://www.defenzelite.com
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCyRunnersTable extends Migration
{ 
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cy_runners', function (Blueprint $table) {
            $table->id();                  
            $table->bigInteger('user_id')->comment('');                             
            $table->bigInteger('project_id')->comment('');                             
            $table->integer('sequence')->comment('');                             
            $table->longText('code')->comment('');                            
            $table->enum('status',["Draft","Active","Discard"])->comment('"Draft","Active","Discard"') ;                    
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
        Schema::dropIfExists('cy_runners');
    }
}
