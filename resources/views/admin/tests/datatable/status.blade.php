@switch($test->status)
    @case('draft')
        @include('partial.badge-info',[
        'icon'=>'',
        'text'=>__("common." . $test->status),
        ])
        @break
    @case('moderation')
        @include('partial.badge-warning',[
        'icon'=>'',
        'text'=>__("common." . $test->status),
        ])
        @break
    @case('active')
        @include('partial.badge-success',[
        'icon'=>'',
        'text'=>__("common." . $test->status),
        ])
        @break
    @default
        {{__("common." . $test->status)}}
@endswitch
