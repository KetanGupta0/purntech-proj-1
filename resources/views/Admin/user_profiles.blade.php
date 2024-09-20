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
                <th>Status</th>
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
                            @if($user->usr_profile_status == 1)
                                <span class="text-success">Active</span>
                            @elseif($user->usr_profile_status == 2)
                                <span class="text-danger">Blocked</span>
                            @else
                                <span class="text-warning">Unknown State</span>
                            @endif
                        </th>
                        <th>
                            <div class="d-flex">
                                {{-- <form action="{{url('/admin/user-profiles/edit-user')}}" class="mx-1" method="post">
                                    @csrf
                                    <input type="hidden" name="uid" value="{{$user->usr_id}}">
                                    <input type="submit" class="btn btn-sm btn-info" value="Edit">
                                </form>
                                <form action="{{url('/admin/user-profiles/view-user')}}" class="mx-1" method="post">
                                    @csrf
                                    <input type="hidden" name="uid" value="{{$user->usr_id}}">
                                    <input type="submit" class="btn btn-sm btn-primary" value="View">
                                </form> --}}
                                <form action="{{url('/admin/user-profiles/delete-user')}}" class="mx-1" class="del_user_form" method="post">
                                    @csrf
                                    <input type="hidden" name="uid" value="{{$user->usr_id}}">
                                    <input type="button" class="btn btn-sm btn-danger usr_del" value="Delete">
                                </form>
                                @if($user->usr_profile_status == 1)
                                    <form action="{{url('/admin/user-profiles/block-user')}}" class="mx-1" method="post">
                                        @csrf
                                        <input type="hidden" name="uid" value="{{$user->usr_id}}">
                                        <input type="submit" class="btn btn-sm btn-warning" value="Block">
                                    </form>
                                @elseif($user->usr_profile_status == 2)
                                    <form action="{{url('/admin/user-profiles/unblock-user')}}" class="mx-1" method="post">
                                        @csrf
                                        <input type="hidden" name="uid" value="{{$user->usr_id}}">
                                        <input type="submit" class="btn btn-sm btn-success" value="Unblock">
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
    $(document).ready(function(){
        $('#useer_profile_table').DataTable();
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