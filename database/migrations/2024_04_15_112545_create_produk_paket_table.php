<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukPaketTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk_paket', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_id');
            $table->foreignId('produk_satuan_id');
            $table->bigInteger('qty_satuan');
            $table->timestamps();

            $table->foreign('paket_id')->references('id')
                ->on('paket')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('produk_satuan_id')->references('id')
                ->on('produk_satuan')
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
        Schema::dropIfExists('produk_paket');
    }
}
