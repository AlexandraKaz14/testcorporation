<div class="d-flex  gap-2">

<a class="btn btn-secondary btn-sm float-left mr-1" href="{{route('admin.categories.show', $category)}}" data-bs-toggle="tooltip" title={{__('common.open')}}>
    <i class="fa fa-eye"></i></a>
<a class="btn btn-info btn-sm float-left mr-1" href="{{route('admin.categories.edit', $category)}}" data-bs-toggle="tooltip" title={{__('common.edit')}}><i
        class="fas fa-edit"></i></a>

<button type="button" class="btn btn-danger btn-sm float-left mr-1" data-toggle="modal" data-bs-toggle="tooltip" title={{__('common.delete')}}  data-target="#modal-danger{{$category->id}}" style="display:inline-block;"><i class="fas fa-trash" ></i></button>
<div class="modal fade" id="modal-danger{{$category->id}}">
    <div class="modal-dialog">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"></span>
                </button>
            </div>
            <div class="modal-body">
                <p> {{__("common.Are you sure you want to delete the category?")}}</p>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-light" data-dismiss="modal"> {{__("common.close")}}</button>
                <form action="{{route('admin.categories.destroy', $category)}}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-outline-light">{{__("common.delete")}}</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    $(document).ready(function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
