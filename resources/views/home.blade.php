@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Total Withdraws</p>
                        </div>
                        
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                    data-target="{{ App\Models\Withdrawrequest::count() }}">0</span> </h4>
                            <a href="/admin/withdraw/index" class="text-decoration-underline">Withdraw History</a>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-soft-success rounded fs-3">
                                <i class="bx bx-dollar-circle text-success"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Total Deposits</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                    data-target="{{ App\Models\depositrequest::count() }}">0</span> </h4>
                            <a href="/admin/deposit/index" class="text-decoration-underline">Deposit History</a>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-soft-success rounded fs-3">
                                <i class="bx bx-dollar-circle text-success"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Trades</p>
                        </div>
                       
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                    data-target="{{ $orders }}">0</span></h4>
                            <a href="/admin/investment/index" class="text-decoration-underline">View all orders</a>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-soft-info rounded fs-3">
                                <i class="bx bx-shopping-bag text-info"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total user</p>
                        </div>
                     
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                    data-target="{{ App\Models\User::count() }}">0</span> </h4>
                            <a href="/admin/user/index" class="text-decoration-underline">See details</a>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-soft-warning rounded fs-3">
                                <i class="bx bx-user-circle text-warning"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-md-6">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0"> Total Transactions</p>
                        </div>
                     
                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                    data-target="{{ App\Models\TransactionTable::count() }}">0</span> </h4>
                            <a href="/admin/transactiontable" class="text-decoration-underline">Transaction Details</a>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-soft-primary rounded fs-3">
                                <i class="bx bx-wallet text-primary"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->
        
    </div> <!-- end row-->



    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Deposit Requests</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                            <thead class="text-muted table-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">User</th>
                                    <th scope="col">Account</th>
                                    <th scope="col">Account Number</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Bank</th>
                                    <th scope="col">Recipt</th>
                                    <th scope="col">Action</th>
                                    {{-- <th scope="col">Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($depositRequests as $request)
                                    <tr>
                                        <td>#{{ $request->id }}</td>
                                        <td><a href='/admin/user/view/{{$request->user->id}}'>{{$request->user->name}}</a></td>
                                        <td>{{ $request->accountholder }}</td>
                                        <td>{{ $request->accountnumber }}</td>
                                        <td><span class="text-success">PKR{{ $request->depositamount }}+</span></td>
                                        <td>{{ $request->bank->bank }}</td>
                                        <td><a href='/upload_image/{{ $request->image }}' target="_blank">Receipt</a></td>
                                        <td>
                                            <div class="row">
                                                <form action="/update-deposit-status/{{ $request->id }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name='status' value="1">
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fas fa-check-circle"></i>
                                                    </button>
                                                </form>
                                                <form action="/update-status-rejected/{{ $request->id }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name='status' value="2">
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-times-circle"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        {{-- <td>
                                            <h5 class="fs-14 fw-medium mb-0">4.7<span class="text-muted fs-11 ms-1">(161 votes)</span></h5>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody><!-- end tbody -->
                        </table><!-- end table -->
                    </div>
                </div>
            </div> <!-- .card-->
        </div> <!-- .col-->
        {{-- second object --}}
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Withdraw Request</h4>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="table-responsive table-card">
                        <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                            <thead class="text-muted table-light">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Account Holder</th>
                                    <th scope="col">Account Number</th>
                                    <th scope="col">WithDraw Amount</th>
                                    <th scope="col">Bank</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($withdrawrequests as $withdrawrequest)
                                    <tr>
                                        <td>#{{ $withdrawrequest->id }}</td>
                                        <td><a
                                                href='/admin/user/view/{{ $withdrawrequest->id }}'>{{ $withdrawrequest->accountholder }}</a>
                                        </td>
                                        <td>{{ $withdrawrequest->accountnumber }}</td>
                                        <td><span class="text-success">PKR{{ $withdrawrequest->withdrawamount }}</span>
                                        </td>
                                        <td>{{ $withdrawrequest->bank->bank }}</td>
                                        <td>
                                            <div class="row">
                                                <form action="/update-withdraw-status/{{ $withdrawrequest->id }}"
                                                    method="post">
                                                    @csrf
                                                    <input type="hidden" name='status' value="1">
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fas fa-check-circle"></i>
                                                    </button>
                                                </form>
                                                <form action="/update-status-rejected-withdraw/{{ $withdrawrequest->id }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" name='status' value="2">
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-times-circle"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody><!-- end tbody -->
                        </table><!-- end table -->
                    </div>
                </div>
            </div> <!-- .card-->
        </div> <!-- .col-->
        {{-- second object --}}
    </div>
{{-- 
    <div class="row">
        <div class="col-xl-4">
            <div class="card card-height-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Reports</h4>
                    <div class="flex-shrink-0">
                        <div class="dropdown card-header-dropdown">
                            <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted">Report<i class="mdi mdi-chevron-down ms-1"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Download Report</a>
                                <a class="dropdown-item" href="#">Export</a>
                                <a class="dropdown-item" href="#">Import</a>
                            </div>
                        </div>
                    </div>
                </div><!-- end card header -->

                <div class="card-body">
                    <div id="store-visits-source"
                        data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]'
                        class="apex-charts" dir="ltr"></div>
                </div>
            </div> <!-- .card-->
        </div> <!-- .col-->
    </div> <!-- end row--> --}}
@endsection
