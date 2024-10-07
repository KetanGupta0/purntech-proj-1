</div>
<!-- end .h-100-->
</div>
<!-- end col -->
</div>
</div>
<!-- container-fluid -->
</div>
<!-- End Page-content -->
<div class="row">
    
    
</div>
<footer class="footer" style="height: unset!important;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <marquee behavior="infinit" direction="left" style="border: 0px solid rgb(189, 189, 189);">
                    <div class="me-1" style="display: inline-block"><img style="max-height: 60px; max-width: 60px;" src="{{ asset('public/dashboard/assets/footer_logo/airtel_new.jpg') }}" alt="logo"></div>
                    <div class="me-1" style="display: inline-block"><img style="max-height: 60px; max-width: 60px;" src="{{ asset('public/dashboard/assets/footer_logo/bsnl_new.jpg') }}" alt="logo"></div>
                    <div class="me-1" style="display: inline-block"><img style="max-height: 60px; max-width: 60px;" src="{{ asset('public/dashboard/assets/footer_logo/jio_new.jpg') }}" alt="logo"></div>
                    <div class="me-1" style="display: inline-block"><img style="max-height: 60px; max-width: 60px;" src="{{ asset('public/dashboard/assets/footer_logo/MTNL-logo-1200x750.jpg') }}" alt="logo"></div>
                    <div class="me-1" style="display: inline-block"><img style="max-height: 60px; max-width: 60px;" src="{{ asset('public/dashboard/assets/footer_logo/Vi-1.png') }}" alt="logo"></div>
                </marquee>
            </div>
            <div class="col-md-12">
                <p class="text-center fs-10">All trademarks, logos and brand names are the property of their respective owners. All company, product and service names used in this website are for identification purposes only. Use of these names,trademarks and brands does not imply endorsement.</p>
            </div>
            <div class="col-sm-12 text-center">
                <script>
                    document.write(new Date().getFullYear());
                </script>
                © Bharti Infratel Tower. Design & Develop by Bharti Infratel
            </div>
        </div>
    </div>
</footer>
</div>
<!-- end main content-->
</div>
<!-- END layout-wrapper -->

<!--start back-to-top-->
<button onclick="topFunction()"
        class="btn btn-danger btn-icon"
        id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>
<!--end back-to-top-->
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
@if (Session::has('success'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: "success",
                title: "{{ Session::get('success') }}"
            });
        });
    </script>
@elseif(Session::has('error'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: "error",
                title: "Error",
                html: "{{ Session::get('error') }}"
            });
        });
    </script>
@endif
<!--preloader-->
<div id="preloader">
    <div id="status">
        <div class="spinner-border text-primary avatar-sm"
             role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>
</body>
<!-- JAVASCRIPT -->
<script type='text/javascript' src="{{ asset('public/dashboard/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script type='text/javascript' src="{{ asset('public/dashboard/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script type='text/javascript' src="{{ asset('public/dashboard/assets/libs/node-waves/waves.min.js') }}"></script>
<script type='text/javascript' src="{{ asset('public/dashboard/assets/libs/feather-icons/feather.min.js') }}"></script>
<script type='text/javascript' src="{{ asset('public/dashboard/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
<script type='text/javascript' src='{{ asset('public/dashboard/assets/js/toastify-js.js') }}'></script>
<script type='text/javascript' src='{{ asset('public/dashboard/assets/libs/choices.js/public/assets/scripts/choices.min.js') }}'></script>
<script type='text/javascript' src='{{ asset('public/dashboard/assets/libs/flatpickr/flatpickr.min.js') }}'></script>
<script type='text/javascript' src='{{ asset('public/dashboard/assets/libs/apexcharts/apexcharts.min.js') }}'></script>
<script type='text/javascript' src='{{ asset('public/dashboard/assets/js/plugins.js') }}'></script>
<script type='text/javascript' src='{{ asset('public/dashboard/assets/js/pages/dashboard-crm.init.js') }}'></script>

<!-- App js -->
<script type='text/javascript' src="{{ asset('public/dashboard/assets/js/app.js') }}"></script>
<script>
    $(document).ready(function() {
        // Get the current URL path
        var path = window.location.pathname;

        // Extract the last segment of the path
        var lastSegment = path.substring(path.lastIndexOf('/') + 1);
        var pageTitle = lastSegment.replace(/-/g, ' ').replace(/\b\w/g, function(l) {
            return l.toUpperCase();
        });
        
        if (pageTitle == 'Admin Dashboard') {
            document.title = 'Admin Dashboard - Bharti Infratel Tower';
            $('.dashboard').addClass('active');
        } else {
            // Set the page title
            document.title = 'Admin '+pageTitle+' - Bharti Infratel Tower';
            $('.' + lastSegment).addClass('active');
            // Set the content of the #page-title div
            $('.pg-title').html(pageTitle);
            $('#pg-title-main').html(pageTitle);
            $('#pg-title-second-main').html(pageTitle.toUpperCase());

        }
        function updateCompanyDetails(){
            $.get("{{ url('fetch-company-info') }}",function(res){
                if(res.cmp_logo == "" || res.cmp_logo == null || res.cmp_logo == undefined){
                    $(".logo-lg").html(`<img src="{{ asset('public/dashboard/assets/images/logo-light.png') }}" alt="" height="17" />`);
                    $(".logo-sm").html(`<img src="{{ asset('public/dashboard/assets/images/logo-sm.png') }}" alt="" height="22" />`);
                }else{
                    $(".logo-lg").html(`<img src="{{ asset('public/assets/img/uploads/logos') }}/${res.cmp_logo}" alt="" height="29" /> <span class="text-light fs-5">${res.cmp_name}</span>`);
                    $(".logo-sm").html(`<img src="{{ asset('public/assets/img/uploads/logos') }}/${res.cmp_logo}" alt="" height="22" />`);
                }
            }).fail(function(err){console.log(err);
            });
        }
        updateCompanyDetails();
        function fetchUserProfilePicture(){
        $.get("{{url('/get-admin-profile-picture')}}",function(res){
            console.log(res);
            
            if($.isEmptyObject(res) || res == null || res == undefined || res == '' || res.length == 0){
                //
            }else{
                $('.header-profile-user').attr('src',"{{asset('public/assets/img/uploads/documents')}}/"+res);
            }
        }).fail(function(err){
            console.log(err);
        });
    }
    fetchUserProfilePicture();
    });
</script>

</body>

</html>
