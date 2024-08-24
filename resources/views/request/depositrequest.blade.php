@extends('layout.app')
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Deposit History</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                        <li class="breadcrumb-item active">Deposit History</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->



    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p class="card-title">Deposit History</p>
                </div>
                <div class="card-body">


                    <div class="table-responsive">
                        <table id="deposit_table" class="table table-bordered  nowrap table-striped align-middle "
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Account Holder</th>
                                    <th>Account Number<small class="text-danger">*</small></th>
                                    <th>Deposit Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                               
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>



    <!-- staticBackdropApproved Modal -->
    <div class="modal fade" id="staticBackdropApproved" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop"
                        colors="primary:#121331,secondary:#08a88a" style="width:120px;height:120px">
                    </lord-icon>

                    <div class="mt-4">
                        <h4 class="mb-3">You've made it!</h4>
                        <p class="text-muted mb-4"> Now the User Has been Enabled For everyone.</p>
                        <div class="hstack gap-2 justify-content-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- First modal dialog -->
    <div class="modal fade" id="RejectRequest" aria-hidden="true" aria-labelledby="..." tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop"
                        colors="primary:#f7b84b,secondary:#405189" style="width:130px;height:130px">
                    </lord-icon>
                    <div class="mt-4 pt-4">
                        <h4>You've made it!</h4>
                        <p class="text-muted"> Now the User Has been disabled For everyone.. the email of the recipient was
                            send.</p>
                        <!-- Toogle to second dialog -->
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- Toggle Between Modals -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#deposit_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/admin/deposit/index",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'user',
                    name: 'user',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'accountholder',
                    name: 'accountholder',
                    orderable: true,
                    searchable: true
                },
                {
                    data: 'accountnumber',
                    name: 'accountnumber',
                    orderable: true,
                    searchable: true
                },
                
                {
                    data: 'depositamount',
                    name: 'depositamount',
                    render: function(data, type, full, meta) {
                        return "PKR" + data;
                    },
                    orderable: true,
                    searchable: true
                },

                {
                    
                    data: 'updated_at',
                    name: 'updated_at',
                    orderable: true,
                    searchable: true
                },
                {
                    
                    data: 'status',
                    name: 'status',
                    orderable: true,
                    searchable: true
                },
                
            ]
        });
    });
</script>
