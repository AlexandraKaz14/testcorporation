@extends('layouts.app')
@section('content_header')

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('common.result')}}</h1>
            </div>
            <div class="col-sm-6 ">
                {{Breadcrumbs::render("{$currentUserRole}.tests.results.create", $result->test)}}
            </div>
        </div>
    </div>
@stop
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-outline card-primary">

                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-edit"></i> {{__('common.create result')}}</h3>
                        </div>

                        <div class="card-body">

                            <div class="card-body">
                                <div id="accordion">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h4 class="card-title w-100">
                                                <a class="d-block w-100" data-toggle="collapse" href="#collapseThree">
                                                    Правила написания условного выражения
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapseThree" class="collapse" data-parent="#accordion">
                                            <div class="card-body">
                                                <p class="text-primary">Подробное объяснение как создавать результат написано в Инструкции по созданию теста.</p>
                                               <p> 1. Формат переменных<br>
                                                Используйте точные названия из системы.
                                                 Если переменная написана так: правильный_ответ, необходимо так же ее и писать (а не "Правильный ответ" или "правильный ответ")</p>

                                                <p> 2. Операторы сравнения<br>
                                                Доступны: <, >, <=, >=, ==, !=<br>
                                                    больше, меньше, меньше или равно, больше или равно, равно, не равно
                                                </p>
                                                <p> 3. Логические операторы<br>
                                                    && или AND — логическое И<br>
                                                    || или OR — логическое ИЛИ
                                                </p>
                                                <p> 4. Пример условного выражения<br>
                                                    Правильное написание условного выражения:<br>
                                                    переменная_1 > переменная_2 && переменная_1 > переменная_3
                                                </p>
                                                <p> 5. Автоматическое преобразование<br>
                                                    После сохранения система добавит скобки:<br>
                                                    ((переменная_1 > переменная_2) && (переменная_1 > переменная_3))
                                                </p>
                                                <p> 6. Баланс скобок<br>
                                                    При редактировании сохраняйте структуру:<br>
                                                    (((условие1) && (условие2)) && (условие3))
                                                </p>

                                                ⚠️ Важно:
                                               <p> Регистр букв в названиях переменных имеет значение <br>
                                                Между операторами и переменными рекомендуются пробелы. <br>
                                                Для сложных условий используйте предпросмотр теста, пройдите тест с различными результатами, если корректно отрабатываются условия получения результата, отправляйте на модерацию. <p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(!$variables->isEmpty())
                                <div class="card-body">
                                    <div class="callout callout-success">
                                        <h5>{{__('common.variables for the test')}} "{{$result->test->title}}"</h5>
                                        <ul>
                                            @foreach($variables as $variable)
                                                <li>{{$variable->name}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @else
                                <div class="card-body">
                                    <div class="alert alert-warning alert-dismissible">
                                        <h5><i class="icon fas fa-exclamation-triangle"></i> {{__('common.Attention!')}}
                                        </h5>
                                        {{__('common.Variables are required to create the result!')}}

                                        <a href="{{route("{$currentUserRole}.tests.variables.create", ['test_id'=>$result->test->id])}}">
                                            {{__('common.Create variables')}}
                                        </a>
                                    </div>
                                </div>
                            @endif


                            <form id="form-group" action="{{route("{$currentUserRole}.tests.results.store")}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="test_id" value="{{ $result->test->id }}">
                                <input type="hidden" name="is_default" value="false">

                                <div class="card-body">

                                    <div class="form-group">
                                        <label for="exampleInputResult">{{__('common.condition')}}</label>
                                        <textarea type="text" class="form-control" name="condition"
                                                  id="exampleInputResult"
                                                  placeholder="{{__('common.enter a conditional expression')}}">{{old('condition')}}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputResult">{{__('common.text')}}</label>
                                        <textarea type="text" class="form-control" name="text"
                                                  id="exampleInputResult"
                                                  placeholder="{{__('common.enter result text')}}">{{old('text')}}</textarea>
                                    </div>


                                    @include('partial.cropper', [
                                    'inputLabel' => __('common.picture'),
                                    'chooseFileLabel' => __('common.choose file'),
                                    'name' => 'picture',
                                    'finalWidth' => 800,
                                    'finalHeight' => 800,
                                    ])

                                    <input class="btn btn-success" id="button" type="submit"
                                           value="{{__('common.save')}}">
                                    <a href="{{route("{$currentUserRole}.tests.show", $result->test)}}"
                                       class="btn btn-secondary">{{__('common.close')}}</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


@push('js')
    <script>$(document).ready(function () {
            $('.select2').select2();
        });
    </script>

    <script>
        $(document).ready(function () {
            $('.custom-file-input').on('change', function () {
                var fileName = $(this).val().split('\\').pop();
                $(this).siblings('.custom-file-label').addClass('selected').html(fileName);
            });
        });
    </script>

@endpush
