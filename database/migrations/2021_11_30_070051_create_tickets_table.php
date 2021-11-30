<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
			$table->foreignId('event_id')->constrained('events')->onUpdate('cascade')->onDelete('cascade');
			$table->string('name');
			$table->text('datetime');
			$table->bigInteger('price');
			$table->integer('qty');
			$table->integer('max_per_person');
			$table->text('package_details');
			$table->string('group')->nullable();
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
        Schema::dropIfExists('tickets');
    }
}
