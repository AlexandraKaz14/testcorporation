@extends('layouts.app')

@section('content_header')

    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('common.test')}}</h1>
            </div>
            <div class="col-sm-6 ">
                {{Breadcrumbs::render('admin.tests.create')}}
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
                            <h3 class="card-title"><i class="fas fa-edit"></i> {{__('common.create test')}}</h3>
                        </div>
                        <div class="card-body">
                            <form id="form-group" action="{{route("{$currentUserRole}.tests.store")}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputTitle">{{__('common.title')}}</label>
                                        <input type="text" class="form-control" id="exampleInputTitle" name="title"
                                               value="{{old('title')}}"
                                               placeholder="{{__('common.enter a title no more than 70 characters')}}">
                                    </div>

                                    <div id="accordion">
                                        <div class="card card-primary">
                                            <div class="card-header">
                                                <h4 class="card-title w-100">
                                                    <a class="d-block w-100" data-toggle="collapse"
                                                       href="#collapseThree">
                                                        <i class="fa fa-angle-double-down"
                                                           aria-hidden="true"></i> {{__('common.A tip for creating a URL slug')}}
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseThree" class="collapse" data-parent="#accordion">
                                                <div class="card-body">
                                                    <p>Slug — это уникальная строка идентификатор, понятная человеку,
                                                        которая используется в URL-адресах.
                                                        <br>
                                                    <p>Slug можно автоматически сгенерировать по заголовку теста и не
                                                        вводить его вручную. Для этого введите заголовок теста и нажмите
                                                        "Создать slug".</p>
                                                    <p> Например, вы создаете
                                                        тест и его заголовок "Мой первый тест".</p>
                                                    <p> В поле "Slug для URL" вы можете написать транслитом
                                                        "moy-pervyy-test" или написать на
                                                        английском языке "my-first-test". Можно
                                                        сократить строку, но чтобы она передавала смысл
                                                        "first-test".
                                                        <br> Чтобы slug был корректным и
                                                        удобным соблюдайте правила:</p>
                                                    <ul>
                                                        <li> Используйте только латинские буквы и цифры: a-z, 0-9.
                                                            (например, "тест" → "test")
                                                        </li>
                                                        <li>Слова разделяются дефисами. Пример: my-first-test, а не
                                                            my_first_test или myfirsttest
                                                        </li>
                                                        <li>Без пробелов и специальных символов. Исключите символы:
                                                            !@#$%^&*()_+{}[]|\/:;'"<>,.?
                                                        </li>
                                                        <li>Используйте строчные буквы:
                                                            Не допускайте заглавных букв (Hello-World → hello-world)
                                                        </li>
                                                        <li>Минимальная длина:
                                                            Должен быть достаточно коротким, чтобы быть читаемым, но
                                                            достаточно длинным для понятности.
                                                            Например: my-article вместо ma
                                                        </li>
                                                        <li>Читаемость:
                                                            Старайтесь использовать осмысленные слова, которые описывают
                                                            контент
                                                        </li>
                                                    </ul>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputSlug">{{__('common.slug')}}</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="exampleInputSlug" name="slug"
                                                   value="{{old('slug')}}"
                                                   placeholder="{{__('common.enter slug')}}">
                                            <span class="input-group-append">
                                                <button type="button" id="generate-slug" class="btn btn-success btn-flat">{{__('common.create slug')}}</button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputDescription">
                                            {{__('common.description')}}
                                        </label>
                                        <textarea type="text" class="form-control" name="description"
                                                  id="exampleInputDescription" rows="5"
                                                  placeholder="{{__('common.enter description')}}">{{old('description')}}</textarea>
                                    </div>

                                    @include('partial.cropper', [
                                        'inputLabel' => __('common.cover'),
                                        'chooseFileLabel' => __('common.choose file'),
                                        'name' => 'picture',
                                        'finalWidth' => 800,
                                        'finalHeight' => 800,
                                    ])

                                    <div class="form-group">
                                        <label for="category">{{__('common.categories')}}</label>
                                        <div class="input-group">
                                            <select class=" form-control select2" name="categories[]"
                                                    multiple="multiple">
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ in_array($category->id, old('categories', [])) ? 'selected' : '' }}>
                                                        {{ $category->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="tag">{{__('common.tags') }}</label>
                                        <div class="input-group">
                                            <select class="form-control select2tags" name="tags[]" multiple="multiple"
                                                    id="tags">
                                                @foreach ($tags as $tag)
                                                    <option value="{{$tag->id}}"  {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>{{$tag->name}} </option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>

                                    <div class="form-group ">
                                        <label for="id_label_single">{{__('common.design theme')}}</label>
                                        <select class="select2 form-control" name="theme_id">
                                            @foreach ($themes as $theme)
                                                <option value="{{ $theme->id}}"
                                                    {{$loop->first ? "selected" : ""}}
                                                >{{$theme->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @include('partial.cropper', [
                                               'inputLabel' => __('common.background_image'),
                                               'chooseFileLabel' => __('common.choose file minimum size 1024x1024px'),
                                               'name' => 'background_image',
                                               'finalWidth' => 430*2,
                                               'finalHeight' => 932*2,
                                               'minWidth' => 1024,
                                               'minHeight' => 1024,
                                   ])
                                    <br>
                                    <input class="btn btn-success" id="submitBtn" type="submit"
                                           value="{{__('common.save')}}">
                                    <a href="{{route("{$currentUserRole}.tests.index")}}"
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
    <script>
        $(document).ready(function () {
            $('.select2').select2();
        });

        $(document).ready(function () {
            $('.select2tags').select2({
                tags: true,
                tokenSeparators: [',', ' '],
            });
        });

        function generateSlug(title) {
            const cyrillicToLatinMap = {
                а: 'a', б: 'b', в: 'v', г: 'g', д: 'd', е: 'e', ё: 'yo', ж: 'zh',
                з: 'z', и: 'i', й: 'y', к: 'k', л: 'l', м: 'm', н: 'n', о: 'o',
                п: 'p', р: 'r', с: 's', т: 't', у: 'u', ф: 'f', х: 'h', ц: 'ts',
                ч: 'ch', ш: 'sh', щ: 'sch', ы: 'y', э: 'e', ю: 'yu', я: 'ya',
                ъ: '', ь: ''
            };

            // Транслитерация кириллицы в латиницу
            const transliterate = (str) =>
                str
                    .split('')
                    .map((char) =>
                        cyrillicToLatinMap[char] || cyrillicToLatinMap[char.toLowerCase()] || char
                    )
                    .join('');

            // Основная логика генерации slug
            return transliterate(title)
                .toLowerCase() // Приводим к нижнему регистру
                .trim() // Убираем лишние пробелы
                .replace(/[\s\W-]+/g, '-') // Заменяем пробелы и спецсимволы на дефисы
                .replace(/^-+|-+$/g, ''); // Убираем дефисы в начале и конце
        }

        document.addEventListener('DOMContentLoaded', function () {
            const titleInput = document.getElementById('exampleInputTitle');
            const slugInput = document.getElementById('exampleInputSlug');
            const generateButton = document.getElementById('generate-slug');

            generateButton.addEventListener('click', function () {
                const titleValue = titleInput.value;
                if (titleValue) {
                    const slug = generateSlug(titleValue);
                    slugInput.value = slug;
                } else {
                    alert('Введите заголовок, чтобы создать slug.');
                }
            });
        });
    </script>

@endpush
