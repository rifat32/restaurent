<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurents', function (Blueprint $table) {
            $table->id();
            $table->string("Name");
            $table->string("Address");
            $table->string("PostCode");
            $table->string("Logo");
            $table->unsignedBigInteger("OwnerID");
            $table->string("Key_ID");
            $table->date("expiry_date");
            $table->integer("totalTables");
            $table->string("Status");
            $table->string("Layout");
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
        Schema::dropIfExists('restaurents');
    }
}
