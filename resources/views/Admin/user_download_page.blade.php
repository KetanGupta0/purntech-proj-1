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
    <div class="card-header">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            Add file
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="fileTable">
                <thead>
                    <tr>
                        <th style="width: 5%;">S.no.</th>
                        <th style="width: 20%;">Title</th>
                        <th style="width: 20%;">Subtitle</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 20%;">Upload Date Time</th>
                        <th style="width: 25%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($downloadables))
                        @foreach ($downloadables as $downloadable)
                            <tr>
                                <th>{{ $loop->index+1 }}</th>
                                <th><a href="{{ asset('public/downloads') }}/{{ $downloadable->dwn_file }}" target="_blank">{{ $downloadable->dwn_title }}</a></th>
                                <th>{{ $downloadable->dwn_subtitle }}</th>
                                <th>
                                    @if ($downloadable->dwn_is_hidden == 0)
                                        <span class="text-success"><b>Visible</b></span>
                                    @else
                                        <span class="text-danger"><b>Hidden</b></span>
                                    @endif
                                </th>
                                <th>{{ date('d M Y h:t A', strtotime($downloadable->created_at)) }}</th>
                                <th>
                                    <div class="d-flex justify-content-start align-items-center">
                                        <a href="{{ asset('public/downloads') }}/{{ $downloadable->dwn_file }}" class="btn btn-sm btn-primary mx-1" target="_blank">View</a>
                                        @if($downloadable->dwn_is_hidden == 0)
                                        <form action="{{ url('/admin/user-download/hide-file') }}" method="post" class="mx-1">
                                            @csrf
                                            <input type="hidden" name="file_id" value="{{ $downloadable->dwn_id }}">
                                            <input type="submit" value="Hide" class="btn btn-sm btn-warning">
                                        </form>
                                        @else
                                        <form action="{{ url('/admin/user-download/show-file') }}" method="post" class="mx-1">
                                            @csrf
                                            <input type="hidden" name="file_id" value="{{ $downloadable->dwn_id }}">
                                            <input type="submit" value="Show" class="btn btn-sm btn-success">
                                        </form>
                                        @endif
                                        <form action="{{ url('/admin/user-download/delete-file') }}" method="post" class="mx-1">
                                            @csrf
                                            <input type="hidden" name="file_id" value="{{ $downloadable->dwn_id }}">
                                            <div class="btn btn-sm btn-danger file_del">Delete</div>
                                        </form>
                                    </div>
                                </th>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" style="text-align: center!important; font-style:italic;" class="text-muted">The files will be visible in all user panel/Download Page, for all active user</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Upload File</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ url('/admin/user-download/upload-file') }}" id="uploadForm" method="post" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="file_title" name="file_title" placeholder="File title" required>
                        <label for="file_title">Title</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="file_subtitle" name="file_subtitle" placeholder="File subtitle" required>
                        <label for="file_subtitle">Subtitle</label>
                    </div>
                    <div class="form-group">
                        <input type="file" class="form-control" id="file" name="file" placeholder="file" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="submitBtn">Add</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#fileTable').dataTable();
        $(document).on('click','.file_del',function(){
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
        $(document).on('click','#submitBtn',function (e) {
            let isValid = true;
            if ($('#file_title').val().trim() === '') {
                Swal.file({
                    icon: 'warning',
                    title: 'warning',
                    text: 'Title is required'
                });
                isValid = false;
            }
            if ($('#file_subtitle').val().trim() === '') {
                Swal.file({
                    icon: 'warning',
                    title: 'warning',
                    text: 'Subtitle is required'
                });
                isValid = false;
            }
            if ($('#file').get(0).files.length === 0) {
                Swal.file({
                    icon: 'warning',
                    title: 'warning',
                    text: 'Please select a file'
                });
                isValid = false;
            }
            if (isValid) {
                $('#uploadForm').submit(); // Submit form if all validations pass
            } else {
                e.preventDefault(); // Prevent the form from submitting
            }
        });
    });
</script>