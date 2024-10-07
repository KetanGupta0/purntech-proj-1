<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 pg-title"></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ url('/user-dashboard') }}"><i class="ri-home-5-fill"></i></a></li>
                    <li class="breadcrumb-item pg-title active"></li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- FullCalendar CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />

<!-- FullCalendar JS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>

@if (isset($user))
    <div class="card">
        <div class="card-header">
            Payment Report
        </div>
        <div class="card-body">
            <h5 class="card-title">File - {{ $user->usr_username }} for {{ $user->usr_service }}</h5> {{-- From DB --}}
            <h5 class="card-title">Advance Amount for LO - ₹{{ sprintf('%.2f', $user->usr_adv_amount) }}</h5> {{-- From DB --}}
            <div>Payment Status - @if ($user->usr_adv_status == 1)
                    <span class="badge bg-success-subtle text-success">Paid</span>
                @elseif($user->usr_adv_status == 0)
                    <span class="badge bg-danger-subtle text-danger">Not Paid</span>
                @endif
            </div>
            <div>Reference ID - <span class="badge bg-success-subtle text-success">{{ $user->usr_adv_txnid }}</span></div>
            <h5 class="card-title">Monthly Rent for LO - ₹{{ sprintf('%.2f', $user->usr_mon_rent) }}</h5> {{-- From DB --}}
            <a href="#calendar" class="btn btn-primary">View Calender</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div id="calendar"></div>
                </div>
                <div class="col-md-6">
                    @if (isset($companyBankDetails) && $companyBankDetails->cbd_is_hidden == 0)
                        <div class="col-md-12">
                            <div class="container">
                                <div class="row justify-content-center">
                                    <div class="col-lg-5 col-md-6 col-sm-12 mb-4">
                                        <div class="card mx-auto" style="max-width: 100%;">
                                            <h5 class="card-title mt-4 mx-3">Payment UPI Details</h5>
                                            <hr>
                                            <img src="{{ asset('public/assets/img/uploads/documents') }}/{{ $companyBankDetails->cbd_qr_code }}" 
                                                 class="card-img-top" alt="company bank qr" style="height: auto; width: 100%;">
                                            <div class="card-body">
                                                <h5 class="card-title">UPI Name - {{ $companyBankDetails->cbd_upi_name }}</h5>
                                                <h5 class="card-text">UPI ID - {{ $companyBankDetails->cbd_upi_id }}</h5>
                                                <div class="my-2"><i>Note: <span class="text-danger">Please contact your customer relationship manager before making any payments.</span></i></div>
                                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#qr">View</button>
                                                <img src="{{ asset('public/assets/img/bank.png') }}" alt="" style="width: 100%;">
                                            </div>
                                        </div>
                                    </div>
                            
                                    <div class="col-lg-5 col-md-6 col-sm-12 mb-4">
                                        <div class="card mx-auto" style="max-width: 100%;">
                                            <h5 class="card-title mt-4 mx-3">Payment Bank Details</h5>
                                            <hr>
                                            <img src="{{ asset('public/assets/img/neft.jpg') }}" class="card-img-top" alt="company bank demo logo">
                                            <div class="card-body">
                                                <h5 class="card-title py-1">Bank Name - {{ $companyBankDetails->cbd_bank_name }}</h5>
                                                <h5 class="card-title py-1">Account Number - {{ $companyBankDetails->cbd_account_number }}</h5>
                                                <h5 class="card-title py-1">IFSC Code - {{ $companyBankDetails->cbd_ifsc_code }}</h5>
                                                <h5 class="card-title py-1">Branch Name - {{ $companyBankDetails->cbd_branch }}</h5>
                                                <div class="my-2"><i>Note: <span class="text-danger">Please contact your customer relationship manager before making any payments.</span></i></div>
                                                <button class="btn btn-primary mt-4" data-bs-toggle="modal" data-bs-target="#ba">View</button>
                                                <img src="{{ asset('public/assets/img/bank.png') }}" alt="" style="width: 100%;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
@if (isset($companyBankDetails) && $companyBankDetails->cbd_is_hidden == 0)
    <!-- Modal -->
    <div class="modal fade" id="qr" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="qrLabel" aria-hidden="true">
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
    <div class="modal fade" id="ba" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="baLabel" aria-hidden="true">
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
<script>
    $(document).ready(function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: '/employee/payment-status', // Fetch events via AJAX
            eventColor: '#378006', // Color for events
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth'
            },
            eventRender: function(info) {
                $(info.el).tooltip({
                    title: info.event.extendedProps.paymentStatus
                });
            }
        });

        calendar.render();
    });
</script>
