<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Bharti Infratel Tower | Insurance Letter</title>
        <style>
            * {
                font-family: Montserrat, sans-serif;
                text-decoration: none;
                margin: 0;
                padding: 0;
            }

            .flex {
                display: flex;
                width: 100%;
            }

            .wrap {
                grid-column: auto;
                flex-wrap: wrap;
            }

            .center-y {
                justify-content: center;
            }

            .center-x {
                align-items: center;
            }

            .flex-column {
                flex-direction: column;
            }

            .flex-row {
                flex-direction: row;
            }

            p {
                color: #4a4a4a;
                padding: 15px 0;
                line-height: 24px;
            }

            tr td p {
                padding: 0;
            }

            tr td {
                padding: 0px;
            }

            .logo {
                height: 80px;
            }

            .title {
                font-size: 28px;
                font-weight: bolder;
            }

            .sub-title {
                font-size: 22px;
                margin: 15px 0;
            }

            .covered-img-container {
                padding: 5px 15px;
            }

            .covered-img img {
                height: 60px;
            }

            .covered-name {
                color: #a8a8a8;
                font-size: 12px;
                max-width: 100px;
                min-width: 100px;
                min-height: 27px;
                text-align: center;
            }

            .theme-link {
                color: #614bb2;
                font-weight: bold;
            }

            .center-button {
                background-color: #0bcf03;
                padding: 15px 35px;
                margin: 25px 0;
                color: #fff;
                font-weight: bold;
                font-size: 22px;
                border-radius: 8px;
            }

            #printButton{
                position: fixed;
                bottom: 15px;
                right: 25px;
                padding: 15px 35px;
                font-weight: bold;
                cursor: pointer;
                font-size: 18px;
                background-color: red;
                color: white;
                border-color: unset;
                border-radius: 12px;
            }
        </style>
    </head>

    <body style="margin: 15px;;">
        <div class="container flex center-x flex-column">
            <div class="logo">
                <img src="{{ asset('public/img/logo/acko.png') }}" alt="">
            </div>
            <div class="title">Details and Benefits</div>
        </div>
        <div class="container body">
            <p>Hi Mr. {{ $insurance->uin_insured_name }},</p>
            <p>Your Bharti Site is insured by Acko General Insurance. Refer to your detailed policy document <a href="#">here.</a></p>
            <p>Take a quick look at your policy details below-</p>
            <table width="600" cellpadding="0" cellspacing="0" style="margin: 15px 0;;">
                <tr>
                    <td>
                        <p>Policy Number: </p>
                    </td>
                    <td>{{ $insurance->uin_policy_number }}</td>
                </tr>
                <tr>
                    <td>
                        <p>Name of Insured: </p>
                    </td>
                    <td>Mr. {{ $insurance->uin_insured_name }}</td>
                </tr>
                <tr>
                    <td>
                        <p>Name of Nominee: </p>
                    </td>
                    <td>Mr./Mrs. {{ $insurance->uin_nominee }}</td>
                </tr>
                <tr>
                    <td><p>Sum Assured: </p></td>
                    <td>₹ {{  number_format($insurance->uin_sum_assured, 2) }} INR</td>
                </tr>
                <tr>
                    <td><p>Insurance Premium: </p></td>
                    <td>₹ {{ number_format($insurance->uin_insurance_premium, 2) }} INR</td>
                </tr>
                <tr>
                    <td>
                        <p>Paid till: </p>
                    </td>
                    <td style="text-transform: uppercase;">{{ date('d M Y', strtotime($insurance->uin_paid_till)) }}</td>
                </tr>
                <tr>
                    <td>
                        <p>Balance Amount: </p>
                    </td>
                    <td>₹ {{ number_format($insurance->uin_balance_amount, 2) }} INR</td>
                </tr>
            </table>
            <p>You are now entitled to a number of coverages against your Bharti Site Insurance.</p>
            <div class="sub-title">What’s covered?</div>
            <div class="flex wrap" style="max-width: 600px;">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <div class="covered-img-container flex center-x flex-column">
                                <div class="covered-img">
                                    <img src="{{ asset('public/img/logo/death.png') }}" alt="Death">
                                </div>
                                <div class="covered-name">Death</div>
                            </div>
                        </td>
                        <td>
                            <div class="covered-img-container flex center-x flex-column">
                                <div class="covered-img">
                                    <img src="{{ asset('public/img/logo/Permanent total disability.png') }}" alt="Permanent total disability">
                                </div>
                                <div class="covered-name">Permanent total disability</div>
                            </div>
                        </td>
                        <td>
                            <div class="covered-img-container flex center-x flex-column">
                                <div class="covered-img">
                                    <img src="{{ asset('public/img/logo/Permanent partial disability.png') }}" alt="Permanent partial disability">
                                </div>
                                <div class="covered-name">Permanent partial disability</div>
                            </div>
                        </td>
                        <td>
                            <div class="covered-img-container flex center-x flex-column">
                                <div class="covered-img">
                                    <img src="{{ asset('public/img/logo/Temporary Total Disability.png') }}" alt="Temporary Total Disability">
                                </div>
                                <div class="covered-name">Temporary Total Disability</div>
                            </div>
                        </td>
                        <td>
                            <div class="covered-img-container flex center-x flex-column">
                                <div class="covered-img">
                                    <img src="{{ asset('public/img/logo/Hospitalization.png') }}" alt="Hospitalization">
                                </div>
                                <div class="covered-name">Hospitalization</div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="covered-img-container flex center-x flex-column">
                                <div class="covered-img">
                                    <img src="{{ asset('public/img/logo/Loan Waiver.png') }}" alt="Loan Waiver">
                                </div>
                                <div class="covered-name">Loan Waiver</div>
                            </div>
                        </td>
                        <td>
                            <div class="covered-img-container flex center-x flex-column">
                                <div class="covered-img">
                                    <img src="{{ asset('public/img/logo/OPD Expenses.png') }}" alt="OPD Expenses">
                                </div>
                                <div class="covered-name">OPD Expenses</div>
                            </div>
                        </td>
                        <td>
                            <div class="covered-img-container flex center-x flex-column">
                                <div class="covered-name">+More</div>
                            </div>

                        </td>
                    </tr>
                </table>
            </div>
            <p>You can raise a claim on the Rapido app or by visiting <a href="https://www.acko.com" target="_blank" class="theme-link">www.acko.com</a>. You
                can also send an email at <a href="mailto:insurancecare@bharti.world"
                   style="font-weight: bold; color: black;">insurancecare@bharti.world</a> for any concerns. You can add a nominee to your Policy by
                clicking on the following button.</p>
            <div class="flex center-y">
                <a href="https://www.acko.com/policy/?pid=-%09BHRT2405LENDON676812&source=null" class="center-button">Add nominee</a>
            </div>
            <p>To know more about your insured sites, simply visit ‘My Account’ by logging in to <a href="https://www.acko.com" target="_blank"
                   class="theme-link">www.acko.com</a>.</p>
            <p>Your file will be forwarded to the accounts department for disbursal only after all dues & documents are cleared.</p>
            <p>Enjoy a Stress-free life with Bharti Site Insure</p>
            <p>
            <div>Thanks</div>
            <div>Team Bharti & Acko India.</div>
            </p>
        </div>
        <hr>
        <div class="footer">
            <div class="flex center-y" style="margin: 50px 0 25px 0;">
                <a href="#" style="padding: 0 10px;"><img style="height: 40px;" src="{{asset('public/img/logo/facebook.png')}}" alt="facebook"></a>
                <a href="#" style="padding: 0 10px;"><img style="height: 40px;" src="{{asset('public/img/logo/instagram.png')}}" alt="facebook"></a>
                <a href="#" style="padding: 0 10px;"><img style="height: 40px;" src="{{asset('public/img/logo/linkedin.png')}}" alt="facebook"></a>
                <a href="#" style="padding: 0 10px;"><img style="height: 40px;" src="{{asset('public/img/logo/twitter.png')}}" alt="facebook"></a>
                <a href="#" style="padding: 0 10px;"><img style="height: 40px;" src="{{asset('public/img/logo/youtube.png')}}" alt="facebook"></a>
            </div>
            <div class="flex center-y">
                Acko General Insurance
            </div>
            <div class="flex center-y">
                <a
                   href="https://www.google.co.in/maps/place/Acko+General+Insurance+Limited/@19.1451599,72.8511159,17z/data=!4m12!1m6!3m5!1s0x3be7b7cc90e9fe67:0x77add62e2eee5ebe!2sAcko+General+Insurance+Limited!8m2!3d19.1451599!4d72.8533046!3m4!1s0x3be7b7cc90e9fe67:0x77add62e2eee5ebe!8m2!3d19.1451599!4d72.8533046?hl=en">3rd
                    Floor, F Wing, Lotus Corporate Park, Goregaon(E), Mumbai 400063</a>
            </div>
        </div>
        <!-- Print Button -->
    <button id="printButton" onclick="printPage()">Print</button>

    <script>
        // JavaScript function to print the page
        function printPage() {
            // Hide the button manually before printing
            const printButton = document.getElementById('printButton');
            printButton.style.display = 'none';

            // Trigger the print dialog
            window.print();

            // Show the button again after a delay, allowing the print dialog to close
            setTimeout(() => {
                printButton.style.display = 'inline'; // or 'block' depending on your layout
            }, 1000);
        }
    </script>
    </body>

</html>
