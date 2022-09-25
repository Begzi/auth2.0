

@extends('layouts.layout')

@section('content')
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
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="content">Год выхода фильма: </label>
            <input name="date" type="number" min="1900" max="2099" step="1" value="2022" />            
            @error('date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="content">Описание</label>
            <textarea name="description" class="form-control" id="content" rows="7"
                      placeholder="Описание ..." ></textarea>            
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


    </div>
    <!-- /.card-body -->

    <div class="card-footer">
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </div>
</form>
@endsection