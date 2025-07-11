@switch($user->status)
    @case('active')
        @include('partial.badge-success',[
        'icon'=>'check',
        'text'=>__("common." . $user->status),
        ])
        @break
    @case('blocked')
        @include('partial.badge-danger',[
        'icon'=>'ban',
        'text'=>__("common." . $user->status),
        ])
        @break
    @default
        {{__("common." . $user->status)}}
@endswitch
