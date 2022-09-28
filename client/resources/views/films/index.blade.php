@extends('layouts.layout')


@section('content')
    @if (isset($token))
        <script type="text/javascript">
           localStorage.setItem('token', <?php echo json_encode($token['token']); ?>) //value must be string! U can do it with JSON.stringify

        </script>
    @endif
    <div class="row">
        <div class="container">
            
            @foreach($films['data'] as $film)
                <div class="blog-box wow fadeIn">
                    <!-- end media -->
                    <div class="blog-meta big-meta text-center">

                        <h4><a href="{{ route('films.show', ['film' => $film['id']]) }}" title="">{{ $film['name'] }}</a></h4>
                        <small>Год выхода фильма: {{ $film['date'] }}</small>
                        <br>
                        <small>{{ $film['description'] }}</small>
                    </div><!-- end meta -->
                </div><!-- end blog-box -->

                <hr class="invis">
            @endforeach

        </div>
    </div>
    <br>

    <hr class="invis">

    <div class="row">
        <div class="container" id="navbar-link">
            @for ($i = 1; $i < $pages['last_page'] + 1; $i++)
                @if ($i == $pages['current_page'])
                    {{ $i }}
                @else
                    <a  href="{{ $link }}{{ $i }}" title="{{ $i }} page">{{ $i }}</a>
                @endif
            @endfor
        </div>
    </div><!-- end row -->

    <style type="text/css">
        
        #navbar-link {
          text-align: center;
        }
    </style>

@endsection
