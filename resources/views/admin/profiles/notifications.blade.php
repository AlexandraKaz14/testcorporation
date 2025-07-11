@extends('layouts.app')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{__('common.notifications')}}</h1>
            </div>
            <div class="col-sm-6 ">
                {{Breadcrumbs::render('profile.notifications')}}
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
                            <h3 class="card-title"><i class="fa fa-bell mr-2"></i>{{__('common.notifications')}}</h3>
                        </div>
                        <div class="card-body">

                            @if($unreadNotifications->isNotEmpty())

                                @foreach($unreadNotifications as $notification)
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-8 col-12">
                                                @if($notification->type === \App\Notifications\TestRejectedNotification::class)

                                                    <div class="card card-danger">
                                                        <div class="card-header">
                                                            <h3 class="card-title">&#9993; Модерация не пройдена!</h3>
                                                            <div class="card-tools">
                                                                <form method="POST"
                                                                      action="{{ route('notifications.markAsRead',  ['notification' => $notification->id]) }}">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-tool" data-bs-toggle="tooltip"
                                                                            title="Отметить прочитанным и закрыть"><i class="fas fa-times"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <strong class="text-danger">{{ $notification->data['message'] }} </strong> &#128683;<br>
                                                            <span><strong>Причина отказа:</strong> {{ $notification->data['reason'] }}  </span>
                                                        </div>
                                                        <div class="text-center mb-3">
                                                            <a href="{{ $notification->data['test_url'] }}"> Смотреть тест <i
                                                                    class="fas fa-arrow-right"></i> </a>
                                                        </div>
                                                    </div>

                                                @elseif($notification->type === \App\Notifications\TestApprovedNotification::class)
                                                    <div class="card card-success">
                                                        <div class="card-header">
                                                            <h3 class="card-title">&#9993; Модерация пройдена!</h3>
                                                            <div class="card-tools">
                                                                <form method="POST"
                                                                      action="{{ route('notifications.markAsRead',  ['notification' => $notification->id]) }}">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-tool" data-bs-toggle="tooltip"
                                                                            title="Отметить прочитанным и закрыть"><i class="fas fa-times"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <strong>{{ $notification->data['message'] }} &#128077;</strong>
                                                        </div>
                                                        <div class="text-center mb-3">
                                                            <a href="{{ $notification->data['test_url'] }}"> Смотреть тест <i
                                                                    class="fas fa-arrow-right"></i> </a>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            @else

                                <div class="text-center">
                                    <h5>Новые уведомления отсутствуют!</h5>
                                </div>
                            @endif

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

@endpush
