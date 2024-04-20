<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packaging', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_packaging_id');
            $table->string('kode');
            $table->string('nama');
            $table->softDeletes();
            $table->timestamps();


            $table->foreign('kategori_packaging_id')
                ->references('id')
                ->on('kategori_packaging')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('packaging');
    }
}
