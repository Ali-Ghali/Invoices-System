<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         //قمنا هنا باضافة حقول لجدول الأقسام 
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('ection_name',999);// اسم القسم
            $table->text('description')->nullable();// الوصف
            $table->string('created_by',999); //الشخص الذي قام بالعملية
            $table->timestamps();
        });
    }

    /**s
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sections');
    }
}
