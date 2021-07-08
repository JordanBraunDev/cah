$(document).ready(function() {

    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    var events_array = [
        {
        title: 'Test1',
        start: new Date(2012, 8, 20),
        tip: 'Personal tip 1'},
    {
        title: 'Test2',
        start: new Date(2012, 8, 21),
        tip: 'Personal tip 2'}
    ];

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        selectable: true,
        events: events_array,
        eventRender: function(event, element) {
            element.attr('title', event.tip);
        },
        select: function(start, end, allDay) {
    var title = prompt('Event Title:');
    if (title) {
        calendar.fullCalendar('renderEvent',
            {
                title: title,
                start: start,
                end: end,
                allDay: allDay
            },
            true // make the event "stick"
        );
        /**
         * ajax call to store event in DB
         */
        jQuery.post(
            "event/new" // your url
            , { // re-use event's data
                title: title,
                start: start,
                end: end,
                allDay: allDay
            }
        );
    }
    calendar.fullCalendar('unselect');
}

    });
});