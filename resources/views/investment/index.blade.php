@extends('layout.app')
@section('content')
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

  <!-- start page title -->
  <div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Trade</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                    <li class="breadcrumb-item active">Trade</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

@if ($message = Session::get('success'))
<div id="successMessage" class="alert alert-primary text-primary mt-3">
    <p class="fs-14">{{ $message }}</p>
</div>
@endif

@if ($message = Session::get('error'))
<div id="dangerMessage" class="alert alert-danger text-primary mt-3">
    <p class="fs-14">{{ $message }}</p>
</div>
@endif


@if ($errors->any())
<div class="alert alert-danger">
    <strong>Whoops!</strong> Something went wrong.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <p class="card-title">Trade</p>
            </div>
            <div class="card-body">


                        <div class="table-responsive">
                            <table id="investment_table" class="table table-bordered  nowrap table-striped align-middle "
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User </th>
                                    <th>Reference </th>
                                    <th>Duration</th>
                                    <th>Trade<small class="text-danger">(Amount)</small></th>
                                    <th>Profit <small class="text-danger">(Rs)</small></th>
                                    <th>Expire Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
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

@endsection
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

  <script>
      $(document).ready(function() {
          $('#investment_table').DataTable({
              processing: true,
              serverSide: true,
              ajax: "/admin/investment/index",
              columns: [
                  {data: 'id', name: 'id'},
                  {data: 'user_id', name: 'user_id'},
                  {data: 'scheme_ref_id', name: 'scheme_ref_id'},
                  { 
                  data: 'duration',
                  name: 'duration',
                  render: function(data, type, full, meta) {
                      return  data + ' (Days)' ;
                  }
                  },
                  { 
                  data: 'amount',
                  name: 'amount',
                  render: function(data, type, full, meta) {
                      return  ' PKR ' + data ;
                  }
                  },
                  { 
                  data: 'profit',
                  name: 'profit',
                  render: function(data, type, full, meta) {
                      return  ' PKR ' + data ;
                  }
                  },
                  {data: 'formatted_end_date', name: 'formatted_end_date'},
                  {data: 'status', name: 'status'},
                  {data: 'action' , name: 'action' ,orderable: true, searchable: true}
              ]
          });
      });
  </script>

