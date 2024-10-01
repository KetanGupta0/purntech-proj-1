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
<!-- FullCalendar CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />

<!-- FullCalendar JS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>

<div class="card">
    <div class="card-header">
      Payment Report
    </div>
    <div class="card-body">
      <h5 class="card-title">Advance Amount for LO - ₹3500000.00</h5> {{-- From DB --}}
      <h5 class="card-title">Monthly Rent for LO - ₹45000.00</h5>{{-- From DB --}}
      <a href="#calendar" class="btn btn-primary">View Calender</a>
    </div>
  </div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: '/employee/payment-status', // Fetch events via AJAX
            eventColor: '#378006', // Color for events
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth'
            },
            eventRender: function (info) {
                $(info.el).tooltip({
                    title: info.event.extendedProps.paymentStatus
                });
            }
        });

        calendar.render();
    });
</script>