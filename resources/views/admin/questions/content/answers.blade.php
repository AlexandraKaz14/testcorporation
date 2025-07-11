<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                    <h3 class="card-title mb-2"><i class="fa fa-list mr-1"></i> {{__('common.list answers')}}</h3>
                    <div class="card-tools w-100 w-md-auto">
                        <div class="row g-2">
                            <div class="col-12 d-flex flex-column flex-md-row justify-content-md-end gap-2">
                                @if($question->test->isDraft())
                        <a href="{{route("{$currentUserRole}.tests.questions.answers.create",  ['question_id'=>$question])}}"
                           class="btn btn-success mb-2 mr-lg-2 mr-md-2">
                            <i class="fas fa-plus mr-2"></i>{{__('common.add answer')}}
                        </a>
                                    @if($answersDeleted)
                                        <a href="{{ route("{$currentUserRole}.tests.questions.show", ['question' => $question->id]) }}"
                                           class="btn btn-primary mb-2 mr-lg-2 mr-md-2">
                                            {{__('common.show active')}}
                                        </a>
                                    @else
                                        <a href="{{ route("{$currentUserRole}.tests.questions.show", ['question' => $question->id, 'deleted_answers' => true]) }}"
                                           class="btn btn-warning mb-2 mr-lg-2 mr-md-2 " id="show-deleted-answers">
                                            {{__('common.show deleted')}}
                                        </a>
                                    @endif


                                @elseif($question->test->isActive() || $question->test->isModeration() && $question->test->user->isAuthor())
                                    <a class="btn btn-success disabled mb-2 mr-lg-2 mr-md-2" aria-disabled="true" role="button"
                                       data-bs-toggle="tooltip" data-bs-placement="top"
                                       title="{{ __('common.test published, cant add') }}"
                                       style="opacity: 0.65;">
                                        <i class="fas fa-plus mr-2"></i> {{ __('common.add answer') }}
                                    </a>

                                @endif



                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body table-responsive p-0">

                @if($answers->isEmpty())
                    <p class="text-center">{{__('common.no answers')}}</p>
                @else
                    <table id='myTable' class="table table-head-fixed text-nowrap">
                        <thead>
                        <tr>
                            <th>{{__('common.№ answer')}}</th>
                            <th>{{__('common.text answer')}}</th>
                            <th>{{__('common.picture')}}</th>
                            <th class="text-center">{{__('common.reactions')}}</th>
                            <th>{{__('common.created_at')}}</th>
                            <th class="fixed-right">{{__('common.actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($number=1)
                        @foreach ($answers as $answer)
                            <tr data-id="{{$answer->id}}">
                                <td class="index">{{ $number++ }}</td>
                                <td>
                                    @if($answersDeleted)
                                        {{mb_strlen($answer->text) > 23 ?
                                            mb_substr($answer->text, 0, 20) . '...' :
                                            $answer->text}}
                                    @else
                                        @if($answer->text)
                                            <a href="{{route("{$currentUserRole}.tests.questions.answers.show", $answer)}}">
                                                {{mb_strlen($answer->text) > 23 ?
                                                mb_substr($answer->text, 0, 20) . '...' :
                                                $answer->text}}</a>
                                        @else
                                            <a href="{{route("{$currentUserRole}.tests.questions.answers.show", $answer)}}">
                                                <p>---</p></a>
                                        @endif
                                    @endif
                                </td>

                                <td>
                                    @if($answer->picture)
                                        <img alt="Avatar" class="rounded-circle"
                                             src="{{ Storage::url($answer->picture)}}" height="50"
                                             width="50">
                                    @else
                                        <p>Отсутствует</p>
                                    @endif
                                </td>
                                <td>
                                    @foreach($answer->reactions as $reaction)
                                        <a class="btn btn-app bg-secondary variable">
                                                             <span class="badge bg-success">
                                                        {{$operations[$reaction->operation]}} {{$reaction->value}}
                                                    </span>
                                            {{$reaction->variable->name}}
                                        </a>
                                    @endforeach
                                </td>
                                <td>{{$answer->created_at}}</td>
                                <td>@include('admin.answers.actions')</td>
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
