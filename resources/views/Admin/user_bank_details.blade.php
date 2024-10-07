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
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped" id="userTable">
                <thead>
                    <tr>
                        <th>S.No.</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($results))
                        @foreach ($results as $user)
                            <tr>
                                <th>{{ $loop->index + 1 }}</th>
                                <th>{{ $user->usr_first_name }} {{ $user->usr_last_name }}</th>
                                <th>{{ $user->usr_email }}</th>
                                <th>{{ $user->usr_mobile }}</th>
                                <th>
                                    @if ($user->ubd_user_kyc_status == null)
                                        <span class="text-warning">Not Available</span>
                                    @elseif($user->ubd_user_kyc_status == 1)
                                        <span class="text-success">Approved</span>
                                    @elseif($user->ubd_user_kyc_status == 2)
                                        <span class="text-warning">Processing</span>
                                    @elseif($user->ubd_user_kyc_status == 3)
                                        <span class="text-warning">Pending</span>
                                    @elseif($user->ubd_user_kyc_status == 4)
                                        <span class="text-danger">Rejected</span>
                                    @endif
                                </th>
                                <th>
                                    <div class="d-flex">
                                        <form method="POST" action="{{ url('/admin/user-bank-details/view-user-bank-details') }}" class="mx-1">
                                            @csrf
                                            <input type="hidden" name="uid" value="{{ $user->usr_id }}">
                                            <input type="submit" class="btn btn-sm btn-secondary" value="View">
                                        </form>
                                        <form method="POST" action="{{ url('/admin/user-bank-details/update-view-user-bank-details') }}" class="mx-1">
                                            @csrf
                                            <input type="hidden" name="uid" value="{{ $user->usr_id }}">
                                            <input type="submit" class="btn btn-sm btn-secondary" value="Update">
                                        </form>
                                    </div>
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
    $(document).ready(function() {
        $('#userTable').DataTable();
    });
</script>