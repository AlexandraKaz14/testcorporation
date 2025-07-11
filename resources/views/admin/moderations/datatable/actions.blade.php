<div class="d-flex align-items-center gap-2">
    <a class="btn btn-info btn-sm mr-1 "
       href="{{route('player.open', $moderation->test->slug)}}"
       data-bs-toggle="tooltip" title="{{__('common.open to player')}}">
        <i class="fa fa-play"></i>
    </a>

@if($moderation->isPending())
        <form action="{{ route('admin.moderations.approved', $moderation->id) }}" method="POST" class="d-flex align-items-center m-0 p-0">
            @csrf
            <button type="submit" class="btn btn-success btn-sm mr-1"
                    data-bs-toggle="tooltip" title="{{ __('common.approve test') }}">
                <i class="fa fa-check"></i>
            </button>
        </form>

        <button data-bs-toggle="tooltip" title="{{__('common.reject')}}" type="button"
                class="btn btn-danger btn-sm mr-1"
                data-toggle="modal" data-target="#modal-danger{{$moderation->id}}">
            <i class="fas fa-window-close"></i>
        </button>

    <div class="modal fade" id="modal-danger{{$moderation->id}}">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('common.reason for refusal')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form id="form-group" action="{{route("admin.moderations.rejected", $moderation)}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="exampleInputRejection">
                                </label>
                                <textarea class="form-control" type="text" name="rejection_reason" rows="3"
                                          id="exampleInputRejection"
                                          placeholder="{{__('common.enter rejection reason')}}"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-light"
                                data-dismiss="modal"> {{__("common.close")}}</button>

                        <input class="btn btn-outline-light" id="submitBtn" type="submit"
                               value="{{__('common.save')}}">
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

@if($moderation->isRejection() || $moderation->isApproved())
    @include('partial.button_no_active_moderation')
@endif
</div>

<script>
    $(document).ready(function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });

</script>
