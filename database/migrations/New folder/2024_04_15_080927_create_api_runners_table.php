<?php /** * Class ApiRunnersTable * * @category ZStarter * * @ref zCURD *
    @author  Defenzelite <hq@defenzelite.com>
 * @license https://www.defenzelite.com Defenzelite Private Limited
 * @version <zStarter: 1.1.0>
 * @link    https://www.defenzelite.com
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiRunnersTable extends Migration
{ 
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_runners', function (Blueprint $table) {
            $table->id();                  
            $table->string('title')->comment('');                                
            $table->bigInteger('group')->comment('');                                
            $table->longText('code')->comment('');                                
            $table->enum('status',["Draft","Active","Discard"])->comment('"Draft","Active","Discard"')->nullable();              
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
    Schema::dropIfExists('api_runners');
    }
    }
