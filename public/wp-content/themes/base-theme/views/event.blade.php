@extends('layouts/master')

@section('content')

    <?php $post = get_post() ?>

    <pre>
        {{ var_dump($post) }}
    </pre>
    
@endsection