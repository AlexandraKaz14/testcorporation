@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'errors.Forbidden'))
@section('message2')
    <h2 class="message-error-two text-center">
        У вас нет прав для просмотра этой страницы.<br>
        Если вы считаете, что это ошибка, обратитесь в поддержку.<br>
        <a class="btn btn-error btn-lg px-4 gap-3 mt-3" href="{{ route('catalog') }}" role="button">Главная</a>
    </h2>

@endsection
