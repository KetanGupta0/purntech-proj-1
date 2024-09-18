        <!-- Page Title -->
        <div class="page-title dark-background"
             data-aos="fade">
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
        <section id="starter-section"
                 class="starter-section section">

            <!-- Section Title -->
            <div class="container section-title"
                 data-aos="fade-up">
                <h2 id="pg-title-second-main"></h2>
                <div><span>Admin Login Form</span> {{-- <span class="description-title">Starter Section</span> --}}</div>
            </div><!-- End Section Title -->

            <div class="container"
                 data-aos="fade-up">
                <div class="container-fluid h-custom">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-md-9 col-lg-6 col-xl-5">
                            <img src="{{ asset('public/assets/img/site/draw2.webp') }}" class="img-fluid" alt="Sample image">
                        </div>
                        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                            <form method="POST" action="{{url('/admin-login-submit')}}">
                                @csrf
                                <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                                    <p class="lead fw-normal mb-0 me-3">Sign in with</p>
                                </div>
                                <!-- Email input -->
                                <div data-mdb-input-init class="form-floating form-outline mb-4">
                                    <input type="email" id="email" name="email" class="form-control form-control-lg" placeholder="Enter a valid email address" />
                                    <label class="form-label" for="email">Email</label>
                                </div>

                                <!-- Password input -->
                                <div data-mdb-input-init class="form-floating form-outline mb-4">
                                    <input type="password" id="password" name="password" class="form-control form-control-lg" placeholder="Enter your password"/>
                                    <label class="form-label" for="password">Password</label>
                                </div>

                                <div class="text-center text-lg-start mt-4 pt-2">
                                    <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg login-submit" style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </section><!-- /Starter Section Section -->

        @if (Session::has("success"))
        <script>
            $(document).ready(function(){
                Swal.fire({
                    icon: "success",
                    title: "{{Session::get('success')}}"
                });
            });
        </script>
        @elseif(Session::has("error"))
        <script>
            $(document).ready(function(){
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    html: "{{Session::get('error')}}"
                });
            });
        </script>
        @endif
