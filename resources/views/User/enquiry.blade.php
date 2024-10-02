        <style>
            .divider:after,
            .divider:before {
                content: "";
                flex: 1;
                height: 1px;
                background: #eee;
            }

            .h-custom {
                height: calc(100% - 73px);
            }

            .upload {
                opacity: 0;
            }

            .upload-label {
                position: absolute;
                top: 50%;
                left: 1rem;
                transform: translateY(-50%);
            }

            @media (max-width: 450px) {
                .h-custom {
                    height: 100%;
                }
            }
        </style>
        <!-- Page Title -->
        <div class="page-title dark-background" data-aos="fade">
            <div class="heading">
                <div class="container">
                    <div class="row d-flex justify-content-center text-center">
                        <div class="col-lg-8">
                            <h1 id="pg-title-main"></h1>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="breadcrumbs">
                <div class="container">
                    <ol>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li class="current pg-title"></li>
                    </ol>
                </div>
            </nav>
        </div><!-- End Page Title -->

        <!-- Starter Section Section -->
        <section id="starter-section" class="starter-section section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2 id="pg-title-second-main"></h2>
                <div><span>Bharti Infratel Tower Apply Online Now</span> </div>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up">
                <div class="container-fluid h-custom">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-md-9 col-lg-6 col-xl-5">
                            <img src="{{ asset('public/assets/img/site/draw2.webp') }}" class="img-fluid"
                                alt="Sample image">
                        </div>
                        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                            <form action="{{ url('enquiry-submit') }}" method="POST" enctype="multipart/form-data">
                                <h3>Mobile Tower Installation Application Details</h3>
                                <!-- First Name input -->
                                <div data-mdb-input-init class="form-floating form-outline mb-4">
                                    <input type="text" id="first_name" name="first_name" class="form-control form-control-lg"
                                        placeholder="Enter your first name" required />
                                    <label class="form-label" for="first_name">First Name <span
                                            class="text-danger">*</span></label>
                                </div>
                                <!-- Last Name input -->
                                <div data-mdb-input-init class="form-floating form-outline mb-4">
                                    <input type="text" id="last_name" name="last_name" class="form-control form-control-lg"
                                        placeholder="Enter your last name" required />
                                    <label class="form-label" for="last_name">Last Name <span
                                            class="text-danger">*</span></label>
                                </div>
                                <!-- Email input -->
                                <div data-mdb-input-init class="form-floating form-outline mb-4">
                                    <input type="email" id="email" name="email" class="form-control form-control-lg"
                                        placeholder="Enter a valid email address" required />
                                    <label class="form-label" for="email">Email address <span
                                            class="text-danger">*</span></label>
                                </div>
                                <!-- Mobile input -->
                                <div data-mdb-input-init class="form-floating form-outline mb-4">
                                    <input type="text" id="mobile" name="mobile" class="form-control form-control-lg"
                                        placeholder="Enter a valid mobile number" required />
                                    <label class="form-label" for="mobile">Mobile Number <span
                                            class="text-danger">*</span></label>
                                </div>
                                <h3>Service</h3>
                                <!-- Service input -->
                                <div data-mdb-input-init class="form-floating form-outline mb-4">
                                    <select name="service" id="service" class="form-control" required>
                                        <option value="">Select</option>
                                        @foreach ($company as $service)
                                            <option value="{{ $service->cms_service_name }}">{{ $service->cms_service_name }}</option>
                                        @endforeach
                                    </select>
                                    <label class="form-label" for="service">Service <span
                                            class="text-danger">*</span></label>
                                </div>

                                <!-- Date input -->
                                <div data-mdb-input-init class="form-floating form-outline mb-3">
                                    <input type="date" name="date" id="date" class="form-control"
                                        onclick="showPicker()" onblur="validateDate()" required>
                                    <label for="date">Select a Date <span class="text-danger">*</span></label>
                                </div>

                                <h3>Documents</h3>

                                <div class="input-group mb-1 px-1 py-1 rounded-pill bg-white shadow-sm mt-1">
                                    <input id="upload_aadhar_front" name="upload_aadhar_front" type="file" onchange="readURL(this);"
                                        class="form-control border-0 upload">
                                    <label for="upload_aadhar_front"
                                        class="font-weight-light text-muted upload-label">Aadhar Front</label>
                                    <div class="input-group-append">
                                        <label for="upload" class="btn btn-light m-0 rounded-pill px-4 afb">
                                            <i class="fa fa-cloud-upload mr-2 text-muted"></i>
                                            <small class="text-uppercase font-weight-bold text-muted">Choose
                                                file</small>
                                        </label>
                                    </div>
                                </div>

                                <!-- Uploaded image area-->
                                
                                <div class="input-group mb-1 px-2 py-1 rounded-pill bg-white shadow-sm mt-2">
                                    <input id="upload_aadhar_back" name="upload_aadhar_back" type="file" onchange="readURL(this);"
                                        class="form-control border-0 upload">
                                    <label for="upload_aadhar_back"
                                        class="font-weight-light text-muted upload-label">Aadhar Back</label>
                                    <div class="input-group-append">
                                        <label for="upload" class="btn btn-light m-0 rounded-pill px-4 abb">
                                            <i class="fa fa-cloud-upload mr-2 text-muted"></i>
                                            <small class="text-uppercase font-weight-bold text-muted">Choose
                                                file</small>
                                        </label>
                                    </div>
                                </div>

                                <!-- Uploaded image area-->
                                
                                <div class="input-group mb-1 px-1 py-1 rounded-pill bg-white shadow-sm mt-2">
                                    <input id="upload_pan_card" name="upload_pan_card" type="file" onchange="readURL(this);"
                                        class="form-control border-0 upload">
                                    <label for="upload_pan_card" class="font-weight-light text-muted upload-label">PAN
                                        Card</label>
                                    <div class="input-group-append">
                                        <label for="upload" class="btn btn-light m-0 rounded-pill px-4 pab">
                                            <i class="fa fa-cloud-upload mr-2 text-muted"></i>
                                            <small class="text-uppercase font-weight-bold text-muted">Choose
                                                file</small>
                                        </label>
                                    </div>
                                </div>

                                <!-- Uploaded image area-->
                                

                                <div class="text-center text-lg-start mt-4 pt-2">
                                    <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                        class="btn btn-primary btn-lg"
                                        style="padding-left: 2.5rem; padding-right: 2.5rem;">📨 Submit</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </section><!-- /Starter Section Section -->

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if ($errors->any())
                    Swal.fire({
                        title: 'Error!',
                        icon: 'error',
                        html: `<ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>`,
                        confirmButtonText: 'OK'
                    });
                @endif
            });
        </script>
        @if (Session::has('status'))
            @if (Session::get('status') == true)
                <script>
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        html: "{{Session::get('message')}}"
                    });
                </script>
            @endif
        @endif
        @if (Session::has('err_code'))
            @if (Session::get('err_code') == 900)
                <script>
                    Swal.fire({
                        icon: "warning",
                        title: "Oops..",
                        html: "<p>Something went wrong! Please refresh the page and try again or contact the site admin!</p>"
                    });
                    console.log("{{Session::get('message')}}");
                </script>
            @else
                <script>
                    Swal.fire({
                        icon: "warning",
                        title: "Oops..",
                        html: "{{Session::get('message')}}"
                    });
                </script>
            @endif
        @endif
        
        <script>
            // $(function() {
            //     $("#date").datepicker();
            //     $("#date").datepicker("option", "dateFormat", "dd-mm-yy");
            // });

            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        // Check which input triggered the change
                        if (input.id === 'upload_aadhar_front') {
                            $('#aadharFrontImageResult').attr('src', e.target.result);
                        } else if (input.id === 'upload_aadhar_back') {
                            $('#aadharBackImageResult').attr('src', e.target.result);
                        } else if (input.id === 'upload_pan_card') {
                            $('#panCardImageResult').attr('src', e.target.result);
                        }
                    }

                    reader.readAsDataURL(input.files[0]); // Read the file
                }
            }

            function setMinDate() {
                var dateInput = document.getElementById('date');
                var today = new Date();
                var tomorrow = new Date(today);

                // Set tomorrow's date
                tomorrow.setDate(tomorrow.getDate() + 1);

                // Format the date to YYYY-MM-DD
                var year = tomorrow.getFullYear();
                var month = ('0' + (tomorrow.getMonth() + 1)).slice(-2); // Add leading 0
                var day = ('0' + tomorrow.getDate()).slice(-2); // Add leading 0

                // Set the min attribute so only future dates can be selected
                dateInput.min = `${year}-${month}-${day}`;
            }

            // Call the function when the page loads to set the min date
            document.addEventListener('DOMContentLoaded', setMinDate);

            // Function to validate the date on form submission
            function validateDate() {
                const dateInput = document.getElementById('date');
                const selectedDate = new Date(dateInput.value);
                const today = new Date();
                const tomorrow = new Date(today);
                tomorrow.setDate(today.getDate()); // Calculate tomorrow's date

                // Check if the selected date is before tomorrow
                if (selectedDate < tomorrow) {
                    Swal.fire({
                        icon: "warning",
                        title: "Warning",
                        text: "Please select a date from tomorrow onwards."
                    });

                    dateInput.value = '';
                }
            }

            $(document).on('input','#mobile',function() {
                // Get the input value
                var value = $(this).val();

                // Remove non-numeric characters
                value = value.replace(/\D/g, '');

                // Limit the input to 10 digits
                if (value.length > 10) {
                    value = value.slice(0, 10);
                }

                // Update the input value
                $(this).val(value);
            });
            
            // Additional Buttons
            $(document).on('click','.afb',function(){
                $('#upload_aadhar_front').click();
            });
            $(document).on('click','.abb',function(){
                $('#upload_aadhar_back').click();
            });
            $(document).on('click','.pab',function(){
                $('#upload_pan_card').click();
            });
        </script>
