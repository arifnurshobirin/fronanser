@extends('layouts.app')
@section('title page','Cashier Page')
@section('title tab','Cashier')


@section('css')
<!-- Tempusdominus Bbootstrap 4 -->
<link href="{{ asset('dashboard/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet">
<!-- datepicker jquery -->
<link href="{{ asset('dashboard/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
<link href="{{ asset('dashboard/plugins/jquery-ui/jquery-ui.theme.min.css') }}" rel="stylesheet">
<!-- Page CSS -->
@endsection

@section('content')
<!-- Main content -->
<section class="content" id="contentpage">
    <!-- Default box -->
    <div class="card card-danger card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-user"></i> Cashier DataTable</h3>
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
                    id="CashierDatatable" style="width:100%">
                    <thead class="bg-danger">
                        <tr>
                            <th><button type="button" name="cashiermoredelete" id="cashiermoredelete"
                                    class="btn btn-secondary btn-sm">
                                    <i class="fas fa-times"></i><span></span>
                                </button></th>
                            <th></th>
                            <th>Avatar</th>
                            <th>Employee</th>
                            <th>Full Name</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    {{-- <tfoot class="bg-danger">
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Avatar</th>
                            <th>Employee</th>
                            <th>Full Name</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </tfoot> --}}
                </table>
            </div>
            <!-- Create Table -->
            <div class="modal fade" id="modalcashier" data-backdrop="static" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modalheading"></h4>
                            <button type="button" class="btn btn-secondary" id="resetmodal" data-dismiss="modal"><i class='fas fa-times'></i> Close</button>
                        </div>
                        <div class="modal-body">
                            <form method="post" id="formcashier" name="formcashier" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" id="cashierid" value="">
                                <label for="idcard">Id Card</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="idcard" name="idcard" class="form-control"
                                            placeholder="Enter your Full Name">
                                    </div>
                                    <div id="erroridcard"></div>
                                </div>
                                <label for="emp">Employee</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-id-badge"></i></span>
                                        </div>
                                        <input type="text" id="employee" name="employee" class="form-control">
                                    </div>
                                    <div id="erroremployee"></div>
                                </div>
                                <label for="fullname">Full Name</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" id="fullname" name="fullname" class="form-control"
                                            placeholder="Enter your Full Name">
                                    </div>
                                    <div id="errorfullname"></div>
                                </div>
                                <label for="birth">Date Of Birth</label>
                                <div class="form-group">
                                    <div class="input-group" id="datetimepicker1" data-target-input="nearest">
                                        <div class="input-group-prepend" data-target="#datetimepicker1"
                                            data-toggle="datetimepicker">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" id="dateofbirth" name="dateofbirth"
                                            class="form-control datetimepicker-input" data-target="#datetimepicker1"
                                            placeholder="dd/mm/yyyy">
                                    </div>
                                    <div id="errordateofbirth"></div>
                                </div>
                                <label for="address">Address</label>
                                <div class="input-group">
                                    <div class="form-line">
                                        <textarea rows="2" id="address" name="address" class="form-control no-resize"
                                            placeholder="Please input your Address..."></textarea>
                                    </div>
                                    <div id="erroraddress"></div>
                                </div>
                                <label for="phone">Phone Number</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                        </div>
                                        <input type="text" id="phonenumber" name="phonenumber" class="form-control">
                                    </div>
                                    <div id="errorphonenumber"></div>
                                </div>
                                <label for="position">Position</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="custom-select" id="position" name="position">
                                            <option value="">-- Please select --</option>
                                            <option value="Cashier">Cashier</option>
                                            <option value="Customer Service">Customer Service</option>
                                            <option value="TDR">TDR</option>
                                            <option value="Senior Cashier">Senior Cashier</option>
                                            <option value="Cashier Head">Cashier Head</option>
                                        </select>
                                    </div>
                                    <div id="errorposition"></div>
                                </div>
                                <label for="join">Join Date</label>
                                <div class="form-group">
                                    <div class="input-group" id="datetimepicker2" data-target-input="nearest">
                                        <div class="input-group-prepend" data-target="#datetimepicker2"
                                            data-toggle="datetimepicker">
                                            <span class="input-group-text">
                                                <i class="far fa-calendar-alt"></i>
                                            </span>
                                        </div>
                                        <input type="text" id="joindate" name="joindate"
                                            class="form-control datetimepicker-input" data-target="#datetimepicker2"
                                            placeholder="dd/mm/yyyy">
                                    </div>
                                    <div id="errorjoindate"></div>
                                </div>
                                    <label for="position">Status</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <select class="custom-select" id="status" name="status">
                                                <option value="">-- Please select --</option>
                                                <option value="Active">Active</option>
                                                <option value="Inactive">Inactive</option>
                                            </select>
                                        </div>
                                        <div id="errorstatus"></div>
                                    </div>
                                    <label for="image">Select Profile Image</label>
                                    <div class="form-group">
                                        <div class="form-line">
                                            <input type="file" id="avatar" name="avatar" class="form-control">
                                        </div>
                                        <div id="erroravatar"></div>
                                    </div>
                                    <button type="submit" class="btn btn-primary m-t-15" id="savecashier">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Create Table -->
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
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('dashboard/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- page script -->
@endsection

@push('scripts')
@error('status')
<script>
    $('#modalcashier').modal('show');
</script>
@enderror
<script>
    $(".preloader").fadeOut("slow");
function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>Full name:</td>'+
            '<td>'+d.idcard+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Extension number:</td>'+
            '<td>'+d.address+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Extra info:</td>'+
            '<td>And any further details here (images etc)...</td>'+
        '</tr>'+
    '</table>';
}
    $(document).ready(function() {
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var arrayerror = ['idcard','employee','fullname','dateofbirth','address','phonenumber','position','joindate','avatar','status'];

            var table = $('#CashierDatatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
            url:"{{ route('cashier.datatable') }}",
            },
            "order": [[ 3, "asc" ]],
            columns: [
                { data: 'checkbox', name: 'checkbox', orderable:false, searchable: false},
                {
                "className":      'details-control',
                "orderable":      false,
                "searchable":     false,
                "data":           null,
                "defaultContent": ''
                },
                {
                    "render": function (data, type, JsonResultRow, meta) {
                        return '<img src="../../dashboard/img/'+JsonResultRow.avatar+'" class="avatar" width="50" height="50">';
                    }
                },
                { data: 'employee', name: 'employee' },
                { data: 'fullname', name: 'fullname' },
                { data: 'position', name: 'position' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false}
            ],
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
                        buttons:[ 'copy', 'csv', 'excel', 'pdf', 'print' ]
                    },
                    {
                        text: '<i class="fas fa-user-plus"></i><span> Add Cashier</span>',
                        className: 'btn btn-secondary',
                        action: function ( e, dt, node, config ) {
                            for( a=0;a<arrayerror.length;a++)
                            {
                                $('#error'+arrayerror[a]).html('');
                            }
                            $('#savecashier').val("create-cashier");
                            $('#savecashier').html('Save');
                            $('#cashierid').val('');
                            $('#formcashier').trigger("reset");
                            $('#modalheading').html("Create New Cashier");
                            $('#modalcashier').modal('show');
                        }
                    }
                ]
        });

         // Add event listener for opening and closing details
        $('#CashierDatatable').on('click', 'td.details-control', function () {
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

        $('#formcashier').on("submit",function (event) {
            event.preventDefault();
            $('#savecashier').html('Sending..');
            var formdata = new FormData($(this)[0]);
            $.ajax({
                data: formdata,
                url: "{{ route('cashier.store') }}",
                type: "POST",
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function (data) {

                    $('#formcashier').trigger("reset");
                    $('#modalcashier').modal('hide');
                    $('#savecashier').html('Save');
                    table.draw();
                    swal.fire("Good job!", "You success update Cashier!", "success");
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#savecashier').html('Save Changes');
                    for( a=0;a<arrayerror.length;a++)
                    {
                        $('#error'+arrayerror[a]).html('');
                    }
                    $.each(data.responseJSON.errors, function(key,value) {
                        $('#error'+key).append('<div class="text-danger mt-2">'+value+'</div');
                    });
                }
            });
        });


        $(document).on('click', '.cashieredit', function () {
            var cashierid = $(this).attr('id');
            $.get("{{ route('cashier.index') }}" +'/' + cashierid +'/edit', function (data)
            {
                for( a=0;a<arrayerror.length;a++)
                    {
                        $('#error'+arrayerror[a]).html('');
                    }
                $('#modalheading').html("Edit Data Cashier");
                $('#savecashier').html('Save Changes');
                $('#modalcashier').modal('show');
                $('#cashierid').val(data.id);
                $('#idcard').val(data.idcard);
                $('#employee').val(data.employee);
                $('#fullname').val(data.fullname);
                $('#dateofbirth').val(data.dateofbirth);
                $('#address').val(data.address);
                $('#phonenumber').val(data.phonenumber);
                $('#position').val(data.position);
                $('#joindate').val(data.joindate);
                $('#status').val(data.status);
            })
        });

        $(document).on('click', '.cashiershow', function () {
            var id = $(this).attr('id');
                $('#contentpage').load('cashier'+'/'+id);
        });

            var cashierid;
            $(document).on('click', '.cashierdelete', function(){
            cashierid = $(this).attr('id');
            swal.fire({
                title: "Are you sure?",
                text: "You will not be able to recover this cashier file!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete!",
                cancelButtonText: "No, cancel!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                url:"cashier/"+cashierid,
                type: "DELETE",
                success:function(data){
                    swal.fire("Deleted!", "Your Cashier file has been deleted.", "success")
                    $('#CashierDatatable').DataTable().ajax.reload();
                }
                });
                } else {
                    swal.fire("Cancelled", "Your Cashier file is safe :)", "error");
                }
            });
        });

        $(document).on('click', '#cashiermoredelete', function(){
            var id = [];
            swal.fire({
                title: "Are you sure?",
                text: "You will not be able to recover this Cashier file!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete!",
                cancelButtonText: "No, cancel!"
            }).then((result) => {
                if (result.value) {
                    $('.cashiercheckbox:checked').each(function(){
                        id.push($(this).val());
                    });
                    if(id.length > 0)
                    {
                        $.ajax({
                        url:"{{ route('cashier.moredelete')}}",
                        method:"get",
                        data:{id:id},
                        success:function(data){
                        swal.fire("Deleted!", "Your Cashier file has been deleted.", "success")
                        $('#CashierDatatable').DataTable().ajax.reload();
                            }
                        });
                    }
                    else
                    {swal.fire("Please select atleast one checkbox");}
                }
                else
                {swal.fire("Cancelled", "Your Cashier file is safe :)", "error");}
                });
            });


        $('#datetimepicker1').datetimepicker({
                    format: 'L'
                });
        $('#datetimepicker2').datetimepicker({
                    format: 'L'
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

    });

</script>
@endpush
