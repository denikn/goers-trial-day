<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFieldOnTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tickets', function (Blueprint $table) {
			$table->dropColumn('datetime');
			$table->text('event_session_ids')->after('name');
			$table->text('selling_period')->after('event_session_ids');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->text('datetime');
			$table->dropColumn('event_session_ids');
			$table->dropColumn('selling_period');
        });
    }
}
