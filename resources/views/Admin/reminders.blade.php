<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 pg-title"></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{url('/admin-dashboard')}}"><i class="ri-home-5-fill"></i></a></li>
                    <li class="breadcrumb-item pg-title active"></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Send Custom Reminder</h5>
    </div>
    <div class="card-body">
        <p class="card-text">
            <form action="{{ url('/admin/send-reminder') }}" method="post" id="reminderForm">
                @csrf
                <div class="row">
                    <div class="col-lg-2 col-md-4 col-sm-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" data-provider="flatpickr" id="from_date" name="from_date" data-date-format="Y-m-d" data-deafult-date="" placeholder="Select Date from" />
                            <label for="from_date">Date From <span class="text-danger">*</span></label>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-12">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" data-provider="flatpickr" id="to_date" name="to_date" data-date-format="Y-m-d" data-deafult-date="" placeholder="Select Date to" />
                            <label for="to_date">Date To</label>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-12">
                        <div class="form-floating mb-3">
                            <select name="rem_type" id="rem_type" class="form-control" placeholder="Reminder Type">
                                <option value="">Select</option>
                                <option value="1">Due KYC</option>
                                <option value="2">Due Invoice</option>
                            </select>
                            <label for="rem_type">Remind type <span class="text-danger">*</span></label>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-12">
                        <div class="form-floating mb-3">
                            <select name="rem_to" id="rem_to" class="form-control" placeholder="Reminder To">
                                <option value="">Select</option>
                                <option value="1">Single Person</option>
                                <option value="2">Everyone</option>
                            </select>
                            <label for="rem_to">Remind to <span class="text-danger">*</span></label>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-12 dynamic" style="display: none;">
                        <div class="form-floating mb-3">
                            <input type="text" name="usr_username" id="usr_username" class="form-control" placeholder="User File/Mobile Number">
                            <label for="usr_username">File/Mobile Number <span class="text-danger">*</span></label>
                        </div>
                    </div>
                    <div class="col-lg-1 col-md-2 col-sm-12 pt-1">
                        <input type="submit" class="btn btn-lg btn-primary" value="Remind">
                    </div>
                </div>
            </form>
        </p>
        <p class="card-text text-muted">Required fields are marked with <span class="text-danger">*</span></p>
    </div>
</div>
<script>
    $(document).ready(function(){
        flatpickr("#from_date", {
            dateFormat: "Y-m-d",
            maxDate: "today",
            onChange: function(selectedDates, dateStr, instance) {
                let fromDate = dateStr;
                let currentToDate = $('#to_date').val();
                if(currentToDate && new Date(currentToDate) < new Date(fromDate)){
                    $('#to_date').val('');
                    $('#to_date').flatpickr({
                        dateFormat: "Y-m-d",
                        minDate: fromDate,
                        maxDate: "today",
                    });
                } else {
                    $('#to_date').flatpickr({
                        dateFormat: "Y-m-d",
                        minDate: fromDate,
                        maxDate: "today",
                    });
                }
            }
        });
        flatpickr("#to_date", {
            dateFormat: "Y-m-d",
            maxDate: "today",
        });
        $('#rem_to').on('change', function(){
            let value = $(this).val();
            if(value == 1){
                $('.dynamic').show();
            }else{
                $('.dynamic').hide();
                $('#usr_username').val('');
            }
        });
        $('#reminderForm').on('submit', function(event) {
            if($('#from_date').val() === ''){
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Please select the "From Date".'
                });
                event.preventDefault();
                return;
            }
            if($('#rem_type').val() === ''){
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Please select the "Reminder Type".'
                });
                event.preventDefault();
                return;
            }
            if($('#rem_to').val() === ''){
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Please select the "Remind To".'
                });
                event.preventDefault();
                return;
            }
            if($('#rem_to').val() == 1 && $('#usr_username').val() === ''){
                Swal.fire({
                    icon: 'warning',
                    title: 'Warning',
                    text: 'Please provide the "File/Mobile Number".'
                });
                event.preventDefault();
                return;
            }
        });
    });
</script>