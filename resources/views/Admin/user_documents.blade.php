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
<div class="table-responsive">
    <table class="table"
           id="user_table">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>User</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Document Upload Status</th>
                <th>Verification Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($data))
                @foreach ($data as $user => $details)
                    <tr>
                        <th>{{ $loop->index + 1 }}</th>
                        <th>{{ $user }}</th>
                        <th>{{ $details['user']->usr_email }}</th>
                        <th>{{ $details['user']->usr_mobile }}</th>
                        <th>
                            @php
                                $totalDocuments = 0;
                                // Count only valid uploaded documents
                                foreach ($details['documents'] as $document) {
                                    if ($document->udc_status != '0' && $document->udc_status != '3') {
                                        $totalDocuments++;
                                    }
                                }
                                // Calculate percentage based on total (assuming 7 required documents)
                                $percent = ($totalDocuments * 100.0) / 7.0;
                            @endphp

                            {{ sprintf('%.0f', $percent) }}% {{-- ({{ $totalDocuments }} documents) --}}
                            {{-- @if ($totalDocuments > 0)
                            @else
                                No documents uploaded
                            @endif --}}
                        </th>
                        <th>
                            @php
                                $isVerified = 'verified';
                                if ($totalDocuments > 0) {
                                    foreach ($details['documents'] as $document) {
                                        if ($document->udc_status != '2') {
                                            if ($document->udc_status == '1') {
                                                $isVerified = 'pending';
                                            } elseif ($document->udc_status == '3') {
                                                $isVerified = 'rejected';
                                            }
                                        }
                                    }
                                } else {
                                    $isVerified = '-';
                                }
                            @endphp
                            @if ($isVerified == 'verified')
                                <span class="text-success">Verified</span>
                            @elseif($isVerified == 'pending')
                                <span class="text-warning">Pending</span>
                            @elseif($isVerified == 'rejected')
                                <span class="text-danger">Rejected</span>
                            @else
                                <span class="text-dark">-</span>
                            @endif
                        </th>
                        <th>
                            <div class="d-flex">
                                @if ($isVerified == 'verified')
                                    <form action="{{ url('/admin/user-documents/verify-documents') }}"
                                          method="post">
                                        @csrf
                                        <input type="hidden"
                                               name="uid"
                                               value="{{ $details['user']->usr_id }}">
                                        <input type="submit"
                                               class="mx-1 btn btn-sm btn-info"
                                               value="Review">
                                    </form>
                                @else
                                    <form action="{{ url('/admin/user-documents/verify-documents') }}"
                                          method="post">
                                        @csrf
                                        <input type="hidden"
                                               name="uid"
                                               value="{{ $details['user']->usr_id }}">
                                        <input type="submit"
                                               class="mx-1 btn btn-sm btn-success"
                                               value="Verify">
                                    </form>
                                @endif

                            </div>
                        </th>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
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
        $(document).ready(function() {
            Swal.fire({
                icon: "success",
                title: "{{ Session::get('success') }}"
            });
        });
    </script>
@elseif(Session::has('error'))
    <script>
        $(document).ready(function() {
            Swal.fire({
                icon: "error",
                title: "Error",
                html: "{{ Session::get('error') }}"
            });
        });
    </script>
@endif
<script>
    $(document).ready(function() {
        $('#user_table').DataTable();
    });
</script>
