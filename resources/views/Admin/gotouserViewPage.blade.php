<!DOCTYPE html>
<html>
<body>
    <form id="postForm" action="{{ url('/admin/user-profiles/view-user') }}" method="POST">
        @csrf
        @if (isset($code) && isset($uid))
            @if($code == 400)
                @php
                    Session::flash('error',$msg);
                @endphp
            @elseif($code == 200)
                @php
                    Session::flash('success',$msg);
                @endphp
            @endif
        @endif
        <input type="hidden" name="uid" value="{{ $uid }}">
    </form>

    <script type="text/javascript">
        document.getElementById('postForm').submit();
    </script>
</body>
</html>