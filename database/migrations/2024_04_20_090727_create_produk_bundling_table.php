<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdukBundlingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk_bundling', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bundling_id');
            $table->foreignId('produk_satuan_id');
            $table->string('jenis');
            $table->string('qty_satuan');
            $table->timestamps();

            $table->foreign('bundling_id')
                ->references('id')
                ->on('bundling')
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
        Schema::dropIfExists('produk_bundling');
    }
}
