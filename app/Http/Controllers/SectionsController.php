<?php

namespace App\Http\Controllers;

use App\Models\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use session;
class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //نقوم بجلب البيانات كلها من جدول الاقسام لعرضها على الصفحة
        $sections= sections::all();
        return view('sections.sections',compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //نعمل فاليداشن على الصفحة بحيث يكون اسم القسم والوصف مطلوبين وفي حال كان اسم القسم موجود لايمكن تكراره واذا كان هو او الوصف فارغيين يعطينا رسالة تحذير انهم غير مدخلين
        $validated = $request->validate([
            'ection_name' => 'required|unique:sections|max:255',
            'description' => 'required',
        ],[
            'ection_name.required'=>'يرجى ادخال اسم القسم',
            'ection_name.unique'=>'اسم القسم مسجل مسبقا',
            'description.required'=>'يرجى ادخال البيان',
        ]);
        //ثم الان يقوم بعملية الحفظ 
            sections::create([
                'ection_name'=>$request->ection_name,
                'description'=>$request->description,
                'created_by'=> (Auth::user()->name), //اظهار اسم المستخدم الذي قام بالحفظ
            ]);
            session()->flash('Add','تم اضافة القسم بنجاح');
            return redirect('/sections');
        
      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function show(sections $sections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function edit(sections $sections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //نعمل فاليداشن على الصفحة بحيث يكون اسم القسم والوصف مطلوبين وفي حال كان اسم القسم موجود لايمكن تكراره واذا كان هو او الوصف فارغيين يعطينا رسالة تحذير انهم غير مدخلين
        $id = $request->id;
       

        $this->validate($request, [

            'ection_name' => 'required|max:255|unique:sections,ection_name,'.$id,
            'description' => 'required',
        ],[
          
            'ection_name.required' =>'يرجي ادخال اسم القسم',
            'ection_name.unique' =>'اسم القسم مسجل مسبقا',
            'description.required' =>'يرجي ادخال البيان',

        ]);
          //ثم الان يقوم بعملية التعديل عن طريق الأي دي
        $sections = sections::find($id);
        $sections->update([
            'ection_name' => $request->ection_name,
            'description' => $request->description,
        ]);

        session()->flash('edit','تم تعديل القسم بنجاج');
        return redirect('/sections');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        // يقوم بعملية التعديل عن طريق الاي دي
        $id = $request->id;
        sections::find($id)->delete();
        session()->flash('delete','تم حذف القسم بنجاح');
        return redirect('/sections');
    }
}
