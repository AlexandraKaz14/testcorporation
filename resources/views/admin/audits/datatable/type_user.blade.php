@switch($audit->user_type)
    @case('App\Models\User')
        {{__("common.Registered user")}}
        @break
    @case(null && $audit->user_id===null && $audit->auditable_type === 'App\Models\TakingTest' )
        {{__("common.guest")}}
        @break
    @default
        {{ $audit->user_type}}
@endswitch
