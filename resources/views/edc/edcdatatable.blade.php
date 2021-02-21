@extends('layouts.app')
@section('title page','EDC Page')
@section('title tab','EDC')


@section('css')
<!-- Page CSS -->
@endsection

@section('content')
<!-- Main content -->
<section class="content" id="contentpage">
    <!-- Default box -->
        <div class="card card-danger card-outline">
            <div class="card-header">
                <h3 class="card-title"><i class="fas fa-fax"></i> EDC DataTable</h3>
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
                        id="EDCDatatable" style="width:100%">
                        <thead class="bg-danger">
                            <tr>
                                <th><button type="button" name="edcmoredelete" id="edcmoredelete" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times"></i><span></span>
                                </button></th>
                                <th></th>
                                <th>TID</th>
                                <th>No Counter</th>
                                <th>Connection</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
<!-- Create Table -->
<div class="modal fade" id="modaledc" data-backdrop="static"  aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modalheading"></h4>
                <button type="button" class="btn btn-secondary" id="resetmodal" data-dismiss="modal"><i class='fas fa-times'></i> Close</button>
            </div>
            <div class="modal-body">
                <form method="post" id="formedc" name="formedc">
                    {{-- action="/admin/edc/store" --}}
                    @csrf
                    <input type="hidden" name="id" id="edcid">
                    <label for="tid">TID EDC</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" id="tidedc" name="tidedc" class="form-control" placeholder="Enter your TID EDC">
                        </div>
                        <div id="errortidedc"></div>
                        {{-- @error('tidedc')
                            <div class="text-danger mt-2">
                            {{ $message }}
                            </div>
                        @enderror --}}
                    </div>
                    <label for="mid">MID EDC</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" id="midedc" name="midedc" class="form-control" placeholder="Enter your MID EDC">
                        </div>
                        <div id="errormidedc"></div>
                    </div>
                    <label for="ipaddress">IP Address</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" id="ipaddress" name="ipaddress" class="form-control" placeholder="Enter your IP Adress">
                        </div>
                        <div id="erroripaddress"></div>
                    </div>
                    <label for="serialnumber">Serial Number</label>
                    <div class="form-group">
                        <div class="form-line">
                            <input type="text" id="serialnumber" name="serialnumber" class="form-control" placeholder="Enter your Serial Number">
                        </div>
                        <div id="errorserialnumber"></div>
                    </div>
                    <label for="no">No Counter</label>
                    <div class="form-group">
                        <div class="form-line">
                            <select class="custom-select" id="selectnocounter" name="counter_id">
                                <option value="">-- Please select --</option>
                                @foreach($datacounter as $counter)
                                <option value="{{$counter->id}}">{{$counter->nocounter}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="errorcounter_id"></div>
                    </div>
                    <label for="connection">Connection</label>
                    <div class="form-group">
                        <div class="form-line">
                            <select class="custom-select" id="connection" name="connection">
                                <option value="">-- Please select --</option>
                                <option value="GPRS">GPRS</option>
                                <option value="LAN">LAN</option>
                            </select>
                        </div>
                        <div id="errorconnection"></div>
                    </div>
                    <label for="sim card">Sim Card</label>
                    <div class="form-group">
                        <div class="form-line">
                            <select class="custom-select" id="simcard" name="simcard">
                                <option value="">-- Please select --</option>
                                <option value="LAN">LAN</option>
                                <option value="Telkomsel">Telkomsel</option>
                                <option value="Indosat">Indosat</option>
                                <option value="XL">XL</option>
                            </select>
                        </div>
                        <div id="errorsimcard"></div>
                    </div>
                    <label for="typeedc">Type EDC</label>
                    <div class="form-group">
                        <div class="form-line">
                            <select class="custom-select" id="typeedc" name="type">
                                <option value="">-- Please select --</option>
                                <option value="WireCard">WireCard</option>
                                <option value="BCA">BCA</option>
                                <option value="Spots">Spots</option>
                                <option value="Mandiri">Mandiri</option>
                                <option value="CIMBNiaga">CIMBNiaga</option>
                            </select>
                        </div>
                        <div id="errortype"></div>
                    </div>
                    <label for="type">Status EDC</label>
                    <div class="form-group">
                        <div class="form-line">
                            <select class="custom-select" id="statusedc" name="status">
                                <option value="">-- Please select --</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                                <option value="Lock">Lock</option>
                                <option value="Broken">Broken</option>
                            </select>
                        </div>
                        <div id="errorstatus"></div>
                    </div>
                    <button type="button" class="btn btn-primary m-t-15" id="savebutton" value="create">Save</button>
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
<!-- page script -->
@endsection

@push('scripts')
@error('status')
<script>
    $('#modaledc').modal('show');
</script>
@enderror
<script>
    $(".preloader").fadeOut("slow");
    function format ( d ) {
        // `d` is the original data object for the row
        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
            '<tr>'+
                '<td>MID :</td>'+
                '<td>'+d.midedc+'</td>'+
            '</tr>'+
            '<tr>'+
                '<td>Sim Card :</td>'+
                '<td>'+d.simcard+'</td>'+
            '</tr>'+
            '<tr>'+
                '<td>IP Address:</td>'+
                '<td>'+d.ipaddress+'</td>'+
            '</tr>'+
            '<tr>'+
                '<td>Serial Number:</td>'+
                '<td>'+d.serialnumber+'</td>'+
            '</tr>'+
        '</table>';
    }
    $(document).ready(function() {
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

        var arrayerror = ['tidedc','midedc','serialnumber','ipaddress','counter_id','connection','simcard','type','status'];

        var table = $('#EDCDatatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {url:"{{ route('edc.datatable') }}"},
            responsive: true,
            columns: [
                { data: 'checkbox', name: 'checkbox', orderable:false, searchable: false},
                {
                "className":      'details-control',
                "orderable":      false,
                "searchable":     false,
                "data":           null,
                "defaultContent": ''
                },
                { data: 'tidedc', name: 'tidedc' },
                { data: 'counter.nocounter', name: 'counter.nocounter' },
                { data: 'connection', name: 'connection' },
                { data: 'type', name: 'type' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false,searchable: false}
            ],
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
                        text: '<i class="fas fa-plus"></i><span> Add EDC</span>',
                        className: 'btn btn-secondary',
                        action: function ( e, dt, node, config ) {
                            for( a=0;a<arrayerror.length;a++)
                            {
                                $('#error'+arrayerror[a]).html('');
                            }
                            $('#savebutton').val("create-edc");
                            $('#savebutton').html('Save');
                            $('#edcid').val('');
                            $('#formedc').trigger("reset");
                            $('#modalheading').html("Create New EDC");
                            $('#modaledc').modal('show');
                        }
                    }
                ]
        });

        // Add event listener for opening and closing details
        $('#EDCDatatable').on('click', 'td.details-control', function () {
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

        $(document).on('click', '.editedc', function () {
            var edcid = $(this).attr('id');
            $.get("{{ route('edc.index') }}" +'/' + edcid +'/edit', function (data)
            {
                for( a=0;a<arrayerror.length;a++)
                    {
                        $('#error'+arrayerror[a]).html('');
                    }
                $('#modalheading').html("Edit Data EDC");
                $('#savebutton').html('Save Changes');
                $('#modaledc').modal('show');
                $('#edcid').val(data.id);
                $('#tidedc').val(data.tidedc);
                $('#midedc').val(data.midedc);
                $('#ipaddress').val(data.ipaddress);
                $('#serialnumber').val(data.serialnumber);
                $('#connection').val(data.connection);
                $('#simcard').val(data.simcard);
                $('#typeedc').val(data.type);
                $('#statusedc').val(data.status);
                $('#selectnocounter').val(data.counter_id);
            })
        });

        $(document).on('click', '.edcshow', function () {
            var id = $(this).attr('id');
                $('#contentpage').load('edc'+'/'+id);
        });

        $('#savebutton').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');
            $.ajax({
                data: $('#formedc').serialize(),
                url: "{{ route('edc.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#formedc').trigger("reset");
                    $('#modaledc').modal('hide');
                    $('#savebutton').html('Save');
                    table.draw();
                    swal.fire("Good job!", "You success update EDC!", "success");
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#savebutton').html('Save Changes');
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

        var type;
        var edcid;
        $(document).on('click', '.deleteedc', function(){
            edcid = $(this).attr('id');
            swal.fire({
                title: "Are you sure?",
                text: "You will not be able to recover this edc file!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Save!",
                cancelButtonText: "No, cancel!",
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                url:"edc/"+edcid,
                type: "DELETE",
                success:function(data){
                    swal.fire("Deleted!", "Your edc file has been deleted.", "success")
                    $('#EDCDatatable').DataTable().ajax.reload();
                }
                });
                } else {
                    swal.fire("Cancelled", "Your edc file is safe :)", "error");
                }
            });
        });

        $(document).on('click', '#edcmoredelete', function(){
            var id = [];
            swal.fire({
                title: "Are you sure?",
                text: "You will not be able to recover this EDC file!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete!",
                cancelButtonText: "No, cancel!"
            }).then((result) => {
                if (result.value) {
                    $('.edccheckbox:checked').each(function(){
                        id.push($(this).val());
                    });
                    if(id.length > 0)
                    {
                        $.ajax({
                        url:"{{ route('edc.moredelete')}}",
                        method:"get",
                        data:{id:id},
                        success:function(data){
                        swal.fire("Deleted!", "Your EDC file has been deleted.", "success")
                        $('#EDCDatatable').DataTable().ajax.reload();
                            }
                        });
                    }
                    else
                    {swal.fire("Please select atleast one checkbox");}
                }
                else
                {swal.fire("Cancelled", "Your EDC file is safe :)", "error");}
                });
            });

    });
</script>
@endpush
