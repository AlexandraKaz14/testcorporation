@include('partial.title', [
'atributes' => [
'class' => $class,
],
'url' => route("{$currentUserRole}.tests.show", $test),
'text' => $test->title,
])
