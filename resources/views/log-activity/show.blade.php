@extends('layouts.app1')
@section('content')
<div class="section-body">
    <h2 class="section-title">Activity Log Details</h2>
    <div class="row">
        <div class="col-9">
            <div class="card">
                <div class="card-header">
                    <h4>Activity Details</h4>
                </div>
                <div class="card-body">
                    <div class="media">
                        <div class="activity-icon text-dark icon-gama">
                            <i class="fas fa-{{ $activity->getIconForEvent() }}"></i>
                        </div>
                        <div class="media-body">
                            <h5 class="mt-0 text-dark"> {{ $activity->description }}</h5>
                            <p class="mb-1">
                                <strong>User:</strong> {{ $activity->causer ? $activity->causer->name : 'System' }}<br>
                                <strong>Time:</strong> {{ $activity->created_at->format('d M Y H:i:s') }} ({{
                                $activity->created_at->diffForHumans() }})<br>
                                @if($activity->subject_type)
                                <strong>Subject:</strong> {{ class_basename($activity->subject_type) }} (ID: {{
                                $activity->subject_id }})<br>
                                @endif
                                @if($activity->event)
                                <strong>Event:</strong> {{ $activity->event }}<br>
                                @endif
                            </p>
                            @if($activity->properties && count($activity->properties) > 0)
                            <div class="mt-3">
                                <h6>Changes & Details:</h6>
                                <div class="row">
                                    @if(isset($activity->properties['old']) &&
                                    isset($activity->properties['attributes']))
                                    <div class="col-md-6">
                                        <h6>Old Values:</h6>
                                        <ul class="list-group">
                                            @foreach($activity->properties['old'] as $key => $value)
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ $key }}
                                                <span class="badge badge-secondary">{{ $value }}</span>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h6>New Values:</h6>
                                        <ul class="list-group">
                                            @foreach($activity->properties['attributes'] as $key => $value)
                                            <li
                                                class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ $key }}
                                                <span class="badge badge-primary">{{ $value }}</span>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @else
                                    <div class="col-12">
                                        <pre
                                            class="bg-light p-3 rounded">{{ json_encode($activity->properties, JSON_PRETTY_PRINT) }}</pre>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('log-activity.index') }}" class="btn btn-outline-primary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection