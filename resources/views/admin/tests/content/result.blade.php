<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                    <h3 class="card-title mb-2"><i class="fa fa-list mr-1"></i> {{__('common.results')}}</h3>


                    <div class="card-tools w-100 w-md-auto">
                        <div class="row g-2">
                            <div class= "col-12 d-flex flex-column flex-md-row justify-content-md-end gap-2">
                        @if($test->isDraft())
                        <a href="{{route("{$currentUserRole}.tests.results.create",  ['test_id'=>$test])}}"
                           class="btn btn-success">
                            <i class="fas fa-plus mr-2"></i>{{__('common.add result')}}
                        </a>
                        @elseif($test->isActive() || $test->isModeration() && $test->user->isAuthor())
                            <a class="btn btn-success" aria-disabled="true" role="button" data-bs-toggle="tooltip"
                               data-bs-placement="top"
                               title="{{__('common.test published, cant add') }}"
                               tabindex="0"
                               style=" opacity: 0.65;">
                                <i class="fas fa-plus mr-2"></i>
                                {{__('common.add result') }}</a>
                        @endif
                    </div>
                    </div>
                    </div>

                </div>

                <div class="card">
                    <div class="card-body table-responsive p-0">

                        <table id='myTableResults' class="table table-head-fixed text-nowrap">
                            <thead>
                            <tr>
                                <th>{{__('common.number')}}</th>
                                <th>{{__('common.condition')}}</th>
                                <th>{{__('common.picture')}}</th>
                                <th>{{__('common.text')}}</th>
                                <th>{{__('common.created_at')}}</th>
                                <th class="fixed-right">{{__('common.actions')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($number=1)
                            @foreach($results as $result)
                                @if($result->is_default === true)
                                    <tr data-id="{{$result->id}}" class="fixedresult">
                                        <td class="index">{{ $number++ }}</td>
                                        <td>
                                            {{__('common.default result')}}
                                        </td>
                                        <td>@if($result->picture)
                                                <img alt="Avatar" class="rounded-circle"
                                                     src="{{ Storage::url($result->picture)}}" height="50"
                                                     width="50">
                                            @else
                                                <p>{{__('common.absent')}}</p>
                                            @endif</td>
                                        <td> {{mb_strlen($result->text) > 23 ?
                                               mb_substr($result->text, 0, 20) . '...' :
                                               $result->text}}
                                        </td>
                                        <td>{{$result->created_at}}</td>
                                        <td>
                                            <div class="d-flex  gap-2">
                                            <a class="btn btn-secondary btn-sm float-left mr-2"
                                               href="{{route("{$currentUserRole}.tests.results.show", $result)}}"
                                               data-bs-toggle="tooltip" title={{__('common.open')}}>
                                                <i class="fa fa-eye"> </i> </a>
                                            @if($result->test->isDraft())
                                            <a class="btn btn-info btn-sm float-left mr-1"
                                               href="{{route("{$currentUserRole}.tests.results.edit", $result->id)}}"
                                               data-bs-toggle="tooltip" title={{__('common.edit')}}> <i
                                                    class="fas fa-edit"></i></a>
                                            @else
                                                <a class="btn btn-info btn-sm float-left mr-1" href="#" data-bs-toggle="tooltip" title="{{__('common.action unavailable')}}"  tabindex="0"
                                                   style=" opacity: 0.65;" > <i class="fas fa-edit"></i></a>
                                            @endif
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    <tr data-id="{{$result->id}}">
                                        <td class="index">{{ $number++ }}</td>
                                        <td> {{$result->condition}}</td>
                                        <td>@if($result->picture)
                                                <img alt="Avatar" class="rounded-circle"
                                                     src="{{ Storage::url($result->picture)}}" height="50"
                                                     width="50">
                                            @else
                                                <p>{{__('common.absent')}}</p>
                                            @endif</td>
                                        <td>
                                            @if($result->text !== null)
                                                {{mb_strlen($result->text) > 23 ?
                                                   mb_substr($result->text, 0, 20) . '...' :
                                                   $result->text}}
                                            @else
                                                <p>---</p>
                                            @endif
                                        </td>
                                        <td>{{$result->created_at}}</td>
                                        <td>
                                            @include('admin.results.actions')
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
