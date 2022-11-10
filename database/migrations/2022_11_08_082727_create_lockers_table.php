<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLockersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('lockers', function (Blueprint $table) {
            $table->id();
            $table->string('level');
            $table->string('location');
            $table->string('locker_number');
            $table->enum('status', ["pending","accepted","rejected",'renewed','available']);
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
        // enable permission for constrained links between entities
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lockers');
    }
}
