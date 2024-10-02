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
                <div>
                    <h1>Bharti Infratel Tower</h1> {{-- <span class="description-title">Starter Section</span> --}}
                </div>
                <h2 id="pg-title-secon">Online Tower Apply Login</h2>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up">

                <div class="container-fluid h-custom">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-md-9 col-lg-6 col-xl-5">
                            <img src="{{ asset('public/assets/img/site/draw2.webp') }}" class="img-fluid" alt="Sample image">
                        </div>
                        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                            <form>
                                <div class="d-flex flex-row align-items-center justify-content-center justify-content-center">
                                    <p class="lead fw-bold mb-0 me-3"><i class="bi bi-shield-lock"></i>  Sign in with </p>
                                </div>
                                <!-- Email input -->
                                <label class="visually-hidden" for="mobile">Mobile</label>
                                <div class="input-group">
                                    <div class="input-group-text" style="font-size: 20px!important;"><i class="bi bi-phone-fill"></i></div>
                                    <input type="text" class="form-control" id="mobile" placeholder="Mobile" style="min-height: 62px; font-size: 20px;">
                                </div>
                                {{-- <div data-mdb-input-init class="form-floating form-outline mb-4">
                                    <input type="text" id="mobile" class="form-control form-control-lg" placeholder="Enter a valid email address" />
                                    <label class="form-label" for="mobile">Mobile</label>
                                </div> --}}

                                <div class="text-center text-lg-start mt-4 pt-2">
                                    <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg send-otp"
                                            style="padding-left: 1.8rem; padding-right: 1.8rem;">🔒 Send OTP</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </section><!-- /Starter Section Section -->

        <!-- Modal -->
        <div class="modal fade" id="otpModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="otpModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="otpModalLabel">OTP Sent to your mobile</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-md-8 mx-auto">
                                    <div class="form-group my-3">
                                        <label for="userotp" class="fw-bold text-center w-100"><i class="bi bi-key"></i> Type your otp</label>
                                        <input type="text" name="userotp" id="userotp" class="form-control">
                                    </div>
                                    <div class="form-group my-3 text-center">
                                        <div class="btn btn-primary verify-otp">🗝️ Verify</div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
                        html: "{{ Session::get('message') }}"
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
                        html: "{{ Session::get('message') }}"
                    });
                    console.log("{{ Session::get('message') }}");
                </script>
            @else
                <script>
                    Swal.fire({
                        icon: "warning",
                        title: "Oops..",
                        html: "{{ Session::get('message') }}"
                    });
                </script>
            @endif
        @endif
        <script>
            $(document).ready(function() {
                // $('#otpModal').modal('show');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                function verifyMobile(mobile, callback) {
                    $.post("{{ url('check-user-mobile') }}", {
                        mobile: mobile
                    }).done(function(res) {
                        callback(res); // Pass the response to the callback
                    }).fail(function(err) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: err.responseJSON.message
                        });
                    });
                }

                $('.send-otp').click(function() {
                    verifyMobile($('#mobile').val(), function(response) {
                        if (response == true) {
                            $('#otpModal').modal('show');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: "User not registered. If you have an account, it may be blocked."
                            });
                        }
                    });
                });

                $(document).on('click', '.verify-otp', function() {
                    $.post("{{ url('match-otp') }}", {
                        otp: $('#userotp').val(),
                        mobile: $('#mobile').val()
                    }, function(res) {
                        if (res == true) {
                            window.location.href = "{{ url('/user-dashboard') }}";
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Invalid OTP',
                                text: 'Please check the otp and try again!'
                            });
                        }
                    }).fail(function(err) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: err.responseJSON.message
                        });
                    });
                });
            });
        </script>
