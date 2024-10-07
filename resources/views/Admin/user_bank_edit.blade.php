<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 pg-title"></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ url('/admin-dashboard') }}"><i class="ri-home-5-fill"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/user-bank-details') }}">User Bank Details</a></li>
                    <li class="breadcrumb-item pg-title active"></li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
{{-- <style>
    .form-control:focus{
        border-color: #f3f3f9;
    }
    .form-control{
        border-color: #f3f3f9;
        border-bottom-color: #405189 !important;
    }
    .is-invalid{
        border-bottom-color: #f06548 !important;
    }
</style> --}}
<div class="card">
    <div class="card-body">
        @if (isset($user) && isset($bankList))
            <form action="{{ url('/admin/user-bank-details/update-user-bank-details') }}" method="POST" enctype="multipart/form-data" id="bank_form">
                @csrf
                <input type="hidden" name="uid" value="{{ $user->usr_id }}">
                <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; margin-bottom: 1rem; border-bottom: 1px solid rgb(180, 180, 180)">
                    <div class="mb-3">
                        <div class="fw-bold">User ID - {{ $user->usr_username }}</div>
                        <div class="fw-bold">Name - {{ $user->usr_first_name }} {{ $user->usr_last_name }}</div>
                        <div class="fw-bold">Email ID - {{ $user->usr_email }}</div>
                    </div>
                </div>
                @if (isset($bankDetails))
                    <section>
                        <h2 class="text-center">Bank Details</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="">User Name in Bank</label>
                                    <input type="text" class="form-control" name="ubd_user_name_in_bank" id="ubd_user_name_in_bank" value="{{ $bankDetails->ubd_user_name_in_bank }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="">Bank Name</label>
                                    <select name="ubd_user_bank_name" id="ubd_user_bank_name" class="form-control">
                                        <option value="">Select</option>
                                        @foreach ($bankList as $bank)
                                            <option value="{{ $bank->bnk_name }}" {{ $bankDetails->ubd_user_bank_name == $bank->bnk_name ? 'selected' : '' }}>{{ $bank->bnk_name }}</option>
                                        @endforeach
                                        <option value="Other" {{ $bankDetails->ubd_user_bank_name == "Other" ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 other_bank" @if($bankDetails->ubd_user_bank_name != 'Other') style="display: none;" @endif>
                                <div class="form-group mt-3">
                                    <label for="ubd_user_bank_name_other">Other Bank Name</label>
                                    <input type="text" name="ubd_user_bank_name_other" id="ubd_user_bank_name_other" class="form-control" value="{{ $bankDetails->ubd_user_bank_name_other }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="">Account Number</label>
                                    <input type="text" class="form-control" name="ubd_user_bank_acc" id="ubd_user_bank_acc" value="{{ $bankDetails->ubd_user_bank_acc }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="">IFSC Code</label>
                                    <input type="text" class="form-control" style="text-transform: uppercase;" name="ubd_user_ifsc" id="ubd_user_ifsc" value="{{ $bankDetails->ubd_user_ifsc }}" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="">PAN Number</label>
                                    <input type="text" class="form-control" style="text-transform: uppercase;" name="ubd_user_pan" id="ubd_user_pan" value="{{ $bankDetails->ubd_user_pan }}" >
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="">Bank Proof</label>
                                    <input type="file" name="ubd_user_bank_proof" id="ubd_user_bank_proof" class="form-control">
                                </div>
                            </div>
                            <div class="col-12">
                                <input type="submit" value="Update" class="btn btn-primary mt-3">
                            </div>
                        </div>
                    </section>
                @else
                    <section>
                        <h2 class="text-center">Bank Details</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="">User Name in Bank</label>
                                    <input type="text" class="form-control" name="ubd_user_name_in_bank" id="ubd_user_name_in_bank">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="">Bank Name</label>
                                    <select name="ubd_user_bank_name" id="ubd_user_bank_name" class="form-control">
                                        <option value="">Select</option>
                                        @foreach ($bankList as $bank)
                                            <option value="{{ $bank->bnk_name }}">{{ $bank->bnk_name }}</option>
                                        @endforeach
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 other_bank" style="display: none;">
                                <div class="form-group mt-3">
                                    <label for="ubd_user_bank_name_other">Other Bank Name</label>
                                    <input type="text" name="ubd_user_bank_name_other" id="ubd_user_bank_name_other" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="">Account Number</label>
                                    <input type="text" class="form-control" name="ubd_user_bank_acc" id="ubd_user_bank_acc">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="">IFSC Code</label>
                                    <input type="text" class="form-control" style="text-transform: uppercase;" name="ubd_user_ifsc" id="ubd_user_ifsc">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="">PAN Number</label>
                                    <input type="text" class="form-control" style="text-transform: uppercase;" name="ubd_user_pan" id="ubd_user_pan">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-3">
                                    <label for="">Bank Proof</label>
                                    <input type="file" name="ubd_user_bank_proof" id="ubd_user_bank_proof" class="form-control">
                                </div>
                            </div>
                            <div class="col-12">
                                <input type="submit" value="Update" class="btn btn-primary mt-3">
                            </div>
                        </div>
                    </section>
                @endif
            </form>
        @else
            Something went wrong. Please contact site admin for resolution!
        @endif
    </div>
</div>
<script>
    $(document).ready(function(){
        $(document).on('change','#ubd_user_bank_name',function(){
            if($(this).val() == 'Other'){
                $('.other_bank').show();
                $(this).removeClass('is-invalid');
            }else{
                $('#ubd_user_bank_name_other').val('');
                $('#ubd_user_bank_name_other').removeClass('is-invalid');
                $('.other_bank').hide();
                if($(this).val() != ''){
                    $(this).removeClass('is-invalid');
                }
            }
        });

        $(document).on('input', '#ubd_user_pan', function() {
            let value = $(this).val();
            let firstFive = value.substr(0, 5).replace(/[^A-Za-z]/g, '');
            let nextFour = value.substr(5, 4).replace(/[^0-9]/g, '');
            let lastChar = value.substr(9, 1).replace(/[^A-Za-z]/g, '');
            let validPAN = firstFive + nextFour + lastChar;
            $(this).val(validPAN);
            if (validPAN.length >= 10) {
                $(this).val(validPAN.substring(0, 10));
            }
        });

        $(document).on('input', '#ubd_user_ifsc', function() {
            let value = $(this).val();
            let firstFour = value.substr(0, 4).replace(/[^A-Za-z]/g, '');
            let fifthChar = value.substr(4, 1).replace(/[^0]/g, '0');
            let lastSix = value.substr(5, 6).replace(/[^A-Za-z0-9]/g, '');
            let validIFSC = firstFour + fifthChar + lastSix;
            $(this).val(validIFSC);
            if (validIFSC.length >= 11) {
                $(this).val(validIFSC.substring(0, 11));
            }
        });

        $(document).on('blur','#ubd_user_pan',function(){
            if($(this).val().length == 10){
                $(this).removeClass('is-invalid');
            }else{
                $(this).addClass('is-invalid');
            }
        });
        $(document).on('blur','#ubd_user_name_in_bank',function(){
            if($(this).val().length == 0){
                $(this).addClass('is-invalid');
            }else{
                $(this).removeClass('is-invalid');
            }
        });
        $(document).on('blur','#ubd_user_bank_name',function(){
            if($(this).val() == ''){
                $(this).addClass('is-invalid');
            }else{
                $(this).removeClass('is-invalid');
            }
        });
        $(document).on('blur','#ubd_user_bank_name_other',function(){
            if($('#ubd_user_bank_name').val() == 'Other'){
                if($(this).val() == ''){
                    $(this).addClass('is-invalid');
                }else{
                    $(this).removeClass('is-invalid');
                }
            }else{
                $('.other_bank').hide();
                $(this).removeClass('is-invalid');
            }
        });
        $(document).on('blur','#ubd_user_ifsc',function(){
            if($(this).val().length == 11){
                $(this).removeClass('is-invalid');
            }else{
                $(this).addClass('is-invalid');
            }
        });
        $(document).on('blur','#ubd_user_bank_acc',function(){
            if($(this).val().length != 0){
                $(this).removeClass('is-invalid');
            }else{
                $(this).addClass('is-invalid');
            }
        });

        $(document).on('submit','#bank_form',function(e){
            if($('#ubd_user_pan').val() == ''){
                e.preventDefault();
                $('#ubd_user_pan').addClass('is-invalid');
            }else{
                $('#ubd_user_pan').removeClass('is-invalid');
            }
            if($('#ubd_user_name_in_bank').val() == ''){
                e.preventDefault();
                $('#ubd_user_name_in_bank').addClass('is-invalid');
            }else{
                $('#ubd_user_name_in_bank').removeClass('is-invalid');
            }
            if($('#ubd_user_bank_name').val() == ''){
                e.preventDefault();
                $('#ubd_user_bank_name').addClass('is-invalid');
            }else{
                $('#ubd_user_bank_name').removeClass('is-invalid');
                if($('#ubd_user_bank_name').val() == "Other"){
                    if($('#ubd_user_bank_name_other').val() == ''){
                        e.preventDefault();
                        $('#ubd_user_bank_name_other').addClass('is-invalid');
                    }else{
                        $('#ubd_user_bank_name_other').removeClass('is-invalid');
                    }
                }
            }
            if($('#ubd_user_bank_acc').val() == ''){
                e.preventDefault();
                $('#ubd_user_bank_acc').addClass('is-invalid');
            }else{
                $('#ubd_user_bank_acc').removeClass('is-invalid');
            }
            if($('#ubd_user_ifsc').val() == ''){
                e.preventDefault();
                $('#ubd_user_ifsc').addClass('is-invalid');
            }else{
                $('#ubd_user_ifsc').removeClass('is-invalid');
            }
        });
    });
</script>