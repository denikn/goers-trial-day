<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
			$table->enum('type', ['webinar', 'education', 'art', 'conference', 'workshop', 'golf', 'coffee', 'other']);
			$table->foreignId('organization_id')->constrained('organizations')->onUpdate('cascade')->onDelete('cascade');
			$table->string('name');
			$table->string('place');
			$table->string('location');
			$table->text('location_details')->nullable();
			$table->text('maps')->nullable();
			$table->text('description');
			$table->text('interests');
			$table->enum('group', ['online', 'events', 'places', 'tours']);
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
        Schema::dropIfExists('events');
    }
}
