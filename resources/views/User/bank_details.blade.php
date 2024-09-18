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
<!-- end page title -->
<style>
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
</style>
@php
    $form = '
    <div class="col-md-6">
        <div class="form-group pb-4">
            <label for="user_name">Name</label>
            <input class="form-control" type="text" id="user_name" name="user_name" placeholder="Enter your full name as per PAN Card" value="'.Session::get('fusername').' '.Session::get('lusername').'">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group pb-4">
            <label for="user_pan">PAN Number</label>
            <input class="form-control" style="text-transform: uppercase;" type="text" id="user_pan" name="user_pan" placeholder="ABCDE1234F">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group pb-4">
            <label for="user_name_in_bank">Name at Bank</label>
            <input class="form-control" type="text" id="user_name_in_bank" name="user_name_in_bank" placeholder="Enter your full name as per your bank">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group pb-4">
            <label for="user_bank_name">Bank Name</label>
            <select class="form-control" name="user_bank_name" id="user_bank_name">
                <option value="">Select</option>
                <option value="Bank 1">Bank 1</option>
                <option value="Bank 2">Bank 2</option>
                <option value="Bank 3">Bank 3</option>
                <option value="Bank 4">Bank 4</option>
                <option value="Bank 5">Bank 5</option>
                <option value="Other">Other</option>
            </select>
        </div>
    </div>
    <div class="col-md-12 other_bank" style="display: none;">
        <div class="form-group pb-4">
            <label for="user_bank_name_other">Other Bank Name</label>
            <input class="form-control" type="text" id="user_bank_name_other" name="user_bank_name_other" placeholder="Enter your bank name">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group pb-4">
            <label for="user_bank_acc">Account Number</label>
            <input class="form-control" type="password" id="user_bank_acc" name="user_bank_acc" placeholder="Enter your account number">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group pb-4">
            <label for="user_bank_acc_re">Re-enter Account Number</label>
            <input class="form-control" type="text" id="user_bank_acc_re" name="user_bank_acc_re" placeholder="Enter your account number again">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group pb-4">
            <label for="user_ifsc">IFSC Code</label>
            <input class="form-control" style="text-transform: uppercase;" type="text" id="user_ifsc" name="user_ifsc" placeholder="Enter your IFSC Code">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group pb-4">
            <label for="user_bank_proof">Upload Bank Proof Cancel Cheque / Bank Passbook</label>
            <input class="form-control" type="file" id="user_bank_proof" name="user_bank_proof">
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group pb-4 text-center">
            <input type="submit" class="btn btn-primary final-submit" value="Submit">
        </div>
    </div>
    ';
@endphp
<div class="container">
    <form action="{{url('/save-bank-info')}}" id="bank_form" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row" id="dynamic_container">
            @if (isset($data))
                <div class="col-md-6">
                    <div class="form-group pb-4">
                        <label for="user_name">Name</label>
                        <input class="form-control" type="text" placeholder="Enter your full name as per PAN Card" value="{{$data->ubd_user_name}}" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group pb-4">
                        <label for="user_pan">PAN Number</label>
                        <input class="form-control" style="text-transform: uppercase;" type="text" value="{{$data->ubd_user_pan}}" placeholder="ABCDE1234F" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group pb-4">
                        <label for="user_name_in_bank">Name at Bank</label>
                        <input class="form-control" type="text"  value="{{$data->ubd_user_name_in_bank}}" placeholder="Enter your full name as per your bank" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group pb-4">
                        <label for="user_bank_name">Bank Name</label>
                        <select class="form-control" value="{{$data->ubd_user_bank_name}}" disabled>
                            <option value="">Select</option>
                            <option value="Bank 1">Bank 1</option>
                            <option value="Bank 2">Bank 2</option>
                            <option value="Bank 3">Bank 3</option>
                            <option value="Bank 4">Bank 4</option>
                            <option value="Bank 5">Bank 5</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 other_bank" @if($data->ubd_user_bank_name_other == '' || $data->ubd_user_bank_name_other == NULL)style="display: none;" @else style="display: block;" @endif>
                    <div class="form-group pb-4">
                        <label for="user_bank_name_other">Other Bank Name</label>
                        <input class="form-control" type="text" value="{{$data->ubd_user_bank_name_other}}" placeholder="Enter your bank name" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group pb-4">
                        <label for="user_bank_acc">Account Number</label>
                        <input class="form-control" type="text" value="{{$data->ubd_user_bank_acc}}" placeholder="Enter your account number" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group pb-4">
                        <label for="user_ifsc">IFSC Code</label>
                        <input class="form-control" style="text-transform: uppercase;" type="text" value="{{$data->ubd_user_ifsc}}" placeholder="Enter your IFSC Code" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group pb-4">
                        <label for="user_bank_proof">Upload Bank Proof Cancel Chque / Bank Passbook</label>
                        <input class="form-control" type="text" value="{{$data->ubd_user_bank_proof}}" disabled>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group pb-4 text-center">
                        <div class="btn btn-success chk_btn" data-id="{{$data->ubd_user_kyc_status}}">Check Verification Status</div>
                    </div>
                </div>
                <script>
                    $(document).ready(function(){
                        let formContent = `{!! $form !!}`;
                        $(document).on('click','.chk_btn',function(){
                            let value = $(this).attr('data-id');
                            if(value == 1){
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'Pending',
                                });
                            }else if(value == 2){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Verified'
                                });
                            }else if(value == 3){
                                Swal.fire({
                                    title: "Rejected",
                                    text: "Do you want to submit your details again?",
                                    icon: "error",
                                    showCancelButton: true,
                                    confirmButtonColor: "#3085d6",
                                    cancelButtonColor: "#d33",
                                    confirmButtonText: "Yes"
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $('#dynamic_container').html(formContent);
                                    }
                                });
                            }
                        });
                    });
                </script>
            @else
                {!!$form!!}
            @endif
        </div>
    </form>
