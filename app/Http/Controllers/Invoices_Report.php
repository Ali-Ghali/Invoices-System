<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\invoices;

class Invoices_Report extends Controller
{
    public function index(){

        return view('reports.invoices_report');
           
       }
   
       public function Search_invoices(Request $request){
   
       $rdio = $request->rdio;
   
   
    // في حالة البحث بنوع الفاتورة
       
       if ($rdio == 1) {
          //عند اختيار الكل بدون وضع تواريخ سيجلب لنا جميع الفواتير ويعرضها بالجدول وكلمة تايب مأخوذة من النيم تبع السيليكت
        if($request->type == 'الكل'  && $request->start_at =='' && $request->end_at ==''){
            $invoices = invoices::select('*')->get();
            $type = $request->type;
            return view('reports.invoices_report',compact('type'))->withDetails($invoices);
       
        }
        //يمكننا هنا عند اختيار الكل يمكننا البحث ايضا بالتواريخ 
        if($request->type == 'الكل'){ 
            
            $start_at = date($request->start_at);
            $end_at = date($request->end_at);
            $type = $request->type;
            $invoices = invoices::whereBetween('invoice_Date',[$start_at,$end_at])->get();
          
            return view('reports.invoices_report',compact('type','start_at','end_at'))->withDetails($invoices);
        }
    // في حالة عدم تحديد تاريخ
    //هنا يمكننا الاختيار البحث حسب حالة الفاتورة
           if($request->type && $request->start_at =='' && $request->end_at =='') {
              
              $invoices = invoices::select('*')->where('Status','=',$request->type)->get();
              $type = $request->type;
              return view('reports.invoices_report',compact('type'))->withDetails($invoices);
           }
           
           
           
           // في حالة تحديد تاريخ استحقاق
           else{
              
             $start_at = date($request->start_at);
             $end_at = date($request->end_at);
             $type = $request->type;
            
             $invoices = invoices::whereBetween('invoice_Date',[$start_at,$end_at])->where('Status','=',$request->type)->get();
             return view('reports.invoices_report',compact('type','start_at','end_at'))->withDetails($invoices);
             
           }
    

    
   
    
           
       } 
       
   //====================================================================
       
   // في البحث برقم الفاتورة
       else {
           
           $invoices = invoices::select('*')->where('invoice_number','=',$request->invoice_number)->get();
           return view('reports.invoices_report')->withDetails($invoices);
           
       }
   
       
        
       }
}
