@extends('layout.app')
@section('content')

  <!-- start page title -->
  <div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">User Bank Details</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                    <li class="breadcrumb-item active">User Details</li>
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
                <p class="card-title">User Bank Details</p>
            </div>
            <div class="card-body">

                        <div class="table-responsive">
                            <table id="userbanktable" class="table table-bordered  nowrap table-striped align-middle "
                            style="width:100%"  >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Account Name</th>
                                    <th>Account Number<small class="text-danger">*</small></th>
                                    <th>Bank</th>
                                    <th>User</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        </div>

        </div>
    </div>
</div>
</div>



@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type="text/javascript">

 $(function() {
     var table = $('#userbanktable').DataTable({
         processing: true,
         serverSide: true,
         ajax: "/admin/userbank/index",
         columns: [
             { data: 'id', name: 'id' },
             { data: 'account_title', name: 'account_title' },
             { data: 'account_number', name: 'account_number' },
             { data: 'bank', name: 'bank' },
             { data: 'action' , name: 'action',orderable: false, searchable: true }
         ]
     });
 });
</script>