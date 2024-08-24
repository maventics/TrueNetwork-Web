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
                                            @if ($depositrequest->image)
                                                <img class="sq_image" src="{{ asset('upload_image/' . $depositrequest->image) }}"
                                                    alt="depositrequest Image">
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
                                                    <th><span class="fw-medium">Account Holder:</span></th>
                                                    <td>{{ ucwords($depositrequest->accountholder) }}</td>
                                                </tr>
                                                <tr>
                                                    <th><span class="fw-medium">Description:</span></th>
                                                    <td>
                                                        @if ($depositrequest->description == null)
                                                            <span class="text-danger">No Description is Available!</span>
                                                        @else
                                                            {{ $depositrequest->description }}
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th><span class="fw-medium">Account Number:</span></th>
                                                    <td>********{{ substr($depositrequest->accountnumber, -4) }}</td>
                                                </tr>
                                                <tr>
                                                    <th><span class="fw-medium">Bank Name:</span></th>
                                                    <td>{{ ucwords($depositrequest->bank->bank) }}</td>
                                                </tr>
                                                <tr>
                                                    <th><span class="fw-medium">Deposit Amount:</span></th>
                                                    <td>{{ ucwords($depositrequest->depositamount) }}</td>
                                                 </tr>
                                                <tr>
                                                    <th><span class="fw-medium">Created At:</span></th>
                                                    <td>{{ \Carbon\Carbon::parse($depositrequest->created_at)->format('Y-m-d h:i:s A') }}</td>

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
