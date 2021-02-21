@extends('layouts.app')
@section('title page','Counter Page')
@section('title tab','Counter')


@section('css')
<!-- Page CSS -->
@endsection

@section('content')
<!-- Main content -->
<section class="content" id="contentpage">
    <!-- Default box -->
    <div class="card card-danger card-outline">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-box"></i> Counter DataTable</h3>
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
                    id="CounterDatatable" style="width:100%">
                    <thead class="bg-danger">
                        <tr>
                            <th><button type="button" name="countermoredelete" id="countermoredelete"
                                    class="btn btn-secondary btn-sm">
                                    <i class="fas fa-times"></i><span></span>
                                </button></th>
                            <th></th>
                            <th>No Counter</th>
                            <th>Ip Address</th>
                            <th>Mac Address</th>
                            <th>Type Counter</th>
                            <th>Status Counter</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot class="bg-danger">
                        <tr>
                            <th></th>
                            <th></th>
                            <th>No Counter</th>
                            <th>Ip Address</th>
                            <th>Mac Address</th>
                            <th>Type Counter</th>
                            <th>Status Counter</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Create Table -->
            <div class="modal fade" id="countermodal"  data-backdrop="static" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modelHeading">Create Counter</h4>
                            <button type="button" class="btn btn-secondary" id="resetmodal" data-dismiss="modal"><i class='fas fa-times'></i> Close</button>
                        </div>
                        <div class="modal-body">
                            <form method="post" id="formcounter" name="formcounter">
                                @csrf
                                <input type="hidden" name="id" id="counterid">
                                <label for="nopos">No Counter</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="number" id="nocounter" name="nocounter" class="form-control" placeholder="Enter your No Counter">
                                    </div>
                                    <div id="errornocounter"></div>
                                </div>
                                <label for="ip">Ip Address</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control ip" id="ipaddress" name="ipaddress"
                                            placeholder="Enter your Ip Address">
                                    </div>
                                    <div id="erroripaddress"></div>
                                </div>
                                <label for="mac">Mac Address</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="text" class="form-control" id="macaddress" name="macaddress"
                                            placeholder="Enter your Mac Address">
                                    </div>
                                    <div id="errormacaddress"></div>
                                </div>
                                <label for="type">Type Counter</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="custom-select" id="type" name="type">
                                            <option value="">-- Please select --</option>
                                            <option value="Regular">Regular</option>
                                            <option value="SaladBar">SaladBar</option>
                                            <option value="Milk">Milk</option>
                                            <option value="Wine">Wine</option>
                                            <option value="Deptstore">Deptstore</option>
                                            <option value="Electronic">Electronic</option>
                                            <option value="TransHello">TransHello</option>
                                            <option value="Homedel">Homedel</option>
                                            <option value="Cigarette">Cigarette</option>
                                            <option value="TransLiving">TransLiving</option>
                                            <option value="TransHardware">TransHardware</option>
                                            <option value="Bakery">Bakery</option>
                                            <option value="Dokar">Dokar</option>
                                            <option value="Canvasing">Canvasing</option>
                                            <option value="Backup">Backup</option>
                                        </select>
                                    </div>
                                    <div id="errortype"></div>
                                </div>

                                <label for="type">Status Counter</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select class="custom-select" id="status" name="status">
                                            <option value="">-- Please select --</option>
                                            <option value="Queueing">Queueing</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                            <option value="Broken">Broken</option>
                                        </select>
                                    </div>
                                    <div id="errorstatus"></div>
                                </div>

                                <button type="button" class="btn btn-primary" id="savebutton" value="create">Save</button>
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
    $('#countermodal').modal('show');
