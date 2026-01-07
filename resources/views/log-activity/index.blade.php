@extends('layouts.app')

@section('content')
<div class="section-body">
    <h2 class="section-title">Activity Logs</h2>
    <div class="row">
        <div class="col-12">
            <div class="activities">
                @forelse($activities as $activity)
                <div class="activity">
                    <div class="activity-icon bg-primary text-white">
                        <i class="fas fa-{{ $activity->getIconForEvent() }}"></i>
                    </div>
                    <div class="activity-detail">
                        <div class="mb-2">
                            <span class="text-job text-info">{{ $activity->created_at->diffForHumans() }}</span>
                            <span class="bullet"></span>
                            <span class="text-job">{{ $activity->causer ? $activity->causer->name : 'System'
                                }}</span>
                            <div class="float-right dropdown">
                                <a href="#" data-toggle="dropdown"><i class="fas fa-ellipsis-h"></i></a>
                                <div class="dropdown-menu">
                                    <div class="dropdown-title">Options</div>
                                    <a href="{{ route('log-activity.show', $activity->id) }}"
                                        class="dropdown-item has-icon"><i class="fas fa-eye"></i> View</a>
                                    <a href="#" class="dropdown-item has-icon"><i class="fas fa-list"></i>
                                        Detail</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="#" class="dropdown-item has-icon text-danger"
                                        data-confirm="Wait, wait, wait...|This action can't be undone. Want to take risks?"
                                        data-confirm-text-yes="Yes, IDC"><i class="fas fa-trash-alt"></i>
                                        Archive</a>
                                </div>
                            </div>
                        </div>
                        <p>{{ $activity->description }}</p>
                        @if($activity->properties && count($activity->properties) > 0)
                        <div class="mt-2">
                            <small class="text-muted">
                                @if(isset($activity->properties['old']) &&
                                isset($activity->properties['attributes']))
                                <strong>Changes:</strong>
                                <ul>
                                    @foreach($activity->properties['attributes'] as $key => $value)
                                    <li>{{ $key }}: {{ $value }}</li>
                                    @endforeach
                                </ul>
                                @else
                                {{-- <strong>Details:</strong> {{ json_encode($activity->properties) }} --}}
                                @endif
                            </small>
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="activity">
                    <div class="activity-detail">
                        <p>No activities found.</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="mt-4">
        {{ $activities->links() }}
    </div>
</div>
@endsection
