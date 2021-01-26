<link href='<?= base_url()."assets/calender/packages/core/main.css";?>' rel='stylesheet' />
<link href='<?= base_url()."assets/calender/packages/daygrid/main.css";?>' rel='stylesheet' />
<link href='<?= base_url()."assets/calender/packages/timegrid/main.css";?>' rel='stylesheet' />
<link href='<?= base_url()."assets/calender/packages/list/main.css";?>' rel='stylesheet' />


<style>


  #calendar {
    max-width: 900px;
    margin: 0 auto;
  }

</style>
<div class="row first">
  <div class="col s12 offset-l3 l9">
    <div id='announcement'>
      {{ message }}
    </div>
  </div>
  <div class="col s12 offset-l3 l9">
    <div id='calendar'></div>
  </div>
</div>

<script src='<?= base_url()."assets/calender/packages/core/main.js";?>'></script>
<script src='<?= base_url()."assets/calender/packages/interaction/main.js";?>'></script>
<script src='<?= base_url()."assets/calender/packages/daygrid/main.js";?>'></script>
<script src='<?= base_url()."assets/calender/packages/timegrid/main.js";?>'></script>
<script src='<?= base_url()."assets/calender/packages/list/main.js";?>'></script>
<script>

  document.addEventListener('DOMContentLoaded', function() {

    new Vue({
      el: '#announcement',
      data: {
        message: 'On maintenance. Please wait...',
        
      }
    })

    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
      },
      defaultDate: new Date(),
      navLinks: true, // can click day/week names to navigate views
      locale: 'id',

      weekNumbers: true,
      weekNumbersWithinDays: true,
      weekNumberCalculation: 'ISO',

      editable: true,
      eventLimit: true, // allow "more" link when too many events
      events: [
        {
          title: 'All Day Event',
          start: '2020-02-01'
        },
        {
          title: 'Long Event',
          start: '2020-02-07',
          end: '2020-02-10'
        },
        {
          groupId: 999,
          title: 'Repeating Event',
          start: '2020-02-09T16:00:00'
        },
        {
          groupId: 999,
          title: 'Repeating Event',
          start: '2020-02-16T16:00:00'
        },
        {
          title: 'Conference',
          start: '2020-02-11',
          end: '2020-02-13'
        },
        {
          title: 'Meeting',
          start: '2020-02-12T10:30:00',
          end: '2020-02-12T12:30:00'
        },
        {
          title: 'Lunch',
          start: '2020-02-12T12:00:00'
        },
        {
          title: 'Meeting',
          start: '2020-02-12T14:30:00'
        },
        {
          title: 'Happy Hour',
          start: '2020-02-12T17:30:00'
        },
        {
          title: 'Dinner',
          start: '2020-02-12T20:00:00'
        },
        {
          
          title: 'Birthday BNI',
          start: '2020-07-06'
        },
        {
          title: 'Click for Google',
          url: 'http://google.com/',
          start: '2020-02-28'
        }
      ]
    });

    calendar.render();
  });

</script>