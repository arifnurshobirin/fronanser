@extends('layouts.app')
@section('title page','Schedule Page')
@section('title tab','Schedule')


@push('css')
<!-- datepicker jquery -->
<link href="{{ asset('dashboard/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
<link href="{{ asset('dashboard/plugins/jquery-ui/jquery-ui.theme.min.css') }}" rel="stylesheet">
<!-- Select2 -->
<link href="{{ asset('dashboard/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<!-- Page CSS -->
@endpush

@section('content')
<!-- Main content -->
<section class="content" id="contentpage">
    <form method="post" id="scheduleform" name="scheduleform">
        @csrf
        <!-- Default box -->
        <div class="card card-danger card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-calendar-check"></i> Filter Schedule : </h3>
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
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="dateinput" name="dateinput" placeholder="Select a date">
                            <input type="text" class="form-control" id="weekinput" name="weekinput" placeholder="Week Number" readonly>
                            <div id="validatedate"></div>
                        </div>
                        <div class="col-md-3">
                            <div class="select2-danger">
                                <select class="form-control select2" multiple="multiple" data-placeholder="Select a Position" style="width: 100%;"
                                data-dropdown-css-class="select2-danger" id="positionselect" name="positionselect[]">
                                    <option value="Cashier">Cashier</option>
                                    <option value="Customer Service">Customer Service</option>
                                    <option value="TDR">TDR</option>
                                    <option value="Senior Cashier">Senior Cashier</option>
                                    <option value="Cashier Head">Cashier Head</option>
                                </select>
                            </div>
                            <input type="hidden" name="positionhidden" id="positionhidden">
                            <div id="validateposition"></div>
                        </div>
                        <div class="col-md-3">
                            <button type="button" name="showschedule" id="showschedule" class="btn btn-primary">Show</button>
                            <button type="button" name="resetschedule" id="resetschedule" class="btn btn-secondary">reset</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.filter schedule -->
            <!-- /.card-body -->

        </div>
        <!-- /.card -->

        <!-- Default box -->
        <div id="schedulebox" class="card card-danger card-outline" style="display: none;">
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
                    <div class="row justify-content-md-center">
                        <div class="col-md-4">
                            <label id="labelname">Schedule : </label><br>
                            <label id="labelweek">Week : </label><br>
                            <label id="labeldate">Date : </label>
                        </div>
                        <div class="col-md-4 text-center">
                            <button type="submit" name="saveschedule" id="saveschedule" class="btn btn-app bg-primary"><i class="fas fa-save"></i> Save Schedule</button>
                        </div>
                        <div class="col-md-4 text-right">
                            <button type="button" name="backschedule" id="backschedule" class="btn btn-secondary"><i class="fas fa-hand-point-left"></i> Back</button>
                            <button type="button" name="nextschedule" id="nextschedule" class="btn btn-secondary">Next <i class="fas fa-hand-point-right"></i></button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover"
                            id="ScheduleDatatable" style="width:100%">
                            <thead class="bg-danger">
                                <tr>
                                    <th>Employee Name</th>
                                    {{-- <th>Status</th> --}}
                                    <th name="day1" id="day1" class="">Monday</th>
                                    <th name="day2" id="day2" class="">Tuesday</th>
                                    <th name="day3" id="day3" class="">Wednesday</th>
                                    <th name="day4" id="day4" class="">Thursday</th>
                                    <th name="day5" id="day5" class="">Friday</th>
                                    <th name="day6" id="day6" class="">Saturday</th>
                                    <th name="day7" id="day7" class="">Sunday</th>
                                    <th>WH</th>
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
    </form>

</section>
<!-- /.content -->
@endsection

@section('javascript')
<!-- jQuery UI -->
<script src="{{ asset('dashboard/plugins/jquery-ui/jquery-ui.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('dashboard/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- jquery-validation -->
{{-- <script src="{{ asset('dashboard/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('dashboard/plugins/jquery-validation/additional-methods.min.js') }}"></script> --}}
<!-- page script -->
<script>
    $(".preloader").fadeOut("slow");
    var arraydatacode = [];
    var arraydataid = [];
    var datajs = {!! json_encode($datashift->toArray()) !!};
    var sizeshift = Object.keys(datajs).length;
    var arraycode = ['codemonday','codetuesday','codewednesday','codethursday','codefriday','codesaturday','codesunday'];
    var arrayshift = ['shiftmonday','shifttuesday','shiftwednesday','shiftthursday','shiftfriday','shiftsaturday','shiftsunday'];
    var arrayhour = ['hourmonday','hourtuesday','hourwednesday','hourthursday','hourfriday','hoursaturday','hoursunday'];
    var arrayid = ['idmonday','idtuesday','idwednesday','idthursday','idfriday','idsaturday','idsunday'];

