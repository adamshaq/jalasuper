{{-- <li class="media content-divider justify-content-center text-muted mx-0">Monday, Feb 10</li> --}}

@foreach ($messages as $item)
    @if ($item->sender_tp == 'WP')
        <li class="media">
            <div class="mr-3">
                <a href="../../../../global_assets/images/placeholders/placeholder.jpg">
                    <img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" width="40" height="40" alt="">
                </a>
            </div>
        
            <div class="media-body">
                <div class="media-chat-item">{{ $item->message }}</div>
                <div class="font-size-sm text-muted mt-2">{{ tgl_dan_jam($item->created_at) }}</div>
            </div>
        </li>
    @else
        <li class="media media-chat-item-reverse">
            <div class="media-body">
                <div class="media-chat-item">{{ $item->message }}</div>
                <div class="font-size-sm text-muted mt-2">{{ tgl_dan_jam($item->created_at) }}</div>
            </div>
        
            <div class="ml-3">
                <a href="../../../../global_assets/images/placeholders/placeholder.jpg">
                    <img src="../../../../global_assets/images/placeholders/placeholder.jpg" class="rounded-circle" width="40" height="40" alt="">
                </a>
            </div>
        </li>
    @endif
@endforeach



