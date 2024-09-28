<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 pg-title"></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="#"><i class="ri-home-5-fill"></i></a></li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

@if(isset($user))
    @php
        $headline = "Dear ".$user->usr_first_name." ".$user->usr_last_name." your file number ".$user->usr_username." is ";
    @endphp
    @if ($user->usr_verification_status == 1)
        <div class="alert alert-success" role="alert">
            {{ $headline }} approved. Please follow <a href="{{ url('/user/approval-letter') }}">this link</a> to download your approval letter.
        </div>
    @else
        <div class="alert alert-danger" role="alert">
            {{ $headline }} pending.
        </div>
    @endif
@endif
<div class="row">
    @if(isset($profileCompletionPercentage))
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-5">
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-0"><a href="{{ url('/user/profile') }}">Profile Completed</a></h5>
                    </div>
                </div>
                <div class="progress animated-progress custom-progress progress-label">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $profileCompletionPercentage }}%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                        <div class="label">{{ $profileCompletionPercentage }}%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if(isset($documentUploadPercentage))
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-5">
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-0"><a href="{{ url('/user/documents') }}">Documents Uploaded</a></h5>
                    </div>
                </div>
                <div class="progress animated-progress custom-progress progress-label">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $documentUploadPercentage }}%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                        <div class="label">{{ $documentUploadPercentage }}%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if(isset($bankDetailsCompletionPercentage))
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-5">
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-0"><a href="{{ url('/user/bank-details') }}">Bank Details</a></h5>
                    </div>
                </div>
                <div class="progress animated-progress custom-progress progress-label">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $bankDetailsCompletionPercentage }}%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">
                        <div class="label">{{ $bankDetailsCompletionPercentage }}%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
