@extends('layout.app')
@section('content')
        <div class="row">
            <div class="col-xxl-3">
                <div class="card">
                    <div class="card-body p-4">
                        <h3 class="text-center">Withdraw Details Page</h3>
                        <div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table mb-0 table-borderless">
                                            <tbody>
                                                <tr>
                                                    <th><span class="fw-medium">Account Holder:</span></th>
                                                    <td>{{ ucwords($withdrawrequests->accountholder) }}</td>
                                                </tr>
                                                <tr>
                                                    <th><span class="fw-medium">Description:</span></th>
                                                    <td>
                                                        @if ($withdrawrequests->description == null)
                                                            <span class="text-danger">No Description is Available!</span>
                                                        @else
                                                            {{ $withdrawrequests->description }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><span class="fw-medium">Account Number:</span></th>
                                                    <td>********{{ substr($withdrawrequests->accountnumber, -4) }}</td>
                                                </tr>
                                                <tr>
                                                    <th><span class="fw-medium">Bank Name:</span></th>
                                                    <td>{{ ucwords($withdrawrequests->bank->bank) }}</td>
                                                </tr>
                                                <tr>
                                                    <th><span class="fw-medium">Withdraw Amount:</span></th>
                                                    <td>{{ ucwords($withdrawrequests->withdrawamount) }}</td>
                                                 </tr>
                                                <tr>
                                                    <th><span class="fw-medium">Created At:</span></th>
                                                    <td>{{ \Carbon\Carbon::parse($withdrawrequests->created_at)->format('Y-m-d h:i:s A') }}</td>

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

 
@endsection
