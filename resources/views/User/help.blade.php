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
<style>
    <style>
        body {
            background-color: #2c2f33;
            color: #ffffff;
            font-family: 'Arial', sans-serif;
        }
        .contact-container {
            background-color: #23272a;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.4);
            padding: 30px;
            margin: 30px auto;
            max-width: 800px;
        }
        .contact-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .contact-header h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #ffffff;
        }
        .contact-header p {
            color: #b0b0b0;
        }
        .contact-item {
            background-color: #2e343b;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .contact-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.3);
        }
        .contact-item i {
            font-size: 2rem;
            color: #7289da;
            margin-right: 15px;
        }
        .contact-item h4 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 10px;
        }
        .contact-item p {
            color: #b0b0b0;
            margin: 0;
        }
        .contact-item a {
            color: #7289da;
            text-decoration: none;
        }
        .contact-item a:hover {
            text-decoration: underline;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #b0b0b0;
        }
        .footer p {
            margin: 0;
        }
    </style>
</style>
<!-- end page title -->
<div class="container">
    <div class="contact-container">
        <div class="contact-header">
            <h2>Need Help? Contact Us!</h2>
            <p>If you have any issues or need further assistance, feel free to reach out to us through the contact details below.</p>
        </div>

        <!-- Contact Details Section -->
        <div class="contact-item">
            <div class="d-flex align-items-center">
                <i class="fas fa-envelope"></i>
                <div>
                    <h4>Email Us</h4>
                    <p><a href="mailto:support@example.com">support@example.com</a></p>
                </div>
            </div>
        </div>

        <div class="contact-item">
            <div class="d-flex align-items-center">
                <i class="fas fa-phone"></i>
                <div>
                    <h4>Call Us</h4>
                    <p><a href="tel:+1234567890">+91 12345 67890</a></p>
                </div>
            </div>
        </div>

        <div class="contact-item">
            <div class="d-flex align-items-center">
                <i class="fas fa-map-marker-alt"></i>
                <div>
                    <h4>Visit Us</h4>
                    <p>123 Building, Gola Road, Patna, Bihar - 123456</p>
                </div>
            </div>
        </div>

        <div class="contact-item">
            <div class="d-flex align-items-center">
                <i class="fas fa-clock"></i>
                <div>
                    <h4>Working Hours</h4>
                    <p>Monday - Friday: 11:00 AM - 6:00 PM</p>
                    <p>Saturday: 11:00 AM - 4:00 PM</p>
                    <p>Sunday: Closed</p>
                </div>
            </div>
        </div>
