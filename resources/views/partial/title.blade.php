<a
@foreach($atributes as $title=>$value)
    {{$title}}="{{$value}}"
@endforeach
href="{{$url}}">{!!$text!!} </a>

