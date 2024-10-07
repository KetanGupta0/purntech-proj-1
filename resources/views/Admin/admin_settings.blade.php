<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 pg-title"></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ url('/admin-dashboard') }}"><i class="ri-home-5-fill"></i></a></li>
                    <li class="breadcrumb-item pg-title active"></li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="accordion" id="settingAccordion">
    @if(isset($admin) && $admin->adm_status == 1)
        @if (isset($companyInfo))
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#companySettings" aria-expanded="false"
                            aria-controls="companySettings">
                        Company Settings
                    </button>
                </h2>
                <div id="companySettings" class="accordion-collapse collapse" data-bs-parent="#settingAccordion">
                    <div class="accordion-body">
                        <section>
                            <div class="card" style="width: 100%;">
                                <div class="card-body">
                                    <form action="{{ url('/admin/settings/update-company') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="cmp_name" name="cmp_name" placeholder="Enter Company Name"
                                                        value="{{ $companyInfo->cmp_name }}">
                                                    <label for="cmp_name">Company Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="cmp_short_name" name="cmp_short_name"
                                                        placeholder="Enter Company Short Name" value="{{ $companyInfo->cmp_short_name }}">
                                                    <label for="cmp_short_name">Company Short Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating mb-3">
                                                    <input type="number" class="form-control" id="cmp_mobile1" name="cmp_mobile1"
                                                        placeholder="Enter Company Phone 1" value="{{ $companyInfo->cmp_mobile1 }}">
                                                    <label for="cmp_mobile1">Phone 1</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating mb-3">
                                                    <input type="number" class="form-control" id="cmp_mobile2" name="cmp_mobile2"
                                                        placeholder="Enter Company Phone 2" value="{{ $companyInfo->cmp_mobile2 }}">
                                                    <label for="cmp_mobile2">Phone 2</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating mb-3">
                                                    <input type="number" class="form-control" id="cmp_mobile3" name="cmp_mobile3"
                                                        placeholder="Enter Company Phone 3" value="{{ $companyInfo->cmp_mobile3 }}">
                                                    <label for="cmp_mobile3">Phone 3</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="email" class="form-control" id="cmp_primary_email" name="cmp_primary_email"
                                                        placeholder="Enter Company Primary Email" value="{{ $companyInfo->cmp_primary_email }}">
                                                    <label for="cmp_primary_email">Company Primary Email</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="email" class="form-control" id="cmp_support_email" name="cmp_support_email"
                                                        placeholder="Enter Company Support Email" value="{{ $companyInfo->cmp_support_email }}">
                                                    <label for="cmp_support_email">Company Support Email</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="email" class="form-control" id="cmp_contact_email" name="cmp_contact_email"
                                                        placeholder="Enter Company Contact Email" value="{{ $companyInfo->cmp_contact_email }}">
                                                    <label for="cmp_contact_email">Company Contact Email</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="cmp_gst_no" name="cmp_gst_no"
                                                        placeholder="Enter Company GST No." value="{{ $companyInfo->cmp_gst_no }}">
                                                    <label for="cmp_gst_no">Company GST No.</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="cmp_website" name="cmp_website"
                                                        placeholder="Enter Company WebSite" value="{{ $companyInfo->cmp_website }}">
                                                    <label for="cmp_website">Company WebSite</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="cmp_address1" name="cmp_address1"
                                                        placeholder="Enter Company Address Line 1" value="{{ $companyInfo->cmp_address1 }}">
                                                    <label for="cmp_address1">Company Address Line 1</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="cmp_address2" name="cmp_address2"
                                                        placeholder="Enter Company Address Line 2" value="{{ $companyInfo->cmp_address2 }}">
                                                    <label for="cmp_address2">Company Address Line 2</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="cmp_address3" name="cmp_address3"
                                                        placeholder="Enter Company Address Line 3" value="{{ $companyInfo->cmp_address3 }}">
                                                    <label for="cmp_address3">Company Address Line 3</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="cmp_landmark" name="cmp_landmark"
                                                        placeholder="Enter Company Landmark" value="{{ $companyInfo->cmp_landmark }}">
                                                    <label for="cmp_landmark">Company Landmark</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="cmp_country" name="cmp_country"
                                                        placeholder="Enter Company Country" value="{{ $companyInfo->cmp_country }}">
                                                    <label for="cmp_country">Company Country</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="cmp_state" name="cmp_state"
                                                        placeholder="Enter Company State" value="{{ $companyInfo->cmp_state }}">
                                                    <label for="cmp_state">Company State</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="cmp_city" name="cmp_city" placeholder="Enter Company City"
                                                        value="{{ $companyInfo->cmp_city }}">
                                                    <label for="cmp_city">Company City</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating mb-3">
                                                    <input type="number" class="form-control" id="cmp_zip" name="cmp_zip"
                                                        placeholder="Enter Company Pin Code" value="{{ $companyInfo->cmp_zip }}">
                                                    <label for="cmp_zip">Company Pin Code</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="cmp_logo">Company Logo</label>
                                                    <input type="file" class="form-control" name="cmp_logo" id="cmp_logo">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="submit" class="btn btn-primary text-center mt-3" id="companyUpdateSubmit" value="Update">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        @endif
        @if (isset($companyBankInfo) && isset($banks))
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#companyBankSettings" aria-expanded="false" aria-controls="companyBankSettings">
                        Company Bank Account Settings
                    </button>
                </h2>
                <div id="companyBankSettings" class="accordion-collapse collapse" data-bs-parent="#settingAccordion">
                    <div class="accordion-body">
                        <section>
                            <div class="card" style="width: 100%;">
                                <div class="card-body">
                                    <form action="{{ url('/admin/settings/update-company-bank') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row mt-3">
                                            <div class="col-md-4">
                                                <div class="form-floating mb-2">
                                                    <select name="cbd_bank_name" id="cbd_bank_name" class="form-control">
                                                        <option value="">Select</option>
                                                        @foreach ($banks as $bank)
                                                            <option value="{{ $bank->bnk_name }}" {{ $companyBankInfo->cbd_bank_name == $bank->bnk_name ? 'selected' : '' }}>{{ $bank->bnk_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <label for="cbd_bank_name">Bank Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating mb-2">
                                                    <input type="text" name="cbd_account_number" id="cbd_account_number" placeholder="Account Number" class="form-control" value="{{ $companyBankInfo->cbd_account_number }}">
                                                    <label for="cbd_account_number">Account Number</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating mb-2">
                                                    <input type="text" name="cbd_ifsc_code" id="cbd_ifsc_code" placeholder="IFSC Code" class="form-control" value="{{ $companyBankInfo->cbd_ifsc_code }}">
                                                    <label for="cbd_ifsc_code">IFSC Code</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating mb-2">
                                                    <input type="text" name="cbd_branch" id="cbd_branch" placeholder="Branch Name" class="form-control" value="{{ $companyBankInfo->cbd_branch }}">
                                                    <label for="cbd_branch">Branch Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating mb-2">
                                                    <input type="text" name="cbd_upi_name" id="cbd_upi_name" placeholder="UPI Name" class="form-control" value="{{ $companyBankInfo->cbd_upi_name }}">
                                                    <label for="cbd_upi_name">UPI Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating mb-2">
                                                    <input type="text" name="cbd_upi_id" id="cbd_upi_id" placeholder="UPI ID" class="form-control" value="{{ $companyBankInfo->cbd_upi_id }}">
                                                    <label for="cbd_upi_id">UPI ID</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group mb-2">
                                                    <label for="cbd_qr_code">QR Code</label>
                                                    <input type="file" name="cbd_qr_code" id="cbd_qr_code"class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating mb-2">
                                                    <select name="cbd_is_hidden" id="cbd_is_hidden" class="form-control">
                                                        <option value="">Select</option>
                                                        <option value="0" {{ $companyBankInfo->cbd_is_hidden == 0 ? 'selected' : '' }}>Show</option>
                                                        <option value="1" {{ $companyBankInfo->cbd_is_hidden == 1 ? 'selected' : '' }}>Hide</option>
                                                    </select>
                                                    <label for="cbd_is_hidden">Show Bank Details</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="submit" class="btn btn-primary text-center mt-3" value="Update">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        @endif
        @if (isset($approvalInfo))
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#approvalSettings"
                            aria-expanded="false" aria-controls="approvalSettings">
                        Approval Letter Settings
                    </button>
                </h2>
                <div id="approvalSettings" class="accordion-collapse collapse" data-bs-parent="#settingAccordion">
                    <div class="accordion-body">
                        <section>
                            <div class="card" style="width: 100%;">
                                <div class="card-body">
                                    <form action="{{ url('/admin/settings/update-approval-letter') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 mt-3">
                                                <div class="form-group">
                                                    <label for="als_header_img">Header Logo</label>
                                                    <input type="file" class="form-control" name="als_header_img" id="als_header_img">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <div class="form-group">
                                                    <label for="als_footer_img">Footer Logo</label>
                                                    <input type="file" class="form-control" name="als_footer_img" id="als_footer_img">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <div class="form-group">
                                                    <label for="als_body_img_1">Body Logo 1</label>
                                                    <input type="file" class="form-control" name="als_body_img_1" id="als_body_img_1">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <div class="form-group">
                                                    <label for="als_body_img_2">Body Logo 2</label>
                                                    <input type="file" class="form-control" name="als_body_img_2" id="als_body_img_2">
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-3">
                                                <div class="form-group">
                                                    <label for="als_default_welcome_msg">Welcome Message</label>
                                                    <textarea class="form-control" name="als_default_welcome_msg" id="als_default_welcome_msg" rows="5" style="width: 100%;">{{ $approvalInfo->als_default_welcome_msg }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="submit" class="btn btn-primary text-center mt-3" id="approvalUpdateSubmit" value="Update">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        @endif
        @if (isset($invoiceInfo))
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#invoiceSettings" aria-expanded="false"
                            aria-controls="invoiceSettings">
                        Invoice Settings
                    </button>
                </h2>
                <div id="invoiceSettings" class="accordion-collapse collapse" data-bs-parent="#settingAccordion">
                    <div class="accordion-body">
                        <section>
                            <div class="card" style="width: 100%;">
                                <div class="card-body">
                                    <form action="{{ url('/admin/settings/update-invoice') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 mt-3">
                                                <div class="form-group">
                                                    <label for="ins_header_img">Header Logo</label>
                                                    <input type="file" class="form-control" name="ins_header_img" id="ins_header_img">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <div class="form-group">
                                                    <label for="ins_footer_img">Footer Logo</label>
                                                    <input type="file" class="form-control" name="ins_footer_img" id="ins_footer_img">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <div class="form-group">
                                                    <label for="ins_body_img_1">Body Logo 1</label>
                                                    <input type="file" class="form-control" name="ins_body_img_1" id="ins_body_img_1">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <div class="form-group">
                                                    <label for="ins_body_img_2">Body Logo 2</label>
                                                    <input type="file" class="form-control" name="ins_body_img_2" id="ins_body_img_2">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <div class="form-group">
                                                    <label for="ins_stamp">Stamp</label>
                                                    <input type="file" class="form-control" name="ins_stamp" id="ins_stamp">
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="ins_website" name="ins_website"
                                                        placeholder="Enter Footer URL" value="{{ $invoiceInfo->ins_website }}">
                                                    <label for="ins_website">Footer URL</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="submit" class="btn btn-primary text-center mt-3" id="invoiceUpdateSubmit" value="Update">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        @endif
        @if (isset($admin))
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accountSettings" aria-expanded="false"
                            aria-controls="accountSettings">
                        Account Settings
                    </button>
                </h2>
                <div id="accountSettings" class="accordion-collapse collapse" data-bs-parent="#settingAccordion">
                    <div class="accordion-body">
                        <section>
                            <div class="card" style="width: 100%;">
                                <div class="card-body">
                                    <form action="{{ url('/admin/settings/admin-account') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 mt-3">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="adm_first_name" name="adm_first_name"
                                                        placeholder="Enter Admin First Name" value="{{ $admin->adm_first_name }}">
                                                    <label for="adm_first_name">Admin First Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="adm_last_name" name="adm_last_name"
                                                        placeholder="Enter Admin Last Name" value="{{ $admin->adm_last_name }}">
                                                    <label for="adm_last_name">Admin Last Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <div class="form-floating mb-3">
                                                    <input type="email" class="form-control" id="adm_email" name="adm_email" placeholder="Enter Admin Email" value="{{ $admin->adm_email }}">
                                                    <label for="adm_email">Admin Email</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <div class="form-floating mb-3">
                                                    <input type="number" class="form-control" id="adm_mobile" name="adm_mobile" placeholder="Enter Admin Mobile" value="{{ $admin->adm_mobile }}">
                                                    <label for="adm_mobile">Admin Mobile</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <div class="form-floating mb-3">
                                                    <input type="password" class="form-control" id="adm_current_password" name="adm_current_password" placeholder="Enter Current Password">
                                                    <label for="adm_current_password">Current Password</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <div class="form-floating mb-3">
                                                    <input type="password" class="form-control" id="adm_new_password" name="adm_new_password" placeholder="Enter Current Password">
                                                    <label for="adm_new_password">New Password</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <div class="form-floating mb-3">
                                                    <input type="password" class="form-control" id="adm_confirm_new_password" name="adm_confirm_new_password" placeholder="Enter Current Password">
                                                    <label for="adm_confirm_new_password">Confirm New Password</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mt-3">
                                                <div class="form-group mb-3">
                                                    <label for="adm_profile_photo">Admin Profile Photo</label>
                                                    <input type="file" class="form-control" id="adm_profile_photo" name="adm_profile_photo" placeholder="Enter Login Email">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="submit" class="btn btn-primary text-center mt-3" id="accountUpdateSubmit" value="Update">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        @endif
    @else
            <h3>You don't have rights to update settings</h3>
    @endif
</div>

