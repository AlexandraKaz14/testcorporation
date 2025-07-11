@extends('layouts.app')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('common.instruction  create test')}}</h1>
            </div>
            <div class="col-sm-6 ">
                                {{Breadcrumbs::render('instruction')}}
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
                            <h3 class="card-title">Шаг 1. Создание теста</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-light">
                                <p class="justified-text"> В <strong> «Корпорации тестов» </strong> вы можете создавать разнообразные тесты: от классических викторин до персонализированных тестов, которые помогут определить к какой группе, типу или категории относится пользователь.</p>
                            </div>

                            <div class="instruction-step">
                                <div class="step-content text-center alert alert-light">
                                    <p> Перейдите в раздел <i class="fa fa-graduation-cap mr-1"></i><strong>Тесты</strong>.<br>
                                        В блоке  <i class="fa fa-list mr-1"></i><strong>Список тестов</strong> нажмите кнопку   <button class="btn btn-sm btn-success mt-2">
                                            <i class="fas fa-plus mr-2"></i>Добавить тест</button>
                                    </p>
                                </div>
                            </div>

                            <div class="instruction-step">
                                <div class="step-content ">
                                    <picture>
                                        <source srcset="/images/1_create_test.webp" media="(max-width: 768px)">
                                        <img src="/images/1.webp" class="img-fluid rounded border mb-3 mt-3" alt="Раздел тестов" loading="lazy">
                                    </picture>
                                    <picture class="mobile-only">
                                        <source srcset="/images/2_add_test.webp" media="(max-width: 768px)">
                                        <img src="/images/2_add_test.webp" class="img-fluid rounded border mb-3 mt-3" alt="Добавить тест" loading="lazy">
                                    </picture>
                                </div>
                            </div>

                            <div class="instruction-step">
                                <div class="step-content">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul class="feature-list">
                                                <li  class="justified-text">
                                                    <strong> Заголовок</strong> — Напишите название теста.
                                                </li>
                                                <li class="justified-text">
                                                    <strong> Slug для URL</strong> — Можно сгенерировать автоматически.
                                                    После ввода заголовка теста нажмите <strong>"Создать
                                                        slug"</strong>. Также можно ввести вручную,
                                                    придерживаясь правил, указанных в памятке.
                                                </li>
                                                <li>
                                                    <strong>Описание</strong> — Цели и назначение теста.
                                                </li>
                                                <li>
                                                    <strong>Обложка</strong> — Визуальное оформление.
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-6">
                                            <ul class="feature-list">
                                                <li class="justified-text"> <strong>Категории</strong> — Выберите одну или несколько
                                                    категорий, к которым относится тест.
                                                </li>
                                                <li class="justified-text"> <strong>Теги</strong> — Добавьте ключевые слова для лучшего поиска. Можно выбрать из предложенного списка, если
                                                    теги подходят, или написать свои (до 10 тегов).
                                                </li>
                                                <li class="justified-text"> <strong>Тема оформления</strong> — Выберите из списка тему для визуального оформления теста. Можно не выбирать,
                                                    применится стандартная тема.
                                                </li>
                                                <li class="justified-text"> <strong>Фоновое изображение</strong> — Для визуального оформления можно добавить свое изображение. Если не выбрано,
                                                    будет применен стандартный фон.
                                                </li>

                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="instruction-step mt-3">
                                <div class="step-content">
                                    <div class="alert alert-light text-center">
                                        <p> Заполните все необходимые поля и нажмите <button class="btn btn-success btn-sm">Сохранить</button></p>
                                    </div>
                                    <picture>
                                        <source srcset="/images/3_form_test.webp" media="(max-width: 768px)">
                                        <img src="/images/2.webp" class="img-fluid rounded border mb-3 mt-3" alt="Раздел тестов" loading="lazy">
                                    </picture>

                                    <div class="example-block mt-3">
                                        <h5 class="text-primary"><i class="fas fa-magic mr-2"></i> Пример:</h5>
                                        <p class="justified-text">Для наглядности создадим тест, который поможет определить, к какой группе относится пользователь на основе его ответов. Например, <strong>"Какой факультет Хогвартса вам подходит?"</strong> <br>
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Шаг 2. Создание вопросов</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="instruction-step">
                                <div class="step-content text-center alert alert-light">
                                    <p>В карточке теста в блоке <i class="fa fa-question ml-1"></i><strong>Список вопросов</strong> нажмите <button class="btn btn-sm btn-success"> <i class="fas fa-plus mr-2"></i>Добавить вопрос</button>
                                    </p>
                                </div>
                                <picture>
                                    <source srcset="/images/4_add_question.webp" media="(max-width: 768px)">
                                    <img src="/images/3.webp" class="img-fluid rounded border mb-3 mt-3" alt="Добавить вопрос" loading="lazy">
                                </picture>
                            </div>

                            <div class="instruction-step">
                                <div class="step-content text-center alert alert-light">
                                    <p>Заполните форму <i class="fas fa-edit"></i><strong>Создание вопроса</strong> и нажмите <button class="btn btn-success btn-sm">Сохранить</button> </p>
                                </div>
                                <div class="step-content">
                                    <div class="field-item">
                                        <ul class="feature-list">
                                            <li class="justified-text"><strong>Текс вопроса</strong> — Формулировка вопроса.
                                            </li>
                                            <li class="justified-text"><strong>Фоновое изображение</strong> — Визуальное отображение вопроса (опционально).
                                                Добавьте изображение,
                                                если это поможет лучше раскрыть суть вопроса. Например, вы можете задать
                                                вопрос "Что изображено на фото?" или использовать картинку как
                                                дополнительный контекст для понимания.
                                            </li>
                                            <li class="justified-text"><strong>Формат ответа</strong> — По умолчанию у вопроса можно выбрать
                                                только один ответ из предложенных вариантов ответов.
                                            </li>
                                        </ul>
                                    </div>

                                    <picture>
                                        <source srcset="/images/5_form_question.webp" media="(max-width: 768px)">
                                        <img src="/images/4.webp" class="img-fluid rounded border mb-3 mt-3" alt="Форма вопроса" loading="lazy">
                                    </picture>
                                    <div class="example-block mt-4">
                                        <h5 class="text-primary"><i class="fas fa-magic mr-2"></i> Продолжаем пример:</h5>
                                        <p class="justified-text">Для теста <strong>"Какой факультет Хогвартса вам подходит?" </strong> создаем необходимые вопросы, добавляем картинки для наглядности, получаем список наших вопросов:</p>
                                        <br>
                                        <ul>
                                            <li>Какой ваш главный жизненный принцип?</li>
                                            <li>Как вы ведете себя в трудной ситуации?</li>
                                            <li>Какая магическая дисциплина вам ближе?</li>
                                            <li>Какое животное вам нравится больше?</li>
                                            <li>Как вы готовитесь к экзаменам?</li>
                                        </ul>
                                        <p>Наши созданные вопросы в таблице:</p>
                                        <picture>
                                            <source srcset="/images/5.1_list_questions.webp" media="(max-width: 768px)">
                                            <img src="/images/5.webp" class="img-fluid rounded border mb-3 mt-3" alt="Пример созданных вопросов" loading="lazy">
                                        </picture>
                                    </div>
                                </div>

                                </div>
                            </div>
                        </div>
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Шаг 3. Создание переменных</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="alert alert-light">
                                <p class="justified-text"> Переменные используются для динамического подсчёта результатов теста.
                                    Они помогают анализировать ответы пользователя и определять, какой итог
                                    больше всего подходит.</p>
                            </div>
                            <div class="instruction-step">
                                <div class="step-content text-center alert alert-light">
                                    <p>В карточке теста найдите блок <i class="fa fa-list ml-1"></i><strong>Список переменных</strong> нажмите <button class="btn btn-sm btn-success"> <i class="fas fa-plus mr-2"></i>Добавить переменную</button>
                                    </p>
                                </div>

                                <picture>
                                    <source srcset="/images/6_add_variable.webp" media="(max-width: 768px)">
                                    <img src="/images/6.webp" class="img-fluid rounded border mb-3 mt-3" alt="Добавление переменных" loading="lazy">
                                </picture>

                            </div>

                            <div class="instruction-step">
                                <div class="step-content text-center alert alert-light">
                                    <p>Заполните форму <i class="fas fa-edit"></i><strong>Создание переменной</strong> и нажмите <button class="btn btn-success btn-sm">Сохранить</button> </p>
                                </div>
                                <div class="step-content">
                                    <div class="field-item">
                                        <ul class="feature-list">
                                            <li class="justified-text"><strong>Имя</strong> — Введите имя переменной.</li>
                                            <li class="justified-text"><strong>Стартовое значение</strong> — Задайте любое значение от которого будет
                                                изменяться значение переменной, обычно можно задать 0.
                                            </li>
                                        </ul>
                                    </div>

                                    <picture>
                                        <source srcset="/images/7_form_variable.webp" media="(max-width: 768px)">
                                        <img src="/images/7.webp" class="img-fluid rounded border mb-3 mt-3" alt="Добавление переменных" loading="lazy">
                                    </picture>

                                    <div class="example-block mt-4">
                                        <h5 class="text-primary"><i class="fas fa-magic"></i> Продолжаем пример:</h5>
                                        <p class="justified-text">Так как мы хотим определить к какому факультету относится пользователь, значит мы можем назвать переменные в соответствии с названием факультетов, и стартовым значением 0, это точка отсчета баллов. Создаем переменные с начальным значением 0:</p>
                                        <ul>
                                            <li>гриффиндор</li>
                                            <li>когтевран</li>
                                            <li>пуффендуй</li>
                                            <li>слизерин</li>
                                        </ul>

                                        <p>Наши созданные переменные в таблице:</p>
                                        <picture>
                                            <source srcset="/images/8_list_variables.webp" media="(max-width: 768px)">
                                            <img src="/images/8.webp" class="img-fluid rounded border mb-3 mt-3" alt="Список переменных" loading="lazy">
                                        </picture>
                                        <br>
                                    </div>
                                </div>
                            </div>
                            <div class="alternative-example mt-4">
                                <h5 class="text-primary"><i class="fas fa-lightbulb"></i> Второй пример создания переменной</h5>
                                <p class="justified-text">Рассмотрим пример создания переменных, когда не нужно распределять ответы по группам, классическая викторина <strong> "Как хорошо вы знаете Вселенную Гарри Поттера". </strong></p>
                                <p class="justified-text">
                                    В таком варианте теста подразумеваются правильные ответы, по которым
                                    считается результат. Значит можно назвать переменную "правильный ответ"
                                    или любое другое название и задать стартовое значение, от которого будут считаться баллы.</p>
                                <ul>Переменная:
                                    <li>правильный_ответ</li>
                                </ul>
                                <p class="justified-text">Переменная автоматически преобразуется:
                                все заглавные буквы становятся строчными, а пробелы между словами заменяются на знак подчеркивания.<br>
                                <p>Например: "Моя переменная" → "моя_переменная".</p>
                            </div>
                        </div>
                    </div>
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Шаг 4. Создание ответов</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-light">
                                <p class="justified-text">Создайте несколько вариантов ответов на вопрос. Ответы могут быть в текстовом формате, с выбором изображений или комбинированными (текст + изображение).</p>
                            </div>

                            <div class="instruction-step">
                                <div class="step-content text-center alert alert-light">
                                    <p>В блоке <i class="fa fa-question mr-1"></i><strong>Список вопросов</strong>, перейдите в карточку созданного вопроса.
                                    </p>
                                    <p>В карточке вопроса найдите блок <i class="fa fa-list mr-1"></i><strong>Список ответов</strong> нажмите <button class="btn btn-sm btn-success"> <i class="fas fa-plus mr-2"></i>Добавить ответ</button>
                                    </p>
                                </div>

                                <picture>
                                    <source srcset="/images/9_add_answer.webp" media="(max-width: 768px)">
                                    <img src="/images/9.webp" class="img-fluid rounded border mb-3 mt-3" alt="Добавление ответа" loading="lazy">
                                </picture>
                            </div>

                            <div class="instruction-step">
                                <div class="step-content text-center alert alert-light">
                                    <p>Заполните форму <i class="fas fa-edit"></i><strong>Создание ответа</strong> и нажмите <button class="btn btn-success btn-sm">Сохранить</button> </p>
                                </div>
                                <div class="step-content">
                                    <div class="field-item">
                                        <ul class="feature-list">
                                            <li><strong>Текст ответа</strong> — Введите текст ответа</li>
                                            <li><strong>Изображение</strong> — В качестве ответа можно использовать изображение.
                                            </li>
                                        </ul>
                                    </div>

                                    <picture>
                                        <source srcset="/images/10_form_answer.webp" media="(max-width: 768px)">
                                        <img src="/images/9_1.webp" class="img-fluid rounded border mb-3 mt-3" alt="Добавление ответа" loading="lazy">
                                    </picture>
                                    <div class="example-block mt-4">
                                        <h5 class="text-primary"><i class="fas fa-magic"></i> Продолжаем пример:</h5>
                                        <p>На каждый созданный вопрос добавим по 4 варианта ответов:</p>
                                        <ul>Какой ваш главный жизненный принцип?
                                            <li>Отвага и честь</li>
                                            <li>Знания и мудрость</li>
                                            <li>Амбиции и целеустремленность</li>
                                            <li>Доброта и честность</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>







                    </div>
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Шаг 5. Создание реакций </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-light">
                                <p class="justified-text">Реакции определяют, как выбранные ответы изменяют значения переменных. Они связывают ответы с переменными и определяют логику теста.</p>
                            </div>

                            <div class="instruction-step">
                                <div class="step-content text-center alert alert-light">
                                    <p>Перейдите в созданный ответ, в блоке <i class="fa fa-list mr-1"></i><strong>Список реакции</strong> нажмите <button class="btn btn-sm btn-success"> <i class="fas fa-plus mr-2"></i>Добавить реакцию</button>
                                    </p>
                                </div>

                                <picture>
                                    <source srcset="/images/11_add_reaction.webp" media="(max-width: 768px)">
                                    <img src="/images/10.webp" class="img-fluid rounded border mb-3 mt-3" alt="Добавление реакции" loading="lazy">
                                </picture>
                            </div>

                            <div class="instruction-step">
                                <div class="step-content text-center alert alert-light">
                                    <p>Заполните форму <i class="fas fa-edit"></i><strong>Создание реакции</strong> и нажмите <button class="btn btn-success btn-sm">Сохранить</button> </p>
                                </div>
                                <div class="step-content">
                                    <div class="field-item">
                                        <ul class="feature-list">
                                            <li class="justified-text"><strong>Переменные</strong> — Выберете из списка необходимую переменную.
                                            </li>
                                            <li class="justified-text"><strong>Действие</strong> — Выберете необходимое действие которое будет изменять переменную.
                                            </li>
                                            <li class="justified-text"><strong>Значение</strong> — Укажите значение на сколько изменится переменная.
                                            </li>
                                        </ul>
                                    </div>
                                    <picture>
                                        <source srcset="/images/11_form_reaction.webp" media="(max-width: 768px)">
                                        <img src="/images/11.webp" class="img-fluid rounded border mb-3 mt-3" alt="Добавление реакции" loading="lazy">
                                    </picture>
                                </div>
                                <div class="example-block mt-4">
                                    <h5 class="text-primary"><i class="fas fa-magic"></i>Пример реакций для нашего теста:</h5>
                                    <p class="justified-text">Рассмотрим как добавлять реакции на нашем примере теста <strong>"Какой факультет Хогвартса вам подходит?"</strong></p>
                                    <p class="justified-text"> Мы создали переменные: гриффиндор, слизерин, когтевран и пуффендуй. Начальное значение переменных задали 0.</p><br>
                                    <p class="justified-text">Наш первый вопрос "Какой ваш главный жизненный принцип?" и ответы:</p>
                                    <ul>
                                        <li>Отвага и честь</li>
                                        <li>Знания и мудрость</li>
                                        <li>Амбиции и целеустремленность</li>
                                        <li>Доброта и честность</li>
                                    </ul>
                                    На каждый ответ добавим реакцию: <br>
                                    "Отвага и честь" → гриффиндор +1 <br>
                                    "Амбиции и целеустремленность" → слизерин +1 <br>
                                    "Знания и мудрость" → когтевран +1 <br>
                                    "Доброта и верность" → пуффендуй +1 <br>
                                    <br>
                                    <p>Добавили реакции на каждый ответ и получили в таблице:</p>
                                    <picture>
                                        <source srcset="/images/12_list_answer_reacrions.webp" media="(max-width: 768px)">
                                        <img src="/images/12.webp" class="img-fluid rounded border mb-3 mt-3" alt="Реакции на ответы" loading="lazy">
                                    </picture>
                                    <div class="alert alert-light justified-text">
                                        <strong>Таким образом, на каждый ответ нужно добавить реакцию, которая будет изменять переменную!
                                            Действие и значение, которое вы укажете, зависит только от вашей логики теста!</strong>
                                    </div>
                                </div>

                                <div class="alternative-example mt-4">
                                    <h5 class="text-primary"><i class="fas fa-lightbulb"></i> Добавление реакции для классической викторины</h5>
                                    <p class="justified-text">Рассмотрим добавление реакции на ответы для теста <strong>"Как хорошо вы знаете
                                            Вселенную Гарри Поттера?"</strong>
                                     </p>
                                    <br>
                                       <p class="justified-text">     Создали переменную: "правильный_ответ" с начальным значением 0.<br>
                                           Создали такое вопрос "Кто написал серию романов о Гарри Поттере?
                                           "<br>
                                           И создали такие ответы: Терри Пратчетт, Дж.Р.Р. Толкин, Дж.К. Роулинг , Нил Гейман.
                                           <br>
                                           В таком случае из четырех вариантов ответов есть один правильный ответ.
                                           На правильный ответ добавляем реакцию: <br>
                                           "Дж.К. Роулинг" → правильный_ответ +1 <br></p>
                                </div>
                        </div>

                    </div>

                </div>

                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Шаг 6. Создание результатов теста</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="instruction-step">
                                <div class="step-content text-center alert alert-light">
                                    <p>Откройте созданный тест. В блоке  <i class="fa fa-list mr-1"></i><strong>Результаты</strong> нажмите <button class="btn btn-sm btn-success"> <i class="fas fa-plus mr-2"></i>Добавить результат</button>
                                    </p>
                                </div>

                                <picture>
                                    <source srcset="/images/13_add_result.webp" media="(max-width: 768px)">
                                    <img src="/images/13.webp" class="img-fluid rounded border mb-3 mt-3" alt="Добавление результата" loading="lazy">
                                </picture>
                            </div>

                            <div class="step-content text-center alert alert-light">
                                <p>Заполните форму <i class="fas fa-edit"></i><strong>Создание результата</strong> и нажмите <button class="btn btn-success btn-sm">Сохранить</button> </p>
                            </div>

                            <div class="step-content">
                                <div class="field-item">
                                    <ul class="feature-list">
                                        <li class="justified-text"><strong>Условное выражение</strong> — Используйте переменные и логические операторы. В примере ниже подробно описано как составлять условное выражение.
                                        </li>
                                        <li class="justified-text"><strong>Текст результата</strong> — Текст результата, который увидит пользователь.
                                        </li>
                                        <li class="justified-text"><strong>Изображение</strong> — Визуализация результата (необязательно).
                                        </li>
                                    </ul>
                                </div>


                            <!-- Что такое условное выражение -->
                            <div class="alert alert-default-success mb-4">
                                <h5 class="alert-heading text-center">Что такое условное выражение?</h5>
                                <p class="mb-0 justified-text"><strong>Условное выражение</strong> — это правило, которое определяет, при каких условиях будет показан этот результат теста. Используйте созданные вами переменные и логические операторы (Подробно описано ниже в примере).</p>
                            </div>

                                <picture>
                                    <source srcset="/images/14_form_result.webp" media="(max-width: 768px)">
                                    <img src="/images/14.webp" class="img-fluid rounded border mb-3 mt-3" alt="Форма создания результата" loading="lazy">
                                </picture>

                            <!-- Пример 1: Факультеты Хогвартса -->
                            <div class="example-card mb-4 p-3 border rounded bg-light">
                                <h5 class="text-primary mb-3"><i class="fas fa-magic mr-2"></i>Пример 1: Тест "Какой факультет Хогвартса вам подходит?"</h5>

                                <div class="mb-3">
                                    <h5>Как работает подсчёт баллов:</h5>
                                    <p>Каждый ответ добавляет баллы к одному из факультетов:</p>
                                    <ul>
                                        <li>гриффиндор</li>
                                        <li>слизерин</li>
                                        <li>когтевран</li>
                                        <li>пуффендуй</li>
                                    </ul>
                                </div>

                                <div class="mb-3">
                                    <h5 class="justified-text"> Создаем условные выражения, где одна из переменных будет преобладать по значениям. Варианты условий:</h5><br>
                                    <div class="code-block mb-3 p-3 bg-dark text-white rounded">
                                        <strong>гриффиндор > слизерин && гриффиндор > когтевран && гриффиндор > пуффендуй</strong><br>
                                        <p class="mb-0 justified-text">👉 Если Гриффиндор набрал больше баллов, чем все остальные факультеты</p>
                                    </div>

                                    <div class="code-block mb-3 p-3 bg-dark text-white rounded">
                                        <strong>слизерин > гриффиндор && слизерин > когтевран && слизерин > пуффендуй</strong><br>
                                        <p class="mb-0 justified-text">👉 Если Слизерин набрал больше баллов, чем все остальные факультеты</p>
                                    </div>

                                    <p class="text-info"><i class="fas fa-info-circle"></i> Аналогичные условия создаются для Когтеврана и Пуффендуя</p>
                                </div>

                                <div class="mb-3">
                                    <h5>Разбор условия:</h5>
                                    <p class="justified-text"><strong>Что означает &&?</strong> — это логический оператор "И" (AND). Все части условия должны быть верны одновременно.</p>

                                    <div class="alert alert-secondary">
                                        <strong>Пример с числами:</strong><br>
                                        гриффиндор = 3, слизерин = 1, когтевран = 2, пуффендуй = 1<br><br>

                                        Проверяем условие:<br>
                                        <strong>гриффиндор > слизерин && гриффиндор > когтевран && гриффиндор > пуффендуй</strong><br><br>

                                        ✔ 3 > 1 (верно)<br>
                                        ✔ 3 > 2 (верно)<br>
                                        ✔ 3 > 1 (верно)<br><br>

                                        <strong>Результат:</strong> условие выполняется, показываем "Гриффиндор"
                                    </div>
                                </div>

                                <div class="alert alert-warning">
                                    <h5><i class="fas fa-exclamation-triangle"></i> Важные нюансы:</h5>
                                    <p class="justified-text">  Когда условие не выполнится? <br></p>

                                    Если баллы равны (например, гриффиндор = 4, слизерин = 4, когтевран = 2, пуффендуй = 1), условие не сработает!
                                    <br>
                                    Проверяем:<br>
                                    гриффиндор > слизерин (4 > 4) ❌ (Неправда, они равны!)<br>
                                    <p class="justified-text">   Остальные части могут быть верны, но из-за одной ошибки условие не
                                        выполнится.</p><br>
                                    <strong> Вывод:</strong><br>
                                    <p class="justified-text">  Оператор && заставляет проверять все условия одновременно.
                                    Чтобы условие выполнилось, Гриффиндор действительно должен быть первым
                                    по баллам.<br>
                                    В таком случае, необходимо чтобы каждая комбинация ответов
                                        соответствовала одному из условий.<br></p>
                                    <strong>Для таких случаев используйте оператор >= ("больше или равно")</strong><br>
                                    Условное выражение:<br>
                                    <p class="justified-text"> гриффиндор >= слизерин && гриффиндор > когтевран && гриффиндор > пуффендуй
                                    и (как пример) прописать текст результата: "Вам подходит Гриффиндор и
                                        Слизерин".</p><br>
                                    <p class="justified-text"> Означает: "Если Гриффиндор набрал больше баллов и равное Слизерину, но
                                    все остальные меньше, то этот результат подходит."<br>
                                    Важно продумать все возможные ситуации!<br>
                                        <strong> Обязательно настройте "Результат по умолчанию" на случай, если ни одно условие не выполнилось</strong><br></p>
                                    <p class="justified-text">  Означает: "Если ни одно другое условие не подошло, покажем этот результат".<br>
                                    Необходимо перейти в результат по умолчанию и нажать на кнопку
                                    "редактировать" и изменить результат под свои цели: в нашем случае в
                                    тексте можем написать:<br>
                                    Распределяющая шляпа не смогла определить какой
                                    факультет тебе подойдет больше всего, поэтому ты можешь учиться в том
                                    факультете, который ты выберешь! <br>
                                        И по желанию добавить картинку<br></p>
                                </div>
                            </div>

                            <!-- Пример 2: Викторина -->
                            <div class="example-card mb-4 p-3 border rounded bg-light">
                                <h5 class="text-primary mb-3"><i class="fas fa-lightbulb mr-2"></i>Пример 2: Тест-викторина "Как хорошо вы знаете Вселенную Гарри Поттера"</h5>

                                <p>Создана переменная "правильный_ответ" с начальным значением 0. За каждый правильный ответ добавляется +1.</p>
                                <p>Допустим у нас 10 вопросов и можно набрать максимально 10 баллов.</p>

                                <div class="mb-3">
                                    <h5>Рекомендуемые условия:</h5>

                                    <div class="code-block mb-3 p-3 bg-dark text-white rounded">
                                        <strong>правильный_ответ > 8</strong>
                                        <p class="mb-0 "> Если количество баллов больше 8</p>
                                        <p class="mb-0 ">👉 "Отлично! Вы знаете Вселенную Гарри Поттера на 100%!"</p>
                                    </div>

                                    <div class="code-block mb-3 p-3 bg-dark text-white rounded">
                                        <strong>правильный_ответ >= 5 && правильный_ответ <= 8</strong>
                                        <p class="mb-0 "> Если количество баллов находится в диапазоне от 5 до 8, включая 5 и 8. </p>
                                        <p class="mb-0 ">👉 "Хороший результат, но есть над чем поработать."</p>
                                    </div>

                                    <div class="code-block mb-3 p-3 bg-dark text-white rounded">
                                        <strong>правильный_ответ < 5</strong>
                                        <p class="mb-0 "> Если количество баллов меньше 5.</p>
                                        <p class="mb-0 ">👉 "Вы плохо знакомы с этой Вселенной. Попробуйте ещё раз!"</p>
                                    </div>
                                </div>

                                <div class="alert alert-danger">
                                    <h5><i class="fas fa-exclamation-circle"></i> Важно!</h5>

                                    <p class="justified-text">Обратите внимание: если в ваших выражениях условия перекрываются (например, >= 5 и >= 8), <br> размещайте результаты в порядке убывания — от самых строгих условий к более общим. Иначе может сработать не тот результат, который вы ожидаете.</p>
                                    <br>
                                </div>
                            </div>

                                <p class="justified-text">Результат по умолчанию необходимо отредактировать, добавить текст/изображение, которое отобразится в случае, если ни одно из условии не сработает. </p>
                                <picture>
                                    <source srcset="/images/15_edit_result.webp" media="(max-width: 768px)">
                                    <img src="/images/15.webp" class="img-fluid rounded border mb-3 mt-3" alt="Результат постоянный" loading="lazy">
                                </picture>
                    </div>
                            <div class="step-content text-center alert alert-light">
                                <p>
                                    Откройте тест в режиме предпросмотра. Для этого перейдите в созданный тест и нажмите
                                    <button class="btn btn-sm btn-info">Предпросмотр теста</button>.
                                </p>

                                <p>
                                    Пройдите тест несколько раз с разными вариантами ответов, чтобы проверить все возможные результаты.
                                    При необходимости внесите исправления, затем отправьте тест на модерацию, нажав
                                    <button class="btn btn-sm btn-success">Отправить на модерацию</button>.
                                </p>

                                <p>
                                    После отправки на модерацию редактирование теста станет недоступным. Если необходимо внести изменения, верните тест в статус "Черновик".</p>
                                  <p>Нажмите на кнопку
                                    <button class="btn btn-sm btn-info">В черновик</button>.
                                    После редактирования снова отправьте тест на модерацию.
                                </p>
                            </div>



                        </div>
                </div>
            </div>
        </div>
            <div class="card-footer text-muted">
                <small>Последнее обновление: 25.03.2025 | Версия 1.0</small>
            </div>
        </div>
    </section>
@endsection


