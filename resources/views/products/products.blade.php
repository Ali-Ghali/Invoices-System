@extends('layouts.master')
@section('css')
<!-- نقوم بجلب الجدول جاهز من صفحة تابل-داتا او من صفحة الأقسام التي عملناها سابقا مع نسخ السكربتات والسي اس اس  ثم نقوم بالتعديلات على الصفحة -->
    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    المنتجات</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

       <!-- عند الاضافة يتم اظهار رسالة تأكيد الاضافة -->

    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

       <!-- عند التعديل يتم اظهار رسالة تأكيد التعديل -->

    @if (session()->has('Edit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Edit') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

       <!-- عند الحذف يتم اظهار رسالة تأكيد الحذف -->

    @if (session()->has('delete'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('delete') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
         <!-- عند الخطاء يتم اظهار رسالة وجود خطأ -->

    @if (session()->has('Error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Error') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
<!--  ننسخ المودل الموجود في صفحة الاقسام مع نسخ الزر اللي منختارو ومنضيف الها فورم لعمل روت من أجل عملية الاضافة مع اضافة حقول اسم المنتج والملاحظات والقسم-->

    <!-- add -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">اضافة منتج</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('products.store') }}" method="post"><!-- سيأخذنا الى الكنترولر لتتم عملية الحفظ -->
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">اسم المنتج</label>
                            <input type="text" class="form-control" id="Product_name" name="Product_name" required>
                        </div>
                         <!-- سيتم جلب الاقسام من جدول الاقسام واظهاره في قائمة منسدلة في صفحة المنتجات وذلك حسب الاي دي -->

                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
                        <select name="section_id" id="section_id" class="form-control" required>
                            <option value="" selected disabled> --حدد القسم--</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->ection_name }}</option>
                            @endforeach
                        </select>

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">ملاحظات</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">تاكيد</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
     <!-- end add modal -->

     <!--  ننسخ المودل الموجود في صفحة الاقسام مع نسخ الزر اللي منختارو ومنضيف الها فورم لعمل روت من أجل عملية التعديل مع اضافة حقول اسم المنتج والملاحظات والقسم-->

    <!-- edit modal -->
    <div class="modal fade" id="edit_Product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">تعديل منتج</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action='products/update' method="post"><!-- سيأخذنا الى الكنترولر لتتم عملية التعديل -->
                        {{ method_field('patch') }}
                        {{ csrf_field() }}
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="title">اسم المنتج :</label>

                                <input type="hidden" class="form-control" name="pro_id" id="pro_id" value=""> <!-- سيتم جلب الاقسام من جدول الاقسام واظهاره في قائمة منسدلة في صفحة المنتجات وذلك حسب الاي دي -->

                                <input type="text" class="form-control" name="Product_name" id="Product_name">
                            </div>
                             <!-- سيتم جلب الاقسام من جدول الاقسام واظهاره في قائمة منسدلة في صفحة المنتجات وذلك حسب الاي دي -->


                            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
                            <select name="ection_name" id="ection_name" class="custom-select my-1 mr-sm-2" required>
                                @foreach ($sections as $section)
                                    <option>{{ $section->ection_name }}</option>
                                @endforeach
                            </select>

                            <div class="form-group">
                                <label for="des">ملاحظات :</label>
                                <textarea name="description" cols="20" rows="5" id='description'
                                    class="form-control"></textarea>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">تعديل البيانات</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
         <!-- end edit modal -->
     <!--  ننسخ المودل الموجود في صفحة الاقسام مع نسخ الزر اللي منختارو ومنضيف الها فورم لعمل روت من أجل عملية الحذف مع اضافة حقول اسم المنتج والملاحظات والقسم-->

          <!-- delete modal -->
        <div class="modal fade" id="modaldemo9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">حذف المنتج</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="products/destroy" method="post"><!-- سيأخذنا الى الكنترولر لتتم عملية الحذف -->
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل انت متاكد من عملية الحذف ؟</p><br>
                            <input type="hidden" name="pro_id" id="pro_id" value="">  <!-- سيتم جلب اسم المنتج من جدول المنتجات واظهاره  وذلك حسب الاي دي -->
                            <input class="form-control" name="product_name" id="product_name" type="text" readonly> <!-- سيتم جلب اسم المنتج من جدول المنتجات واظهاره  وذلك حسب الاي دي -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            <button type="submit" class="btn btn-danger">تاكيد</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
         <!-- end delete modal -->




    <!-- row -->
    <div class="row">
        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale"
                            data-toggle="modal" href="#exampleModal">اضافة منتج</a>  <!-- زر من اجل اضافة منتج -->

                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'>
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">اسم المنتج</th>
                                    <th class="border-bottom-0">اسم القسم</th>
                                    <th class="border-bottom-0">ملاحظات</th>
                                    <th class="border-bottom-0">العمليات</th>

                                </tr>
                            </thead>
                            <tbody>
                        <!-- سنقوم بعرض االرقم المتسلسل واسم المنتج واسم القسم والوصف من جدول المنتجات ونعرضها في الجدول على الصفحة -->
                         
                                <?php $i = 0; ?>
                                @foreach ($products as $Product)
                                    <?php $i++; ?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $Product->Product_name }}</td>
                                        <td>{{ $Product->section->ection_name }}</td> <!-- قمنا في البداية بعمل حقل اسمه سيكشن اي دي وهو مفتاح اجنبي وهملنا الاي دي الموجود في جدول الاقسام هو مرجعية له فأصبح يوجد علاقة بين جدول الاقسام والمنتجات لذلك نذهب الى المودل برودكت ونفتحه ونكتب بداخله تعليمة بيلونغ تو -->
                                        <td>{{ $Product->description }}</td>
                                        <td>
                                        <!-- قمنا بعمل زر واستدعاء المودل تبع التعديل مع استدعاء الاي دي واسم المنتج واسم القسم والوصف من قاعدة البيانات  -->

                                                <button class="btn btn-outline-success btn-sm"
                                                    data-name="{{ $Product->Product_name }}"
                                                    data-pro_id="{{ $Product->id }}"
                                                    data-ection_name="{{ $Product->section->ection_name }}"
                                                    data-description="{{ $Product->description }}" data-toggle="modal"
                                                    data-target="#edit_Product">تعديل</button>
                                          

                                       <!-- قمنا بعمل زر واستدعاء المودل تبع الحذف مع استدعاء الاي دي واسم المنتج  من قاعدة البيانات  -->

                                                <button class="btn btn-outline-danger btn-sm "
                                                    data-pro_id="{{ $Product->id }}"
                                                    data-product_name="{{ $Product->Product_name }}" data-toggle="modal"
                                                    data-target="#modaldemo9">حذف</button>
                                            

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- row closed -->
    </div>

    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
    <!--Internal  Datatable js -->
    <script src="{{ URL::asset('assets/js/table-data.js') }}"></script>

    <!--قمنا بعمل مودل في الأعلى من اجل عملية التعديل ولكن لم تقم لوحدها بجلب البيات فقمنا هنا بعمل سكربت لجلب اسم المنتج واسم القسم والوصف -->
     <!--نفس الامر بالنسبة لعملية الحذف -->
    <script>
        
        $('#edit_Product').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var Product_name = button.data('name')
            var ection_name = button.data('ection_name')
            var pro_id = button.data('pro_id')
            var description = button.data('description')
            var modal = $(this)
            modal.find('.modal-body #Product_name').val(Product_name);
            modal.find('.modal-body #ection_name').val(ection_name);
            modal.find('.modal-body #description').val(description);
            modal.find('.modal-body #pro_id').val(pro_id);
        })


        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var pro_id = button.data('pro_id')
            var product_name = button.data('product_name')
            var modal = $(this)

            modal.find('.modal-body #pro_id').val(pro_id);
            modal.find('.modal-body #product_name').val(product_name);
        })

    </script>
@endsection
