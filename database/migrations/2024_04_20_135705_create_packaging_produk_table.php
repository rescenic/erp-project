<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagingProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packaging_produk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('packaging_id');
            $table->foreignId('produk_satuan_id');
            $table->timestamps();

            $table->foreign('packaging_id')
                ->references('id')
                ->on('packaging')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('produk_satuan_id')
                ->references('id')
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
        Schema::dropIfExists('packaging_produk');
    }
}
