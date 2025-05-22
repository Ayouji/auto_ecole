@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Notifications</h1>
        <div>
            <a href="{{ route('notifications.markAllAsRead') }}" class="btn btn-outline-primary">
                <i class="bi bi-check2-all me-1"></i> Mark All as Read
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link {{ request()->query('filter') !== 'read' ? 'active' : '' }}" 
                       href="{{ route('notifications.index') }}">
                        All Notifications
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->query('filter') === 'unread' ? 'active' : '' }}" 
                       href="{{ route('notifications.index', ['filter' => 'unread']) }}">
                        Unread
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->query('filter') === 'read' ? 'active' : '' }}" 
                       href="{{ route('notifications.index', ['filter' => 'read']) }}">
                        Read
                    </a>
                </li>
            </ul>
        </div>
        <div class="card-body p-0">
            @if($notifications->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($notifications as $notification)
                        <div class="list-group-item {{ !$notification->is_read ? 'list-group-item-light' : '' }}">
                            <div class="d-flex w-100 justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    @php
                                        $typeClass = 'secondary';
                                        $typeIcon = 'bell';
                                        
                                        switch($notification->type) {
                                            case 'relance':
                                                $typeClass = 'warning';
                                                $typeIcon = 'bell';
                                                break;
                                            case 'relance_50':
                                                $typeClass = 'info';
                                                $typeIcon = 'info-circle';
                                                break;
                                            case 'relance_75':
                                                $typeClass = 'primary';
                                                $typeIcon = 'clock-history';
                                                break;
                                            case 'cloture':
                                                $typeClass = 'success';
                                                $typeIcon = 'check-circle';
                                                break;
                                        }
                                    @endphp
                                    
                                    <div class="me-3">
                                        <div class="d-flex align-items-center justify-content-center bg-light rounded-circle" style="width: 45px; height: 45px;">
                                            <i class="bi bi-{{ $typeIcon }} text-{{ $typeClass }} fs-4"></i>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <div class="d-flex align-items-center mb-1">
                                            <h5 class="mb-0">{{ $notification->entreprise_name }}</h5>
                                            <span class="badge bg-{{ $typeClass }} ms-2">{{ $notification->type }}</span>
                                            @if(!$notification->is_read)
                                                <span class="badge bg-danger ms-2">New</span>
                                            @endif
                                        </div>
                                        <p class="mb-1">{{ $notification->contenu }}</p>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</small>
                                    </div>
                                </div>
                                
                                @if(!$notification->is_read)
                                    <form action="{{ route('notifications.markAsRead') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $notification->id }}">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-check2-all me-1"></i> Mark as Read
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted"><i class="bi bi-check2-all"></i> Read</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="p-3">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="text-center p-5">
                    <i class="bi bi-bell-slash fs-1 text-muted"></i>
                    <p class="mt-3 text-muted">No notifications found</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection