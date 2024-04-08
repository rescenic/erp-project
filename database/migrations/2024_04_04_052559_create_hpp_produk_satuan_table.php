<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHppProdukSatuanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hpp_produk_satuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_satuan_id');
            $table->bigInteger('hpp');
            $table->string('status')->default('aktif');
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
        Schema::dropIfExists('hpp_produk_satuan');
    }
}
