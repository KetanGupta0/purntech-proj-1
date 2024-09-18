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
<style>
    th{
        text-align: center!important;
    }
</style>
<div class="container-fluid">
    <table class="table" id="documents_table">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Document Name</th>
                <th>Upload Status</th>
                <th>KYC Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="documents">
            <tr>
                <th>1.</th>
                <th>Aadhar Card Front</th>
                <th id="af_upload_status"><span class="text-danger">Not Uploaded</span></th>
                <th id="af_kyc_status"><span class="">-</span></th>
                <th id="af_btn">
                    {{-- <i class="btn btn-outline-primary fs-4 px-2 py-1 ri-eye-line" id="af_view"></i> --}}
                    <i class="btn btn-outline-success fs-4 px-2 py-1 ri-upload-cloud-line int_upload" id="af_upload" data-id="1"></i>
                </th>
            </tr>
            <tr>
                <th>2.</th>
                <th>Aadhar Card Back</th>
                <th id="ab_upload_status"><span class="text-danger">Not Uploaded</span></th>
                <th id="ab_kyc_status"><span class="">-</span></th>
                <th id="ab_btn">
                    {{-- <i class="btn btn-outline-primary fs-4 px-2 py-1 ri-eye-line" id="ab_view"></i> --}}
                    <i class="btn btn-outline-success fs-4 px-2 py-1 ri-upload-cloud-line int_upload" id="ab_upload" data-id="2"></i>
                </th>
            </tr>
            <tr>
                <th>3.</th>
                <th>PAN Card</th>
                <th id="pan_upload_status"><span class="text-danger">Not Uploaded</span></th>
                <th id="pan_kyc_status"><span class="">-</span></th>
                <th id="pan_btn">
                    {{-- <i class="btn btn-outline-primary fs-4 px-2 py-1 ri-eye-line" id="pan_view"></i> --}}
                    <i class="btn btn-outline-success fs-4 px-2 py-1 ri-upload-cloud-line int_upload" id="pan_upload" data-id="3"></i>
                </th>
            </tr>
            <tr>
                <th>4.</th>
                <th>Bank Passbook / Cancel Cheque</th>
                <th id="chk_upload_status"><span class="text-danger">Not Uploaded</span></th>
                <th id="chk_kyc_status"><span class="">-</span></th>
                <th id="chk_btn">
                    {{-- <i class="btn btn-outline-primary fs-4 px-2 py-1 ri-eye-line" id="chk_view"></i> --}}
                    <i class="btn btn-outline-success fs-4 px-2 py-1 ri-upload-cloud-line int_upload" id="chk_upload" data-id="4"></i>
                </th>
            </tr>
            <tr>
                <th>5.</th>
                <th>Voter ID / Driving License</th>
                <th id="dl_upload_status"><span class="text-danger">Not Uploaded</span></th>
                <th id="dl_kyc_status"><span class="">-</span></th>
                <th id="dl_btn">
                    {{-- <i class="btn btn-outline-primary fs-4 px-2 py-1 ri-eye-line" id="dl_view"></i> --}}
                    <i class="btn btn-outline-success fs-4 px-2 py-1 ri-upload-cloud-line int_upload" id="dl_upload" data-id="5"></i>
                </th>
            </tr>
            <tr>
                <th>6.</th>
                <th>Land Doucments</th>
                <th id="lan_upload_status"><span class="text-danger">Not Uploaded</span></th>
                <th id="lan_kyc_status"><span class="">-</span></th>
                <th id="lan_btn">
                    {{-- <i class="btn btn-outline-primary fs-4 px-2 py-1 ri-eye-line" id="lan_view"></i> --}}
                    <i class="btn btn-outline-success fs-4 px-2 py-1 ri-upload-cloud-line int_upload" id="lan_upload" data-id="6"></i>
                </th>
            </tr>
            <tr>
                <th>7.</th>
                <th>Land Photographs</th>
                <th id="lan_pic_upload_status"><span class="text-danger">Not Uploaded</span></th>
                <th id="lan_pic_kyc_status"><span class="">-</span></th>
                <th id="lan_pic_btn">
                    {{-- <i class="btn btn-outline-primary fs-4 px-2 py-1 ri-eye-line" id="lan_pic_view"></i> --}}
                    <i class="btn btn-outline-success fs-4 px-2 py-1 ri-upload-cloud-line int_upload" id="lan_pic_upload" data-id="7"></i>
                </th>
            </tr>
        </tbody>
    </table>
