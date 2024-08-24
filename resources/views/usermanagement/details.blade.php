@extends('layout.app')
@section('content')
    @if ($user)
        <div class="row">
            <div class="col-xxl-12">
                <div class="card">
                    <div class="card-body p-4">
                        <div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="flex-shrink-0 mx-auto">
                                        <div class="bg-light rounded">
                                            @if ($user->image)
                                                <img class="sq_image" src="{{ asset($user->image) }}" alt="User Image">
                                            @else
                                                <p class="text-center">Image not found</p>
                                            @endif
                                            {{--
                                            @if ($scheme->bg_image)
                                            <img class="sq_image" src="{{ asset('upload_image/' . $scheme->bg_image) }}"
                                                alt="Scheme Image">
                                        @else
                                            <p class="text-center">Image not found</p>
                                        @endif --}}

                                        </div>
                                    </div>
                                    <div class="mt-4 text-center">
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="table-responsive">
                                        <table class="table mb-0 table-borderless">
                                            <tbody>
                                                <tr>
                                                    <th><span class="fw-medium">User Name : </span></th>
                                                    <td>{{ ucwords($user->name) }}</td>
                                                </tr>
                                                <tr>
                                                    <th><span class="fw-medium">Email : </span></th>
                                                    <td>{{ ucwords($user->email) }}</td>
                                                </tr>
                                                <tr>
                                                    <th><span class="fw-medium">Phone : </span></th>
                                                    <td>{{ ucwords($user->phone) }} <small class="text-danger">(PAK)</small>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><span class="fw-medium">Referral Link : </span></th>
                                                    <td>{{ ucwords($user->referral_link) }} <small
                                                            class="text-danger">(PAKISTAN STOCK EXCHANGE)</small>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><span class="fw-medium">Total Deposit Amount : </span></th>
                                                    <td>{{ ucwords($sumdepositrequest) }} <small
                                                            class="text-danger">(PKR)</small></td>
                                                </tr>

                                                <tr>
                                                    <th><span class="fw-medium">Total Team Members : </span></th>
                                                    <td>
                                                        <?php
                                                        
                                                        echo $commissions->total_members;
                                                        
                                                        ?>
                                                    </td>
                                                </tr>


                                                <tr>

                                                    <th><span class="fw-medium">Total Level 1 Commissions : </span></th>
                                                    <td>
                                                        PKR{{ App\Models\Comissions::where('user_id',$user->id)->where('level', 'Level 1')->sum('amount') }}
                                                    </td>

                                                </tr>

                                                {{-- level 2 --}}

                                                <tr>
                                                    <th><span class="fw-medium">Total Level 2 Commissions : </span></th>
                                                    <td>

                                                       PKR{{ App\Models\Comissions::where('user_id',$user->id)->where('level', 'Level 2')->sum('amount') }}

                                                    </td>
                                                </tr>


                                                {{-- level 3 --}}

                                                <tr>
                                                    <th><span class="fw-medium">Total Level 3 Commissions : </span></th>
                                                    <td>

                                                        PKR{{App\Models\Comissions::where('user_id',$user->id)->where('level','Level 3')->sum('amount')}}
                                                    </td>

                                                </tr>

                                                <tr>
                                                    <th><span class="fw-medium">Total Team Commissions : </span></th>
                                                    <td>

                                                       PKR{{App\Models\Comissions::where('user_id',$user->id)->sum('amount')}}
                                                    </td>
                                                </tr>



                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <p>User not found.</p>
    @endif
    <div class="row">
        <div class="col-xl-12 ">
            <div class="card">
                <div class="card-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#DepositRequest" role="tab"
                                aria-selected="false">
                                Deposit Request
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#Investment" role="tab"
                                aria-selected="false">
                                Trade
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#TransactionHistory" role="tab"
                                aria-selected="true">
                                Transaction History
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#WithdrawRequest" role="tab"
                                aria-selected="true">
                                Withdraw Request
                            </a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content text-muted">
                        <div class="tab-pane" id="DepositRequest" role="tabpanel">
                            <h6>Deposit Request</h6>
                            <div class="table-responsive">
                                <table id="deposit_request_table"
                                    class="table table-bordered nowrap table-striped align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>User</th>
                                            <th>Bank</th>
                                            <th>Account Holder</th>
                                            <th>Account Number</th>
                                            <th>Deposit Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>

                                </table>
                           

                            </div>

                        </div>
                        <div class="tab-pane active" id="Investment" role="tabpanel">
                            <h6>Trade</h6>
                            <div class="table-responsive">
                                <table id="investment_table" class="table table-bordered nowrap table-striped align-middle"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>User</th>
                                            <th>Scheme</th>
                                            <th>Amount</th>
                                            <th>End Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     
                                    </tbody>
                                </table>
                           
                            </div>
                        </div>
                        <div class="tab-pane" id="TransactionHistory" role="tabpanel">
                            <h6>Transaction History</h6>
                            <div class="table-responsive">
                                <table id="transaction_history_table"
                                    class="table table-bordered nowrap table-striped align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>User</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                               
                                    </tbody>
                                </table>
                            </div>
                            <div>
                            </div>
                        </div>
                        <div class="tab-pane" id="WithdrawRequest" role="tabpanel">
                            <h6>Withdraw Request</h6>
                            <div class="table-responsive">
                                <table id="withdraw_request_table"
                                    class="table table-bordered nowrap table-striped align-middle" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>User</th>
                                            <th>Bank</th>
                                            <th>Account Holder</th>
                                            <th>Account Number</th>
                                            <th>Withdraw Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div><!-- end tab-content -->
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div><!-- end col -->
    </div><!-- end row -->


