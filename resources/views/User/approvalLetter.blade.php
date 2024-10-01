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
@if (isset($user))
    <div class="card">
        <div class="card-header">
            {{ $user->usr_username }}
        </div>
        <div class="card-body">
            @if ($user->usr_verification_status == 0)
                <h5 class="card-title text-warning">Your file is pending</h5>
            @elseif ($user->usr_verification_status == 1)
                <h5 class="card-title text-success">Your file is approved</h5>
                <p class="card-text">Please follow the below button to download or view your approval letter.</p>
                <a href="{{ url('user/view-approval-letter') }}" class="btn btn-primary">View/Download</a>
            @endif
        </div>
    </div>
@endif
<script>
    $(document).ready(function() {
        $('#inv_table').DataTable();
    });
</script>
