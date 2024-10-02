<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approval Letter</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            box-sizing: border-box;
        }
        body {
            background-color: #f4f4f4;
        }
        .al-container {
            display: block;
            margin: 0 auto;
            width: 210mm;
            min-height: 297mm;
            background-color: #fff;
        }
        .meta-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #ddd;
        }
        .meta-logo img {
            height: 30px;
            margin-right: 10px;
        }
        .timestamp {
            font-size: 0.85em;
            color: #777;
        }
        h2 {
            text-align: center;
            font-size: 1.5em;
            text-transform: uppercase;
            color: #333;
        }
        h3 {
            font-size: 1.2em;
            margin-bottom: 10px;
        }
        .party {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .party-info p {
            margin: 5px 0;
            font-size: 1em;
            line-height: 1.5;
        }
        .party-image img {
            max-height: 170px;
        }
        p {
            font-size: 0.95em;
            line-height: 1.6;
            margin-top: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        td {
            border: 2px solid #ddd;
            padding: 15px;
            vertical-align: top;
            font-size: 0.9em;
            line-height: 1.6;
        }
        .box-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
            font-size: 1.1em;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .box-block p {
            margin: 5px 0;
        }
        .box-block {
            margin: 10px 0;
        }
        footer {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            padding-top: 30px;
            border-top: 2px solid #ddd;
        }
        .website a {
            color: #0066cc;
            text-decoration: none;
            font-size: 0.95em;
        }
        .foot-logo img {
            height: 80px;
        }
        .meta-logo{
            display: flex;
            align-items: center;
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
    @if (isset($user) && isset($companyInfos) && isset($aprovalSetting))
        <div class="al-container">
            <!-- Header Section -->
            <section class="meta-head">
                <div class="timestamp">{{ date('m/d/y, g:i A') }}</div>
                <div class="meta-logo">
                    <img src="{{ asset('public/assets/img/uploads/logos') }}/{{ $aprovalSetting->als_header_img }}" alt="logo">
                    <span>{{ $companyInfos->cmp_name }}</span>
                </div>
            </section>

            <!-- Title Section -->
            <section style="margin-top: 20px;">
                <h2><u>Approval Letter</u></h2>
            </section>

            <!-- Party Information -->
            <section class="party">
                <div class="party-data">
                    <div class="party-logo">
                        <img src="{{ asset('public/assets/img/uploads/logos') }}/{{ $aprovalSetting->als_body_img_1 }}" alt="logo" style="max-width: 100px;">
                    </div>
                    <div class="party-info">
                        <p><strong>Mr./Mrs. {{ $user->usr_first_name }} {{ $user->usr_last_name }}</strong></p>
                        <p>Vill/Land - {{ $user->usr_landmark }}</p>
                        <p>{{ $user->usr_full_address }}</p>
                        <p>Date: {{ date('d M Y', strtotime($user->updated_at)) }}</p>
                        <p>Contact: +91-{{ $user->usr_mobile }} @if($user->usr_alt_mobile != '' && $user->usr_alt_mobile != null) / +91-{{ $user->usr_alt_mobile }} @endif</p>
                    </div>
                </div>
                <div class="party-image">
                    <img src="{{ asset('public/assets/img/uploads/logos') }}/{{ $aprovalSetting->als_body_img_2 }}" alt="party logo">
                </div>
            </section>

            <!-- Letter Body -->
            <section>
                <p><strong>Dear Sir/Madam,</strong></p>
                <p style="text-align: justify;">
                    <strong>{{ str_replace("JIO", strtoupper(str_replace(" 5G/4G", "", $user->usr_service) ), $aprovalSetting->als_default_welcome_msg)}}</strong>
                </p>
            </section>

            <!-- Details Table -->
            <section>
                <table>
                    <tr>
                        <td>
                            <div class="box">
                                <div class="box-title">Application Detail</div>
                                <div class="box-block">
                                    <p>Ref. No. / Serial No.: {{ $user->usr_username }}</p>
                                    <p>Application No.: {{ strtoupper(str_replace(" 5G/4G", "", $user->usr_service) )}}/{{ $user->usr_username }}</p>
                                </div>
                                <div class="box-block">
                                    <p><strong>Applicant Name</strong></p>
                                    <p>Mr./Mrs. {{ $user->usr_first_name }} {{ $user->usr_last_name }}</p>
                                    <p>Vill:- {{ $user->usr_landmark }}</p>
                                    <p>{{ $user->usr_full_address }}, India</p>
                                </div>
                                <div class="box-block">Date: {{ date('d M Y', strtotime($user->updated_at)) }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="box">
                                <div class="box-title">Job Application Detail</div>
                                <div class="box-block">
                                    <p>Ref. No. / Serial No.: {{ $user->usr_username }}</p>
                                    <p>Application No.: {{ strtoupper(str_replace(" 5G/4G", "", $user->usr_service) )}}/{{ $user->usr_username }}</p>
                                </div>
                                <div class="box-block">
                                    <p><strong>Proposed Applicant</strong></p>
                                    <p>Mr./Mrs. {{ $user->usr_first_name }} {{ $user->usr_last_name }}</p>
                                    <p>Vill:- {{ $user->usr_landmark }}</p>
                                    <p>{{ $user->usr_full_address }}, India</p>
                                </div>
                                <div class="box-block">Date: {{ date('d M Y', strtotime($user->updated_at)) }}</div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="box">
                                <div class="box-title">Applicant Address</div>
                                <div class="box-block"></div>
                            </div>
                        </td>
                        <td>
                            <div class="box">
                                <div class="box-title">Site Address</div>
                                <div class="box-block"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="box">
                                <div class="box-title">Applicant Bank Details</div>
                                <div class="box-block"></div>
                            </div>
                        </td>
                        <td>
                            <div class="box">
                                <div class="box-title">Proposed Applicant Bank Details</div>
                                <div class="box-block"></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="box">
                                <div class="box-title">Rent & Advance Approved</div>
                                <div class="box-block">
                                    <p>Rent: @if($user->usr_mon_rent != '' && $user->usr_mon_rent != null) ₹{{ number_format($user->usr_mon_rent) }} @else ₹25,000 - ₹50,000 @endif per month</p>
                                    <p>Advance: @if($user->usr_adv_amount != '' && $user->usr_adv_amount != null) ₹{{ number_format($user->usr_adv_amount) }} @else ₹30 lakh - ₹60 lakh (Non-refundable after 15 years) @endif</p>
                                    <p>Agreement No.: {{ strtoupper(str_replace(" 5G/4G", "", $user->usr_service) )}}/{{ $user->usr_username }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="box">
                                <div class="box-title">Job Acceptance</div>
                                <div class="box-block"></div>
                            </div>
                        </td>
                    </tr>
                </table>
            </section>

            <!-- Footer Section -->
            <footer>
                <div class="website">
                    <a href="{{ $companyInfos->cmp_website }}">{{ $companyInfos->cmp_website }}</a>
                </div>
                <div class="foot-logo">
                    <img src="{{ asset('public/assets/img/uploads/logos') }}/{{ $aprovalSetting->als_footer_img }}" alt="footer logo">
                </div>
            </footer>
            <div class="btn-cont">
                <button id="print" onclick="printfun()">Print</button>
            </div>
        </div>
    @endif
    <script>
        function printfun(){
            let prBtn = document.getElementById('print');
    
            if (prBtn) {
                prBtn.style.display = "none";
            }
    
            window.print();
            prBtn.style.display = "block";
            
        }
        document.addEventListener('DOMContentLoaded', function() {
            //printfun();
        });
    
    </script>
</body>
</html>
