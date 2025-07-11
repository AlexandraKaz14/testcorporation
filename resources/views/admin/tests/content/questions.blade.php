<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary">

                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                    <h3 class="card-title mb-2">
                        <i class="fa fa-question mr-1"></i> {{ __('common.list questions') }}
                    </h3>

                    <div class="card-tools w-100 w-md-auto">
                        <div class="row g-2">
                            <div class="col-12 d-flex flex-column flex-md-row justify-content-md-end gap-2">
                                @if($test->isDraft())
                                    <a href="{{ route("{$currentUserRole}.tests.questions.create",  ['test_id'=>$test]) }}"
                                       class="btn btn-success mb-2 mr-lg-2 mr-md-2">
                                        <i class="fas fa-plus mr-2"></i>{{ __('common.add question') }}
                                    </a>

                                    @if($questionsDeleted)
                                        <a href="{{ route("{$currentUserRole}.tests.show", ['test' => $test->id]) }}"
                                           class="btn btn-primary mb-2">
                                            {{ __('common.show active') }}
                                        </a>
                                    @else
                                        <a href="{{ route("{$currentUserRole}.tests.show", ['test' => $test->id, 'deleted_questions' => true]) }}"
                                           class="btn btn-warning mb-2" id="show-deleted-questions">
                                            {{ __('common.show deleted') }}
                                        </a>
                                    @endif

                                @elseif($test->isActive() || $test->isModeration() )
                                    <a class="btn btn-success disabled mb-2 mr-lg-2 mr-md-2" aria-disabled="true" role="button"
                                       data-bs-toggle="tooltip" data-bs-placement="top"
                                       title="{{ __('common.test published, cant add') }}"
                                       style="opacity: 0.65;">
                                        <i class="fas fa-plus mr-2"></i> {{ __('common.add question') }}
                                    </a>
                                @endif



                            </div>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-body table-responsive p-0">

                        @if($questions->isEmpty())
                            <p class="text-center"> {{__('common.There are no questions')}}</p>
                        @else
                            <table id='myTable' class="table table-head-fixed text-nowrap">
                                <thead>
                                <tr>
                                    <th>{{__('common.№ question')}}</th>
                                    <th>{{__('common.question text')}}</th>
                                    <th>{{__('common.picture')}}</th>
                                    <th class="hide-mobile">{{__('common.form answer')}}</th>
                                    <th>{{__('common.created_at')}}</th>
                                    <th class="fixed-right">{{__('common.actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($number=1)
                                @foreach ($questions as $question)
                                    <tr data-id="{{$question->id}}">
                                        <td class="index">{{ $number++ }}</td>
                                        <td>
                                            @if($questionsDeleted)
                                                {{mb_strlen($question->text) > 23 ?
                                                    mb_substr($question->text, 0, 20) . '...' :
                                                    $question->text}}
                                            @else
                                                @if($question->text)
                                                    <a href="{{route("{$currentUserRole}.tests.questions.show", $question)}}">
                                                        {{mb_strlen($question->text) > 23 ?
                                                        mb_substr($question->text, 0, 20) . '...' :
                                                        $question->text}}</a>
                                                @else
                                                    <a href="{{route("{$currentUserRole}.tests.questions.show", $question)}}">
                                                        <p>---</p></a>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if($question->picture)
                                                <img alt="Avatar" class="rounded-circle"
                                                     src="{{ Storage::url($question->picture)}}" height="50"
                                                     width="50">
                                            @else
                                                <p>{{__('common.absent')}}</p>
                                            @endif
                                        </td>
                                        <td class="hide-mobile">{{ __("common.{$question->type }") }}</td>
                                        <td>{{ $question->created_at }}</td>
                                        <td>

                                            @include('admin.questions.actions')

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

