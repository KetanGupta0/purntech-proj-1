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
        <section class="table-responsive">
            <table class="table table-responsive" id="inv_table">
                <thead>
                    <tr>
                        <th>S. No.</th>
                        <th>Invoice Number</th>
                        <th>Invoice Date</th>
                        <th>Due Date</th>
                        <th>Amount</th>
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
                                    <th>{{date("d M Y", strtotime($inv->inv_date))}}</th>
                                    <th>{{date("d M Y", strtotime($inv->inv_due_date))}}</th>
                                    <th>₹ {{sprintf("%.2f",$inv->inv_amount)}}</th>
                                    <th>
                                        @if($inv->inv_status == 1)
                                            <span class="text-warning">Not Paid</span>
                                        @elseif($inv->inv_status == 2)
                                            <span class="text-warning">Partial Paid</span>
                                        @elseif($inv->inv_status == 3)
                                            <span class="text-warning">Refuded</span>
                                        @elseif($inv->inv_status == 4)
                                            <span class="text-warning">Pending</span>
                                        @elseif($inv->inv_status == 5)
                                            <span class="text-success">Paid</span>
                                        @endif
                                    </th>
                                    <th>
                                        <form action="{{ url('/user/invoices/invoice-view') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="uid" value="{{ $inv->inv_party_id }}">
                                            <input type="hidden" name="inv_id" value="{{ $inv->inv_id }}">
                                            <input type="submit" class="btn btn-sm btn-primary" value="View">
                                        </form>
                                    </th>
                                </tr>
                            @endforeach
                        @endif
                    @endif
                </tbody>
            </table>
        </section>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('#inv_table').DataTable();
    });
</script>