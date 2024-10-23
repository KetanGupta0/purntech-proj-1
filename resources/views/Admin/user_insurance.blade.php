<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 pg-title"></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ url('/admin-dashboard') }}"><i class="ri-home-5-fill"></i></a></li>
                    <li class="breadcrumb-item pg-title active"></li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
<div class="card">
    <h5 class="card-header">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Issue Insurance
        </button>
    </h5>
    <div class="card-body">
        @if (isset($insurance))
            @if (count($insurance) == 0)
                <div class="alert alert-danger" role="alert">
                    No active insurance found.
                </div>
            @else
                <table class="table" id="insuranceTable">
                    <thead>
                        <tr>
                            <th>S. No.</th>
                            <th>Policy Number</th>
                            <th>Name of Insured</th>
                            <th>Name of Nominee</th>
                            <th>Sum Assured</th>
                            <th>Insurance Premium</th>
                            <th>Paid till</th>
                            <th>Balance Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($insurance as $ins)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$ins->uin_policy_number}}</td>
                                <td>{{$ins->uin_insured_name}}</td>
                                <td>{{$ins->uin_nominee}}</td>
                                <td>{{sprintf('%.2f',$ins->uin_sum_assured)}}</td>
                                <td>{{sprintf('%.2f',$ins->uin_insurance_premium)}}</td>
                                <td>{{date('d M Y',strtotime($ins->uin_paid_till))}}</td>
                                <td>{{sprintf('%.2f',$ins->uin_balance_amount)}}</td>
                                <td><a href="{{url('admin/view/insurance-'.$ins->uin_id)}}" class="btn btn-primary">View/Download</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @else
            <div class="alert alert-danger" role="alert">
                No active insurance found.
            </div>
        @endif
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Issue Insurance</h1>
                <button type="button" class="btn-close close-btn" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/admin/insurance/submit-insurance-form') }}" id="insuranceForm" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Customer mobile number">
                                <label for="mobile">Customer mobile number</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <button type="button" id="fetch-customer-data" class="btn btn-primary">Find Customer</button>
                        </div>
                    </div>
                    <div class="row" id="base-form" style="display: none;">
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="text" name="policy" id="policy" class="form-control" placeholder="Policy Number">
                                <label for="policy">Policy Number</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="text" name="customerName" id="customer-name" class="form-control" placeholder="Name of Insured">
                                <label for="customer-name">Name of Insured</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="text" name="nomineeName" id="nominee-name" class="form-control" placeholder="Name of Nominee">
                                <label for="nominee-name">Name of Nominee</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="number" name="sumAssured" id="sum-assured" class="form-control" placeholder="Sum Assured" value="3000000">
                                <label for="sum-assured">Sum Assured</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="number" name="insurancePremium" id="insurance-premium" class="form-control" placeholder="Insurance Premium">
                                <label for="insurance-premium">Insurance Premium</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="text" name="paidTill" id="paid-till" class="form-control" placeholder="Paid till">
                                <label for="paid-till">Paid till</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="text" name="balanceAmount" id="balance-amount" class="form-control" placeholder="Balance Amount">
                                <label for="balance-amount">Balance Amount</label>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-btn" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    function userInfo(mobile) {
        if (mobile.length == 10 && /^[0-9]+$/.test(mobile)) {
            $.post("{{ url('/admin/user-insurance/fetch-user-by-phone-ajax') }}", {
                mobile: mobile,
                _token: '{{ csrf_token() }}'
            }, function(res) {
                if (res) {
                    $('#base-form').show();
                    $('#policy').val(res.usr_username);
                    $('#customer-name').val(res.usr_first_name + ' ' + res.usr_last_name);
                    $('#nominee-name').val(res.usr_father);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No user found for this mobile number.'
                    });
                }
            }).fail(function(err) {
                console.log(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while fetching user details.'
                });
            });
        } else {
            $('#base-form').hide();
            $('#policy').val('');
            $('#customer-name').val('');
            $('#nominee-name').val('');
        }
    }

    function showError(message = 'Something went wrong') {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message
        });
    }
    $(document).ready(function() {
        flatpickr('#paid-till', {
            dateFormat: 'd M Y', // Format the date in 'YYYY-MM-DD'
            minDate: 'today', // Restrict past dates
            defaultDate: new Date().fp_incr(365), // Set default date to 1 year from today
            disableMobile: true // Force Flatpickr on mobile devices
        });
        $(document).on('input', '#mobile', function() {
            let mobile = $(this).val();
            mobile = mobile.replace(/\D/g, '');
            if (mobile.length > 10) {
                mobile = mobile.substring(0, 10);
            }
            $(this).val(mobile);
            userInfo(mobile);
        });
        $(document).on('click', '#fetch-customer-data', function() {
            let mobile = $('#mobile').val();
            userInfo(mobile);
        });
        $(document).on('submit', '#insuranceForm', function(e) {
            // Get all the input values
            let mobile = $('#mobile').val().trim();
            let policy = $('#policy').val().trim();
            let customerName = $('#customer-name').val().trim();
            let nomineeName = $('#nominee-name').val().trim();
            let sumAssured = $('#sum-assured').val().trim();
            let insurancePremium = $('#insurance-premium').val().trim();
            let paidTill = $('#paid-till').val().trim();
            let balanceAmount = $('#balance-amount').val().trim();

            // List of required fields for validation
            let requiredFields = [{
                    value: mobile,
                    name: 'Customer mobile number'
                },
                {
                    value: policy,
                    name: 'Policy Number'
                },
                {
                    value: customerName,
                    name: 'Name of Insured'
                },
                {
                    value: nomineeName,
                    name: 'Name of Nominee'
                },
                {
                    value: sumAssured,
                    name: 'Sum Assured'
                },
                {
                    value: insurancePremium,
                    name: 'Insurance Premium'
                },
                {
                    value: paidTill,
                    name: 'Paid Till'
                },
                {
                    value: balanceAmount,
                    name: 'Balance Amount'
                }
            ];

            // Validate required fields
            for (let field of requiredFields) {
                if (!field.value || field.value.length === 0) {
                    e.preventDefault();
                    showError(`${field.name} is required.`);
                    return;
                }
            }
        });
    });
</script>
