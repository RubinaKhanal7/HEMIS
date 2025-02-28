<?php




use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;




class CreateMembershipheadTable extends Migration
{
    public function up()
    {
        Schema::create('membershiphead', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }




    public function down()
    {
        Schema::dropIfExists('membershiphead');
    }
}