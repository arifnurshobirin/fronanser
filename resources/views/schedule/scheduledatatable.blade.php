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
                        {{-- <div class="col-md-3">
                            <div class="select2-danger">
                                <select data-column="5" class="form-control select2" multiple="multiple" data-placeholder="Select a Status" style="width: 100%;"
                                data-dropdown-css-class="select2-danger" id="statusselect" name="statusselect" required>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div> --}}
                        <div class="col-md-3">
                            <button type="button" name="showschedule" id="showschedule" class="btn btn-success">Show</button>
                            <button type="button" name="createschedule" id="createschedule" class="btn btn-info">Create</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- /.filter schedule -->
        <!-- /.card-body -->
        <div class="card-footer">
            Project Website Cashier Carrefour Taman Palem
        </div>
    </div>
    <!-- /.card -->

    <div class="row">
        <!-- Default box -->
        <div class="card card-danger card-outline col-md-7">
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
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                Project Website Cashier Carrefour Taman Palem
            </div>
        </div>
        <!-- /.card -->

        <!-- Default box -->
        <div class="card card-danger card-outline col-md-5">
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
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" id="avatarschedule" src="{{ asset('dashboard/img/avatar.png') }}" alt="User">
                </div>
                <h3 class="profile-username text-center" id="fullnameschedule">Null</h3>
                <p class="text-muted text-center" id="positionschedule">Null</p>
                <form method="post" id="scheduledetailform" name="scheduledetailform">
                    @csrf
                <div class="form-group row">
                    <label for="labeldate" id="labelweeknumber" name="labelweeknumber" class="col-sm-3 col-form-label">Week </label>
                    <button type="button" class="btn btn-primary col-sm-7" id="savebutton" name="savebutton" value="create">Save</button>
                    <label class="col-form-label col-sm-2" id="labeltotalwh" name="labeltotalwh">0 Hour</label>
                </div>
                <input type="hidden" name="cashierid" id="cashierid">
                <input type="hidden" name="scheduleid" id="scheduleid">
                <input type="hidden" name="startdate" id="startdate">
                <input type="hidden" name="hiddenweeknumber" id="hiddenweeknumber">
                <?php for($i=0;$i<=6;$i++){
                    $a = $i+1;
                ?>
                    <div class="form-group row">
                        <label for="labeldate" id="<?php echo "day" . $a; ?>" class="col-sm-3 col-form-label">Day <?php echo $a; ?> :</label>
                        <div class="form-line col-sm-2">
                            <input type="text" class="form-control input-uppercase" id="<?php echo "codeshift" . $i; ?>" name="<?php echo "codeshift" . $i; ?>" oninput="datashift(<?php echo $i; ?>)">
                        </div>
                        <div class="form-line col-sm-5">
                        <input type="text" class="form-control" id="<?php echo "inputshift" . $i; ?>" name="<?php echo "inputshift" . $i; ?>" readonly>
                        </div>
                        <div class="form-line col-sm-2">
                            <label class="col-form-label" id="<?php echo "labelhour" . $i; ?>" name="<?php echo "labelhour" . $i; ?>">0 </label>
                            Hour
                        </div>
                    </div>
                <?php } ?>
                </form>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                Project Website Cashier Carrefour Taman Palem
            </div>
        </div>
        <!-- /.card -->
    </div>


            <!-- modal codeshift -->
            <div class="modal fade" id="modalschedule" data-backdrop="static" aria-hidden="true">
                <div class="modal-dialog">
                    <!-- modal-lg -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modalheadschedule"></h4>
                        </div>
                        <div class="modal-body">
                            <button type="button" name="createcodeshift" id="createcodeshift"
                                onclick="fnClickAddRow()" class="btn btn-success">Weekly</button>
                                <button type="button" name="createcodeshift" id="createcodeshift"
                                onclick="fnClickAddRow()" class="btn btn-success">Weekly</button>
                                <button type="button" class="btn btn-secondary" id="resetmodal" data-dismiss="modal"><i class='fas fa-times'></i> Close</button>
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
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# modal codeshift -->


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

    for( c=0;c<7;c++)
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

        var arrayerror = ['tidedc','midedc','ipaddress','counter_id','connection','simcard','type','status'];

        function loadcreate(){
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
                                                "<td><div class='btn-group'>"+
                                                        "<button type='button' class='btn btn-secondary dropdown-toggle' data-toggle='dropdown'><i class='fas fa-wrench'></i> </button>"+
                                                        "<div class='dropdown-menu dropdown-menu-right' role='menu'>"+
                                                            "<a class='createform dropdown-item' id="+datatablecashier.id+"><i class='fas fa-desktop'></i> Create</a>"+
                                                            "<a class='editform dropdown-item' id="+datatablecashier.id+"><i class='fas fa-edit'></i> Edit</a>"+
                                                            "<a class='deleteform dropdown-item' id="+datatablecashier.id+"><i class='fas fa-trash'></i> Delete</a>"+
                                                        "</div>"+
                                                    "</div>"+
                                                "</td></tr>");
                    })
                },
                    error: function (data) {
                        console.log('Error:', data);
                    }
            });
        }
        $(document).on('click', '#createschedule', function () {
            loadcreate();
        });

        $(document).on('click', '#showschedule', function () {
            ('#modalheadschedule').html("List Schedule");
            $('#modalschedule').modal('show');
        });

        $(document).on('click', '.createform', function () {
            var cashierid = $(this).attr('id');
            var weeknumber = $('#weekinput').val();
            var startdate = $('#dateinput').val();
            var day;
            $('#startdate').val(startdate);
            $('#scheduledetailform').trigger("reset");


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

            $.get("{{ route('schedule.index') }}" +'/' + cashierid +'/create', function (data)
            {
                //console.log(data.dataschedule);
                var totaltimework=0;
                $('#modelHeading').html("Create Data Schedule");
                $('#savebutton').html('Save');
                $('#cashierid').val(data.datacashier.id);
                $('#hiddenweeknumber').val(weeknumber);
                $('#labelweeknumber').html("Week "+weeknumber);
                $('#avatarschedule').attr('src','../../dashboard/img/'+data.datacashier['avatar']);
                $('#fullnameschedule').html(data.datacashier['fullname']);
                $('#positionschedule').html(data.datacashier['position']);

                if (data.dataschedule.length > 0) {
                    for( c=0;c<=6;c++)
                    {
                        $('#savebutton').html('Save Changes');
                        $('#codeshift'+c).val(data.dataschedule[c].shift['codeshift']);
                        $('#inputshift'+c).val(data.dataschedule[c].shift['startshift'].concat(' - ',data.dataschedule[c].shift['endshift']));
                        $('#labelhour'+c).html(data.dataschedule[c].shift['workinghour']);
                        hour = $('#labelhour'+c).html();
                        totaltimework = totaltimework+parseInt(hour);
                    }
                }
                $('#labeltotalwh').html(totaltimework+ " Hour");

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
                    loadcreate();
                    swal.fire("Deleted!", "Your employee status has been Inactive.", "success")
                }
                });
                } else {
                    swal.fire("Cancelled", "Your employee status  is Active :)", "error");
                }
            });

        });

        $('#savebutton').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');
            $.ajax({
                data: $('#scheduledetailform').serialize(),
                url: "{{ route('schedule.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {

                    $('#scheduledetailform').trigger("reset");
                    $('#savebutton').html('Save');
                    swal.fire("Good job!", "You success create Schedule!", "success");
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#savebutton').html('Save Changes');
                    for( a=0;a<8;a++)
                    {
                        $('#error'+arrayerror[a]).html('');
                    }
                    $.each(data.responseJSON.errors, function(key,value) {
                        $('#error'+key).append('<div class="text-danger mt-2">'+value+'</div');
                    });
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
