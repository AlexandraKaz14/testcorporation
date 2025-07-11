<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                    <h3 class="card-title mb-2"><i class="fa fa-list mr-1"></i> {{__('common.list variables')}}</h3>

                    <div class="card-tools w-100 w-md-auto">
                        <div class="row g-2">
                            <div class="col-12 d-flex flex-column flex-md-row justify-content-md-end gap-2">
                                @if($test->isDraft())
                                    <a href="{{route("{$currentUserRole}.tests.variables.create",  ['test_id'=>$test])}}"
                                       class="btn btn-success mb-2 mr-lg-2 mr-md-2">
                                        <i class="fas fa-plus mr-2"></i>{{__('common.add variable')}}
                                    </a>
                                    @if($variablesDeleted)
                                        <a href="{{route("{$currentUserRole}.tests.show", ['test' => $test->id])}}"
                                           class="btn btn-primary mb-2">
                                            {{__('common.show active')}}
                                        </a>
                                    @else
                                        <a href="{{route("{$currentUserRole}.tests.show", ['test' => $test->id, 'deleted_variables' => true])}}"
                                           class="btn btn-warning mb-2" id="show-deleted-variables">
                                            {{__('common.show deleted')}}
                                        </a>
                                    @endif
                                @elseif($test->isActive() || $test->isModeration() && $test->user->isAuthor())
                                    <a class="btn btn-success mb-2 mr-lg-2 mr-md-2" aria-disabled="true" role="button"
                                       data-bs-toggle="tooltip"
                                       data-bs-placement="top"
                                       title="{{__('common.test published, cant add') }}"
                                       tabindex="0"
                                       style=" opacity: 0.65;">
                                        <i class="fas fa-plus mr-2"></i>
                                        {{__('common.add variable') }}</a>
                                @endif


                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body table-responsive p-0">

                        @if($variables->isEmpty())
                            <p class="text-center"> {{__('common.variables are missing')}}</p>
                        @else
                            <table id='myTableVariables' class="table table-head-fixed text-nowrap">
                                <thead>
                                <tr>
                                    <th>{{__('common.name variable')}}</th>
                                    <th>{{__('common.starting value')}}</th>
                                    <th>{{__('common.created_at')}}</th>
                                    <th class="fixed-right">{{__('common.actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($variables as $variable)
                                    <tr>
                                        <td>
                                            @if($variablesDeleted)
                                                {{$variable->name}}
                                            @else
                                                <a href="{{route("{$currentUserRole}.tests.variables.show", $variable)}}">{{$variable->name}}</a>
                                        </td>
                                        @endif
                                        <td>{{$variable->start_value}}</td>
                                        <td>{{$variable->created_at}}</td>
                                        <td>
                                            @include('admin.variables.actions')
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