function datashift(id){
    var totaltimework=0;

    for( a=0;a<7;a++)
    {
        joincode = arraycode[a].concat(id);
        joinshift = arrayshift[a].concat(id);
        joinhour = arrayhour[a].concat(id);
        joinwh = 'workinghour'.concat(id);
        shift = $('#'+joincode).val();
        if (shift) {
            shift = shift.toUpperCase(shift);
        }
        timework = 0;
        for(b=0;b<sizeshift;b++)
        {
            if(shift==datajs[b]['codeshift']){
                timework = datajs[b]['workinghour'];
                shiftstart = datajs[b]['startshift'];
                shiftend = datajs[b]['endshift'];
                shiftstart = shiftstart.substr(0,5);
                shiftend = shiftend.substr(0,5);
                shift=shiftstart.concat(' - ',shiftend);
                break;
            }
            else if(shift=="AL"){
                shift="Cuti";
            }
            else if(shift=="EO"){
                shift="Extra Off";
            }
        }

        $('#'+joinshift).html(shift);
        $('#'+joinhour).html(timework);

        hour = $('#'+joinhour).html();
        totaltimework = totaltimework+parseInt(hour);
        $('#'+joinwh).html(totaltimework+ " Hour");

    }

}

function lockschedule(){
    rowschedule = document.getElementById("ScheduleDatatable").rows.length - 1;
    for (c=0;c<rowschedule;c++)
    {
        for(d=0;d<7;d++)
        {
            joincode = arraycode[d].concat(c);
            shift = $('#'+joincode).val();
            if (shift) {
            shift = shift.toUpperCase(shift);
            }
            for(h=0;h<sizeshift;h++)
            {
                if(shift==datajs[h]['codeshift']){
                    $('#'+joincode).attr("readonly",true);
                    document.getElementById(joincode).className = "form-control form-control-sm is-valid input-uppercase";
                    break;
                }
                else if(shift==''){
                    $('#'+joincode).removeAttr("readonly");
                    document.getElementById(joincode).className = "form-control form-control-sm is-warning input-uppercase";
                }
                else {
                    $('#'+joincode).removeAttr("readonly");
                    document.getElementById(joincode).className = "form-control form-control-sm is-invalid input-uppercase";
                }
            }
        }
    }

}

function editschedule(id){
    for( e=0;e<7;e++)
    {
        joincode = arraycode[e].concat(id);
        $('#'+joincode).removeAttr("readonly");
        document.getElementById(joincode).className = "form-control form-control-sm is-warning input-uppercase";
    }
}

function  toastschedule(){
    $(document).Toasts('create', {
        class: 'bg-secondary',
        position: 'topLeft',
        title: 'Schedule',
        autohide: true,
        delay: 2000,
        body: 'Please enter a Date and Position in column schedule page.',
        subtitle: 'validate',
        icon: 'fas fa-envelope fa-calendar-alt'
    })
}


function  showschedule(){
    rowschedule = document.getElementById("ScheduleDatatable").rows.length -1;
    row = 0;
    for( f=0;f<rowschedule;f++)
    {
        for( g=0;g<arraycode.length;g++)
        {
            $('#'+arraycode[g]+''+f).val(arraydatacode[row]);
            $('#'+arrayid[g]+''+f).val(arraydataid[row]);
            row++;
        }
    }
}


