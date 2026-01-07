@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>All Notifications</h4>
                <div class="card-header-action">
                    <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Mark All as Read</button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Message</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($notifications as $notification)
                            <tr>
                                <td>{{ $notification->data['message'] ?? 'Notification received' }}</td>
                                <td>{{ $notification->created_at->diffForHumans() }}</td>
                                <td>
                                    @if($notification->read_at)
                                    <span class="badge badge-success">Read</span>
                                    @else
                                    <span class="badge badge-warning">Unread</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!$notification->read_at)
                                    <form action="{{ route('notifications.markAsRead', $notification->id) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary">Mark as Read</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">No notifications found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="float-right">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
