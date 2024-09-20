<!DOCTYPE html>
<html>
<body>
    <form id="postForm" action="{{ url('/admin/user-documents/verify-documents') }}" method="POST">
        @csrf
        @if (isset($status))
            @if($status == true)
                @php
                    Session::flash('success','Document verified successfully!');
                @endphp
            @else
                @php
                    Session::flash('error','Something went wrong. Please try again later!');
                @endphp
            @endif
        @elseif (isset($status1))
            @if($status1 == true)
                @php
                    Session::flash('success','Document rejected successfully!');
                @endphp
            @else
                @php
                    Session::flash('error','Something went wrong. Please try again later!');
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