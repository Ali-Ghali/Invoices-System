@extends('layouts.master')

@section('title')
    الأقسام - برنامج الفواتير
@stop

@section('css')
<!-- نقوم بجلب الجدول جاهز من صفحة تابل-داتا مع نسخ السكربتات والسي اس اس  ثم نقوم بالتعديلات على الصفحة -->
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
                    الأقسام</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
 <!-- عند وجود اي خطأ يتم التحذير وهذه التعليمة خاصة بال فاليداشن -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<!--يوجد ملف جايي جاهز اسمه مودلز نفتحه ونختار منه مودل واحدة مع نسخ الزر اللي منختارو ومنضيف الها فورم لعمل روت من أجل عملية الاضافة مع اضافة حقول اسم القسم والوصف-->
    <!-- Basic modal ADD-->
    <div class="modal" id="modaldemo8">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">اضافة قسم</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('sections.store') }}" method="post"><!-- سيأخذنا الى الكنترولر لتتم عملية الحفظ -->

                    {{ csrf_field() }}
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">اسم القسم</label>
                            <input type="text" name="ection_name" class="form-control" id="recipient-name">
                        </div>

                        <div class="form-group">
                            <label for="message-text" class="col-form-label">الوصف</label>
                            <textarea class="form-control" name="description" id="message-text"></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success" type="submit">تأكيد</button>
                        <button class="btn btn-secondary" data-dismiss="modal" type="button">اغلاق</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Basic modal ADD-->

    <!--يوجد ملف جايي جاهز اسمه سكشنز نفتحه من مجلد الابديت على الحاسب وننسخ منه مودل  ومنضيف الها فورم لعمل روت من أجل عملية التعديل مع اضافة حقول اسم القسم والوصف-->

    <!-- Edit -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true"> <!-- سيتم الربط مع الزر عن طرق الاي دي  -->
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعديل القسم</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="sections/update" method="post" autocomplete="off"> <!-- سيأخذنا الى الكنترولر لتتم عملية التعديل -->
                        {{ method_field('patch') }}
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="hidden" name="id" id="id" value="">  <!-- سيتم عمليه التعديل عن طريق الاي دي -->
                            <label for="recipient-name" class="col-form-label">اسم القسم:</label>
                            <input class="form-control" name="ection_name" id="ection_name" type="text">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">ملاحظات:</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">تاكيد</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Edit -->

        <!--يوجد ملف جايي جاهز اسمه سكشنز نفتحه من مجلد الابديت على الحاسب وننسخ منه مودل  ومنضيف الها فورم لعمل روت من أجل عملية الحذف  -->
    
    <!-- delete -->
    <div class="modal" id="modaldemo9">  <!-- سيتم الربط مع الزر عن طرق الاي دي  -->
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">حذف القسم</h6><button aria-label="Close" class="close"
                        data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="sections/destroy" method="post">    <!-- سيأخذنا الى الكنترولر لتتم عملية الحذف -->
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>هل انت متاكد من عملية الحذف ؟</p><br>
                        <input type="hidden" name="id" id="id" value="">    <!-- سيتم عمليه الحذف عن طريق الاي دي -->
                        <input class="form-control" name="ection_name" id="ection_name" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
    <!-- End delete -->


       <!-- عند الاضافة يتم اظهار رسالة تأكيد الاضافة -->
    @if (session()->has('Add'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Add') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

         <!-- عند الخطاء يتم اظهار رسالة وجود خطأ -->
    @if (session()->has('Error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('Error') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
       <!-- عند التعديل يتم اظهار رسالة تأكيد التعديل -->
    @if (session()->has('edit'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session()->get('edit') }}</strong>
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
    <!-- row -->
    <div class="row">


        <div class="col-xl-12">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale"
                            data-toggle="modal" href="#modaldemo8">اضافة قسم</a> <!-- زر من اجل اضافة قسم -->

                    </div>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'>
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">#</th>
                                    <th class="border-bottom-0">اسم القسم</th>
                                    <th class="border-bottom-0">الوصف</th>
                                    <th class="border-bottom-0">العمليات</th>
                                </tr>
                            </thead>

                            <tbody>
                                 <!-- سنقوم بعرض االرقم المتسلسل واسم القسم والوصف من جدول الاقسام ونعرضها في الجدول على الصفحة -->
                                <?php $i = 0; ?>
                                @foreach ($sections as $section)
                                    <?php $i++; ?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $section->ection_name }}</td>
                                        <td>{{ $section->description }}</td>
                                        <td>
                                            <!-- قمنا بعمل زر واستدعاء المودل تبع التعديل مع استدعاء الاي دي واسم القسم والوصف من قاعدة البيانات  -->

                                            <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                data-id="{{ $section->id }}"
                                                data-ection_name="{{ $section->ection_name }}"
                                                data-description="{{ $section->description }}" data-toggle="modal"
                                                href="#exampleModal2" title="تعديل"><i class="las la-pen"></i></a>

                                            <!-- قمنا بعمل زر واستدعاء المودل تبع الحذف مع استدعاء الاي دي واسم القسم  من قاعدة البيانات  -->

                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                data-id="{{ $section->id }}"
                                                data-ection_name="{{ $section->ection_name }}" data-toggle="modal"
                                                href="#modaldemo9" title="حذف"><i class="las la-trash"></i></a>

                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>




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
        <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
        <!-- Internal Select2 js-->
        <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
        <!-- Internal Modal js-->
        <script src="{{ URL::asset('assets/js/modal.js') }}"></script>

        <!--هذه السكربت قمنا بعملها من اجل اظهار بيانات القسم في المودل تبع التعديل عن طريق الاي دي -->
        <!-- script for edit-->
        <script>
            $('#exampleModal2').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var id = button.data('id')
                var ection_name = button.data('ection_name')
                var description = button.data('description')
                var modal = $(this)
                modal.find('.modal-body #id').val(id);
                modal.find('.modal-body #ection_name').val(ection_name);
                modal.find('.modal-body #description').val(description);
            })
        </script>
        <!--end script for edit-->

         <!--هذه السكربت قمنا بعملها من اجل اظهار اسم القسم في المودل تبع الحذف عن طريق الاي دي -->
        <!-- script for delete-->
        <script>
            $('#modaldemo9').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget)
                var id = button.data('id')
                var ection_name = button.data('ection_name')
                var modal = $(this)
                modal.find('.modal-body #id').val(id);
                modal.find('.modal-body #ection_name').val(ection_name);
            })
        </script>
        <!--end script for delete-->
    @endsection
