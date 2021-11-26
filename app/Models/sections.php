<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sections extends Model
{
   // قمنا بجلب الحقول من قاعدة البيانات من جدول الأقسام
    protected $fillable = ['ection_name','description','created_by'];
    use HasFactory;
}
