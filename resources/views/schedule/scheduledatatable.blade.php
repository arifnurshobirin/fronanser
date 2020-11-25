@extends('layouts.app')
@section('title page','Schedule Page')
@section('title tab','Schedule')


@push('css')
<!-- datepicker bootstrap -->
{{-- <link href="{{ asset('dashboard/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet"> --}}
<!-- daterange picker -->
{{-- <link href="{{ asset('dashboard/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet"> --}}
<!-- Tempusdominus Bbootstrap 4 -->
{{-- <link href="{{ asset('dashboard/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet"> --}}
<!-- datepicker jquery -->
<link href="{{ asset('dashboard/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
<!-- datepicker jquery -->
<link href="{{ asset('dashboard/plugins/jquery-ui/jquery-ui.theme.min.css') }}" rel="stylesheet">
<!-- Select2 -->
<link href="{{ asset('dashboard/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<!-- Page CSS -->
@endpush

@section('content')
<!-- Main content -->
<section class="content" id="contentpage">
    <!-- Default box -->
    <div class="card card-danger card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-calendar-check"></i> Schedule DataTable</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
                    <i class="fas fa-minus"></i></button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                    title="Remove">
                    <i class="fas fa-times"></i></button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <!-- Filter -->
            <form method="post" id="scheduleform" name="scheduleform">
                @csrf
                <div class="form-group">
                    <label>Filter :</label>
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="dateinput" name="dateinput" placeholder="Select a date" required>
                            <input type="text" class="form-control" id="weekinput" name="weekinput" placeholder="Week Number" readonly>
                        </div>
                        <div class="col-md-3">
                            {{-- <input type="text" class="form-control" id="position" name="position"> --}}
                            <div class="select2-danger">
                                <select data-column="3" class="form-control select2" multiple="multiple" data-placeholder="Select a Position" style="width: 100%;"
                                data-dropdown-css-class="select2-danger" id="positionselect" name="positionselect" required>
                                    <option value="Cashier">Cashier</option>
                                    <option value="Customer Service">Customer Service</option>
                                    <option value="TDR">TDR</option>
                                    <option value="Senior Cashier">Senior Cashier</option>
                                    <option value="Cashier Head">Cashier Head</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            {{-- <input type="text" class="form-control" id="status" name="status"> --}}
                            <div class="select2-danger">
                                <select data-column="5" class="form-control select2" multiple="multiple" data-placeholder="Select a Status" style="width: 100%;"
                                data-dropdown-css-class="select2-danger" id="statusselect" name="statusselect" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" name="showschedule" id="showschedule" class="btn btn-success">Show</button>
                            <button type="button" name="createschedule" id="createschedule" class="btn btn-info createschedule">Create</button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- /.filter schedule -->
            <div class="row">
                <div class="col-md-7">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable"
                            id="ScheduleDatatable" style="width:100%">
                            <thead class="bg-danger">
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Position</th>
                                    <th>Week</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="bodytable">
                            </tbody>
                            <tfoot class="bg-danger">
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Position</th>
                                    <th>Week</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="col-md-5">
                    <!-- Profile Image -->
                    <div class="card card-danger card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" id="avatarschedule" src="{{ asset('dashboard/img/avatar.png') }}" alt="User">
                            </div>
                            <h3 class="profile-username text-center" id="fullnameschedule">Null</h3>
                            <p class="text-muted text-center" id="positionschedule">Null</p>
                            <form method="post" id="scheduleformcreate" name="scheduleformcreate">
                                @csrf
                            <div class="form-group row">
                                <label for="labeldate" id="labelweeknumber" name="labelweeknumber" class="col-sm-3 col-form-label">Week </label>
                                <button type="submit" class="btn btn-primary col-sm-7" id="schedulesave" value="create">Save</button>
                                <label class="col-form-label col-sm-2" id="labeltotalwh" name="labeltotalwh">0 Hour</label>
                            </div>
                            <input type="hidden" name="scheduleid" id="scheduleid">
                            <div class="form-group row">
                                <label for="labeldate" id="day1" class="col-sm-3 col-form-label">Day 1 :</label>
                                <div class="form-line col-sm-2">
                                    <input type="text" class="form-control input-uppercase" id="codeshift1" name="codeshift1" oninput="datashift(1)">
                                </div>
                                <div class="form-line col-sm-5">
                                <input type="text" class="form-control" id="inputshift1" name="inputshift1" readonly>
                                </div>
                                <div class="form-line col-sm-2">
                                    <label class="col-form-label" id="labelhour1" name="labelhour">0</label>
                                    Hour
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="labeldate"  id="day2" class="col-sm-3 col-form-label">Day 2 :</label>
                                <div class="form-line col-sm-2">
                                    <input type="text" class="form-control input-uppercase" id="codeshift2" name="codeshift2" oninput="datashift(2)">
                                </div>
                                <div class="form-line col-sm-5">
                                <input type="text" class="form-control" id="inputshift2" name="inputshif2t" readonly>
                                </div>
                                <div class="form-line col-sm-2">
                                    <label class="col-form-label" id="labelhour2" name="labelhour">0</label>
                                    Hour
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="labeldate"  id="day3" class="col-sm-3 col-form-label">Day 3 :</label>
                                <div class="form-line col-sm-2">
                                    <input type="text" class="form-control input-uppercase" id="codeshift3" name="codeshift3" oninput="datashift(3)">
                                </div>
                                <div class="form-line col-sm-5">
                                <input type="text" class="form-control" id="inputshift3" name="inputshift3" readonly>
                                </div>
                                <div class="form-line col-sm-2">
                                    <label class="col-form-label" id="labelhour3" name="labelhour">0</label>
                                    Hour
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="labeldate"  id="day4" class="col-sm-3 col-form-label">Day 4 :</label>
                                <div class="form-line col-sm-2">
                                    <input type="text" class="form-control input-uppercase" id="codeshift4" name="codeshift4" oninput="datashift(4)">
                                </div>
                                <div class="form-line col-sm-5">
                                <input type="text" class="form-control" id="inputshift4" name="inputshift4" readonly>
                                </div>
                                <div class="form-line col-sm-2">
                                    <label class="col-form-label" id="labelhour4" name="labelhour">0</label>
                                    Hour
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="labeldate"  id="day5" class="col-sm-3 col-form-label">Day 5 :</label>
                                <div class="form-line col-sm-2">
                                    <input type="text" class="form-control input-uppercase" id="codeshift5" name="codeshift5" oninput="datashift(5)">
                                </div>
                                <div class="form-line col-sm-5">
                                <input type="text" class="form-control" id="inputshift5" name="inputshift5" readonly>
                                </div>
                                <div class="form-line col-sm-2">
                                    <label class="col-form-label" id="labelhour5" name="labelhour">0</label>
                                    Hour
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="labeldate"  id="day6" class="col-sm-3 col-form-label">Day 6 :</label>
                                <div class="form-line col-sm-2">
                                    <input type="text" class="form-control input-uppercase" id="codeshift6" name="codeshift6" oninput="datashift(6)">
                                </div>
                                <div class="form-line col-sm-5">
                                <input type="text" class="form-control" id="inputshift6" name="inputshift6" readonly>
                                </div>
                                <div class="form-line col-sm-2">
                                    <label class="col-form-label" id="labelhour6" name="labelhour">0</label>
                                    Hour
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="labeldate"   id="day7" class="col-sm-3 col-form-label">Day 7 :</label>
                                <div class="form-line col-sm-2">
                                    <input type="text" class="form-control input-uppercase" id="codeshift7" name="codeshift7" oninput="datashift(7)">
                                </div>
                                <div class="form-line col-sm-5">
                                <input type="text" class="form-control" id="inputshift7" name="inputshift7" readonly>
                                </div>
                                <div class="form-line col-sm-2">
                                    <label class="col-form-label" id="labelhour7" name="labelhour">0</label>
                                    Hour
                                </div>
                            </div>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>

            <!-- modal codeshift -->
            <div class="modal fade" id="codeshiftmodal" data-backdrop="static" aria-hidden="true">
                <div class="modal-dialog">
                    <!-- modal-lg -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modalheadingcodeshift"></h4>
                        </div>
                        <div class="modal-body">
                            <button type="button" name="createcodeshift" id="createcodeshift"
                                onclick="fnClickAddRow()" class="btn btn-success">Create Code Shift</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <br>
                            <div class="table-responsive">
                                <table
                                    class="display responsive table table-striped table-hover dataTable js-exportable"
                                    id="CodeShiftDatatable" style="width:100%">
                                    <thead class="bg-danger">
                                        <tr>
                                            <th>Code Shift</th>
                                            <th>Start Shift</th>
                                            <th>End Shift</th>
                                            <th>Working Hour</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($datashift as $listshift)
                                        <tr>
                                            <td>{{ $listshift->codeshift }}</td>
                                            <td>{{ $listshift->startshift }}</td>
                                            <td>{{ $listshift->endshift }}</td>
                                            <td>{{ $listshift->workinghour }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-danger">
                                        <tr>
                                            <th>Code Shift</th>
                                            <th>Start Shift</th>
                                            <th>End Shift</th>
                                            <th>Working Hour</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# modal codeshift -->

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            Project Website Cashier Carrefour Taman Palem
        </div>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('javascript')
<!-- jQuery UI -->
<script src="{{ asset('dashboard/plugins/jquery-ui/jquery-ui.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('dashboard/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- date-range-picker -->
{{-- <script src="{{ asset('dashboard/plugins/daterangepicker/daterangepicker.js') }}"></script> --}}
<!-- Tempusdominus Bootstrap 4 -->
{{-- <script src="{{ asset('dashboard/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script> --}}
<!-- datepicker -->
{{-- <script src="{{ asset('dashboard/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script> --}}
<!-- page script -->
<script>
    $(".preloader").fadeOut("slow");

function datashift(day){
    var datajs = {!! json_encode($datashift->toArray()) !!};
    var size = Object.keys(datajs).length;
    var totaltimework=0;

    shift = $('#codeshift'+day).val();
    shift = shift.toUpperCase(shift);

    for(b=0;b<size;b++)
    {
        if(shift==datajs[b]['codeshift']){
            timework = datajs[b]['workinghour'];
            shiftstart = datajs[b]['startshift'];
            shiftend = datajs[b]['endshift'];
            shift=shiftstart.concat(' - ',shiftend);
            break;
        }
        else if(shift=="AL"){
            shift="Cuti";
        }
        else if(shift=="EO"){
            shift="Extra Off";
        }
        timework = 0;
    }
    $('#inputshift'+day).val(shift);
    $('#labelhour'+day).html(timework);

    for( c=1;c<8;c++)
    {
        hour = $('#labelhour'+c).html();
        totaltimework = totaltimework+parseInt(hour);
    }
    $('#labeltotalwh').html(totaltimework+ " Hour");
    totaltimework=0;

}

    $(document).ready(function() {
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        $('#scheduleform').on("submit",function (event) {
            event.preventDefault();
            // console.log(document.getElementById("scheduleshow"));
            // console.log($(this)[0]);
            var formdata = new FormData($(this)[0]);
            // console.log(formdata);
            var table = $('#ScheduleDatatable').DataTable({
                destroy: true,
                // retrieve: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url:"{{ route('schedule.datatablepost') }}",
                    type: "POST",
                    data: function ( d ) {
                            d.week = $('#weekinput').val();
                            d.position = $('#positionselect').val();
                            d.status = $('#statusselect').val();
                            }
                    // processData: false,
                    // contentType: false
                    },
                columns: [
                    { data: 'EmployeeName', name: 'EmployeeName' },
                    { data: 'cashier.position', name: 'cashier.position' },
                    { data: 'week', name: 'week' },
                    { data: 'cashier.status', name: 'cashier.status' },
                    { data: 'action', name: 'action', orderable: false}
                ],
                order: [[ 0, "asc" ]],
                dom: 'Bfrtip',
                lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10 rows', '25 rows', '50 rows', 'Show all' ]
                ],
                buttons:['pageLength',
                    {
                        extend: 'collection',
                        text: 'Export',
                        className: 'btn btn-info',
                        buttons:[ 'copy', 'csv', 'excel', 'pdf', 'print',
                                    {
                                        collectionTitle: 'Visibility control',
                                        extend: 'colvis',
                                        collectionLayout: 'two-column'
                                    }
                                ]
                    },
                    {
                        text: '<i class="fas fa-user-clock"></i><span> Code Shift</span>',
                        className: 'btn btn-success',
                        action: function ( e, dt, node, config ) {
                            $('#schedulesave').val("create-schedule");
                            $('#schedulesave').html('Save');
                            $('#scheduleid').val('');
                            $('#scheduleform').trigger("reset");
                            $('#modelHeading').html("Create New Schedule");
                            $('#codeshiftmodal').modal('show');
                        }
                    }
                ]
            });
        });

        $(document).on('click', '.createschedule', function () {
            $('#bodytable').html("");
            var position = $('#positionselect').val();
            $.ajax({
                url: "{{ route('schedule.create') }}",
                type: "GET",
                data: {'position': position },
                // processData: false,
                // contentType: false,
                success: function (data) {

                    var objectcashier= data;
                    var linkimage="{{ asset('dashboard/img/')}}";
                    var week = $('#weekinput').val();

                    objectcashier.forEach(function(datatablecashier, data){
                        $('#bodytable').append("<tr>"+
                                                "<td>"+datatablecashier.employee+" - "+datatablecashier.fullname+"</td>"+
                                                "<td>"+datatablecashier.position+"</td>"+
                                                "<td id='weeknumber'>"+week+"</td>"+
                                                "<td><span class='badge badge-success'>"+datatablecashier.status+"</span></td>"+
                                                "<td><button class='createform btn btn-warning' id="+datatablecashier.id+"><i class='fas fa-edit'></i></button>"+
                                                "    <button class='deleteform btn btn-danger' id="+datatablecashier.id+"><i class='fas fa-trash'></i></button>"+
                                                "</td></tr>");
                    })
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });


        $(document).on('click', '.scheduleedit', function () {
            var scheduleid = $(this).attr('id');
            $.get("{{ route('schedule.index') }}" +'/' + scheduleid +'/edit', function (data)
            {
                var linkimage="{{ asset('dashboard/img/')}}";
                $('#modelHeading').html("Edit Data Schedule");
                $('#schedulesave').html('Save Changes');
                $('#scheduleid').val(data.id);
                $('#avatarschedule').attr('src','../../dashboard/img/'+data.cashier.avatar);
                $('#fullnameschedule').html(data.cashier.fullname);
                $('#positionschedule').html(data.cashier.position);
                $('#schedulemodal').modal('show');
            })
        });

        $(document).on('click', '.createform', function () {
            var cashierid = $(this).attr('id');
            var weeknumber = $('#weekinput').val();
            var startdate = $('#dateinput').val();
            var day;

            for( i=1;i<=7;i++)
            {
                if(i==1){
                    day = new Date(startdate);
                }
                else{
                    day = new Date(day);
                    day.setDate(day.getDate()+1);
                }
                formatday = moment(day).format('dd DD-MM-YYYY');
                $('#day'+i).html(formatday);
            }

            $.get("{{ route('schedule.index') }}" +'/' + cashierid +'/create', function (datacashier)
            {
                $('#modelHeading').html("Edit Data Schedule");
                $('#scheduleid').val(datacashier.id);
                $('#labelweeknumber').html("Week "+weeknumber);
                $('#avatarschedule').attr('src','../../dashboard/img/'+datacashier.avatar);
                $('#fullnameschedule').html(datacashier.fullname);
                $('#positionschedule').html(datacashier.position);
            })
        });


        $(document).on('click', '.deleteform', function () {
            var cashierid = $(this).attr('id');
            swal.fire({
                title: "Are you sure?",
                text: "You will change the employee status to Inactive!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete!",
                cancelButtonText: "No, cancel!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                url:"cashier/"+cashierid,
                type: "PATCH",
                success:function(data){
                    swal.fire("Deleted!", "Your employee status has been Inactive.", "success")
                }
                });
                } else {
                    swal.fire("Cancelled", "Your employee status  is Active :)", "error");
                }
            });

        });


        $('#scheduleformAAAA').on("submit",function (event) {
            event.preventDefault();
            var formdata = new FormData($(this)[0]);
            $.ajax({
                url: "{{ route('schedule.store') }}",
                type: "POST",
                data: formdata,
                processData: false,
                contentType: false,
                success: function (data) {

                    $('#scheduleform').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    $('#schedulesave').html('Save');
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#schedulesave').html('Save Changes');
                }
            });
        });

        //Date range picker
        $('#dateinput').datepicker({
            onSelect: function (dateText, inst) {
            $('#weekinput').val($.datepicker.iso8601Week(new Date(dateText)));
            },
            showWeek: true,
            firstDay: 1,
            showOtherMonths: true,
            selectOtherMonths: true
        });

        //Initialize Select2 Elements
        $('.select2').select2()

        //filter berdasarkan Nama Product
        $('.filter-positiongagal').keyup(function () {
        table.column( $(this).data('column'))
        .search( $(this).val() )
        .draw();
        });

    });
</script>
@endsection
