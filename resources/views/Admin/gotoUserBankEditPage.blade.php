<!DOCTYPE html>
<html>
    <body>
        @if (isset($code) && isset($uid))
            <form id="postForm" action="{{ url('/admin/user-bank-details/update-view-user-bank-details') }}" method="POST">
                @csrf
                @if ($code == 400)
                    @php
                        Session::flash('error', $msg);
                    @endphp
                @elseif($code == 200)
                    @php
                        Session::flash('success', $msg);
                    @endphp
                @endif
                <input type="hidden" name="uid" value="{{ $uid }}">
            </form>
            <script type="text/javascript">
                document.getElementById('postForm').submit();
            </script>
        @endif
    </body>
</html>