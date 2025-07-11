<div class="d-flex  gap-2">

@if($user->trashed())
    <form action="{{route('admin.users.restore', $user->id)}}" method="post">
       @csrf
        <button type="submit" class="btn btn-warning btn-sm float-left mr-1" data-bs-toggle="tooltip" title={{__('common.restore')}}><i class="fa fa-undo"></i></button>
    </form>
@else
    <a class="btn btn-secondary btn-sm float-left mr-1" href="{{route('admin.users.show', $user)}}" data-bs-toggle="tooltip" title={{__('common.open')}}><i class="fas fa-id-card"></i></a>
    <a class="btn btn-info btn-sm float-left mr-1" href="{{route('admin.users.edit', $user->id)}}" data-bs-toggle="tooltip" title={{__('common.edit')}}><i class="fas fa-edit"></i></a>


    <button type="button" class="btn btn-danger btn-sm float-left mr-1" data-toggle="modal" data-target="#modal-danger" style="display:inline-block;" data-bs-toggle="tooltip" title={{__('common.delete')}}><i class="fas fa-trash"></i></button>
    <div class="modal fade" id="modal-danger">
        <div class="modal-dialog">
            <div class="modal-content bg-danger">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-center"> {{__("common.Are you sure you want to delete the user?")}}</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal"> {{__("common.close")}}</button>
                    <form action="{{route('admin.users.destroy', $user)}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-outline-light">{{__("common.delete")}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if($user->status === \App\Models\User::STATUS_ACTIVE)
        @if(auth()->id() === $user->id)
            <button class="btn btn-secondary btn-sm float-left mr-1" disabled>
                <i class="fa fa-key"></i>
            </button>
        @else
            <a class="btn btn-warning btn-sm float-left mr-1"
               href="{{ route('admin.users.login_as_user', $user->id) }}"
               data-bs-toggle="tooltip"
               title="{{ __('common.login to account') }}">
                <i class="fa fa-key"></i>
            </a>
        @endif
    @endif


@endif

</div>

<script>
    $(document).ready(function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
