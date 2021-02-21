@extends('layouts.app')
@section('title page','Chronology Page')
@section('title tab','Chronology')


@section('css')
<!-- Page CSS -->
@endsection

@section('content')
<!-- Main content -->
<section class="content" id="contentpage">
    <!-- Default box -->
    <div class="card card-danger card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-clipboard-list"></i> Chronology DataTable</h3>
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
                    <label id="labelname">Activity : Cashier Division</label><br>
                    <label id="labelweek">Week : {{ $today->format('W') }} </label><br>
                    <label id="labeldate">Date : {{ date('d-M-Y') }} </label>
                </div>
                <div class="col-md-4 text-center">
                    <button type="submit" name="saveschedule" id="saveschedule" class="btn btn-app bg-primary"><i class="fas fa-save"></i> Save Schedule</button>
                </div>
                <div class="col-md-4 text-right">
                    <button type="button" name="backschedule" id="backschedule" class="btn btn-secondary"><i class="fas fa-hand-point-left"></i> Back</button>
                    <button type="button" name="nextschedule" id="nextschedule" class="btn btn-secondary">Next <i class="fas fa-hand-point-right"></i></button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"><i class="fas fa-desktop"></i> Show</button>
                        <div class="dropdown-menu dropdown-menu-right" role="menu">
                            <a class="createform dropdown-item" onclick="lockschedule()"><i class="fas fa-desktop"></i> Lock</a>
                            <a class="editform dropdown-item"  onclick="editschedule()"><i class="fas fa-edit"></i> Edit</a>
                            <a class="deleteform dropdown-item"><i class="fas fa-trash"></i> Delete</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover dataTable js-exportable"
                    id="ChronolgyDatatable">
                    <thead class="bg-danger">
                        <tr>
                            <th></th>
                            <th>Employee Name</th>
                            <th>Position</th>
                            <th>Shift</th>
                            <th>Activity</th>
                            <th>Information</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <!-- Create Table -->
            <div class="modal fade" id="chronologymodal" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modelHeading"></h4>
                        </div>
                        <div class="modal-body">
                            <form method="post" id="picasso" name="picasso" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="picassoid" id="picassoid">
                                <label for="emp">Employee</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-id-badge"></i></span>
                                        </div>
                                        <input type="text" id="emp" name="emp" class="form-control"
                                            data-inputmask='"mask": "(999)"' data-mask required>
                                    </div>
                                </div>
                                <label for="fullname">Full Name</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="name" name="name" class="form-control"
                                            placeholder="Enter your Full Name" required>
                                    </div>
                                </div>
                                <label for="birth">Date Work</label>
                                <div class="form-group">
                                    <div class="input-group" id="datetimepicker1" data-target-input="nearest">
                                        <div class="input-group-prepend" data-target="#datetimepicker1"
                                            data-toggle="datetimepicker">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" id="date" name="date"
                                            class="form-control datetimepicker-input" data-target="#datetimepicker1"
                                            placeholder="dd/mm/yyyy">
                                    </div>
                                </div>
                                <label for="birth">Start Work</label>
                                <div class="form-group">
                                    <div class="input-group" id="datetimepicker2" data-target-input="nearest">
                                        <div class="input-group-prepend" data-target="#datetimepicker2"
                                            data-toggle="datetimepicker">
                                            <span class="input-group-text">
                                                <i class="far fa-clock"></i>
                                            </span>
                                        </div>
                                        <input type="text" id="start" name="start"
                                            class="form-control datetimepicker-input" data-target="#datetimepicker2"
                                            paceholder="Chosee Start Work">
                                    </div>
                                </div>
                                <label for="birth">End Work</label>
                                <div class="form-group">
                                    <div class="input-group" id="datetimepicker3" data-target-input="nearest">
                                        <div class="input-group-prepend" data-target="#datetimepicker3"
                                            data-toggle="datetimepicker">
                                            <span class="input-group-text">
                                                <i class="far fa-clock"></i>
                                            </span>
                                        </div>
                                        <input type="text" id="end" name="end" class="form-control datetimepicker-input"
                                            data-target="#datetimepicker3" paceholder="Chosee End Work">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary m-t-15 waves-effect" id="schedulesave"
                                    value="create">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Create Table -->

            <!-- modal picasso -->
            <div class="modal fade" id="modalpicasso" data-backdrop="static" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modalheadingpicasso"></h4>
                        </div>
                        <div class="modal-body">
                            <button type="button" name="createcodeshift" id="createcodeshift"
                                class="btn btn-success">Create Picasso</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable"
                                id="PicassoDatatable">
                                <thead>
                                    <tr>
                                        <th>Code Shift</th>
                                        <th>Start Shift</th>
                                        <th>End Shift</th>
                                        <th>Working Hour</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# modal picasso -->

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
<!-- page script -->
@endsection

