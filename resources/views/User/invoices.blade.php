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

<section>
    <table class="table table-responsive" id="inv_table">
        <thead>
            <tr>
                <th>S. No.</th>
                <th>Invoice Number</th>
                <th>Invoice Date</th>
                <th>Amount</th>
                <th>Due Date</th>
                <th>Invoice Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($data))
                @if(count($data) != 0)
                    @foreach ($data as $inv)
                        <tr>
                            <th>{{$loop->index+1}}</th>
                            <th>{{$inv->inv_number}}</th>
                            <th>{{$inv->inv_date}}</th>
                            <th>{{$inv->inv_amount}}</th>
                            <th>
                                @if ($inv->inv_status == 1)
                                    <span class="text-warning">Pending</span>
                                @elseif ($inv->inv_status == 2)
                                    <span class="text-success">Completed</span>
                                @elseif ($inv->inv_status == 3)
                                    <span class="text-danger">Rejected/Expired</span>
                                @endif
                            </th>
                            <th>{{$inv->inv_number}}</th>
                            <th>
                                @if ($inv->inv_status == 1)
                                    @if($inv->inv_paid_amt == NULL || $inv->inv_paid_amt == '')
                                        <div class="btn btn-success">Submit Payment Details</div>
                                        <div class="btn btn-primary">View</div>
                                    @else
                                        <div class="btn btn-primary">View</div>
                                    @endif
                                @elseif ($inv->inv_status == 2)
                                    <div class="btn btn-primary">View</div>
                                @elseif ($inv->inv_status == 3)
                                    <span>-</span>
                                @endif
                            </th>
                        </tr>
                    @endforeach
                @endif
            @endif
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </tbody>
    </table>
</section>
<script>
    $(document).ready(function(){
        $('#inv_table').DataTable();
    });
</script>