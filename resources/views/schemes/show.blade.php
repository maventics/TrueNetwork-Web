@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-xxl-3">
            <div class="card">
                <div class="card-body p-4">
                    <div>
                        <div class="row">
                            <div class="col-4">
                                <div class="flex-shrink-0 mx-auto">
                                    <div class=" bg-light rounded">

                                        @if ($scheme->bg_image)
                                            <img class="sq_image" src="{{ asset('upload_image/' . $scheme->bg_image) }}"
                                                alt="Scheme Image">
                                        @else
                                            <p class="text-center">Image not found</p>
                                        @endif
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
                                                <th><span class="fw-medium">Scheme Title  : </span></th>
                                                <td>{{ ucwords($scheme->title) }}</td>
                                            </tr>
                                            <tr>
                                                <th><span class="fw-medium">Description  : </span></th>
                                                <td>{{ ucwords($scheme->sub_title) }}</td>
                                            </tr>
                                            <tr>
                                                <th><span class="fw-medium">Profit  : </span></th>
                                                <td>{{ ucwords($scheme->profit) }} <small
                                                        class="text-danger">(%)</small></td>
                                            </tr>
                                            <tr>
                                                <th><span class="fw-medium">Duration  : </span></th>
                                                <td>{{ ucwords($scheme->duration) }} <small
                                                        class="text-danger">(Days)</small>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><span class="fw-medium">Total Active Trade  : </span></th>
                                                @php
                                                    $totalActiveMembers = $scheme
                                                        ->investments()
                                                        ->where('status', '0')
                                                        ->count();
                                                @endphp
                                                <td>{{ $totalActiveMembers }} <small
                                                        class="text-danger">(Members)</small></td>
                                            </tr>
                                            <tr>
                                                <th><span class="fw-medium">Total Investment  : </span></th>
                                                @php
                                                    $totalInvestment = $scheme
                                                        ->investments()
                                                        ->where('status', '0')
                                                        ->sum('amount');
                                                @endphp
                                                <td>{{ $totalInvestment }} <small class="text-danger">(Rs)</small></td>
                                            </tr>
                                            <tr>
                                                <th><span class="fw-medium">User Investment Limit  : </span></th>
                                                <td>{{ ucwords($scheme->user_investment_limit) }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><span class="fw-medium">Investment Limit  : </span></th>
                                                <td>{{ number_format($scheme->starting_investment) }} - {{ number_format($scheme->ending_investment) }} PKR
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><span class="fw-medium">Created At  : </span></th>
                                                    <td>{{ \Carbon\Carbon::parse($scheme->created_at)->format('Y-m-d h:i:s A') }}</td>

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




<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <p class="card-title">Investment History</p>
            </div>
            <div class="card-body">

                        <div class="table-responsive">
                            <table id="investment_table" class="table table-bordered  nowrap table-striped align-middle "
                            style="width:100%"  >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User id</th>
                                    <th>Scheme Reference <small class="text-danger">*</small></th>
                                    <th>Amount</th>
                                    <th>end_date_timestamp</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($Investments as $investment)
                            <tr>
                            <th>{{ $investment->id }}</th>
                            <th>{{ $investment->user->name}}</th>
                            <th>{{ $scheme->title}}</th>
                            <th>{{ $investment->amount }}</th>
                            <th>{{ \Carbon\Carbon::parse($investment->end_date_timestamp)->format('Y-m-d h:i:s A') }}</th>

                            </tr>
                            @endforeach
                            <tbody>
                            </tbody>
                        </table>
                        </div>

        </div>
    </div>
</div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <p class="card-title">User Details</p>
            </div>
            <div class="card-body">

                        <div class="table-responsive">
                            <table id="investment_table" class="table table-bordered  nowrap table-striped align-middle "
                            style="width:100%"  >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email<small class="text-danger">*</small></th>
                                    <th>Phone</th>
                                    <th>Referral Link<small class="text-danger">*</small></th>
                                  
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($Investments as $investment)
                            <tr>
                            <th>{{ $investment->user->id }}</th>
                            <th>{{ $investment->user->name}}</th>
                            <th>{{ $investment->user->email }}</th>
                            <th>{{ $investment->user->phone }}</th>
                            <th>{{ $investment->user->referral_link }}</th>
                    
                            <th>{{ $investment->user->created_at }}</th>
                           
                            </tr>
                            @endforeach
                            <tbody>
                            </tbody>
                        </table>
                        </div>

        </div>
    </div>
</div>
</div>



@endsection
