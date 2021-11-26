<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
                //قمنا هنا باضافة حقول لجدول المنتجات 

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('Product_name', 999);//اسم المنتج
            $table->text('description')->nullable();//الوصف
            $table->unsignedBigInteger('section_id'); //لايقبل الساالب رقم القسم 
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade'); //يتم ربط رقم القسم مع الاي دي الموجود في جدول الاقسام وعند حذف قسم ما سيتم حذف كل المنتجات التابعة له
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
        Schema::dropIfExists('products');
    }
}
