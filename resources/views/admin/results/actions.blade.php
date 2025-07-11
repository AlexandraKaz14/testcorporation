{{--<div class="d-flex  gap-2">--}}
<a class="btn btn-secondary btn-sm  mr-1" href="{{route("{$currentUserRole}.tests.results.show", $result)}}"
   data-bs-toggle="tooltip" title={{__('common.open')}}>
    <i class="fa fa-eye"> </i> </a>

@if($result->test->isDraft())
    <a class="btn btn-info btn-sm  mr-1" href="{{route("{$currentUserRole}.tests.results.edit", $result->id)}}" data-bs-toggle="tooltip" title={{__('common.edit')}}> <i class="fas fa-edit"></i></a>

    <button data-bs-toggle="tooltip" title={{__('common.delete')}} type="button"
            class="btn btn-danger btn-sm  mr-1" data-toggle="modal" data-target="#modal-danger{{$result->id}}"
            style="display:inline-block;"><i class="fas fa-trash"></i></button>
    <div class="modal fade" id="modal-danger{{$result->id}}">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-center"> {{__("common.Are you sure you want to delete the result?")}}<br>
                        {{__("common.This result cannot be restored!")}}</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light"
                            data-dismiss="modal"> {{__("common.close")}}</button>
                    <form action="{{route("{$currentUserRole}.tests.results.destroy", $result)}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-outline-light">{{__("common.delete")}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@else
@include('partial.button_delete_edit_no_active')
@endif
{{--</div>--}}



@push('js')
<script>
    $(document).ready(function () {
        jQuery(function($){
            $(".hasTooltip").tooltip({"html": true,"container": "body"});
        });
    });

</script>
@endpush
