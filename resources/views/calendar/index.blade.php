@extends('layouts.app1')
@section('title', 'Calendar')

@section('css')
<link rel="stylesheet" href="{{asset('admin/assets/bundles/fullcalendar/fullcalendar.min.css')}}">
@endsection

@section('content')
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Calendar</h4>
                  </div>
                  <div class="card-body">
                    <div class="fc-overflow">
                      <div id="myEvent"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
@endsection

@section('js')
<script src="{{asset('assets/bundles/fullcalendar/fullcalendar.min.js')}}"></script>
<script src="{{asset('admin/assets/js/page/calendar.js')}}"></script>
<script>
var events = @json($jadwalKeberangkatans);

var calendar = $('#myEvent').fullCalendar({
  height: 'auto',
  defaultView: 'month',
  editable: true,
  selectable: true,
  header: {
    left: 'prev,next today',
    center: 'title',
    right: 'month,agendaWeek,agendaDay,listMonth'
  },
  events: events
});
</script>
@endsection
