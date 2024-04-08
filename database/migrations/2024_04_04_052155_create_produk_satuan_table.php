<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukSatuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk_satuan', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('sku')->nullable();
            $table->string('nama');
            $table->foreignId('kategori_id');
            $table->string('no_bpom')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('kategori_id')->references('id')
            ->on('kategori')
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
        Schema::dropIfExists('produk_satuan');
    }
}
