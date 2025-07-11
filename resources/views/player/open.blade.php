@extends('layouts.player')

@section('title', $test->title)
@section('description', $test->meta_description)
@section('keywords', $test->meta_keywords)

@section('og_title', $test->title)
@section('og_description', $test->description)
@section('og_image', Storage::url($test->picture))
@section('og_url',url()->current())



@section('content')
    <div class="preloader">
        <div></div>
        <div></div>
    </div>

    <div class="main-content"
         style="{{ $test->background_image ? "background-image: url('" . Storage::url($test->background_image) . "'); background-size:cover;" : '' }}">

        <div class="test-container" style="display: none">

            <div class="w-100 d-flex justify-content-end">
                <div class="btn-back-catalog ">
                    <a href="{{ url()->previous(route('catalog')) }}" style="text-decoration: none; color: inherit;"> <i
                            class="fa-solid fa-xmark fa-2xl"></i></a>
                </div>
            </div>

            <!-- Основное содержимое теста -->
            <div class="test-body text-center">
                @if($test->isDraft() || $test->isModeration())
                    <div class="alert alert-warning" role="alert">
                        Вы находитесь в режиме предпросмотра теста. Тест можно пройти без сохранения результата, для
                        редактирования теста вернитесь в личный кабинет
                        <a href="{{route("{$currentUserRole}.tests.show", $test)}}" class="alert-link">Вернуться в
                            личный кабинет</a>
                    </div>
                @endif

                <input type="hidden" id="test-id" value="{{ $test->id }}">
                <p class="categories" id="test-preview-categories">name</p>
                <div class="row flex-lg-row-reverse align-items-center g-5 py-3">
                    <div class="col-10 col-sm-8 col-lg-6 image-container">
                        <img id="test-preview-picture" src="https://via.placeholder.com/800x350"
                             class="test-image d-block img-fluid" alt="Test Image" loading="lazy">
                    </div>

                    <div class="col-lg-6">
                        <div class="test-title lead">
                            <h4 id="test-preview-title">Test title</h4>
                        </div>
                        <p lang="ru" id="test-preview-description" class="test-description lead"
                           style="text-align: justify; word-break: break-word; hyphens: auto;">This is a description of
                            the test</p>

                        <div class="d-flex justify-content-between align-items-start count-questions">
                            <small id="test-preview-count-questions">count</small>
                        </div>

                    </div>
                    <div class="d-grid  col-lg-4 col-md-6 col-sm-12 mx-auto">
                        <a id="test-preview-start-btn" href="#test-player" class="btn btn-start">Пройти тест</a>
                    </div>
                </div>

                <div class="test-tags-container"><p id="test-preview-tags">name</p></div>
            </div>
            <div class="d-flex justify-content-center align-items-center">
                <div class="test-info">
                    <small id="test-preview-author">Author Name</small>
                </div>
            </div>
        </div>


        <!-- Вариант блока вопросов c  картинкой-->
        <div class="container-fluid question-container" style="display: none">

            <!-- Основное содержимое блока вопросов -->
            <div class="question-body">
                <div class="w-100 d-flex justify-content-end">
                    <div class="btn-result-back-catalog">
                        <a href="{{url()->previous(route('catalog')) }}" id="close-player"  style="text-decoration: none; color: inherit;">
                            <i class="fa-solid fa-xmark fa-2xl"></i></a>
                    </div>
                </div>
                @if($test->isDraft() || $test->isModeration())
                    <div class="alert alert-warning mt-2" role="alert">
                        Вы находитесь в режиме предпросмотра теста. Тест можно пройти без сохранения результата, для
                        редактирования теста вернитесь в личный кабинет
                        <a href="{{route("{$currentUserRole}.tests.show", $test)}}" class="alert-link">Вернуться в
                            личный кабинет</a>
                    </div>
                @endif
                <div class="progress-container">
                    <div class="progress-bar" style="width: 90%;"></div>
                </div>
                <p class="progress-text">
                    <span>5</span>/<span>20</span>
                </p>

                <!-- Изображение вопроса -->
                <div class="image-container-question">
                    <img id="question-picture"
                         src="https://i.pinimg.com/736x/04/6d/89/046d89426f3fbdcf0cdbc3d5e34103c0.jpg"
                         class="question-image img-fluid" alt="Question Image">
                </div>

                <!-- Текст вопроса -->
                <p lang="ru"  class="question-text lead">Question text</p>

                <!-- Варианты ответов -->
                <section class="radio-section col-12 answers-only-text lead">
                    <div class="radio-list col-12">
                        <div class="radio-item col-12">
                            <input name="radio" id="radio1" type="radio" required><label for="radio1">Answer
                                text</label>
                        </div>
                    </div>
                </section>

                <div class="answers-only-pictures">
                    <div class="row row-cols-1 row-cols-lg-2 row-cols-md-2 align-items-center">
                        <div class="col align-items-center">
                            <label for="option4" class="radio-card">
                                <input type="radio" name="option" id="option4" value="4"/>
                                <div class="card-content-wrapper">
                                    <span class="check-icon"></span>
                                    <div class="card-content image-container-answer">
                                        <div class="image-container-answer">
                                            <img
                                                src="https://mail.mytubs.ru/uploads/posts/2022-10/kapibar.jpg"
                                                alt="Image answer" class="answer-image"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>


                <div class="answers-mix">
                    <div class="row row-cols-1 row-cols-lg-2 row-cols-md-2 align-items-stretch">
                        <div class="col align-self-stretch">
                            <label for="radio-card-2" class="radio-card">
                                <input type="radio" name="radio-card" id="radio-card-2"/>
                                <div class="card-content-wrapper">
                                    <span class="check-icon"></span>
                                    <div class="card-content image-container-answer">
                                        <div class="image-container-answer">
                                            <img
                                                src="https://mail.mytubs.ru/uploads/posts/2022-10/kapibar.jpg"
                                                alt="Image answer" class="answer-image"
                                            />
                                        </div>
                                        <p class="answer-text">Вариант картинка и текст</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-12 col-md-6">
                    <button type="submit" class="btn btn-lg btn-next">
                        <i class="fa-solid fa-arrow-right-long fa-xl" style="color: #ffffff"></i></button>
                </div>

            </div>
        </div>
    </div>


    <script>
        window.addEventListener("load", async function () {
            const testSlug = window.location.pathname.split("/").pop();
            const response = await fetch(`/player/${testSlug}/metadata`);
            if (response.status !== 200) {
                alert('Что-то пошло не так, обновите страницу');
                return;
            }
            content = await response.json();

            // Восстановление состояния из localStorage
            const savedAnswers = localStorage.getItem(`answers_${testSlug}`);
            const savedCurrentQuestion = localStorage.getItem(`currentQuestionNumber_${testSlug}`);
            answers = savedAnswers ? JSON.parse(savedAnswers) : [];
            currentQuestionNumber = savedCurrentQuestion ? parseInt(savedCurrentQuestion) : 1;

            document.querySelector('#test-preview-title').innerHTML = content.test.title;
            document.querySelector('#test-preview-picture').setAttribute('src', content.test.picture);
            document.querySelector('#test-preview-description').innerHTML = content.test.description.replace(/\n/g, '<br>');

            let authorLink = `<p class="text-secondary ">Автор: <a href="/?author_id=${content.test.author.id}" class="link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"> ${content.test.author.name}</a></p>`;
            document.querySelector('#test-preview-author').innerHTML = authorLink;

            let tags = ``;
            content.test.tags.forEach(tag => {
                tags += `<a href="/?tag_id=${tag.id}"><span class="badge test-tags"><i class="fa-solid fa-hashtag fa-sm"></i>${tag.name}</span></a>`;
            });
            document.querySelector('#test-preview-tags').innerHTML = tags;

            let categories = ``;
            content.test.categories.forEach(category => {
                categories += `<a href="/?category_id=${category.id}"><span class="btn btn-sm mb-2 btn-test-categories">${category.title}</span></a>`;
            });
            document.querySelector('#test-preview-categories').innerHTML = categories;

            document.querySelector('#test-preview-count-questions').innerHTML = `Количество вопросов: ${content.test.questions.length}`;

            document.querySelector('.preloader').style.display = 'none';
            if (savedAnswers && savedCurrentQuestion) {
                // Продолжить тест с сохранённого места
                document.querySelector('.test-container').style.display = 'none';
                document.querySelector('.question-container').style.display = 'block';
                questionRender();
                scrollToQuestionTop();
            } else {
                // Показываем стартовую страницу
                document.querySelector('.test-container').style.display = 'block';
            }

            document.querySelector('#test-preview-start-btn').addEventListener('click', function () {
                document.querySelector('.test-container').style.display = 'none';
                document.querySelector('.question-container').style.display = 'block';
                questionRender();
            });

            document.querySelector('.btn-next').addEventListener('click', async function () {
                let answer = document.querySelector('.question-container input[name="answer"]:checked');
                if (!answer) {
                    swal({
                        icon: "warning",
                        title: 'Внимание!',
                        text: "Пожалуйста, выберите один из вариантов, чтобы продолжить!",
                        button: {text: "OK"},
                        timer: 3000,
                    });
                    return;
                }

                answers[currentQuestionNumber - 1] = answer.value;

                // Сохраняем в localStorage
                localStorage.setItem(`answers_${testSlug}`, JSON.stringify(answers));

                if (currentQuestionNumber === content.test.questions.length) {
                    document.querySelector('.question-container').style.display = 'none';
                    document.querySelector('.preloader').style.display = 'block';

                    let formData = new FormData;
                    for (let i = 0; i < answers.length; i++) {
                        formData.append('answers[]', answers[i]);
                    }

                    const testId = document.getElementById('test-id').value;
                    const response = await fetch(`/player/${testId}/finish`, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });

                    if (response.status !== 200) {
                        alert('Что-то пошло не так, обновите страницу');
                        return;
                    }

                    // Очистка localStorage после завершения
                    localStorage.removeItem(`answers_${testSlug}`);
                    localStorage.removeItem(`currentQuestionNumber_${testSlug}`);

                    window.location = (await response.json()).redirect;
                    return;
                }

                currentQuestionNumber++;
                localStorage.setItem(`currentQuestionNumber_${testSlug}`, currentQuestionNumber);
                questionRender();
                scrollToQuestionTop();
            });
        });

        let answers = [];
        let content;
        let currentQuestionNumber = 1;

        function scrollToQuestionTop() {
            const top = document.querySelector('.question-container').offsetTop;
            window.scrollTo({
                top: top - 50,
                behavior: 'smooth'
            });
        }

        function questionRender() {
            document.querySelector('.question-container .progress-text span:nth-of-type(1)').innerHTML = currentQuestionNumber;
            document.querySelector('.question-container .progress-text span:nth-of-type(2)').innerHTML = content.test.questions.length;
            let currentProgressPercent = 100 / content.test.questions.length * currentQuestionNumber;
            document.querySelector('.question-container .progress-bar').style.width = currentProgressPercent + '%';

            let currentQuestion = content.test.questions[currentQuestionNumber - 1];

            if (currentQuestion.picture) {
                document.querySelector('#question-picture').setAttribute('src', currentQuestion.picture);
                document.querySelector('.image-container-question').style.display = 'block';
            } else {
                document.querySelector('.image-container-question').style.display = 'none';
            }

            if (currentQuestion.text) {
                document.querySelector('.question-text').innerHTML = currentQuestion.text;
                document.querySelector('.question-text').style.display = 'block';
            } else {
                document.querySelector('.question-text').style.display = 'none';
            }

            answersRender(currentQuestion.answers);
        }

        function answersRender(answers) {
            document.querySelector('.answers-only-text').style.display = 'none';
            document.querySelector('.answers-only-pictures').style.display = 'none';
            document.querySelector('.answers-mix').style.display = 'none';
            clearRenderAll();

            switch (getAnswersRenderType(answers)) {
                case 'text':
                    answersRenderText(answers);
                    break;
                case 'picture':
                    answersRenderPicture(answers);
                    break;
                case 'mix':
                    answersRenderMix(answers);
                    break;
            }
        }

        function clearRenderAll() {
            document.querySelector('.answers-only-text').innerHTML = '';
            document.querySelector('.answers-only-pictures .row').innerHTML = '';
            document.querySelector('.answers-mix .row').innerHTML = '';
        }

        function answersRenderText(answers) {
            document.querySelector('.answers-only-text').style.display = 'block';
            let content = '';
            let i = 0;
            for (let answer of answers) {
                i++;
                content += `<div class="radio-item col-12"><input name="answer" id="radio${i}" type="radio" value="${answer.id}" required><label for="radio${i}">${answer.text}</label></div>`;
            }
            document.querySelector('.answers-only-text').innerHTML = content;
        }

        function answersRenderPicture(answers) {
            document.querySelector('.answers-only-pictures').style.display = 'block';
            let content = '';
            let i = 0;
            for (let answer of answers) {
                i++;
                content += `<div class="col align-items-center">
                <label for="option${i}" class="radio-card">
                    <input type="radio" name="answer" id="option${i}" value="${answer.id}">
                    <div class="card-content-wrapper">
                        <span class="check-icon"></span>
                        <div class="card-content image-container-answer">
                            <img src="${answer.picture}" alt="Image answer" class="answer-image" />
                        </div>
                    </div>
                </label>
            </div>`;
            }
            document.querySelector('.answers-only-pictures .row').innerHTML = content;
        }

        function answersRenderMix(answers) {
            document.querySelector('.answers-mix').style.display = 'block';
            let content = '';
            let i = 0;
            for (let answer of answers) {
                i++;
                content += `<div class="col align-self-stretch mb-3">
                <label for="radio-card-${i}" class="radio-card">
                    <input type="radio" name="answer" id="radio-card-${i}" value="${answer.id}" />
                    <div class="card-content-wrapper">
                        <span class="check-icon"></span>
                        <div class="card-content">`;

                if (answer.picture) {
                    content += `<div class="image-container-answer"><img src="${answer.picture}" alt="Image answer" class="answer-image" /></div>`;
                }
                if (answer.text) {
                    if (answer.text.length < 40) {
                        content += `<p lang="ru" class="answer-text text-center lead">${answer.text}</p>`;
                    } else {
                        content += `<p lang="ru" class="answer-text lead">${answer.text}</p>`;
                    }
                }

                content += `</div></div></label></div>`;
            }
            document.querySelector('.answers-mix .row').innerHTML = content;
        }

        function getAnswersRenderType(answers) {
            let pic = 0, text = 0;
            for (let answer of answers) {
                if (answer.picture) pic++;
                if (answer.text) text++;
            }
            if (pic === 0) return 'text';
            if (text === 0) return 'picture';
            return 'mix';
        }


        document.addEventListener('DOMContentLoaded', function () {
            const closeBtn = document.getElementById('close-player');
            if (closeBtn) {
                closeBtn.addEventListener('click', function () {
                    const testSlug = window.location.pathname.split("/").pop();
                    localStorage.removeItem(`answers_${testSlug}`);
                    localStorage.removeItem(`currentQuestionNumber_${testSlug}`);
                });
            }
        });

    </script>

@endsection
