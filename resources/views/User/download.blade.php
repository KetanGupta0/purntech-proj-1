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



<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 5%;">S.no.</th>
                        <th style="width: 25%;">Title</th>
                        <th style="width: 25%;">Subtitle</th>
                        <th style="width: 20%;">Upload Date Time</th>
                        <th style="width: 25%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($downloads))
                        @foreach ($downloads as $download)
                            <tr>
                                <th>{{ $loop->index+1 }}</th>
                                <th>{{ $download->dwn_title }}</th>
                                <th>{{ $download->dwn_subtitle }}</th>
                                <th>{{ date('d M Y h:t A', strtotime($download->created_at)) }}</th>
                                <th>
                                    <a href="{{ asset('public/downloads') }}/{{ $download->dwn_file }}" class="btn btn-sm btn-primary mx-1" target="_blank">View/Download</a>
                                </th>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>