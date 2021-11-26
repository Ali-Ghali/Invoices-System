<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_Invoice');//الاي دي تبع الفاتورة الاساسية 
            $table->string('invoice_number', 50);//رقم الفاتورة
            $table->foreign('id_Invoice')->references('id')->on('invoices')->onDelete('cascade');//ربط بين الاي دي تبع الفاتورة الاساسية مع الاي دي في جدول الفواتير وعند حذف فاتورة سيتم حذف كل تفاصيلها
            $table->string('product', 50);//المنتج
            $table->string('Section', 999);//القسم
            $table->string('Status', 50);//حالة الفاتورة مدفوعة او غير مدفوعة
            $table->integer('Value_Status');//مثلا قيمة مدفوعة 1 وقيمة غير مدفوعة 2 وذلك من اجل عملية الاستعلام
            $table->date('Payment_Date')->nullable();//تاريخ الدفع
            $table->text('note')->nullable();//الملاحظات
            $table->string('user',300);//لمعرفة اسم الشخص الذي قام بالعملية
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
        Schema::dropIfExists('invoices_details');
    }
}
