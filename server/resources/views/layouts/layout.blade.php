<!DOCTYPE html>
<html lang="en">

    <!-- Basic -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Site Metas -->
    <title>Header</title>

    <link rel="stylesheet" href="{{ asset('assets/admin/css/admin.css') }}">



</head>
<body>


    <section id="cta" class="section">
        <div class="row">
            <div class="col-lg-2 col-md-12 align-self-center">
                <h1>Header</h1>
            </div>
            <div class="col-lg-1 col-md-12 align-self-center">
                <a href="{{ route('films.index') }}" class="btn btn-primary">All films</a>
            </div>
            <div class="col-lg-7 col-md-12 align-self-center">
                <a href="{{ route('favorite') }}" class="btn btn-primary">Favorite films</a>
            </div>
            <div class="col-lg-1 col-md-12 align-self-center">
                <a href="{{ route('films.create') }}" class="btn btn-primary">Add film</a>
            </div>
            <div class="col-lg-1 col-md-12 align-self-center">
                <h2>@php echo (auth()->user()->name); @endphp</h2>
            </div>
        </div>
    </section>

    <hr class="invis">

    <div class="container">
        
        @yield('content')
    </div>

    
    <section id="footer" class="section">
        <div class="container">
            <a href="{{ route('logout') }}" class="mt-5">Logout</a>            
        </div>

    </section>

</body>
</html>