</div>
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
<script>
    $(document).ready(function() {
        $(document).on('input', '#user_pan', function() {
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
        $(document).on('change','#user_bank_name',function(){
            if($(this).val() == 'Other'){
                $('.other_bank').show();
                $(this).removeClass('is-invalid');
            }else{
                $('#user_bank_name_other').val('');
                $('#user_bank_name_other').removeClass('is-invalid');
                $('.other_bank').hide();
                if($(this).val() != ''){
                    $(this).removeClass('is-invalid');
                }
            }
        });
        $(document).on('input', '#user_ifsc', function() {
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
        $(document).on('blur','#user_name',function(){
            if($(this).val() == ''){
                $(this).addClass('is-invalid');
            }else{
                $(this).removeClass('is-invalid');
            }
        });
        $(document).on('blur','#user_pan',function(){
            if($(this).val().length == 10){
                $(this).removeClass('is-invalid');
            }else{
                $(this).addClass('is-invalid');
            }
        });
        $(document).on('blur','#user_name_in_bank',function(){
            if($(this).val().length == 0){
                $(this).addClass('is-invalid');
            }else{
                $(this).removeClass('is-invalid');
            }
        });
        $(document).on('blur','#user_bank_name',function(){
            if($(this).val() == ''){
                $(this).addClass('is-invalid');
            }else{
                $(this).removeClass('is-invalid');
            }
        });
        $(document).on('blur','#user_bank_name_other',function(){
            if($('#user_bank_name').val() == 'Other'){
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
        $(document).on('blur','#user_ifsc',function(){
            if($(this).val().length == 11){
                $(this).removeClass('is-invalid');
            }else{
                $(this).addClass('is-invalid');
            }
        });
        $(document).on('blur','#user_bank_acc',function(){
            if($(this).val().length != 0){
                $(this).removeClass('is-invalid');
            }else{
                $(this).addClass('is-invalid');
            }
        });
        $(document).on('blur','#user_bank_acc_re',function(){
            if($(this).val().length == 0){
                $(this).addClass('is-invalid');
                if($("#user_bank_acc").val().length == 0){
                    $("#user_bank_acc").addClass('is-invalid');
                }else{
                    $("#user_bank_acc").removeClass('is-invalid');
                }
            }else{
                if($(this).val() !== $('#user_bank_acc').val()){
                    $(this).addClass('is-invalid');
                    $("#user_bank_acc").addClass('is-invalid');
                }else{
                    $(this).removeClass('is-invalid');
                    $("#user_bank_acc").removeClass('is-invalid');
                }
            }
        });
        $(document).on('submit','#bank_form',function(e){
            if($('#user_name').val() == ''){
                e.preventDefault();
                $('#user_name').addClass('is-invalid');
            }else{
                $('#user_name').removeClass('is-invalid');
            }
            
            if($('#user_pan').val() == ''){
                e.preventDefault();
                $('#user_pan').addClass('is-invalid');
            }else{
                $('#user_pan').removeClass('is-invalid');
            }

            if($('#user_name_in_bank').val() == ''){
                e.preventDefault();
                $('#user_name_in_bank').addClass('is-invalid');
            }else{
                $('#user_name_in_bank').removeClass('is-invalid');
            }

            if($('#user_bank_name').val() == ''){
                e.preventDefault();
                $('#user_bank_name').addClass('is-invalid');
            }else{
                $('#user_bank_name').removeClass('is-invalid');
            }

            if($('#user_bank_name_other').val() == ''){
                e.preventDefault();
                $('#user_bank_name_other').addClass('is-invalid');
            }else{
                $('#user_bank_name_other').removeClass('is-invalid');
            }

            if($('#user_bank_acc').val() == ''){
                e.preventDefault();
                $('#user_bank_acc').addClass('is-invalid');
            }else{
                $('#user_bank_acc').removeClass('is-invalid');
            }

            if($('#user_bank_acc_re').val() == ''){
                e.preventDefault();
                $('#user_bank_acc_re').addClass('is-invalid');
            }else{
                $('#user_bank_acc_re').removeClass('is-invalid');
            }

            if($('#user_ifsc').val() == ''){
                e.preventDefault();
                $('#user_ifsc').addClass('is-invalid');
            }else{
                $('#user_ifsc').removeClass('is-invalid');
            }

            if($('#user_bank_proof').val() == ''){
                e.preventDefault();
                $('#user_bank_proof').addClass('is-invalid');
            }else{
                $('#user_bank_proof').removeClass('is-invalid');
            }

        });
    });

</script>