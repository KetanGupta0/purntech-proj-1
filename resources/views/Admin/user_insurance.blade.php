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
                <form action="#">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Customer mobile number" required>
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
                                <input type="text" name="policy" id="policy" class="form-control" placeholder="Policy Number" required>
                                <label for="policy">Policy Number</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="text" name="customer-name" id="customer-name" class="form-control" placeholder="Name of Insured" required>
                                <label for="customer-name">Name of Insured</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="text" name="nominee-name" id="nominee-name" class="form-control" placeholder="Name of Nominee" required>
                                <label for="nominee-name">Name of Nominee</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="number" name="sum-assured" id="sum-assured" class="form-control" placeholder="Sum Assured" value="3000000"
                                       required>
                                <label for="sum-assured">Sum Assured</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="number" name="insurance-premium" id="insurance-premium" class="form-control" placeholder="Insurance Premium"
                                       required>
                                <label for="insurance-premium">Insurance Premium</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="date" name="paid-till" id="paid-till" class="form-control" placeholder="Paid till" required>
                                <label for="paid-till">Paid till</label>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-floating">
                                <input type="text" name="balance-amount" id="balance-amount" class="form-control" placeholder="Balance Amount" required>
                                <label for="balance-amount">Balance Amount</label>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <button type="button" id="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                    <div class="container">
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
    $(document).ready(function() {
        // Listen for input on the #mobile field
        $(document).on('input', '#mobile', function() {
            let mobile = $(this).val();
            userInfo(mobile);
        });

        $(document).on('click','#fetch-customer-data',function(){
            let mobile = $('#mobile').val();
            userInfo(mobile);
        });
    });
</script>
