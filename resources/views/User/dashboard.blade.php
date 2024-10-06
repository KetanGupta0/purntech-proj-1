<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 pg-title"></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="#"><i class="ri-home-5-fill"></i></a></li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

@if (isset($user))
    @php
        $headline = 'Dear ' . $user->usr_first_name . ' ' . $user->usr_last_name . ' your file number ' . $user->usr_username . ' is ';
    @endphp
    @if ($user->usr_verification_status == 1)
        <div class="alert alert-success" role="alert">
            {{ $headline }} approved for {{ $user->usr_service }}. Please follow <a href="{{ url('/user/approval-letter') }}">this link</a> to download your
            approval letter.
        </div>
    @else
        <div class="alert alert-danger" role="alert">
            {{ $headline }} pending.
        </div>
    @endif
@endif
<div class="row">
    <div class="col-md-6">
        <div class="row">
            @if (isset($profileCompletionPercentage))
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-5">
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-0"><a href="{{ url('/user/profile') }}">Profile</a></h5>
                                </div>
                            </div>
                            <div class="progress animated-progress custom-progress progress-label">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $profileCompletionPercentage }}%" aria-valuenow="30"
                                     aria-valuemin="0" aria-valuemax="100">
                                    <div class="label">{{ $profileCompletionPercentage }}%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (isset($documentUploadPercentage))
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-5">
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-0"><a href="{{ url('/user/documents') }}">Documents</a></h5>
                                </div>
                            </div>
                            <div class="progress animated-progress custom-progress progress-label">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $documentUploadPercentage }}%" aria-valuenow="30"
                                     aria-valuemin="0" aria-valuemax="100">
                                    <div class="label">{{ $documentUploadPercentage }}%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (isset($bankDetailsCompletionPercentage))
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-5">
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-0"><a href="{{ url('/user/bank-details') }}">Bank Details</a></h5>
                                </div>
                            </div>
                            <div class="progress animated-progress custom-progress progress-label">
                                <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $bankDetailsCompletionPercentage }}%"
                                     aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                    <div class="label">{{ $bankDetailsCompletionPercentage }}%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if (isset($companyBankDetails) && $companyBankDetails->cbd_is_hidden == 0)
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card" style="width: 18rem;">
                                <h5 class="card-title mt-4 mx-3">Payment UPI Details</h5>
                                <hr>
                                <img src="{{ asset('public/assets/img/uploads/documents') }}/{{ $companyBankDetails->cbd_qr_code }}" class="card-img-top"
                                     alt="company bank qr">
                                <div class="card-body">
                                    <h5 class="card-title">UPI Name - {{ $companyBankDetails->cbd_upi_name }}</h5>
                                    <h5 class="card-text">UPI ID - {{ $companyBankDetails->cbd_upi_id }}</h5>
                                    <div><i>Note: <span class="text-danger">Please contact your customer relationship manager before making any payments.</span></i></div>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#qr">View</button>
                                    <img src="{{ asset('public/assets/img/bank.png') }}" alt="" style="width: 100%;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card" style="width: 18rem;">
                                <h5 class="card-title mt-4 mx-3">Payment Bank Details</h5>
                                <hr>
                                <img src="{{ asset('public/assets/img/neft.jpg') }}" class="card-img-top" alt="company bank demo logo">
                                <div class="card-body">
                                    <h5 class="card-title py-3">Bank Name - {{ $companyBankDetails->cbd_bank_name }}</h5>
                                    <h5 class="card-title py-3">Account Number - {{ $companyBankDetails->cbd_account_number }}</h5>
                                    <h5 class="card-title py-3">IFSC Code - {{ $companyBankDetails->cbd_ifsc_code }}</h5>
                                    <h5 class="card-title py-3">Branch Name - {{ $companyBankDetails->cbd_branch }}</h5>
                                    <div class="mb-2"><i>Note: <span class="text-danger">Please contact your customer relationship manager before making any payments.</span></i></div>
                                    <button class="btn btn-primary mt-4" data-bs-toggle="modal" data-bs-target="#ba">View</button>
                                    <img src="{{ asset('public/assets/img/bank.png') }}" alt="" style="width: 100%;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card body table-responsive">
                <!-- Bordered Tables -->
                <table class="table table-bordered table-nowrap">
                    <thead>
                        <tr>
                            <th scope="col">S.No.</th>
                            <th scope="col">Invoice Number</th>
                            <th scope="col">Invoice Date</th>
                            <th scope="col">Due Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Amount</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($invoices))
                            @foreach ($invoices as $inv)
                                <tr>
                                    <th scope="row">{{ $loop->index + 1 }}</th>
                                    <td>{{ $inv->inv_number }}</td>
                                    <td>{{ date('d M Y', strtotime($inv->inv_date)) }}</td>
                                    <td>{{ date('d M Y', strtotime($inv->inv_due_date)) }}</td>
                                    <td>
                                        @if ($inv->inv_status == 1)
                                            <span class="badge bg-warning-subtle text-warning">Not Paid</span>
                                        @elseif($inv->inv_status == 2)
                                            <span class="badge bg-warning-subtle text-warning">Partial Paid</span>
                                        @elseif($inv->inv_status == 3)
                                            <span class="badge bg-warning-subtle text-warning">Refuded</span>
                                        @elseif($inv->inv_status == 4)
                                            <span class="badge bg-warning-subtle text-warning">Pending</span>
                                        @elseif($inv->inv_status == 5)
                                            <span class="badge bg-success-subtle text-success">Paid</span>
                                        @endif
                                    </td>
                                    <td>₹ {{ sprintf('%.2f', $inv->inv_amount) }}</td>
                                    <td>
                                        <form action="{{ url('/user/invoices/invoice-view') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="uid" value="{{ $inv->inv_party_id }}">
                                            <input type="hidden" name="inv_id" value="{{ $inv->inv_id }}">
                                            <input type="submit" class="btn btn-sm btn-primary" value="View">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@if (isset($companyBankDetails) && $companyBankDetails->cbd_is_hidden == 0)
    <!-- Modal -->
    <div class="modal fade" id="qr" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="qrLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="qrLabel">Payment UPI Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <label for="">Payment UPI QR</label>
                        <img src="{{ asset('public/assets/img/uploads/documents') }}/{{ $companyBankDetails->cbd_qr_code }}" class="card-img-top"
                             alt="company bank qr">
                    </div>
                    <h5 class="card-title mt-3 mb-2">UPI Name - {{ $companyBankDetails->cbd_upi_name }}</h5>
                    <h5 class="card-text">UPI ID - {{ $companyBankDetails->cbd_upi_id }}</h5>
                    <img src="{{ asset('public/assets/img/bank.png') }}" alt="" style="width: 100%;">
                    <div><i>Note: <span class="text-danger">Please contact your customer relationship manager before making any payments.</span></i></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ba" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="baLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="baLabel">Payment Bank Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="{{ asset('public/assets/img/neft.jpg') }}" class="w-100" alt="company bank demo logo">
                    <h5 class="card-title">Bank Name - {{ $companyBankDetails->cbd_bank_name }}</h5>
                    <h5 class="card-title">Account Number - {{ $companyBankDetails->cbd_account_number }}</h5>
                    <h5 class="card-title">IFSC Code - {{ $companyBankDetails->cbd_ifsc_code }}</h5>
                    <h5 class="card-title">Branch Name - {{ $companyBankDetails->cbd_branch }}</h5>
                    <div><i>Note: <span class="text-danger">Please contact your customer relationship manager before making any payments.</span></i></div>
                    <img src="{{ asset('public/assets/img/bank.png') }}" alt="" style="width: 100%;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endif
