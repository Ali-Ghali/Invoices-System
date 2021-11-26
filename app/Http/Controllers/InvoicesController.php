<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\sections;
use App\Models\invoices_details;
use App\Models\invoice_attachments;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Notifications\AddInvoice;
use Illuminate\Support\Facades\Notification;
use App\Exports\InvoicesExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InvoicesImport;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            //نقوم بجلب البيانات كلها من جدول الفواتير لعرضها على الصفحة

        $invoices = invoices::all();
        return view('invoices.invoices', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          //نقوم بجلب البيانات كلها من جدول الأقسام لعرضها على صفحة اضافة فاتورة

        $sections = sections::all();
        return view('invoices.add_invoice', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //سيتم تخزين هذه البيانات في جدول الفواتير
        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,//اعطينا قيمة 2 للفواتير الغير مدفوعة
            'note' => $request->note,
        ]);
    
        //سيتم تخزين هذه البيانات في جدول تفاصيل الفاتورة
        $invoice_id = invoices::latest()->first()->id;//يجلب اخر اي دي من جدول الفواتير
        invoices_details::create([
            'id_Invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section' => $request->Section,
            'Status' => 'غير مدفوعة',
            'Value_Status' => 2,//اعطينا قيمة 2 للفواتير الغير مدفوعة
            'note' => $request->note,
            'user' => (Auth::user()->name),
        ]);

        //سيتم تخزين هذه البيانات في جدول مرفقات الفاتورة
        if ($request->hasFile('pic')) {

            $invoice_id = invoices::latest()->first()->id;//يجلب اخر اي دي من جدول الفواتير
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoice_attachments();
            $attachments->file_name = $file_name;//جيب اسم الملف
            $attachments->invoice_number = $invoice_number;//جيب رقم الفاتورة
            $attachments->Created_by = Auth::user()->name;//جيب اسم المستخدم
            $attachments->invoice_id = $invoice_id;//جيب اي دي الفاتورة
            $attachments->save();//احفظ

            // يقوم بخلق مجلد ضمن مجلد الببلك اسمه اتاتشمينتس وبداخله يتم خلق مجلد برقم الفاتورة وضمنه الملف 
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
        }
        // $user = User::first();//سيأخذ ايميل المستخدم من موديل اليوزر

        // Notification::send($user, new \App\Notifications\AddInvoice($invoice_id)); 
 
        //في حال اردنا ان ترسل الاشعارات للشخص الذي قام بالاضافة فقط نكتب الكود التالي
       // $user = User::find(Auth::user()->id);

        $user = User::get();
        $invoices = invoices::latest()->first();
        Notification::send($user, new \App\Notifications\Add_invoice($invoices));

        session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
        return back();


           // $user = User::first();
           // Notification::send($user, new AddInvoice($invoice_id));

        // $user = User::get();
        // $invoices = invoices::latest()->first();
        // Notification::send($user, new \App\Notifications\Add_invoice_new($invoices));

        
        // event(new MyEventClass('hello world'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoices = invoices::where('id', $id)->first();
        return view('invoices.status_update', compact('invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoices = invoices::where('id', $id)->first();
        $sections = sections::all();
        return view('invoices.edit_invoice', compact('sections', 'invoices'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $invoices = invoices::findOrFail($request->invoice_id);
        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' => $request->invoice_Date,
            'Due_date' => $request->Due_date,
            'product' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'Discount' => $request->Discount,
            'Value_VAT' => $request->Value_VAT,
            'Rate_VAT' => $request->Rate_VAT,
            'Total' => $request->Total,
            'note' => $request->note,
        ]);

        session()->flash('edit', 'تم تعديل الفاتورة بنجاح');
        return back();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->invoice_id;
        $invoices = invoices::where('id', $id)->first();
        $Details = invoice_attachments::where('invoice_id', $id)->first();

         $id_page =$request->id_page;


        if (!$id_page==2) {

        if (!empty($Details->invoice_number)) {

            Storage::disk('public_uploads')->deleteDirectory($Details->invoice_number);
        }

        $invoices->forceDelete();
        session()->flash('delete_invoice');
        return redirect('/invoices');

        }

        else {

            $invoices->delete();
            session()->flash('archive_invoice');
            return redirect('/Archive');
        }


    }
       //سيذهب الى جدول المنتجات بحيث رقم القسم يساوي الاي دي ضمن التابع الجايي من الصفحة تبعنا لذلك بدك تجبلي اسم المنتج والرقم تبعه
    
       //يقوم هذا التابع بجلب اسم المنتج والاي دي تبعه من جدول المنتجات وذلك بعد ان يقارن بين الاي دي تبع القسم مع الاي دي القادم من صفحتنا
       //كل هذا من اجل جلب اسم المنتج التابع لقسم معين
       public function getproducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("Product_name", "id");
        return json_encode($products);
    }

    public function Status_Update($id, Request $request)
    {
        $invoices = invoices::findOrFail($id);

        if ($request->Status === 'مدفوعة') {

            $invoices->update([
                'Value_Status' => 1,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);

            invoices_details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 1,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }

        else {
            $invoices->update([
                'Value_Status' => 3,
                'Status' => $request->Status,
                'Payment_Date' => $request->Payment_Date,
            ]);
            invoices_details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'Section' => $request->Section,
                'Status' => $request->Status,
                'Value_Status' => 3,
                'note' => $request->note,
                'Payment_Date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('Status_Update');
        return redirect('/invoices');

    }

    public function Invoice_Paid()
    {
        $invoices = invoices::where('Value_Status', 1)->get();
        return view('invoices.invoices_paid',compact('invoices'));
    }

    public function Invoice_unPaid()
    {
        $invoices = invoices::where('Value_Status',2)->get();
        return view('invoices.invoices_unpaid',compact('invoices'));
    }

    public function Invoice_Partial()
    {
        $invoices = invoices::where('Value_Status',3)->get();
        return view('invoices.invoices_Partial',compact('invoices'));
    }

    public function Print_invoice($id)
    {
        $invoices = invoices::where('id', $id)->first();
        return view('invoices.Print_invoice',compact('invoices'));
    }

    public function export()
    {

        return Excel::download(new InvoicesExport, 'invoices.xlsx');

    }

    public function import(Request $request) 
    {

         Excel::import(new InvoicesImport, request()->file('file'));
        
         return redirect('/invoices')->with('success', 'All good!');
    }

    public function MarkAsRead_all (Request $request)
    {
//سيجلب كل الاشعارات في قاعدة البيانات واذا وجد أنه يوجد اشعارات سيقوم بقراءتها كلها
        $userUnreadNotification= auth()->user()->unreadNotifications; 
        if($userUnreadNotification) {
            $userUnreadNotification->markAsRead();
            return back();
        }


    }




}