</div>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <form action="{{url('/upload-user-doc')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <lord-icon src="https://cdn.lordicon.com/pbhjpofq.json" trigger="loop" style="width:250px;height:250px;cursor: pointer;" class="trigger_file">
                    </lord-icon>
                    <h4 class="mb-3 doc_title">Upload</h4>
                    <div class="mt-4">
                        <p class="text-muted mb-4">
                            <input type="file" name="doc_name" id="doc_name" style="display: none;">
                            <input type="hidden" name="doc_type" id="doc_type" value="0">
                        </p>
                        <div class="hstack gap-2 justify-content-center">
                            <a href="javascript:void(0);" class="btn btn-link link-danger fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a>
                            <button type="submit" class="btn btn-success">Upload</button>
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
@if (Session::has('success'))
    <script>
        Swal.fire({
            icon: "success",
            title: "Success",
            html: "{{Session::get('success')}}"
        });
    </script>
@endif
<script>
    $(document).ready(function(){
        $('#documents_table').DataTable();
        function refreshDocumentsRecord(){
            $('#documents_table').DataTable().destroy();
            $.get("{{url('/fetch-user-documents')}}",function(res){
                var isUploaded = `<span class="text-success">Uploaded</span>`;
                let isApproved = '';
                $.each(res,function(key,val){
                    if(val.udc_status == 1){
                        isApproved = `<span class="text-warning">Pending</span>`;
                    }else if(val.udc_status == 2){
                        isApproved = `<span class="text-success">Verified</span>`;
                    }else if(val.udc_status == 0){
                        isApproved = `<span class="text-danger">Rejected</span>`;
                    }
                    switch(val.udc_doc_type){
                        case 1: 
                            $('#af_upload_status').html(isUploaded);
                            $('#af_kyc_status').html(isApproved);
                            if(val.udc_status == 0){
                                $('#af_btn').html(`<i class="btn btn-outline-success fs-4 px-2 py-1 ri-upload-cloud-line int_upload" id="af_upload" data-id="1"></i>`);
                            }else{
                                $('#af_btn').html(`No Action Required`);
                            }
                            break;
                        case 2:
                            $('#ab_upload_status').html(isUploaded);
                            $('#ab_kyc_status').html(isApproved);
                            if(val.udc_status == 0){
                                $('#ab_btn').html(`<i class="btn btn-outline-success fs-4 px-2 py-1 ri-upload-cloud-line int_upload" id="ab_upload" data-id="2"></i>`);
                            }else{
                                $('#ab_btn').html(`No Action Required`);
                            }
                            break;
                        case 3:
                            $('#pan_upload_status').html(isUploaded);
                            $('#pan_kyc_status').html(isApproved);
                            if(val.udc_status == 0){
                                $('#pan_btn').html(`<i class="btn btn-outline-success fs-4 px-2 py-1 ri-upload-cloud-line int_upload" id="pan_upload" data-id="3"></i>`);
                            }else{
                                $('#pan_btn').html(`No Action Required`);
                            }
                            break;
                        case 4:
                            $('#chk_upload_status').html(isUploaded);
                            $('#chk_kyc_status').html(isApproved);
                            if(val.udc_status == 0){
                                $('#chk_btn').html(`<i class="btn btn-outline-success fs-4 px-2 py-1 ri-upload-cloud-line int_upload" id="chk_upload" data-id="4"></i>`);
                            }else{
                                $('#chk_btn').html(`No Action Required`);
                            }
                            break;
                        case 5:
                            $('#dl_upload_status').html(isUploaded);
                            $('#dl_kyc_status').html(isApproved);
                            if(val.udc_status == 0){
                                $('#dl_btn').html(`<i class="btn btn-outline-success fs-4 px-2 py-1 ri-upload-cloud-line int_upload" id="dl_upload" data-id="5"></i>`);
                            }else{
                                $('#dl_btn').html(`No Action Required`);
                            }
                            break;
                        case 6:
                            $('#lan_upload_status').html(isUploaded);
                            $('#lan_kyc_status').html(isApproved);
                            if(val.udc_status == 0){
                                $('#lan_btn').html(`<i class="btn btn-outline-success fs-4 px-2 py-1 ri-upload-cloud-line int_upload" id="lan_upload" data-id="6"></i>`);
                            }else{
                                $('#lan_btn').html(`No Action Required`);
                            }
                            break;
                        case 7:
                            $('#lan_pic_upload_status').html(isUploaded);
                            $('#lan_pic_kyc_status').html(isApproved);
                            if(val.udc_status == 0){
                                $('#lan_pic_btn').html(`<i class="btn btn-outline-success fs-4 px-2 py-1 ri-upload-cloud-line int_upload" id="lan_pic_upload" data-id="7"></i>`);
                            }else{
                                $('#lan_pic_btn').html(`No Action Required`);
                            }
                            break;
                    }
                });
                $('#documents_table').DataTable();
            }).fail(function(err){
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: err.responseJSON.message
                });
                $('#documents_table').DataTable();
            });
        }
        refreshDocumentsRecord();
        $(document).on('click','.trigger_file',function(){$('#doc_name').click();});

        $(document).on('click','.int_upload',function(){
            let type = $(this).attr('data-id');
            $('#doc_type').val(type);
            $('#staticBackdrop').modal('show');
        });
    });
</script>