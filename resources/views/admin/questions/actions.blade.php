@if($questionsDeleted)
    @if($question->test->isDraft())
    <form action="{{route("{$currentUserRole}.tests.questions.restore", $question->id)}}" method="post">
        @csrf
        <button type="submit" class="btn btn-warning btn-sm mr-1" data-bs-toggle="tooltip" title={{__('common.restore')}}><i class="fa fa-undo"></i></button>
    </form>
    @elseif($question->test->isActive())
        <button type="submit" class="btn btn-warning btn-sm mr-1" data-bs-toggle="tooltip" title={{__('common.cant be restored')}} tabindex="0" style=" opacity: 0.65;"><i class="fa fa-undo"></i></button>
    @endif
@else

    <a class="btn btn-secondary btn-sm mr-1" href="{{route("{$currentUserRole}.tests.questions.show", $question)}}"
   data-bs-toggle="tooltip" title={{__('common.open')}}>
    <i class="fa fa-eye"> </i> </a>

@if($question->test->isDraft())

    <a class="btn btn-info btn-sm mr-1" href="{{route("{$currentUserRole}.tests.questions.edit", $question->id)}}" data-bs-toggle="tooltip" title={{__('common.edit')}}> <i class="fas fa-edit"></i></a>

    <button data-bs-toggle="tooltip" title={{__('common.delete')}} type="button"
            class="btn btn-danger btn-sm mr-1 " data-toggle="modal" data-target="#modal-danger{{$question->id}}"
            style="display:inline-block;"><i class="fas fa-trash"></i></button>
    <div class="modal fade" id="modal-danger{{$question->id}}">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-center"> {{__("common.Are you sure you want to delete the question?")}}</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light"
                            data-dismiss="modal"> {{__("common.close")}}</button>
                    <form action="{{route("{$currentUserRole}.tests.questions.destroy", $question)}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-outline-light">{{__("common.delete")}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@elseif(!$question->test->isDraft())
    @include('partial.button_delete_edit_no_active')
@endif


@endif
@push('js')
<script>
    $(document).ready(function () {
        jQuery(function($){
            $(".hasTooltip").tooltip({"html": true,"container": "body"});
        });
    });

</script>
@endpush
