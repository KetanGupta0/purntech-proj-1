<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 pg-title"></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{url('/admin-dashboard')}}"><i class="ri-home-5-fill"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{url('/admin/user-invoices-page')}}">User Invoices Page</a></li>
                    <li class="breadcrumb-item pg-title active"></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="card">
    <div class="card-body">
        @if (isset($user))
        {{-- {{ dd($user) }} --}}
            <form action="{{ url('/admin/user-invoices-page/raise-new-invoice/form-submit') }}" method="POST" id="raise-new-invoice" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="inv_date" class="form-label">Invoice Date</label>
                            <input type="text" class="form-control" data-provider="flatpickr" id="inv_date" name="inv_date" data-date-format="d M, Y" data-deafult-date="" placeholder="Select Invoice Date" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="text" class="form-control" data-provider="flatpickr" id="due_date" name="due_date" data-date-format="d M, Y" data-deafult-date="" placeholder="Select Due Date" />
                        </div>
                    </div>
                </div>
                <h3>Billed To</h3>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Customer Name</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Customer Name" value="{{ $user->usr_first_name }} {{ $user->usr_last_name }}"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="customer_phone1" class="form-label">Phone 1</label>
                            <input type="text" class="form-control" id="customer_phone1" name="customer_phone1" placeholder="Customer Primary Phone" value="{{ $user->usr_mobile }}"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="customer_phone2" class="form-label">Phone 2</label>
                            <input type="text" class="form-control" id="customer_phone2" name="customer_phone2" placeholder="Customer Secondary Phone" value="{{ $user->usr_alt_mobile }}"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="customer_address1" class="form-label">Address Line 1</label>
                            <input type="text" class="form-control" id="customer_address1" name="customer_address1" placeholder="Customer Address" value="{{ $user->usr_landmark }}"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="customer_address2" class="form-label">Address Line 2</label>
                            <input type="text" class="form-control" id="customer_address2" name="customer_address2" placeholder="Customer Address" value="{{ $user->usr_full_address }}"/>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <tbody id="dynamicTable">
                            <tr>
                                <th align="center"><h4>Description</h4></th>
                                <th align="center"><h4>Amount</h4></th>
                                <th></th>
                            </tr>
                            <tr>
                                <td><input type="text" name="inv_desc_title[]" id="inv_desc_title_1" class="form-control" placeholder="Description Title 1"></td>
                                <td><input type="number" name="inv_amount[]" id="inv_amount_1" class="form-control" placeholder="Amount 1"></td>
                                <td></td> <!-- No remove button for the first row -->
                            </tr>
                        </tbody>
                    </table>
                    <p id="form_error" style="color:red;"></p>
                    <div class="d-flex justify-content-between">
                        <button type="button" id="addRow" class="btn btn-primary">Add Row</button>
                        <button type="submit" id="submitForm" class="btn btn-secondary">Final Submit</button>
                    </div>
                </div>
                <input type="hidden" name="uid" value="{{ $user->usr_id }}">
            </form>
        @else
            <h3>Someting went wrong please contact developer for this problem.</h3>
        @endif
    </div>
</div>
<script>
    $(document).ready(function() {
        var rowCount = 1; // Start from 1 as there's already 1 row
    
        // Add row button click event
        $('#addRow').click(function() {
            rowCount++;
            var newRow = `
                <tr>
                    <td><input type="text" name="inv_desc_title[]" id="inv_desc_title_${rowCount}" class="form-control" placeholder="Description Title ${rowCount}"></td>
                    <td><input type="number" name="inv_amount[]" id="inv_amount_${rowCount}" class="form-control" placeholder="Amount ${rowCount}"></td>
                    <td><button type="button" class="btn btn-danger removeRow">Remove</button></td>
                </tr>
            `;
            $('#dynamicTable').append(newRow);
        });

        // Remove row button click event
        $(document).on('click', '.removeRow', function() {
            $(this).closest('tr').remove();
        });

        // Form submit validation
        $('#submitForm').click(function(e) {
            e.preventDefault(); // Prevent form submission
            var error = false;
            $('#form_error').text(''); // Clear any previous errors

            // Loop through each row and validate
            $('#dynamicTable tr').each(function() {
                var description = $(this).find('input[type="text"]').val();
                var amount = $(this).find('input[type="number"]').val();

                if ((description === '' && amount !== '') || (description !== '' && amount === '')) {
                    $('#form_error').text('Both Description and Amount must be filled out or both must be blank.');
                    error = true;
                    return false; // Break the loop
                }
            });

            // If no error, allow the form to submit
            if (!error) {
                $('#raise-new-invoice').submit(); // Uncomment if you're using a form element
            }
        });
    });


</script>