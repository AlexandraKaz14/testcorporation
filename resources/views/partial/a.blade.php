<a
    @foreach($atributes as $name=>$value)
        {{$name}}="{{$value}}"
    @endforeach
    href="{{$url}}">{!!$text!!} </a>
