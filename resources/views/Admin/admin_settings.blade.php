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
    @if(isset($companyInfo))
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#companySettings" aria-expanded="false" aria-controls="companySettings">
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
                                        <input type="text" class="form-control" id="cmp_name" name="cmp_name" placeholder="Enter Company Name">
                                        <label for="cmp_name">Company Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="cmp_short_name" name="cmp_short_name" placeholder="Enter Company Short Name">
                                        <label for="cmp_short_name">Company Short Name</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" id="cmp_mobile1" name="cmp_mobile1" placeholder="Enter Company Phone 1">
                                        <label for="cmp_mobile1">Phone 1</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" id="cmp_mobile2" name="cmp_mobile2" placeholder="Enter Company Phone 2">
                                        <label for="cmp_mobile2">Phone 2</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" id="cmp_mobile3" name="cmp_mobile3" placeholder="Enter Company Phone 3">
                                        <label for="cmp_mobile3">Phone 3</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="cmp_primary_email" name="cmp_primary_email"
                                               placeholder="Enter Company Primary Email">
                                        <label for="cmp_primary_email">Company Primary Email</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="cmp_support_email" name="cmp_support_email"
                                               placeholder="Enter Company Support Email">
                                        <label for="cmp_support_email">Company Support Email</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="cmp_contact_email" name="cmp_contact_email"
                                               placeholder="Enter Company Contact Email">
                                        <label for="cmp_contact_email">Company Contact Email</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="cmp_gst_no" name="cmp_gst_no" placeholder="Enter Company GST No.">
                                        <label for="cmp_gst_no">Company GST No.</label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="cmp_website" name="cmp_website" placeholder="Enter Company WebSite">
                                        <label for="cmp_website">Company WebSite</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="cmp_address1" name="cmp_address1" placeholder="Enter Company Address Line 1">
                                        <label for="cmp_address1">Company Address Line 1</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="cmp_address2" name="cmp_address2" placeholder="Enter Company Address Line 2">
                                        <label for="cmp_address2">Company Address Line 2</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="cmp_address3" name="cmp_address3" placeholder="Enter Company Address Line 3">
                                        <label for="cmp_address3">Company Address Line 3</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="cmp_landmark" name="cmp_landmark" placeholder="Enter Company Landmark">
                                        <label for="cmp_landmark">Company Landmark</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="cmp_country" name="cmp_country" placeholder="Enter Company Country">
                                        <label for="cmp_country">Company Country</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="cmp_state" name="cmp_state" placeholder="Enter Company State">
                                        <label for="cmp_state">Company State</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="cmp_city" name="cmp_city" placeholder="Enter Company City">
                                        <label for="cmp_city">Company City</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating mb-3">
                                        <input type="number" class="form-control" id="cmp_zip" name="cmp_zip" placeholder="Enter Company Pin Code">
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

    @if(isset($approvalInfo))
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#approvalSettings" aria-expanded="false" aria-controls="approvalSettings">
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
                                        <textarea class="form-control" name="als_default_welcome_msg" id="als_default_welcome_msg" rows="5" style="width: 100%;"></textarea>
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

    @if(isset($invoiceInfo))
    <div class="accordion-item">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#invoiceSettings" aria-expanded="false" aria-controls="invoiceSettings">
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
                                        <input type="text" class="form-control" id="ins_website" name="ins_website" placeholder="Enter Footer URL">
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
  </div>
  @endif



