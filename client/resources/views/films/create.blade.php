

@extends('layouts.layout')

@section('content')
<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function(){ //При загрузке DOM дерева будет вызвана функция
	    // console.log('Loaded')
	    try{
		    let obj = (localStorage.getItem('token'))
	        if (obj === null){
	        	console.log('have not token')
	        }
	        else{
				let form = document.querySelector('form')
				let div = document.createElement("div")
				div.className = "form-group"
				div.innerHTML = ('afterend', `<input name="tokenlogin" type="text" hidden value="${obj}">`)
				form.appendChild(div)
			}
	    }
	    catch(e){
	        console.log('have not token')

	    }
	})
</script>
<form role="form" method="post" action="{{ route('films.store') }}">
    @csrf
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="form-group">
            <label for="content">Название фильма: </label>
            <input name="name" type="text">            
        </div>

        <div class="form-group">
            <label for="content">Год выхода фильма: </label>
            <input name="date" type="number" min="1900" max="2099" step="1" value="2022" />        
        </div>

        <div class="form-group">
            <label for="content">Описание</label>
            <textarea name="description" class="form-control" id="content" rows="7"
                      placeholder="Описание ..." ></textarea>            
        </div>


    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</form>
@endsection