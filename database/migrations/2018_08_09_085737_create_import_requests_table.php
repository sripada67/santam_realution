
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fileType');
            $table->string('sequence_number');
            $table->string('fileName');
            $table->string('response_file')->nullable();
            $table->integer('total_records'); 
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
        Schema::dropIfExists('import_requests');
    }
}
