<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 pg-title"></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{url('/admin-dashboard')}}"><i class="ri-home-5-fill"></i></a></li>
                    <li class="breadcrumb-item"><a href="{{url('/admin/user-invoices-page')}}">User Invoices Page</a></li>
                    <li class="breadcrumb-item pg-title active"></li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="card">
    <div class="card-body">
        @if (isset($invoiceList))
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Invoice Number</th>
                            <th>Invoice Date</th>
                            <th>Due Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th style="text-align: center!important;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoiceList as $invoice)
                            <tr>
                                <th>{{ $loop->index+1 }}</th>
                                <th>{{ $invoice->inv_number }}</th>
                                <th>{{ date('d M Y', strtotime($invoice->inv_date)) }}</th>
                                <th>{{ date('d M Y', strtotime($invoice->inv_due_date)) }}</th>
                                <th>₹ {{ sprintf('%.2f',$invoice->inv_amount) }}</th>
                                <th>
                                    @if($invoice->inv_status == 1)
                                        <span class="text-warning">Not Paid</span>
                                    @elseif($invoice->inv_status == 2)
                                        <span class="text-warning">Partial Paid</span>
                                    @elseif($invoice->inv_status == 3)
                                        <span class="text-warning">Refuded</span>
                                    @elseif($invoice->inv_status == 4)
                                        <span class="text-warning">Pending</span>
                                    @elseif($invoice->inv_status == 5)
                                        <span class="text-success">Paid</span>
                                    @endif
                                </th>
                                <th>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ url('/admin/user-invoices-page/command/view') }}/{{ $invoice->inv_party_id }}/{{ $invoice->inv_id }}" class="me-1 btn btn-sm btn-info">View</a>
                                        @if ($invoice->inv_status == 1)
                                            <form class="me-1" action="{{ url('/admin/user-invoices-page/command/paid') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="uid" value="{{ $invoice->inv_party_id }}">
                                                <input type="hidden" name="inv_id" value="{{ $invoice->inv_id }}">
                                                <input type="submit" value="Paid" class="btn btn-sm btn-success">
                                            </form>
                                            <form class="me-1" action="{{ url('/admin/user-invoices-page/command/pending') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="uid" value="{{ $invoice->inv_party_id }}">
                                                <input type="hidden" name="inv_id" value="{{ $invoice->inv_id }}">
                                                <input type="submit" value="Pending" class="btn btn-sm btn-warning">
                                            </form>
                                            <form class="me-1" action="{{ url('/admin/user-invoices-page/command/partial') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="uid" value="{{ $invoice->inv_party_id }}">
                                                <input type="hidden" name="inv_id" value="{{ $invoice->inv_id }}">
                                                <input type="submit" value="Partial Paid" class="btn btn-sm btn-success">
                                            </form>
                                            <form class="me-1" action="{{ url('/admin/user-invoices-page/command/refunded') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="uid" value="{{ $invoice->inv_party_id }}">
                                                <input type="hidden" name="inv_id" value="{{ $invoice->inv_id }}">
                                                <input type="submit" value="Refunded" class="btn btn-sm btn-success">
                                            </form>
                                        @elseif ($invoice->inv_status == 2)
                                            <form class="me-1" action="{{ url('/admin/user-invoices-page/command/paid') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="uid" value="{{ $invoice->inv_party_id }}">
                                                <input type="hidden" name="inv_id" value="{{ $invoice->inv_id }}">
                                                <input type="submit" value="Paid" class="btn btn-sm btn-success">
                                            </form>
                                            <form class="me-1" action="{{ url('/admin/user-invoices-page/command/unpaid') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="uid" value="{{ $invoice->inv_party_id }}">
                                                <input type="hidden" name="inv_id" value="{{ $invoice->inv_id }}">
                                                <input type="submit" value="Unpaid" class="btn btn-sm btn-warning">
                                            </form>
                                            <form class="me-1" action="{{ url('/admin/user-invoices-page/command/pending') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="uid" value="{{ $invoice->inv_party_id }}">
                                                <input type="hidden" name="inv_id" value="{{ $invoice->inv_id }}">
                                                <input type="submit" value="Pending" class="btn btn-sm btn-warning">
                                            </form>
                                            <form class="me-1" action="{{ url('/admin/user-invoices-page/command/refunded') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="uid" value="{{ $invoice->inv_party_id }}">
                                                <input type="hidden" name="inv_id" value="{{ $invoice->inv_id }}">
                                                <input type="submit" value="Refunded" class="btn btn-sm btn-success">
                                            </form>
                                        @elseif ($invoice->inv_status == 3)
                                            <form class="me-1" action="{{ url('/admin/user-invoices-page/command/paid') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="uid" value="{{ $invoice->inv_party_id }}">
                                                <input type="hidden" name="inv_id" value="{{ $invoice->inv_id }}">
                                                <input type="submit" value="Paid" class="btn btn-sm btn-success">
                                            </form>
                                            <form class="me-1" action="{{ url('/admin/user-invoices-page/command/unpaid') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="uid" value="{{ $invoice->inv_party_id }}">
                                                <input type="hidden" name="inv_id" value="{{ $invoice->inv_id }}">
                                                <input type="submit" value="Unpaid" class="btn btn-sm btn-warning">
                                            </form>
                                            <form class="me-1" action="{{ url('/admin/user-invoices-page/command/pending') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="uid" value="{{ $invoice->inv_party_id }}">
                                                <input type="hidden" name="inv_id" value="{{ $invoice->inv_id }}">
                                                <input type="submit" value="Pending" class="btn btn-sm btn-warning">
                                            </form>
                                            <form class="me-1" action="{{ url('/admin/user-invoices-page/command/partial') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="uid" value="{{ $invoice->inv_party_id }}">
                                                <input type="hidden" name="inv_id" value="{{ $invoice->inv_id }}">
                                                <input type="submit" value="Partial Paid" class="btn btn-sm btn-success">
                                            </form>
                                        @elseif ($invoice->inv_status == 4)
                                            <form class="me-1" action="{{ url('/admin/user-invoices-page/command/paid') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="uid" value="{{ $invoice->inv_party_id }}">
                                                <input type="hidden" name="inv_id" value="{{ $invoice->inv_id }}">
                                                <input type="submit" value="Paid" class="btn btn-sm btn-success">
                                            </form>
                                            <form class="me-1" action="{{ url('/admin/user-invoices-page/command/unpaid') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="uid" value="{{ $invoice->inv_party_id }}">
                                                <input type="hidden" name="inv_id" value="{{ $invoice->inv_id }}">
                                                <input type="submit" value="Unpaid" class="btn btn-sm btn-warning">
                                            </form>
                                            <form class="me-1" action="{{ url('/admin/user-invoices-page/command/partial') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="uid" value="{{ $invoice->inv_party_id }}">
                                                <input type="hidden" name="inv_id" value="{{ $invoice->inv_id }}">
                                                <input type="submit" value="Partial Paid" class="btn btn-sm btn-success">
                                            </form>
                                            <form class="me-1" action="{{ url('/admin/user-invoices-page/command/refunded') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="uid" value="{{ $invoice->inv_party_id }}">
                                                <input type="hidden" name="inv_id" value="{{ $invoice->inv_id }}">
                                                <input type="submit" value="Refunded" class="btn btn-sm btn-success">
                                            </form>
                                        @elseif ($invoice->inv_status == 5)
                                            <form class="me-1" action="{{ url('/admin/user-invoices-page/command/unpaid') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="uid" value="{{ $invoice->inv_party_id }}">
                                                <input type="hidden" name="inv_id" value="{{ $invoice->inv_id }}">
                                                <input type="submit" value="Unpaid" class="btn btn-sm btn-warning">
                                            </form>
                                            <form class="me-1" action="{{ url('/admin/user-invoices-page/command/pending') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="uid" value="{{ $invoice->inv_party_id }}">
                                                <input type="hidden" name="inv_id" value="{{ $invoice->inv_id }}">
                                                <input type="submit" value="Pending" class="btn btn-sm btn-warning">
                                            </form>
                                            <form class="me-1" action="{{ url('/admin/user-invoices-page/command/partial') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="uid" value="{{ $invoice->inv_party_id }}">
                                                <input type="hidden" name="inv_id" value="{{ $invoice->inv_id }}">
                                                <input type="submit" value="Partial Paid" class="btn btn-sm btn-success">
                                            </form>
                                            <form class="me-1" action="{{ url('/admin/user-invoices-page/command/refunded') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="uid" value="{{ $invoice->inv_party_id }}">
                                                <input type="hidden" name="inv_id" value="{{ $invoice->inv_id }}">
                                                <input type="submit" value="Refunded" class="btn btn-sm btn-success">
                                            </form>
                                        @endif
                                        <form class="me-1" action="{{ url('/admin/user-invoices-page/command/delete') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="uid" value="{{ $invoice->inv_party_id }}">
                                            <input type="hidden" name="inv_id" value="{{ $invoice->inv_id }}">
                                            <input type="submit" value="Delete" class="btn btn-sm btn-danger">
                                        </form>
                                    </div>
                                </th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            Something went wrong. Please contact site admin for resolution!
        @endif
    </div>
</div>
