@if($announcements->count())
    @foreach($announcements as $announcement)
        <div class="nk-notification">
            <div class="nk-notification-item dropdown-inner">
                <div class="nk-notification-icon">
                    <em class="icon icon-circle bg-{{ $announcement->type }}-dim ni ni-curve-down-left"></em>
                </div>
                <div class="nk-notification-content">
                    <div class="nk-notification-text">{!! $announcement->message !!}</div>
                    <div class="nk-notification-time">{{ $announcement->updated_at->diffForHumans() }}</div>
                </div>
            </div>
        </div>
    @endforeach
@endif
