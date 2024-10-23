<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 pg-title"></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ url('/user-dashboard') }}"><i class="ri-home-5-fill"></i></a></li>
                    <li class="breadcrumb-item pg-title active"></li>
                </ol>
            </div>

        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        @if (isset($insurance))
            @if (count($insurance) == 0)
                <div class="alert alert-danger" role="alert">
                    No active insurance found.
                </div>
            @else
                <table class="table" id="insuranceTable">
                    <thead>
                        <tr>
                            <th>S. No.</th>
                            <th>Policy Number</th>
                            <th>Name of Insured</th>
                            <th>Name of Nominee</th>
                            <th>Sum Assured</th>
                            <th>Insurance Premium</th>
                            <th>Paid till</th>
                            <th>Balance Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($insurance as $ins)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$ins->uin_policy_number}}</td>
                                <td>{{$ins->uin_insured_name}}</td>
                                <td>{{$ins->uin_nominee}}</td>
                                <td>{{sprintf('%.2f',$ins->uin_sum_assured)}}</td>
                                <td>{{sprintf('%.2f',$ins->uin_insurance_premium)}}</td>
                                <td>{{date('d M Y',strtotime($ins->uin_paid_till))}}</td>
                                <td>{{sprintf('%.2f',$ins->uin_balance_amount)}}</td>
                                <td><a href="{{url('user/view/insurance-'.$ins->uin_id)}}" class="btn btn-primary">View/Download</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @else
            <div class="alert alert-danger" role="alert">
                No active insurance found.
            </div>
        @endif
    </div>
</div>
