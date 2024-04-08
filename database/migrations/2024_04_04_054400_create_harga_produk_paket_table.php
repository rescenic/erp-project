<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHargaProdukPaketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('harga_produk_paket', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_paket_id');
            $table->bigInteger('harga');
            $table->string('status')->default('aktif');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('produk_paket_id')->references('id')
            ->on('produk_paket')
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
        Schema::dropIfExists('harga_produk_paket');
    }
}
