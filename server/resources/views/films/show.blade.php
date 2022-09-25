@extends('layouts.layout')


@section('content')

    <div class="page-wrapper">
        <div class="card-header">
            <h3 class="card-title">Фильм</h3>
        </div>
        <div class="films-build">

            <div class="film-box wow fadeIn">
                <div class="film-meta big-meta text-center">
                    @csrf
                    <div>
                        ID Фильма:
                        <span id="film-id">
                            {{ $film->id }} 
                        </span>
                    </div>
                    <h4>
                        {{ $film->name }}
                    </h4> 
                    <div id="date">
                        <small>Год выхода фильма: {{ $film->date }}</small>                        
                    </div>
                    <div id="master">
                        <small>Добавил пользователь: {{ $film->user->name }}</small>               
                    </div>
                    <br>
                    <small>{{ $film->description }}</small>
                </div><!-- end meta -->
                
            </div><!-- end blog-box -->


        </div>
        <div>
            @if ($favorite)
                <button id = "favorite">Remove from favorite</button>
            @else
                <button id = "favorite">Add to favorite</button>
            @endif
        </div>
    </div>


<script type="text/javascript">
    
const scrfToken = document.querySelector('[name="_token"]')
const btn = document.querySelector('#favorite')
btn.addEventListener('click', event => {
    event.preventDefault()
    const scrfToken = document.querySelector('[name="_token"]')
    const user = document.querySelector('h2')
    const film = document.querySelector('#film-id')

    const sent_data = {
        "_token": scrfToken.value,
        "user_name": user.innerText,
        "film_id": film.innerText,
    }
    console.log(sent_data)
    let post = JSON.stringify(sent_data)
 
    const url = "http://php-laravel-server.com/ajax_post"
    let xhr = new XMLHttpRequest()
     
    xhr.open('POST', url, true)
    xhr.setRequestHeader('Content-type', 'application/json; charset=UTF-8')
    xhr.send(post);
     
    xhr.onload = function () {
        if(xhr.status === 200) {
            alert("Post successfully created!") 
            console.log(xhr)
        }
    }
    if (btn.innerText == 'Add to favorite'){
        btn.innerText = 'Remove from favorite'
    }
    else{
        btn.innerText = 'Add to favorite'
    }

})
</script>
@endsection
