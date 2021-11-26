<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('file_name', 999);//اسم الملف
            $table->string('invoice_number', 50);//رقم الفاتورة
            $table->string('Created_by', 999);//اسم الشخص
            $table->unsignedBigInteger('invoice_id')->nullable();//اي دي الفاتورة لايقبل قيم سالبة
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');//ربط اي دي الفاتورة مع الاي دي في جدول الفواتير
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_attachments');
    }
}
