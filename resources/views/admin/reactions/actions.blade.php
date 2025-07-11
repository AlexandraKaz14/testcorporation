
<a class="btn btn-secondary btn-sm  mr-1" href="{{route("{$currentUserRole}.tests.questions.answers.reactions.show",$reaction)}}"
   data-bs-toggle="tooltip" title={{__('common.open')}}>
    <i class="fa fa-eye"> </i> </a>


@if($reaction->answer->question->test->isDraft())
    <a class="btn btn-info btn-sm mr-1" href="{{route("{$currentUserRole}.tests.questions.answers.reactions.edit", $reaction->id)}}" data-bs-toggle="tooltip" title={{__('common.edit')}}> <i class="fas fa-edit"></i></a>
    <button data-bs-toggle="tooltip" title={{__('common.delete')}} type="button"
            class="btn btn-danger btn-sm  mr-1" data-toggle="modal" data-target="#modal-danger{{$reaction->id}}"
            style="display:inline-block;"><i class="fas fa-trash"></i></button>
    <div class="modal fade" id="modal-danger{{$reaction->id}}">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-center"> {{__("common.Are you sure you want to delete the reaction?")}}</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light"
                            data-dismiss="modal"> {{__("common.close")}}</button>
                    <form action="{{route("{$currentUserRole}.tests.questions.answers.reactions.destroy", $reaction)}}" method="post">
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



@push('js')
    <script>
        $(document).ready(function () {
            $('[data-bs-toggle="tooltip"]').tooltip();
        });

    </script>
@endpush
