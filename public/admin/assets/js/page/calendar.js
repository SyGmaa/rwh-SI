
// Calendar initialization is handled in the view file

$("#myEvent").fullCalendar({
  height: 'auto',
  header: {
    left: 'prev,next today',
    center: 'title',
    right: 'month,agendaWeek,agendaDay,listWeek'
  },
  editable: true,
  events: '/calendar-events',
  eventRender: function(event, element) {
    var title = '<b>' + event.nama_paket + '</b> (' + event.jumlah_jemaah + ' Jemaah)';
    element.find('.fc-title').html(title);
    element.find('.fc-time').remove();
  }
});