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
            $table->string('sku')->nullable();
            $table->string('nama');
            $table->string('no_bpom')->nullable();
            $table->bigInteger('qty_produk_satuan_di_paket')->nullable();
            $table->foreignId('produk_satuan_id');
            $table->softDeletes();
            $table->timestamps();

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
