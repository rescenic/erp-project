<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHargaSuplierProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('harga_suplier_produk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('suplier_produk_satuan_id');
            $table->bigInteger('harga');
            $table->string('status')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('suplier_produk_satuan_id')
            ->references('id')
            ->on('suplier_produk_satuan')
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
        Schema::dropIfExists('harga_suplier_produk');
    }
}
