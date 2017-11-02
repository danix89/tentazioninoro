@extends('layouts.tentazioninoro')
@section('title', 'Home')
@section('content')
<p>Prova</p>
    @foreach($books as $index => $book)
        <h2>{{ $book }}</h2>
        <p>
            {{ $book }}<br/>
            <a href="{{ route('bookDetail', [ 'id' => $index ]) }}">Guarda dettaglio</a>
        </p>
    @endforeach
@endsection