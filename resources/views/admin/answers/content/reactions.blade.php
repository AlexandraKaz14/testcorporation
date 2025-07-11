<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                    <h3 class="card-title mb-2"><i class="fa fa-list mr-1"></i> {{__('common.list reactions')}}</h3>
                    <div class="card-tools w-100 w-md-auto">
                        <div class="row g-2">
                            <div class="col-12 d-flex flex-column flex-md-row justify-content-md-end gap-2">
                                @if($answer->question->test->isDraft())
                        <a href="{{route("{$currentUserRole}.tests.questions.answers.reactions.create",  ['answer_id'=>$answer])}}"
                           class="btn btn-success mb-2 mr-lg-2 mr-md-2">
                            <i class="fas fa-plus mr-2"></i>{{__('common.add reaction')}}
                        </a>
                                @elseif($answer->question->test->isActive() || $answer->question->test->isModeration() && $answer->question->test->user->isAuthor())
                                    <a class="btn btn-success disabled mb-2 mr-lg-2 mr-md-2" aria-disabled="true" role="button"
                                       data-bs-toggle="tooltip" data-bs-placement="top"
                                       title="{{ __('common.test published, cant add') }}"
                                       style="opacity: 0.65;">
                                        <i class="fas fa-plus mr-2"></i> {{ __('common.add reaction') }}
                                    </a>
                                @endif
                    </div>
                    </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body table-responsive p-0">

                        @if($reactions->isEmpty())
                            <p class="text-center">{{__('common.no reaction')}}</p>
                        @else
                            <table id='myTable' class="table table-head-fixed text-nowrap">
                                <thead>
                                <tr>
                                    <th>{{__('common.variable')}}</th>
                                    <th>{{__('common.operation')}}</th>
                                    <th>{{__('common.created_at')}}</th>
                                    <th class="fixed-right">{{__('common.actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($reactions as $reaction)
                                    <tr>
                                        <td>
                                            <a href="{{route("{$currentUserRole}.tests.questions.answers.reactions.show", $reaction)}}">
                                                {{$reaction->variable->name}}</a>
                                        </td>
                                        <td>
                                                    <span class="badge bg-success">
                                                        {{$operations[$reaction->operation]}} {{$reaction->value}}
                                                    </span>
                                        </td>
                                        <td>{{$reaction->created_at}}</td>
                                        <td>@include('admin.reactions.actions')</td>
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
