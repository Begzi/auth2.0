@extends('layouts.layout')


@section('content')

    <div class="page-wrapper">
        <div class="card-header">
            <h3 class="card-title">Список фильмов</h3>
        </div>
        <div class="films-build">

            @if (count($favoriteLists))
               @foreach($favoriteLists as $favoriteList)
                    <div class="film-box wow fadeIn">
                        <div class="film-meta big-meta text-center">


                            <h4>{{ $favoriteList->film->name }}</h4>
                            <small>Год выхода фильма: {{ $favoriteList->film->date }}</small>
                            <br>
                            <small>{{ $favoriteList->film->description }}</small>
                        </div><!-- end meta -->
                        
                    </div><!-- end blog-box -->

                    <hr class="invis">
                @endforeach
            @else
                <p>Избранных пока нет...</p>
            @endif

        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <nav aria-label="Page navigation">
                {{ $favoriteLists->links() }}
            </nav>
        </div><!-- end col -->
    </div><!-- end row -->

@endsection