</script>
@enderror
<script>
    $(".preloader").fadeOut("slow");
    function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td>type Counter:</td>'+
            '<td>'+d.type+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td>Status :</td>'+
            '<td>'+d.status+'</td>'+
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
            var arrayerror = ['nocounter','ipaddress','macaddress','type','status'];

        var table = $('#CounterDatatable').DataTable({
        processing: true,
        serverSide: true,
        "responsive": true,
        paging: true,
        ajax: { url:"{{ route('counter.datatable') }}",},
        "order": [[ 2, "asc" ]],
        columns: [
            { data: 'checkbox', name: 'checkbox', orderable:false, searchable: false},
            {
                "className":      'details-control',
                "orderable":      false,
                "searchable":     false,
                "data":           null,
                "defaultContent": ''
            },
            { data: 'nocounter', name: 'nocounter' },
            { data: 'ipaddress', name: 'ipaddress' },
            { data: 'macaddress', name: 'macaddress' },
            { data: 'type', name: 'type' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action', orderable: false,searchable: false}
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
                            buttons:[ 'copy', 'csv', 'excel', 'pdf', 'print']
                        },
                        {
                            text: '<i class="fas fa-plus"></i><span> Add Counter</span>',
                            className: 'btn btn-secondary',
                            action: function ( e, dt, node, config ) {
                                for( a=0;a<arrayerror.length;a++)
                            {
                                $('#error'+arrayerror[a]).html('');
                            }
                                $('#countersave').val("create Counter");
                                $('#countersave').html('Save');
                                $('#counterid').val('');
                                $('#formcounter').trigger("reset");
                                $('#modelHeading').html("Create New Counter");
                                $('#countermodal').modal('show');
                            }
                        }
                    ]
        });

        // Add event listener for opening and closing details
        $('#CounterDatatable').on('click', 'td.details-control', function () {
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

        $('#savebutton').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');
            $.ajax({
                data: $('#formcounter').serialize(),
                url: "{{ route('counter.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {

                    $('#formcounter').trigger("reset");
                    $('#countermodal').modal('hide');
                    $('#possave').html('Save');
                    table.draw();
                    swal.fire("Good job!", "You success update Counter!", "success");
                },
                error: function (data) {
                    console.log('Error nya apa:', data);
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

        $(document).on('click', '.counteredit', function () {
            var counterid = $(this).attr('id');
            $.get("{{ route('counter.index') }}" +'/' + counterid +'/edit', function (data)
            {
                $('#modelHeading').html("Edit Data Counter");
                $('#countersave').val("edit-counter");
                $('#countersave').html('Save Changes');
                $('#countermodal').modal('show');
                $('#counterid').val(data.id);
                $('#nocounter').val(data.nocounter);
                $('#ipaddress').val(data.ipaddress);
                $('#macaddress').val(data.macaddress);
                $('#typecounter').val(data.type);
                $('#status').val(data.status);
            })
        });

        $(document).on('click', '.countershow', function () {
            var id = $(this).attr('id');
                $('#contentpage').load('counter'+'/'+id);
        });

        $(document).on('click', '.counterdelete', function(){
            var counterid = $(this).attr('id');
            swal.fire({
                title: "Are you sure?",
                text: "You will not be able to recover this Counter file!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete!",
                cancelButtonText: "No, cancel!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                url:"counter/"+counterid,
                type: "DELETE",
                success:function(data){
                    swal.fire("Deleted!", "Your Counter file has been deleted.", "success")
                    $('#CounterDatatable').DataTable().ajax.reload();
                }
                });
                } else {
                    swal.fire("Cancelled", "Your Counter file is safe :)", "error");
                }
            });
        });

        $(document).on('click', '#countermoredelete', function(){
            var id = [];
            swal.fire({
                title: "Are you sure?",
                text: "You will not be able to recover this Counter file!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete!",
                cancelButtonText: "No, cancel!"
            }).then((result) => {
                if (result.value) {
                    $('.countercheckbox:checked').each(function(){
                        id.push($(this).val());
                    });
                    if(id.length > 0)
                    {
                        $.ajax({
                        url:"{{ route('counter.moredelete')}}",
                        method:"get",
                        data:{id:id},
                        success:function(data){
                        swal.fire("Good job!", "You success delete Counter!", "success");
                        $('#CounterDatatable').DataTable().ajax.reload();
                            }
                        });
                    }
                    else
                    {swal.fire("Please select atleast one checkbox");}
                }
                else
                swal.fire("Cancelled", "Your Counter file is safe :)", "error");
            });
        });

    });
</script>
@endpush
