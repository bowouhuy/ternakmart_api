<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Transaksi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('id_ternak');
            $table->foreignId('id_user');
            $table->integer('ternak_harga');
            $table->integer('masa_perawatan');
            $table->integer('total_harga');
            $table->date('transaksi_tanggal');
            $table->string("transaksi_st");
            $table->text('transaksi_alamat');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
