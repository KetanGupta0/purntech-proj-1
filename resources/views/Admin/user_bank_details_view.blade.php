<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 pg-title"></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{url('/admin-dashboard')}}"><i class="ri-home-5-fill"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{url('/admin/user-bank-details')}}">User Bank Details</a></li>
                    <li class="breadcrumb-item pg-title active"></li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
@if (isset($user) && isset($bankDetails))
    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; margin-bottom: 1rem; border-bottom: 1px solid rgb(180, 180, 180)">
        <div class="mb-3">
            <div class="fw-bold">User ID - {{ $user->usr_username }}</div>
            <div class="fw-bold">Name - {{ $user->usr_first_name }} {{ $user->usr_last_name }}</div>
            <div class="fw-bold">Email ID - {{ $user->usr_email }}</div>
        </div>
        <form action="{{ url('/admin/user-bank-details/update-status') }}" method="POST" class="mb-3" style="display: flex; flex-wrap: wrap; justify-content: center;">
            @csrf
            <input type="hidden" name="uid" value="{{ $user->usr_id }}">
            <input type="hidden" name="ubdid" value="{{ $bankDetails->ubd_usr_id }}">
            <select name="ubd_user_kyc_status" id="ubd_user_kyc_status" class="form-control" style="max-width: fit-content;">
                <option value="">Change KYC Status</option>
                <option value="1" {{ $bankDetails->ubd_user_kyc_status == 1 ? "selected" : "" }}>Approved</option>
                <option value="3" {{ $bankDetails->ubd_user_kyc_status == 3 ? "selected" : "" }}>Pending</option>
                <option value="2" {{ $bankDetails->ubd_user_kyc_status == 2 ? "selected" : "" }}>Processing</option>
                <option value="4" {{ $bankDetails->ubd_user_kyc_status == 4 ? "selected" : "" }}>Rejected</option>
            </select>
            <button type="submit" class="btn btn-secondary">Update</button>
        </form>
    </div>
    <section>
        <h2 class="text-center">Bank Details</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mt-3">
                    <label for="">User Name in Bank</label>
                    <input type="text" class="form-control" name="" id="" value="{{ $bankDetails->ubd_user_name_in_bank }}" disabled>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mt-3">
                    <label for="">Bank Name</label>
                    <input type="text" class="form-control" name="" id="" value="@if($bankDetails->ubd_user_bank_name == "Other") {{ $bankDetails->ubd_user_bank_name_other }} @else {{ $bankDetails->ubd_user_bank_name }} @endif" disabled>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mt-3">
                    <label for="">Account Number</label>
                    <input type="text" class="form-control" name="" id="" value="{{ $bankDetails->ubd_user_bank_acc }}" disabled>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mt-3">
                    <label for="">IFSC Code</label>
                    <input type="text" class="form-control" style="text-transform: uppercase;" name="" id="" value="{{ $bankDetails->ubd_user_ifsc }}" disabled>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mt-3">
                    <label for="">PAN Number</label>
                    <input type="text" class="form-control" style="text-transform: uppercase;" name="" id="" value="{{ $bankDetails->ubd_user_pan }}" disabled>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group mt-3">
                    <label for="">Bank Proof</label>
                    <div>
                        <a href="{{ asset('public/assets/uploads/documents') }}/{{ $bankDetails->ubd_user_bank_proof }}" class="btn btn-primary" target="_blank">View</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@else
    No
@endif