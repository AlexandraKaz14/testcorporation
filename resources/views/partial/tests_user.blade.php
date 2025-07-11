<p><a href="{{route('admin.tests.index',['users[]' => $user->id,  'deletedStatuses[]'=>\App\Models\Test::STATUS_UNDELETED ])}}" class="badge badge-warning" data-bs-toggle="tooltip"
      title="{{ __('common.total tests') }}">{{$user->tests->count()}}</a>
/
<a href="{{route('admin.tests.index',['users[]' => $user->id, 'statuses[]'=>\App\Models\Test::STATUS_ACTIVE , 'deletedStatuses[]'=>\App\Models\Test::STATUS_UNDELETED ])}}" class="badge badge-success" data-bs-toggle="tooltip"
   title="{{ __('common.active tests') }}">    {{$user->tests->filter(fn($test) => $test->status === \App\Models\Test::STATUS_ACTIVE)->count()}}
</a>
</p>


<script>
    $(document).ready(function () {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>

