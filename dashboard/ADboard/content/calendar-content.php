<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Interview Calendar</title>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
    <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
</head>
<body>
<h1>Interview Calendar</h1>
    <div id="calendar"></div>
    <script src="path/to/your/calendar-script.js"></script>
   <!-- <div class="container">
        <h2>Interview Calendar</h2>
        <div id="calendar"></div>
    </div> -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: {
                    url: '../../actions/admin_action.php?action=fetch_calendar_data',
                    method: 'GET',
                    failure: function() {
                        alert('There was an error while fetching events!');
                    }
                },
                eventClick: function(info) {
                    alert('Job: ' + info.event.title + '\nRecruiter ID: ' + info.event.extendedProps.recruiter_id +
                          '\nInterviews: ' + info.event.extendedProps.interview_count);
                }
            });

            calendar.render();
        });
    </script>
</body>
</html>
