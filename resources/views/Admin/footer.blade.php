</div>
<!-- end .h-100-->
</div>
<!-- end col -->
</div>
</div>
<!-- container-fluid -->
</div>
<!-- End Page-content -->

<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <script>
                    document.write(new Date().getFullYear());
                </script>
                © Velzon.
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    Design & Develop by Themesbrand
                </div>
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
        
        if (pageTitle == 'Admin Dashboard View') {
            document.title = 'Admin - Dashboard';
            $('.dashboard').addClass('active');
        } else {
            // Set the page title
            document.title = 'Admin - '+pageTitle;
            $('.' + lastSegment).addClass('active');
            // Set the content of the #page-title div
            $('.pg-title').html(pageTitle);
            $('#pg-title-main').html(pageTitle);
            $('#pg-title-second-main').html(pageTitle.toUpperCase());

        }


    });
</script>

</body>

</html>
