<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice 24HS1880</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
    }

    .invoice-container {
      background-color: #fff;
      /* padding: 20px; */
      max-width: 800px;
      margin: 0 auto;
    }

    header {
      text-align: center;
      margin-bottom: 20px;
    }

    header h1 {
      font-size: 2em;
      margin-bottom: 10px;
    }

    .company-info,
    .billing-info {
      padding: 15px;
      flex: 5;
    }

    .company-info{
      border-right: 1px solid rgb(226, 226, 226);
    }
    .billing-info{
      border-left: 1px solid rgb(226, 226, 226);
    }

    h2 {
      font-size: 1.2em;
      margin-bottom: 8px;
      color: #333;
    }

    p {
      font-size: 1em;
      line-height: 1.6;
      color: #666;
    }

    .invoice-table table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    .invoice-table th,
    .invoice-table td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ccc;
    }

    .invoice-table th {
      background-color: #f7f7f7;
      font-weight: bold;
    }

    .invoice-table td {
      background-color: #fff;
    }

    .invoice-table td:last-child {
      text-align: right;
    }

    footer {
      text-align: center;
      margin-top: 20px;
      color: #888;
    }

    footer p {
      margin-bottom: 4px;
    }

    .meta-logo{
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 20px;
    }

    .main-logo{
      display: flex;
      align-items: center;
    }

    .logo {
      max-width: 30px;
    }

    .invoice-image {
      max-width: 100px;
      margin: 20px 0;
      display: flex;
      gap: 20px;
    }

    .footer-image {
      max-width: 100px;
      
    }
    .seal-container{
      display: flex;
      justify-content: end;
    }
    .seal{
      max-width: 150px;
    }
    .meta-data{
      display: flex;
    }
    .btn-cont{
        display: flex;
        justify-content: center;
    }
    #print{
        padding: 3px;
        font-size: 18px;
    }
  </style>
</head>

<body>
    @if(isset($user) && isset($invoice) && isset($company))
        <div class="invoice-container">
            <header>
            <!-- Include Logo Image -->
            <div class="meta-logo">
                <div class="timestamp">
                <span>{{ date('m/d/y, g:i A') }}</span>
                </div>
                <div class="main-logo">
                <img src="{{ asset('public/assets/invoice/logo1.png') }}" alt="Company Logo" class="logo">
                <span>Bharti Infratel Tower</span>
                </div>
            </div>
            <h1>INVOICE</h1>
            <p>Invoice No: {{ $invoice->inv_number }}</p>
            <p>Invoice Date: {{ date("d M Y", strtotime($invoice->inv_date)) }}</p>
            <p>Due Date: {{ date("d M Y", strtotime($invoice->inv_due_date)) }}</p>
            </header>

            <div class="meta-data">
            <section class="company-info">
                <h2>Corporate Office</h2>
                @if($company->cmp_address1 != "" && $company->cmp_address1 != null)
                    <p>{{ $company->cmp_address1 }}</p>
                @endif
                @if($company->cmp_address2 != "" && $company->cmp_address2 != null)
                    <p>{{ $company->cmp_address2 }}</p>
                @endif
                @if($company->cmp_address3 != "" && $company->cmp_address3 != null)
                    <p>{{ $company->cmp_address3 }}</p>
                @endif
                <p>Mob: +91-{{ $company->cmp_mobile1 }}@if($company->cmp_mobile2 != '' && $company->cmp_mobile2 != null), +91-{{ $company->cmp_mobile2 }}@endif @if($company->cmp_mobile3 != '' && $company->cmp_mobile3 != null), +91-{{ $company->cmp_mobile3 }} @endif</p>
                <p>GST No: {{ $company->cmp_gst_no }}</p>
            </section>
        
            <section class="billing-info">
                <h2>Billed To:</h2>
                <p>Mr./Mrs. {{ $invoice->inv_party_name }}</p>
                @if($invoice->inv_party_address_1 != "" && $invoice->inv_party_address_1 != null)
                    <p>{{ $invoice->inv_party_address_1 }}</p>
                @endif
                @if($invoice->inv_party_address_2 != "" && $invoice->inv_party_address_2 != null)
                    <p>{{ $invoice->inv_party_address_2 }}</p>
                @endif
                <p>Contact: +91-{{ $invoice->inv_party_mobile1 }} @if($invoice->inv_party_mobile2 != '' && $invoice->inv_party_mobile2 != null) / +91-{{ $invoice->inv_party_mobile2 }} @endif</p>
            </section>
            </div>

            <!-- Include any relevant images from the PDF -->
            <section class="invoice-image">
            <img src="{{ asset('public/assets/invoice/logo1.png') }}" alt="Invoice Details Image" class="invoice-image">
            <img src="{{ asset('public/assets/invoice/logo2.png') }}" alt="Invoice Details Image" class="invoice-image">
            </section>

            <section class="invoice-table">
            <table>
                <thead>
                <tr>
                    <th>Description</th>
                    <th>Amount (₹)</th>
                </tr>
                </thead>
                <tbody>
                    @php
                        $totalAmount = 0;
                    @endphp
                    @foreach ($invoiceDescriptions as $desc)
                        <tr>
                            <td>{{ $desc->ida_description }}</td>
                            <td>{{ sprintf('%.2f',$desc->ida_amount) }}</td>
                        </tr>
                        @php
                            $totalAmount += $desc->ida_amount;
                        @endphp
                    @endforeach
                <tr>
                    <td><strong>Total</strong></td>
                    <td><strong>{{ sprintf('%.2f',$totalAmount) }}</strong></td>
                </tr>
                </tbody>
            </table>
            </section>

            <footer>
            <div class="seal-container">
                <img src="{{ asset('public/assets/invoice/logo3.png') }}" alt="seal" class="seal">
            </div>
            <img src="{{ asset('public/assets/invoice/logo4.png') }}" alt="Footer Image" class="footer-image">
            @if($company->cmp_website != '' && $company->cmp_website != null)
                <p><a href="{{ $company->cmp_website }}">{{ $company->cmp_website }}</a></p>
            @endif
            </footer>
            <div class="btn-cont">
                <button id="print" onclick="printfun()">Print</button>
            </div>
        </div>
    @else
        <h1>Please contact admin for this problem</h1>
    @endif
</body>

</html>

<script>
    function printfun(){
        let prBtn = document.getElementById('print');

        if (prBtn) {
            prBtn.style.display = "none";
        }

        window.print();

        window.onafterprint = function() {
            if (prBtn) {
                prBtn.style.display = "block";
            }
        };
    }
    document.addEventListener('DOMContentLoaded', function() {
        printfun();
    });

</script>