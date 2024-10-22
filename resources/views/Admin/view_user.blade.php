<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 pg-title"></h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{url('/admin-dashboard')}}"><i class="ri-home-5-fill"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{url('/admin/user-profiles')}}">User Profiles</a></li>
                    <li class="breadcrumb-item pg-title active"></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h4>Basic Details</h4>
        @if(isset($user))
            <form action="{{ url('/admin/user-profiles/user-update') }}" method="post">
                @csrf
                <input type="hidden" name="uid" value="{{ $user->usr_id }}">
                <div class="row">
                    <div class="col-md-4 mt-3">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="usr_first_name" name="usr_first_name"
                                placeholder="First Name" value="{{ $user->usr_first_name }}">
                            <label for="usr_first_name">First Name</label>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="usr_last_name" name="usr_last_name"
                                placeholder="Last Name" value="{{ $user->usr_last_name }}">
                            <label for="usr_last_name">Last Name</label>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="usr_email" name="usr_email"
                                placeholder="Email" value="{{ $user->usr_email }}">
                            <label for="usr_email">Email</label>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="usr_mobile" name="usr_mobile"
                                placeholder="Primary Phone" value="{{ $user->usr_mobile }}">
                            <label for="usr_mobile">Primary Phone</label>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="usr_alt_mobile" name="usr_alt_mobile"
                                placeholder="Secondary Phone" value="{{ $user->usr_alt_mobile }}">
                            <label for="usr_alt_mobile">Secondary Phone</label>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" data-provider="flatpickr" id="usr_dob" name="usr_dob" data-date-format="Y-m-d" data-deafult-date="{{ date('Y-m-d', strtotime($user->usr_dob)) }}" placeholder="Select Date of Birth" />
                            <label for="usr_dob">Date of birth <span class="text-muted">(yyyy-mm-dd)</span></label>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-floating mb-3">
                            <select name="usr_gender" id="usr_gender" class="form-control">
                                <option value="">Select</option>
                                <option value="Male" {{ $user->usr_gender == "Male" ? "selected" : "" }}>Male</option>
                                <option value="Female" {{ $user->usr_gender == "Female" ? "selected" : "" }}>Female</option>
                                <option value="Other" {{ $user->usr_gender == "Other" ? "selected" : "" }}>Other</option>
                            </select>
                            <label for="usr_gender">Gender</label>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="usr_father" name="usr_father"
                                placeholder="Father Name" value="{{ $user->usr_father }}">
                            <label for="usr_father">Father Name</label>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="usr_mother" name="usr_mother"
                                placeholder="Mother Name" value="{{ $user->usr_mother }}">
                            <label for="usr_mother">Mother Name</label>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="usr_full_address" name="usr_full_address"
                                placeholder="City, State, Country - Pin" value="{{ $user->usr_full_address }}">
                            <label for="usr_full_address">City, State, Country - Pin</label>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="usr_landmark" name="usr_landmark"
                                placeholder="Village/Street/Colony" value="{{ $user->usr_landmark }}">
                            <label for="usr_landmark">Village/Street/Colony</label>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="latitude" name="latitude"
                                placeholder="Latitude" value="@if(isset($location)) {{$location->loc_latitude}} @endif">
                            <label for="latitude">Latitude</label>
                        </div>
                    </div>
                    <div class="col-md-6 mt-3">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="longitude" name="longitude"
                                placeholder="Longitude" value="@if(isset($location)) {{$location->loc_longitude}} @endif">
                            <label for="longitude">Longitude</label>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-floating mb-3">
                            <select name="usr_service" id="usr_service" class="form-control">
                                <option value="">Select</option>
                                @foreach ($services as $s)
                                    <option value="{{ $s->cms_service_name }}" {{ $user->usr_service == $s->cms_service_name ? "selected" : "" }}>{{ $s->cms_service_name }}</option>
                                @endforeach
                            </select>
                            <label for="usr_service">Service</label>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="usr_adv_amount" name="usr_adv_amount"
                                placeholder="Enter Advance Amount" value="{{ $user->usr_adv_amount }}">
                            <label for="usr_adv_amount">Advance Amount</label>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="usr_mon_rent" name="usr_mon_rent"
                                placeholder="Enter Monthly Rent" value="{{ $user->usr_mon_rent }}">
                            <label for="usr_mon_rent">Monthly Rent</label>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="usr_adv_txnid" name="usr_adv_txnid"
                                placeholder="Enter Transaction ID" value="{{ $user->usr_adv_txnid }}">
                            <label for="usr_adv_txnid">Transaction ID</label>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3">
                        <div class="form-floating mb-3">
                            <select name="usr_adv_status" id="usr_adv_status" class="form-control">
                                <option value="">Select</option>
                                <option value="0" {{ $user->usr_adv_status == "0" ? "selected" : "" }}>Not Paid</option>
                                <option value="1" {{ $user->usr_adv_status == "1" ? "selected" : "" }}>Paid</option>
                            </select>
                            <label for="usr_adv_status">Payment Status</label>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3">
                        <input type="submit" value="Update" class="btn btn-sm btn-primary">
                    </div>
                </div>
            </form>
        @else
            <h3>Something went wrong. Please contact the site admin!</h3>
        @endif
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h4>Documents</h4>
        @if(isset($user))
            <form action="{{ url('/admin/user-profiles/user-documents-update') }}" method="POST" enctype="multipart/form-data" class="mt-3">
                @csrf
                <input type="hidden" name="uid" value="{{ $user->usr_id }}">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-control mb-3">
                            <label for="">Aadhar Card Front</label>
                            <input type="file" name="aadharf" id="aadharf" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-control mb-3">
                            <label for="">Aadhar Card Back</label>
                            <input type="file" name="aadharb" id="aadharb" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-control mb-3">
                            <label for="">PAN Card</label>
                            <input type="file" name="pancard" id="pancard" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-control mb-3">
                            <label for="">Bank Passbook / Cancel Cheque</label>
                            <input type="file" name="passbook" id="passbook" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-control mb-3">
                            <label for="">Voter ID / Driving License</label>
                            <input type="file" name="dl" id="dl" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-control mb-3">
                            <label for="">Land Doucments</label>
                            <input type="file" name="ld" id="ld" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-control mb-3">
                            <label for="">Land Photographs</label>
                            <input type="file" name="lp" id="lp" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                    </div>
                </div>
            </form>
        @endif
    </div>
</div>