@endsection
<!--end col-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<script type="text/javascript">
    $(function() {
     var table = $('#deposit_request_table').DataTable({
         processing: true,
         serverSide: true,
         ajax: "/admin/user/details/depositrequest",
         columns: [
             { data: 'id', name: 'id' },
             { data: 'user', name: 'user' },
             { data: 'bank', name: 'bank' },
             { data: 'accountholder', name: 'accountholder' },
             { data: 'accountnumber', name: 'accountnumber' },
             { 
                 data: 'depositamount',
                 name: 'depositamount',
                 render: function(data, type, full, meta) {
                     return 'PKR : ' + data;
                 }
             },
             { data: 'action', name: 'action', orderable: false, searchable: true }
         ]
     });
 });

 // Transaction History

 $(function() {
     var table = $('#transaction_history_table').DataTable({
         processing: true,
         serverSide: true,
         ajax: "/admin/user/details/transactiontable",
         columns: [
             { data: 'id', name: 'id' },
             { data: 'user', name: 'user' },
             { data: 'type', name: 'type' },
             { 
                 data: 'avaiable_amount',
                 name: 'avaiable_amount',
                 render: function(data, type, full, meta) {
                     return 'PKR : ' + data;
                 }
             },
             { data: 'action', name: 'action', orderable: false, searchable: true }
         ]
     });
 });

 // trade History

 $(function() {
     var table = $('#investment_table').DataTable({
         processing: true,
         serverSide: true,
         ajax: "/admin/user/details/trade",
         columns: [
             { data: 'id', name: 'id' },
             { data: 'user', name: 'user' },
             { data: 'scheme', name: 'scheme' },
             { data: 'amount', name: 'amount' },
             { data: 'action', name: 'action', orderable: false, searchable: true }
         ]
     });
 });

  // withdraw History

  $(function() {
     var table = $('#withdraw_request_table').DataTable({
         processing: true,
         serverSide: true,
         ajax: "/admin/user/details/withdrawrequest",
         columns: [ 
             { data: 'id', name: 'id' },
             { data: 'user', name: 'user' },
             { data: 'bank', name: 'bank' },
             { data: 'accountholder', name: 'accountholder' },
             { data: 'accountnumber', name: 'accountnumber' },
             { 
                 data: 'withdrawamount',
                 name: 'withdrawamount',
                 render: function(data, type, full, meta) {
                     return 'PKR : ' + data;
                 }
             },
             { data: 'action', name: 'action', orderable: false, searchable: true }
         ]
     });
 });
 </script>