@push('scripts')
@error('status')
<script>
    $('#modalchronolgy').modal('show');
</script>
@enderror
<script>
    $(".preloader").fadeOut("slow");
    function format ( d ) {
        // `d` is the original data object for the row
        return '<table  class="table-sm bg-danger">'+
            '<Thead>'+
            '<tr align="center" valign="center">'+
                '<th>Employee Name</th>'+
                '<th>In</th>'+
                '<th>Break</th>'+
                '<th>Back</th>'+
                '<th>Out</th>'+
                '<th>Action</th>'+
            '</tr>'+
            '<Thead>'+
            '<tr>'+
                '<td>'+d.cashier.fullname+'</td>'+
                '<td>14:00 in Reguler(19)</td>'+
                '<td>17:00 in Reguler(19)</td>'+
                '<td>18:00 in Reguler(21)</td>'+
                '<td>22:00 in Reguler(21)</td>'+
                '<td><button type="button" class="editchronology btn btn-secondary" id="'+d.id+'"><i class="fas fa-edit"></i> Edit</button></td>'+
            '</tr>'+
        '</table>';
    }
function  toastchronology(){
    $(document).Toasts('create', {
        class: 'bg-secondary',
        position: 'topLeft',
        title: 'Chronology',
        autohide: true,
        delay: 2000,
        body: 'Please enter a Counter in Activity Table .',
        subtitle: 'validate',
        icon: 'fas fa-envelope fa-calendar-alt'
    })
}
    $(document).ready(function() {
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        var arrayerror = ['tidedc','midedc','serialnumber','ipaddress','counter_id','connection','simcard','type','status'];

        var table = $('#ChronolgyDatatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {url:"{{ route('chronology.datatable') }}",},
        columns: [
            {
            "className":      'details-control',
            "orderable":      false,
            "searchable":     false,
            "data":           null,
            "defaultContent": ''
            },
            { data: 'EmployeeName', name: 'EmployeeName' },
            { data: 'cashier.position', name: 'cashier.position' },
            { data: 'time', name: 'time' },
            { data: 'activity', name: 'activity', orderable: false},
            { data: 'information', name: 'information', orderable: false},
            { data: 'action', name: 'action', orderable: false}
        ],
        responsive: true,
        order: [[ 3, "asc" ]],
        dom: 'Bfrtip',
        lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        buttons:['pageLength',
                {
                    collectionTitle: 'Visibility control',
                    extend: 'colvis',
                    collectionLayout: 'two-column'
                },
                {
                    extend: 'collection',
                    text: 'Export',
                    className: 'btn btn-secondary',
                    buttons:[ 'copy', 'csv', 'excel', 'pdf', 'print']
                },
                {
                    text: '<i class="fas fa-plus"></i><span> Picasso</span>',
                    className: 'btn btn-secondary',
                    action: function ( e, dt, node, config ) {
                        $('#schedulesave').val("create-Picasso");
                        $('#schedulesave').html('Save');
                        $('#scheduleid').val('');
                        $('#scheduleform').trigger("reset");
                        $('#modelHeading').html("Create New Picasso ");
                        $('#modalpicasso').modal('show');
                    }
                },
                {
                    text: '<i class="fas fa-calendar"></i><span> Code Shift</span>',
                    className: 'btn btn-secondary',
                    action: function ( e, dt, node, config ) {
                        $('#schedulesave').val("create-schedule");
                        $('#schedulesave').html('Save');
                        $('#scheduleid').val('');
                        $('#scheduleform').trigger("reset");
                        $('#modalheadingcodeshift').html("Daftar Shift Schedule");
                        $('#modalcodeshift').modal('show');
                    }
            }
            ]
        });


         // Add event listener for opening and closing details
        $('#ChronolgyDatatable').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row( tr );

            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( format(row.data()) ).show();
                tr.addClass('shown');
            }
        });

        $(document).on('click', '.statusbutton', function () {
            var scheduleid = $(this).attr('id');
            var status = $(this).attr('status');
            //var id =  $('#chronologyid'+scheduleid).val();
            var id;
            var counterid =  $('#chronologyselect'+scheduleid).val();
            var workingtime = new Date().toLocaleTimeString();
            var information =  $('#info'+scheduleid).val();
            if (!counterid) {
                toastchronology()
            } else {
                swal.fire({
                title: "Are you sure?",
                text: "You will fill attendance this Employee!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, save!",
                cancelButtonText: "No, cancel!"
                }).then((result) => {
                    if (result.value) {
                        formtag = {"id": id,"schedule_id": scheduleid,"counter_id": counterid,"status": status,"workingtime": workingtime,"information": information};
                        $.ajax({
                            data: formtag,
                            url:"{{ route('chronology.store') }}",
                            type: "POST",
                            dataType: 'json',
                            success:function(data){
                            swal.fire("Success!",data["success"], "success")
                            $('#ChronolgyDatatable').DataTable().ajax.reload();
                            }
                        });
                    } else {
                        swal.fire("Cancelled", "This employee has not filled in attendance", "error");
                    }
                });
            }
        });


        $(document).on('click', '.editchronology', function () {
            var scheduleid = $(this).attr('id');
            swal.fire({
                title: "Are you sure?",
                text: "You will fill attendance this Employee!",
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
                    swal.fire("Success!", "This employee has filled in attendance.", "success")
                }
                });
                } else {
                    swal.fire("Cancelled", "This employee has not filled in attendance", "error");
                }
            });
        });


        $(document).on('click', '.showschedule', function () {
            var id = $(this).attr('id');
                $('#contentpage').load('schedule'+'/'+id);
        });


        $('#scheduleform').on("submit",function (event) {
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
                    $('#chronologymodal').modal('hide');
                    $('#schedulesave').html('Save');
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#schedulesave').html('Save Changes');
                }
            });
        });

            var type;
            var schedule_id;
            $(document).on('click', '.js-sweetalert', function(){
            schedule_id = $(this).attr('id');
            var type = $(this).data('type');
            if (type === 'basic') {
                showBasicMessage();
            }
            else if (type === 'cancel') {
                showCancelMessage();
            }
        });


        function showCancelMessage() {
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this edc file!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete!",
                cancelButtonText: "No, cancel!",
                closeOnConfirm: false,
                closeOnCancel: false,
                showLoaderOnConfirm: true
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                url:"schedule/destroy/"+schedule_id,
                success:function(data){
                    swal("Deleted!", "Your Schedule file has been deleted.", "success")
                    $('#ChronolgyDatatable').DataTable().ajax.reload();
                }
                });
                } else {
                    swal("Cancelled", "Your Schedule file is safe :)", "error");
                }
            });
        }


        // $('#datetimepicker1').datetimepicker({
        //             format: 'L'
        //         });
        // $('#datetimepicker2').datetimepicker({
        //             format: 'LT'
        //         });
        // $('#datetimepicker3').datetimepicker({
        //             format: 'LT'
        //         });
        // $('[data-mask]').inputmask()

        // $('.datepicker').datepicker({
        //     format: 'dddd DD MMMM YYYY',
        //     clearButton: true,
        //     weekStart: 1,
        //     time: false
        // });

    });
</script>
@endpush
