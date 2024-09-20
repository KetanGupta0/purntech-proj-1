<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 ">User: {{ $user->usr_first_name }} {{ $user->usr_last_name }}</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ url('/admin-dashboard') }}"><i class="ri-home-5-fill"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{ url('/admin/user-documents') }}">User Documents</a></li>
                    <li class="breadcrumb-item pg-title active"></li>
                </ol>
            </div>

        </div>
    </div>
</div>

<!-- end page title -->
<!-- Check if data exists -->
@if (isset($data))
    @php
        $totalPending = 0;
        $totalVerified = 0;
        $totalRejected = 0;
        foreach ($data as $doc) {
            if ($doc->udc_status == 1) {
                $totalPending++;
            } elseif ($doc->udc_status == 2) {
                $totalVerified++;
            } elseif ($doc->udc_status == 3) {
                $totalRejected++;
            }
        }
    @endphp
    <p>Total Documents for Verification: {{ $totalPending }}</p>
    <p>Total Verified Documents: {{ $totalVerified }}</p>
    <p>Total Rejected Documents: {{ $totalRejected }}</p>

    <!-- Iterate through the documents -->
    <div class="table-responsive">
        <table class="table" id="verification_table">
            <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Document Name</th>
                    <th>Upload Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    function getFileName($type)
                    {
                        $fileName = 'Other';
                        switch ($type) {
                            case '1':
                                $fileName = 'Aadhar Front';
                                break;

                            case '2':
                                $fileName = 'Aadhar Back';
                                break;

                            case '3':
                                $fileName = 'Pan Card';
                                break;

                            case '4':
                                $fileName = 'Bank Passbook / Cancel Cheque';
                                break;

                            case '5':
                                $fileName = 'Voter ID / Driving License';
                                break;

                            case '6':
                                $fileName = 'Land Doucments';
                                break;

                            case '7':
                                $fileName = 'Land Photographs';
                                break;

                            default:
                                # code...
                                break;
                        }
                        return $fileName;
                    }
                @endphp
                @foreach ($data as $index => $document)
                    <tr>
                        <th>{{ $index + 1 }}</th>
                        <th><a href="{{ asset('public/assets/img/uploads/documents') }}/{{ $document->udc_name }}"
                               target="_blank">{{ getFileName($document->udc_doc_type) }}</a></th>
                        <th>{{ $document->created_at->format('d M Y \a\t h:i A') }}</th>
                        <th>
                            @if ($document->udc_status == 1)
                                <span class="text-warning">Pending</span>
                            @elseif($document->udc_status == 2)
                                <span class="text-success">Verified</span>
                            @elseif ($document->udc_status == 3)
                                <span class="text-danger">Rejected</span>
                            @endif
                        </th>
                        <th>
                            <!-- Add actions like verify/reject here -->
                            <div class="d-flex">
                                @if ($document->udc_status != 3)
                                    <form action="{{ url('/admin/user-documents/verify-documents/reject-now') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="uid" value="{{ $document->udc_user_id }}">
                                        <input type="hidden" name="doc_id" value="{{ $document->udc_id }}">
                                        <input type="submit" class="mx-1 btn btn-sm btn-warning" value="Reject">
                                    </form>
                                @endif
                                @if ($document->udc_status == 1 || $document->udc_status == 3)
                                    <form action="{{ url('/admin/user-documents/verify-documents/verify-now') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="uid" value="{{ $document->udc_user_id }}">
                                        <input type="hidden" name="doc_id" value="{{ $document->udc_id }}">
                                        <input type="submit" class="mx-1 btn btn-sm btn-success" value="Verify">
                                    </form>
                                @endif
                                <form action="{{ url('/admin/user-documents/verify-documents/delete-now') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="uid" value="{{ $document->udc_user_id }}">
                                    <input type="hidden" name="doc_id" value="{{ $document->udc_id }}">
                                    <input type="button" class="mx-1 btn btn-sm btn-danger usr_del" value="Delete">
                                </form>
                            </div>
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <p>No documents found for verification.</p>
@endif

<script>
    $(document).ready(function() {
        $('#verification_table').DataTable();
        $(document).on('click','.usr_del',function(){
            let form = $(this).closest('form');
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