function createschedule(){
    document.getElementById("schedulebox").removeAttribute("style");
    var position = $('#positionselect').val();
    var week = $('#weekinput').val();
    var date = $('#dateinput').val();
    rowschedule = document.getElementById("ScheduleDatatable").rows.length -1;
    arraydatacode = [];
    arraydataid = [];
    $('#dateinput').attr("readonly",true);
    $('#positionselect').prop("disabled", true);
    $('#dateinput').prop("disabled", true);
    $('#positionhidden').val(position);

    $.ajax({
        url: "{{ route('schedule.create') }}",
        type: "GET",
        data: {'position': position , 'week': week},
        // processData: false,
        // contentType: false,
        success: function (data) {
            $('#labelname').html("Schedule : " + position);
            $('#labelweek').html("Week : " + week);

            for( i=1;i<=7;i++)
            {
                if(i==1){
                    var day = new Date(date);
                }
                else{
                    day = new Date(day);
                    day.setDate(day.getDate()+1);
                }
                formatday = moment(day).format('dddd DD-MM-YYYY');
                $('#day'+i).html(formatday);
            }

            var startdate = $('#day1').html();
            var enddate = $('#day7').html();
            $('#labeldate').html("Date : "+startdate+" - "+enddate);

            data.datacashier.forEach(function(cashier, list){
                //console.log(cashier + ' - ' + list);
                $('#bodytable').append("<tr>"+
                "<td>"+cashier.employee+" - "+cashier.fullname+"</td>"+

                "<td><input type='text' class='form-control form-control-sm input-uppercase' id='codemonday"+list+"' name='codemonday"+list+"' onkeyup='datashift("+list+")'>"+
                "<h6 id='shiftmonday"+list+"' name='shiftmonday"+list+"' align='center'></h6>"+
                "<h6 id='hourmonday"+list+"' name='hourmonday"+list+"' align='center'></h6><input type='hidden' name='idmonday"+list+"' id='idmonday"+list+"'></td>"+

                "<td><input type='text' class='form-control form-control-sm input-uppercase' id='codetuesday"+list+"' name='codetuesday"+list+"' onkeyup='datashift("+list+")'>"+
                "<h6 id='shifttuesday"+list+"' name='shifttuesday"+list+"' align='center'></h6>"+
                "<h6 id='hourtuesday"+list+"' name='hourtuesday"+list+"' align='center'></h6><input type='hidden' name='idtuesday"+list+"' id='idtuesday"+list+"'></td>"+

                "<td><input type='text' class='form-control form-control-sm input-uppercase' id='codewednesday"+list+"' name='codewednesday"+list+"' onkeyup='datashift("+list+")'>"+
                "<h6 id='shiftwednesday"+list+"' name='shiftwednesday"+list+"' align='center'></h6>"+
                "<h6 id='hourwednesday"+list+"' name='hourwednesday"+list+"' align='center'></h6><input type='hidden' name='idwednesday"+list+"' id='idwednesday"+list+"'></td>"+

                "<td><input type='text' class='form-control form-control-sm input-uppercase' id='codethursday"+list+"' name='codethursday"+list+"' onkeyup='datashift("+list+")'>"+
                "<h6 id='shiftthursday"+list+"' name='shiftthursday"+list+"' align='center'></h6>"+
                "<h6 id='hourthursday"+list+"' name='hourthursday"+list+"' align='center'></h6><input type='hidden' name='idthursday"+list+"' id='idthursday"+list+"'></td>"+

                "<td><input type='text' class='form-control form-control-sm input-uppercase' id='codefriday"+list+"' name='codefriday"+list+"' onkeyup='datashift("+list+")'>"+
                "<h6 id='shiftfriday"+list+"' name='shiftfriday"+list+"' align='center'></h6>"+
                "<h6 id='hourfriday"+list+"' name='hourfriday"+list+"' align='center'></h6><input type='hidden' name='idfriday"+list+"' id='idfriday"+list+"'></td>"+

                "<td><input type='text' class='form-control form-control-sm input-uppercase' id='codesaturday"+list+"' name='codesaturday"+list+"' onkeyup='datashift("+list+")'>"+
                "<h6 id='shiftsaturday"+list+"' name='shiftsaturday"+list+"' align='center'></h6>"+
                "<h6 id='hoursaturday"+list+"' name='hoursaturday"+list+"' align='center'></h6><input type='hidden' name='idsaturday"+list+"' id='idsaturday"+list+"'></td>"+

                "<td><input type='text' class='form-control form-control-sm input-uppercase' id='codesunday"+list+"' name='codesunday"+list+"' onkeyup='datashift("+list+")'>"+
                "<h6 id='shiftsunday"+list+"' name='shiftsunday"+list+"' align='center'></h6>"+
                "<h6 id='hoursunday"+list+"' name='hoursunday"+list+"' align='center'></h6><input type='hidden' name='idsunday"+list+"' id='idsunday"+list+"'></td>"+

                "<td><h6 id='workinghour"+list+"' name='workinghour"+list+"' align='center'></h6></td>"+
                "<td><div class='btn-group'>"+
                        "<button type='button' class='btn btn-secondary dropdown-toggle' data-toggle='dropdown'><i class='fas fa-wrench'></i> </button>"+
                        "<div class='dropdown-menu dropdown-menu-right' role='menu'>"+
                            "<a class='createform dropdown-item' id="+list+" onclick='lockschedule("+list+")'><i class='fas fa-desktop'></i> Lock</a>"+
                            "<a class='editform dropdown-item' id="+list+"  onclick='editschedule("+list+")'><i class='fas fa-edit'></i> Edit</a>"+
                            "<a class='deleteform dropdown-item' id="+list+"><i class='fas fa-trash'></i> Delete</a>"+
                        "</div>"+
                    "</div>"+
                "</td></tr>");
            })
            data.dataschedule.forEach(function(schedule, list){
                arraydatacode.push(schedule.shift.codeshift);
                arraydataid.push(schedule.id);
            })
            showschedule();
            lockschedule();
            for (i=0;i<rowschedule;i++)
            {
                datashift(i);
            }

        },
            error: function (data) {
                console.log('Error nya adalah:', data);
            }
    });
}

    $(document).ready(function() {
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        var arrayerror = ['tidedc','midedc','ipaddress','counter_id','connection','simcard','type','status'];

        $(document).on('click', '#resetschedule', function () {
            $('#schedulebox').attr("style", "display: none;");
            $('#dateinput').removeAttr("readonly");
            $('#dateinput').prop("disabled", false).val('').trigger('change');
            $('#positionselect').prop("disabled", false).val('').trigger('change');
            $('#scheduleform').trigger("reset");
            $('#bodytable').html("");
        });

        $(document).on('click', '#backschedule', function () {
            var day = new Date($('#dateinput').val());
            day.setDate(day.getDate()-7);
            formatday = moment(day).format('MM/DD/YYYY');
            $('#dateinput').val(formatday);
            $('#weekinput').val($.datepicker.iso8601Week(new Date(formatday)));
            $('#bodytable').html("");
            createschedule();
        });

        $(document).on('click', '#nextschedule', function () {
            var day = new Date($('#dateinput').val());
            day.setDate(day.getDate()+7);
            formatday = moment(day).format('MM/DD/YYYY');
            $('#dateinput').val(formatday);
            $('#weekinput').val($.datepicker.iso8601Week(new Date(formatday)));
            $('#bodytable').html("");
            createschedule();
        });

        $(document).on('click', '#showschedule', function () {
            $('#bodytable').html("");
            $('#validatedate').html("");
            document.getElementById('dateinput').className = "form-control";
            $('#validateposition').html("");
            var position = $('#positionselect').val();
            var date = $('#dateinput').val();
            if (position =='' && date ==''){
                toastschedule();
                // $('#validatedate').append('<div class="text-danger mt-2">Please enter a date</div>');
                // $('#validateposition').append('<div class="text-danger mt-2">Please enter a position</div>');
                document.getElementById('dateinput').className = "form-control is-invalid";
            }
            else if (date =='' || position ==''){
                toastschedule();
                // $('#validatedate').append('<div class="text-danger mt-2">Please enter a date</div>');
                // document.getElementById('dateinput').className = "form-control is-invalid";
                //document.getElementById('positionselect').className = "form-control is-invalid select2";
            }
            else {
                createschedule();
            }

        });

        $(document).on('click', '.deleteform', function () {
            var cashierid = $(this).attr('id');
            swal.fire({
                title: "Are you sure?",
                text: "You will change the employee status to Inactive!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, save!",
                cancelButtonText: "No, cancel!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                url:"cashier/"+cashierid,
                type: "PATCH",
                success:function(data){
                    createschedule();
                    swal.fire("Deleted!", "Your employee status has been Inactive.", "success")
                }
                });
                } else {
                    swal.fire("Cancelled", "Your employee status  is Active :)", "error");
                }
            });

        });

        $(document).keypress(
            function(event){
            if (event.which == '13') {
                event.preventDefault();
                return false;
            }
        });

        $('#saveschedule').click(function (e) {
            e.preventDefault();
            swal.fire({
                title: "Are you sure?",
                text: "You will Save Schedule the employee!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#007bff",
                confirmButtonText: "Yes, save!",
                cancelButtonText: "No, cancel!"
            }).then((result) => {
                if (result.value) {
                    lockschedule();
                    var cellschedule= $('.input-uppercase').length;
                    console.log(cellschedule);
                    // for (k=0;k<cellschedule;k++)
                    //     {
                            if ($('.input-uppercase').hasClass('is-invalid')|| $('.input-uppercase').hasClass('is-warning'))
                            {
                                swal.fire("Cancelled", "Please check Your Schedule", "error");
                            } else {
                                $.ajax({
                                    data: $('#scheduleform').serialize(),
                                    url: "{{ route('schedule.store') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    success:function(data){
                                    swal.fire("Good job!",data["success"], "success")
                                    },
                                    error: function (data) {
                                        console.log('Errornya adalah:', data);
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
                            }
                        // }
                } else {
                    swal.fire("Cancelled", "Your Schedule  status have not save :)", "error");
                }
            });
        });

        //Date picker
        $('#dateinput').datepicker({
            onSelect: function (dateText, inst) {
            $('#weekinput').val($.datepicker.iso8601Week(new Date(dateText)));
            },
            showWeek: true,
            firstDay: 1,
            showOtherMonths: true,
            selectOtherMonths: true,
            changeMonth: true,
            changeYear: true,
            beforeShowDay: onlymonday
        });
        function onlymonday(date){
        if (date.getDay() === 1)  /* Monday */
            return [ true, "", "" ]
        else
            return [ false, "closed", "Closed on Monday" ]
        }

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
