@switch($audit->event)
    @case('updated')
        {{__("common.updated")}}
        @break
    @case('created' )
        {{__("common.created")}}
        @break
    @case('deleted' )
        {{__("common.deletion")}}
        @break
    @case('restored' )
        {{__("common.restored")}}
        @break
    @default
        {{ $audit->event}}
@endswitch
