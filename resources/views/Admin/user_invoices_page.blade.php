<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 pg-title"></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{url('/admin-dashboard')}}"><i class="ri-home-5-fill"></i></a></li>
                    <li class="breadcrumb-item pg-title active"></li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
<div class="table-responsive">
    <table class="table" id="useer_profile_table">
        <thead>
            <tr>
                <th>S. No.</th>
                <th>Name</th>
                <th>Primary Email</th>
                <th>Primary Contact</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($data))
                @foreach ($data as $user)
                    <tr>
                        <th>{{$loop->index+1}}</th>
                        <th>{{$user->usr_first_name}} {{$user->usr_last_name}}</th>
                        <th>{{$user->usr_email}}</th>
                        <th>{{$user->usr_mobile}}</th>
                        <th>
                            <div class="d-flex">
                                <form action="{{url('/admin/user-invoices-page/raise-new-invoice')}}" class="mx-1" class="del_user_form" method="post">
                                    @csrf
                                    <input type="hidden" name="uid" value="{{$user->usr_id}}">
                                    <input type="submit" class="btn btn-sm btn-primary" value="Raise">
                                </form>
                                <form action="{{url('/admin/user-invoices-page/view-invoice-list')}}" class="mx-1" class="del_user_form" method="post">
                                    @csrf
                                    <input type="hidden" name="uid" value="{{$user->usr_id}}">
                                    <input type="submit" class="btn btn-sm btn-secondary" value="View">
                                </form>
                            </div>
                        </th>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
<script>
    $('#useer_profile_table').DataTable();
</script>