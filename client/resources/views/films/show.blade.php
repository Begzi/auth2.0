@extends('layouts.layout')


@section('content')

    <div class="page-wrapper">
        <div class="card-header text-center">
            <h3 class="card-title">{{ $film['name'] }}</h3>
        </div>
        <div class="films-build">

            <div class="film-box wow fadeIn">
                <div class="film-meta big-meta text-center">
                    <div>
                        ID Фильма:
                        <span id="film-id">
                            {{ $film['id'] }} 
                        </span>
                    </div>
                    <div id="date">
                        <small>Год выхода фильма: {{ $film['date'] }}</small>                        
                    </div>
                    <div id="master">
                        <small>Добавил пользователь: {{ $film['user'] }}</small>               
                    </div>
                    <br>
                    <small>{{ $film['description'] }}</small>
                </div><!-- end meta -->
                
            </div><!-- end blog-box -->


        </div>
        <div>
            <a href="{{ route('films.edit', ['film' => $film['id']]) }}"><button class="btn btn-primary">Редакитровать</button></a>
        </div>
    </div>

@endsection
