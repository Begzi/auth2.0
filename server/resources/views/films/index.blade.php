@extends('layouts.layout')


@section('content')

    <div class="page-wrapper">
        <div class="card-header">
            <h3 class="card-title">Список фильмов</h3>
        </div>
        <div class="films-build">

            @if (count($films))
               @foreach($films as $film)
                    <div class="film-box wow fadeIn">
                        <div class="film-meta big-meta text-center">

                            <h4>
                                <a href="{{ route('films.show', ['film' => $film->id]) }}" title="">
                                    {{ $film->name }}
                                </a>
                            </h4>
                            <h4>{{ $film->name }}</h4>
                            <small>Год выхода фильма: {{ $film->date }}</small>
                            <br>
                            <small>{{ $film->description }}</small>
                        </div><!-- end meta -->

                    </div><!-- end blog-box -->

                    <hr class="invis">
                @endforeach
            @else
                <p>Категорий пока нет...</p>
            @endif

        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <nav aria-label="Page navigation">
                {{ $films->links() }}
            </nav>
        </div><!-- end col -->
    </div><!-- end row -->

@endsection
