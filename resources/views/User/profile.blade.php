<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 pg-title"></h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{url('/user-dashboard')}}"><i class="ri-home-5-fill"></i></a></li>
                    <li class="breadcrumb-item pg-title active"></li>
                </ol>
            </div>
        </div>
    </div>
</div>
@if (isset($user))
<!-- end page title -->
<div class="container-fluid mt-5">
    <form action="{{url('/user-update-profile')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-xxl-3">
                <div class="card mt-n5">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                @if ($user->usr_profile_photo == NULL || $user->usr_profile_photo == "")
                                    <img src="{{asset('public/assets/img/uploads/documents/user.png')}}" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                                @else
                                    <img src="{{asset('public/assets/img/uploads/documents')}}/{{$user->usr_profile_photo}}" class="rounded-circle avatar-xl img-thumbnail user-profile-image" alt="user-profile-image">
                                @endif
                                <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                    <input id="profile-img-file-input" type="file" name="usr_profile_photo" class="profile-img-file-input">
                                    <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                        <span class="avatar-title rounded-circle bg-light text-body">
                                            <i class="ri-camera-fill"></i>
                                        </span>
                                    </label>
                                </div>
                            </div>
                            <h5 class="fs-16 mb-1">{{$user->usr_first_name}} {{$user->usr_last_name}}</h5>
                            <p class="text-muted mb-0">Unique ID - {{$user->usr_username}}</p>
                        </div>
                    </div>
                </div>
                <!--end card-->
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-5">
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-0">Complete Your Profile</h5>
                            </div>
                            <div class="flex-shrink-0">
                                <a href="javascript:void(0);" class="badge bg-light text-primary fs-12"><i class="ri-edit-box-line align-bottom me-1"></i> Edit</a>
                            </div>
                        </div>
                        <div class="progress animated-progress custom-progress progress-label">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                                <div class="label">30%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-xxl-9">
                <div class="card mt-xxl-n5">
                    <div class="card-header">
                        <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                    <i class="fas fa-home"></i> Personal Details
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab">
                                    <i class="far fa-user"></i> Change Password
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body p-4">
                        <div class="tab-content">
                            <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="usr_first_name" class="form-label">First Name</label>
                                                <input type="text" class="form-control" id="usr_first_name" placeholder="Enter your firstname" value="{{$user->usr_first_name}}" disabled>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="usr_last_name" class="form-label">Last Name</label>
                                                <input type="text" class="form-control" id="usr_last_name" placeholder="Enter your lastname" value="{{$user->usr_last_name}}" disabled>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="usr_father" class="form-label">Father Name</label>
                                                <input type="text" class="form-control" id="usr_father" name="usr_father" placeholder="Enter your firstname" value="{{$user->usr_father}}">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="usr_mother" class="form-label">Mother Name</label>
                                                <input type="text" class="form-control" id="usr_mother" name="usr_mother" placeholder="Enter your lastname" value="{{$user->usr_mother}}">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="usr_gender" class="form-label">Gender</label>
                                                <select name="usr_gender" id="usr_gender" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="Male" @if($user->usr_gender == 'Male') selected @endif>Male</option>
                                                    <option value="Female" @if($user->usr_gender == 'Female') selected @endif>Female</option>
                                                    <option value="Other" @if($user->usr_gender == 'Other') selected @endif>Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="usr_dob" class="form-label">Date of Birth</label>
                                                <input type="text" class="form-control" data-provider="flatpickr" id="usr_dob" name="usr_dob" data-date-format="d M, Y" data-deafult-date="{{ date('d M, Y', strtotime($user->usr_dob)) }}" placeholder="Select Date of Birth" />
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="usr_email" class="form-label">Email Address</label>
                                                <input type="email" class="form-control" id="usr_email" placeholder="Enter your email" value="{{$user->usr_email}}" disabled>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="usr_mobile" class="form-label">Phone Number</label>
                                                <input type="text" class="form-control" id="usr_mobile" placeholder="Enter your phone number" value="{{$user->usr_mobile}}" disabled>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="usr_alt_mobile" class="form-label">Alternate Phone Number</label>
                                                <input type="text" class="form-control" id="usr_alt_mobile" name="usr_alt_mobile" placeholder="Enter your alternate phone number" value="{{$user->usr_alt_mobile}}">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="usr_full_address" class="form-label">Full Address</label>
                                                <textarea class="form-control" id="usr_full_address" name="usr_full_address" placeholder="Enter your complete address" rows="3">{{$user->usr_full_address}}</textarea>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="usr_landmark" class="form-label">Nearest Landmark</label>
                                                <input type="text" class="form-control" id="usr_landmark" name="usr_landmark" placeholder="Enter your nearest landmark" value="{{$user->usr_landmark}}">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button type="submit" class="btn btn-primary">Updates</button>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                
                            </div>
                            <!--end tab-pane-->
                            <div class="tab-pane" id="changePassword" role="tabpanel">
                                <form action="javascript:void(0);">
                                    <div class="row g-2">
                                        <div class="col-lg-4">
                                            <div>
                                                <label for="oldpasswordInput" class="form-label">Old Password*</label>
                                                <input type="password" class="form-control" id="oldpasswordInput" placeholder="Enter current password">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-4">
                                            <div>
                                                <label for="newpasswordInput" class="form-label">New Password*</label>
                                                <input type="password" class="form-control" id="newpasswordInput" placeholder="Enter new password">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-4">
                                            <div>
                                                <label for="confirmpasswordInput" class="form-label">Confirm Password*</label>
                                                <input type="password" class="form-control" id="confirmpasswordInput" placeholder="Confirm password">
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <a href="javascript:void(0);" class="link-primary text-decoration-underline">Forgot Password ?</a>
                                            </div>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-12">
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-success">Change Password</button>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </form>
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
</div>
@else
<h1>Please Contact Admin</h1>
@endif
<script>
    $(document).ready(function () {
    $('#profile-img-file-input').change(function (event) {
        // Check if a file was selected
        if (event.target.files && event.target.files[0]) {
            var reader = new FileReader();

            // When the file is loaded, update the img src
            reader.onload = function (e) {
                $('.user-profile-image').attr('src', e.target.result);
            };

            // Read the selected image file
            reader.readAsDataURL(event.target.files[0]);
        }
    });
});

</script>