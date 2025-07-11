@switch($moderation->moderation_status)

    @case('pending')
        @include('partial.badge-warning',[
        'icon'=>'spinner',
        'text'=>__("common." . $moderation->moderation_status),
        ])
        @break
    @case('approved')
        @include('partial.badge-success',[
        'icon'=>'check',
        'text'=>__("common." . $moderation->moderation_status),
        ])
        @break
    @case('rejected')
        @include('partial.badge-danger',[
        'icon'=>'times',
        'text'=>__("common." . $moderation->moderation_status),
        ])
        @break
    @default
        {{__("common." . $moderation->moderation_status)}}
@endswitch

