@extends('layouts.app')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('common.profile')}}</h1>
            </div>
            <div class="col-sm-6 ">
                {{Breadcrumbs::render('profile')}}
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
                            <h3 class="card-title"><i class="fa fa-user mr-2"></i>{{__('common.profile')}}</h3>
                        </div>
                        <div class="card-body">

                            @if($currentUser->tests->isEmpty())
                            <div style="text-align: center; padding: 20px; font-family: Arial, sans-serif;">
                                <p style="font-size: 18px; color: #555;" class="text-center">
                                    У вас пока нет тестов, но это только начало! 🚀
                                </p>
                                <p style="font-size: 16px; color: #777;" class="text-center">
                                    Как только вы создадите тесты, опубликуете, вы сможете отслеживать прохождение тестов за все время/месяц/неделю/день, их популярность и узнавать,<br> какие 3 ваших теста лидируют по количеству прохождений 📊<br> А также отслеживать ваше положение в рейтинге &#128200;
                                </p>
                                <p style="font-size: 16px; color: #777;">
                                    Начните создавать тесты прямо сейчас и делитесь ими с друзьями! 😊
                                </p>

                                <a href="{{route("{$currentUserRole}.tests.create")}}" class="btn btn-success">
                                    {{__('common.сreate your first test')}}</a>
                            </div>
                            @endif
                            <!-- Small boxes (Stat box) -->
                            <div class="row">
                                <div class="col-lg-7 col-md-8 col-12">
                                    <!-- small box -->
                                    <div class="small-box bg-gradient-secondary">
                                        <div class="inner">
                                            <h5>Популярные тесты:</h5>

                                            @if($currentUser->tests->isEmpty())
                                                <p class="text-center">У вас еще нет тестов</p>
                                            @else
                                            @foreach($popularTests as $popularTest)
                                                <h6 style="word-wrap: break-word; word-break: break-word; white-space: normal;">{{$popularTest->title}}
                                                    <span
                                                        class="float-right badge bg-info">{{$popularTest->total_passages}}</span>
                                                </h6>
                                            @endforeach
                                            @endif
                                        </div>

                                    </div>
                                </div>
                                <!-- ./col -->
                                <div class="col-lg-5 col-md-4 col-12">
                                    <!-- small box -->
                                    <div class="small-box bg-gradient-secondary">
                                        <div class="inner">
                                            <h5>Прохождение тестов:</h5>
                                            @if($currentUser->tests->isEmpty())
                                                <p class="text-center">У вас еще нет тестов</p>
                                            @else
                                                <h6>За все время <span
                                                        class="float-right badge bg-info text-bg-secondary">{{$totalPassings}}</span>
                                                </h6>
                                                <h6>За месяц <span
                                                        class="float-right badge bg-info text-bg-secondary">{{$mountPassings}}</span>
                                                </h6>
                                                <h6>За неделю <span
                                                        class="float-right badge bg-info text-bg-secondary">{{$weekPassings}}</span>
                                                </h6>
                                                <h6>За день <span
                                                        class="float-right badge bg-info text-bg-secondary">{{$dayPassings}}</span>
                                                </h6>
                                            @endif

                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <section class="col-lg-7 col-md-12 col-12 connectedSortable ui-sortable">

                                    <div class="card table-responsive">
                                        <div class="card-header border-0">
                                            <div class="d-flex justify-content-between">
                                                <h3 class="card-title">График прохождения за 30 дней</h3>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <p><span class=" badge bg-primary">{{$mountPassings}}</span> Общее
                                                    количество
                                                    прохождений за текущие 30 дней </p>

                                                <p><span class="badge bg-secondary">{{$lastMountPassings}}</span> Общее
                                                    количество
                                                    прохождений за прошедшие 30 дней </p>

                                                <p class="ml-auto d-flex flex-column text-right">

                                                    @if($percentageChange > 0)
                                                        <span class="text-success">
                      <i class="fas fa-arrow-up"></i> {{round($percentageChange,2)}}%
                    </span>
                                                    @elseif($percentageChange===0)
                                                        <span class="text-dark">{{round($percentageChange,2)}}% </span>
                                                    @else
                                                        <span class="text-danger">
                      <i class="fas fa-arrow-down"></i> {{round($percentageChange,2)}}%
                    </span>
                                                    @endif

                                                    <span class="text-muted">С прошлого месяца</span>
                                                </p>
                                            </div>

                                            <div class="position-relative mb-4">
                                                <div class="chartjs-size-monitor">
                                                    <div class="chartjs-size-monitor-expand">
                                                        <div class=""></div>
                                                    </div>
                                                    <div class="chartjs-size-monitor-shrink">
                                                        <div class=""></div>
                                                    </div>
                                                </div>
                                                <canvas id="userChart" height="400"
                                                        style="display: block; height: 200px; width: 304px;"
                                                        width="608" class="chartjs-render-monitor"></canvas>
                                            </div>


                                        </div>
                                    </div>

                                </section>

                                <section class="col-lg-5 col-md-12 col-12 connectedSortable ui-sortable">

                                    <div class="card">
                                        <div class="card-header border-0">
                                            <h3 class="card-title">Рейтинг авторов тестов за последние 30 дней</h3>
                                        </div>
                                        <div class="card-body table-responsive p-0">
                                            <table class="table table-striped table-valign-middle">
                                                <thead>
                                                <tr>
                                                    <th>Место</th>
                                                    <th>Имя</th>
                                                    <th>Баллы</th>
                                                    <th>Изменение за сутки</th>
                                                </tr>
                                                </thead>

                                                <tbody>
                                                @foreach($topUsers as $topUser)
                                                   @if($topUser->rank_today >=5)
                                                       <tr>
                                                       <td>...</td>
                                                       <td>...</td>
                                                       <td>...</td>
                                                       <td>...</td>
                                                       </tr>
                                                   @endif

                                                    <tr>
                                                        <td>@switch($topUser->rank_today)
                                                                @case(1)
                                                                    <i class="fas fa-trophy" style="color: gold;"></i>
                                                                    @break
                                                                @case(2)
                                                                    <i class="fas fa-trophy"
                                                                       style="color: #C0C0C0;"></i>
                                                                    @break
                                                                @case(3)
                                                                    <i class="fas fa-trophy"
                                                                       style="color: #b87333;"></i>
                                                                    @break
                                                                @case(4)
                                                                    <span class="badge bg-info">{{$topUser->rank_today}}</span>
                                                                    @break
                                                                @default
                                                                    <span class="badge bg-secondary">{{$topUser->rank_today}}</span>
                                                            @endswitch
                                                        </td>
                                                        <td>{{$topUser->name}}</td>
                                                        <td>{{$topUser->points_today}}</td>
                                                        <td>{{$topUser->rank_change}}</td>
                                                    </tr>

                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                </section>
                            </div>

                            <!-- Смена пароля-->
                            <div class="row">
                                <section class="col-lg-7 col-md-12 col-12 connectedSortable ui-sortable">
                                    <div class="card card-info">
                                        <div class="card-header">
                                            <h3 class="card-title">Сменить пароль</h3>
                                        </div>
                                        <div class="card-body">
                                            <form class="form-horizontal" id="form-user"
                                                  action="{{ route('profile.update-password', ['user' => auth()->id()]) }}"
                                                  method="post">
                                                @csrf
                                                @method('patch')
                                                <div class="form-group row">
                                                    <label for="currentPassword" class="col-sm-3 col-form-label">Текущий
                                                        пароль</label>
                                                    <div class="col-sm-9 position-relative">
                                                        <input type="password" name="current_password"
                                                               class="form-control"
                                                               id="currentPassword" placeholder="Текущий пароль"
                                                               required
                                                               style="padding-right: 30px;">
                                                        <button type="button" class="toggle-password"
                                                                data-target="currentPassword"
                                                                style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                        @error('current_password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="newPassword" class="col-sm-3 col-form-label">Новый
                                                        пароль</label>
                                                    <div class="col-sm-9 position-relative">
                                                        <input type="password" name="new_password" class="form-control"
                                                               id="newPassword" placeholder="Новый пароль" required
                                                               style="padding-right: 30px;">
                                                        <button type="button" class="toggle-password"
                                                                data-target="newPassword"
                                                                style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                        @error('new_password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="confirmPassword" class="col-sm-3 col-form-label">Подтвердите
                                                        пароль</label>
                                                    <div class="col-sm-9 position-relative">
                                                        <input type="password" name="new_password_confirmation"
                                                               class="form-control"
                                                               id="confirmPassword" placeholder="Подтвердите пароль"
                                                               required
                                                               style="padding-right: 30px;">
                                                        <button type="button" class="toggle-password"
                                                                data-target="confirmPassword"
                                                                style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer;">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                        @error('new_password_confirmation')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div>
                                                    <input class="btn btn-info mr-2" type="submit" value="Сохранить">
                                                    <button type="button" id="cancelButton" class="btn btn-default">
                                                        Отмена
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </section>
                            </div>

                            <!-- Смена пароля конец-->
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
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Показ/скрытие пароля
            document.querySelectorAll('.toggle-password').forEach(function (button) {
                button.addEventListener('click', function () {
                    const targetId = button.getAttribute('data-target');
                    const passwordField = document.getElementById(targetId);
                    const icon = button.querySelector('i');

                    // Переключение типа input
                    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordField.setAttribute('type', type);

                    // Переключение иконки
                    icon.classList.toggle('fa-eye');
                    icon.classList.toggle('fa-eye-slash');
                });
            });

            // Сброс полей по кнопке "Отмена"
            document.getElementById('cancelButton').addEventListener('click', function () {
                document.getElementById('currentPassword').value = '';
                document.getElementById('newPassword').value = '';
                document.getElementById('confirmPassword').value = '';
            });

            // Проверка совпадения паролей
            document.getElementById('confirmPassword').addEventListener('input', function () {
                const newPassword = document.getElementById('newPassword').value;
                const confirmPassword = this.value;

                if (newPassword !== confirmPassword) {
                    this.setCustomValidity('Пароли не совпадают');
                } else {
                    this.setCustomValidity('');
                }
            });

            // Проверка перед отправкой формы
            document.getElementById('form-user').addEventListener('submit', function (event) {
                const currentPassword = document.getElementById('currentPassword').value;
                const newPassword = document.getElementById('newPassword').value;
                const confirmPassword = document.getElementById('confirmPassword').value;

                if (!currentPassword) {
                    event.preventDefault();
                    alert('Текущий пароль обязателен');
                    return;
                }

                if (newPassword !== confirmPassword) {
                    event.preventDefault();
                    alert('Пароли не совпадают');
                }
            });
        });

    </script>

    <script>

        document.addEventListener("DOMContentLoaded", function () {
            // Получаем данные
            const currentLabels = @json($currentLabels);
            const currentValues = @json($currentValues);
            const previousValues = @json($previousValues);
            const previousLabels = @json($previousLabels);

            // Настройка графика
            const ctx = document.getElementById('userChart').getContext('2d');
            const userChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: currentLabels,  // Метки оси X
                    datasets: [
                        {
                            label: 'Текущие 30 дней',
                            data: currentValues, // Значения оси Y
                            borderColor: 'rgba(13, 110, 253, 1)', // Цвет линии
                            backgroundColor: 'rgb(13, 110, 253)', // Цвет заливки
                            borderWidth: 2,
                        },
                        {
                            label: 'Прошлые 30 дней',
                            data: previousValues, // Значения для прошлого периода
                            borderColor: 'rgb(108, 117, 125)',
                            backgroundColor: 'rgb(108, 117, 125)',
                            borderWidth: 2,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Дата'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Количество прохождений'
                            }
                        }
                    }
                }
            });
        });
    </script>

@endpush
