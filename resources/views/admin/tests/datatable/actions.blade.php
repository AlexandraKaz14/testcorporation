<div class="d-flex  gap-2">

@if($test->trashed())
    <form action="{{route("{$currentUserRole}.tests.restore", $test->id)}}" method="post">
        @csrf
        <button type="submit" class="btn btn-warning btn-sm mr-1" data-bs-toggle="tooltip" title={{__('common.restore')}}><i class="fa fa-undo"></i></button>
    </form>
@else
    <a class="btn btn-secondary btn-sm  mr-1" href="{{route("{$currentUserRole}.tests.show", $test)}}" data-bs-toggle="tooltip" title={{__('common.open')}}>
        <i class="fa fa-eye"> </i> </a>

    @if($test->isDraft())
    <a class="btn btn-info btn-sm mr-1" href="{{route("{$currentUserRole}.tests.edit", $test->id)}}" data-bs-toggle="tooltip" title={{__('common.edit')}}> <i class="fas fa-edit"></i></a>

    <button data-bs-toggle="tooltip" title={{__('common.delete')}} type="button" class="btn btn-danger btn-sm  mr-1" data-toggle="modal" data-target="#modal-danger{{$test->id}}" style="display:inline-block;" ><i class="fas fa-trash"></i></button>
    <div class="modal fade" id="modal-danger{{$test->id}}">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-center"> {{__("common.Are you sure you want to delete the test?")}}</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal"> {{__("common.close")}}</button>
                    <form action="{{route("{$currentUserRole}.tests.destroy", $test)}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-outline-light">{{__("common.delete")}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @elseif(!$test->isDraft())

            <a class="btn btn-info btn-sm mr-1" href="#" data-bs-toggle="tooltip" title="{{__('common.action unavailable')}}"  tabindex="0"
               style=" opacity: 0.65;" > <i class="fas fa-edit"></i></a>

            <button data-bs-toggle="tooltip" title={{__('common.action unavailable')}} type="button" class="btn btn-danger btn-sm mr-1" data-toggle="modal" data-target="#modal-danger"  tabindex="0" style=" opacity: 0.65;" ><i class="fas fa-trash"></i></button>    @endif
@endif

</div>


<script>
    $(document).ready(function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });

</script>






