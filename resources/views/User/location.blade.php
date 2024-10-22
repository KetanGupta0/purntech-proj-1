<script>
    // Success message using Swal.fire
    @if(Session::has('location'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ Session::get('location') }}'
        });
    @endif

    // General error message using Swal.fire
    @if(Session::has('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ Session::get('error') }}'
        });
    @endif

    // Validation errors using Swal.fire
    @if($errors->any())
        let errorMessages = '';
        @foreach($errors->all() as $error)
            errorMessages += '{{ $error }}<br>';
        @endforeach

        Swal.fire({
            icon: 'error',
            title: 'Validation Errors',
            html: errorMessages,
            showConfirmButton: true
        });
    @endif
</script>
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
<!-- end page title -->
@if (isset($location))
    <div class="card ">
        <form action="{{ url('user/save-geolocation') }}" id="location-form" method="post">
            <div class="card-body">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" name="latitude" id="latitude" class="form-control" placeholder="Latitude" value="{{$location->loc_latitude}}">
                            <label for="latitude">Latitude</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" name="longitude" id="longitude" class="form-control" placeholder="Longitude" value="{{$location->loc_longitude}}">
                            <label for="longitude">Longitude</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-body-secondary">
                <input type="button" id="fetch-location" value="Fetch your location" class="btn btn-success">
                <input type="submit" id="submit" value="Save" class="btn btn-primary">
            </div>
        </form>
    </div>
@else
    <div class="card ">
        <form action="{{ url('user/save-geolocation') }}" id="location-form" method="post">
            <div class="card-body">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" name="latitude" id="latitude" class="form-control" placeholder="Latitude">
                            <label for="latitude">Latitude</label>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-floating">
                            <input type="text" name="longitude" id="longitude" class="form-control" placeholder="Longitude">
                            <label for="longitude">Longitude</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-body-secondary">
                <input type="button" id="fetch-location" value="Fetch your location" class="btn btn-success">
                <input type="submit" id="submit" value="Save" class="btn btn-primary">
            </div>
        </form>
    </div>
@endif
<script>
    $(document).ready(function() {
        $('#fetch-location').on('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        var latitude = position.coords.latitude;
                        var longitude = position.coords.longitude;
                        $('#latitude').val(latitude);
                        $('#longitude').val(longitude);
                    },
                    function(error) {
                        console.log(error);
                    });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        });
        $(document).on('submit', '#location-form', function(e) {
            let latitude = $('#latitude').val();
            let longitude = $('#longitude').val();
            if (latitude == '' || latitude == null || latitude == undefined) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Latitude is required!'
                }).then(function() {
                    $('#latitude').focus();
                });
                return;
            }
            if (longitude == '' || longitude == null || longitude == undefined) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Longitude is required!'
                }).then(function() {
                    $('#longitude').focus();
                });
                return;
            }
            // $('#location-form').submit();
        });
    });
</script>

