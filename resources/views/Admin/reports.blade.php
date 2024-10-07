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
<div class="card">
    <h5 class="card-header">Approved Files</h5>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="approvalTable">
                <thead>
                    <tr>
                        <th>S. No.</th>
                        <th>File Number</th>
                        <th>User Name</th>
                        <th>User email</th>
                        <th>User phone</th>
                        <th>Status</th>
                        <th>Updated Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($users))
                        @foreach ($users as $user)
                            <tr>
                                <th>{{ $loop->index+1 }}</th>
                                <th>{{ $user->usr_username }}</th>
                                <th>{{ $user->usr_first_name }} {{ $user->usr_last_name }}</th>
                                <th>{{ $user->usr_email }}</th>
                                <th>{{ $user->usr_mobile }}</th>
                                <th>@if($user->usr_verification_status == 1) <span class="text-success">Approved</span> @else <span class="text-danger">Not Approved</span> @endif</th>
                                <th>{{ date('d M Y', strtotime($user->updated_at)) }}</th>
                                <th>
                                    <a href="{{ url('/admin/view/approval') }}/{{ $user->usr_id }}" class="btn btn-primary">View/Download</a>
                                </th>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#approvalTable').dataTable();
    });
</script>