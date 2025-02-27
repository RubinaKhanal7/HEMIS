<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('memberhead_id')->constrained('membershiphead'); 
            $table->string('fullname');
            $table->date('membershipdate');
            $table->string('membershipnumber')->unique();
            $table->string('mobile_number');
            $table->string('email');
            $table->string('province');
            $table->string('district');
            $table->string('locallevel');
            $table->string('ward');
            $table->string('tole');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('members');
    }
}