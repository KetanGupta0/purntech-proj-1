<!DOCTYPE html>
<html>
<body>
    <form id="postForm" action="{{ url('/admin/user-bank-details/view-user-bank-details') }}" method="POST">
        @csrf
        @if (isset($code) && isset($uid))
            @if($code == 400)
                @php
                    Session::flash('error','Something went wrong. Please try again later!');
                @endphp
            @elseif($code == 401)
                @php
                    Session::flash('error','Something went wrong. Please try again later!');
                @endphp
            @elseif($code == 402)
                @php
                    Session::flash('success','KYC Status updated!');
                @endphp
            @elseif($code == 403)
                @php
                    Session::flash('error','Something went wrong. Please try again later!');
                @endphp
            @elseif($code == 404)
                @php
                    Session::flash('error','Something went wrong. Please try again later!');
                @endphp
            @elseif($code == 405)
                @php
                    Session::flash('error',$msg);
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