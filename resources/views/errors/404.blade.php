@extends('errors::minimal')

@section('title', __('errors.Not Found'))
@section('code', '404')
@section('message', __('errors.Not Found'))
@section('message2')
    <h2 class="message-error-two text-center">
        Возможно, страница была удалена, переименована или адрес введен с ошибкой.<br>
        Проверьте правильность URL или перейдите на главную.<br>
        <a class="btn btn-error btn-lg px-4 gap-3 mt-3" href="{{ route('catalog') }}" role="button">Главная</a>
    </h2>

@endsection
