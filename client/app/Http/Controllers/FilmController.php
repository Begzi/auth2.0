<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class FilmController extends Controller
{
    private $url_server='http://php-laravel-server.com';
    private $url_client='http://php-laravel-client.com';

    public function home(Request $request)
    {
        $page = $request->query('page');
        if ($page){
            $response = Http::get( $this->url_server . '/api/films?page=' . $page);
        }
        else{
            $response = Http::get( $this->url_server . '/api/films');
        }
        $films = $response->json();
        // dump($films);
        // dd($response);
        $pages = [
            'current_page' => $films['current_page'],
            'last_page' => $films['last_page'],
        ];
        $link = $this->url_client . '/?page=';
        return view('films.index', compact('films', 'pages', 'link'));
    }

    public function login(Request $request)
    {
        $code = $request->query('code');
        if ($code == null){
            $request->session()->flash('error', 'Авторизуйтесь');
            return redirect()->route('home');
        }

        $response = Http::get( $this->url_server . '/api/access_token?code=' . $code);
        $token = ($response->json());
        $page = $request->query('page');
        if ($page){
            $response = Http::get( $this->url_server . '/api/films?page=' . $page);
        }
        else{
            $response = Http::get( $this->url_server . '/api/films');
        }
        $films = $response->json();
        $pages = [
            'current_page' => $films['current_page'],
            'last_page' => $films['last_page'],
        ];

        $request->session()->put('tokenlogin', $token['token']); 
        $link = $this->url_client . '/?page=';
        return view('films.index', compact('films', 'pages', 'link', 'token'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('films.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [    //Как по мне круче этот
            'name' => 'required|max:100',
            'description' => 'required',
            'date' => 'integer',
            'tokenlogin' => 'required',
        ];

        $messages = [
            'name.required' => 'Add name',
            'name.max' => 'Name max 100 char',
            'description.required' => 'Add description',
            'date.integer' => 'Date must be number',
            'tokenlogin.required' => 'You must Login',
        ];
        $validator = Validator::make($request->all(), $rules, $messages)->validate();
        $tokenlogin = session()->get('tokenlogin');
        if ($request['tokenlogin'] !=  session()->get('tokenlogin')){
            $tokenlogin = session()->get('tokenlogin');
            $request->session()->forget('tokenlogin'); 
            return redirect()->route('home'); 
        }

        $response = Http::withHeaders([
            'tokenheader' => $request['tokenlogin']
        ])->post( $this->url_server . '/api/films',[
            'name' => $request['name'],
            'date' => $request['date'],
            'description' => $request['description'],
            'token' => $request['tokenlogin'],
        ]);

        $data = $response->json();
        // dump($data);
        // dd($response);
        if ($data == 200){

            $request->session()->flash('success', 'Данные были добавлены'); 
        }
        else{

            $request->session()->flash('error', 'Что то пошло не так, попытайтесь заного, либо обратитесь к Администратору'); 
        }
        return redirect()->route('home'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = Http::get( $this->url_server . '/api/show/' . $id);
        $film = $response->json();
        return view('films.show', compact('film'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $response = Http::get( $this->url_server . '/api/show/' . $id);
        $film = $response->json();
        // $film['date'] = strval($film['date']);
        return view('films.edit', compact('film'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [    //Как по мне круче этот
            'name' => 'required|max:100',
            'description' => 'required',
            'date' => 'integer',
            'tokenlogin' => 'required',
        ];

        $messages = [
            'name.required' => 'Add name',
            'name.max' => 'Name max 100 char',
            'description.required' => 'Add description',
            'date.integer' => 'Date must be number',
            'tokenlogin.required' => 'You must Login',
        ];
        $validator = Validator::make($request->all(), $rules, $messages)->validate();
        $tokenlogin = session()->get('tokenlogin');
        if ($request['tokenlogin'] !=  session()->get('tokenlogin')){
            $tokenlogin = session()->get('tokenlogin');
            $request->session()->forget('tokenlogin'); 
            return redirect()->route('home'); 
        }

        $response = Http::withHeaders([
            'tokenheader' => $request['tokenlogin']
        ])->put( $this->url . '/api/films/' . $id,[
            'name' => $request['name'],
            'date' => $request['date'],
            'description' => $request['description'],
            'token' => $request['tokenlogin'],
        ]);
        $data = $response->json();
        if ($data == 200){

            $request->session()->flash('success', 'Данные были изменены'); 
        }
        else{

            $request->session()->flash('error', 'Что то пошло не так, попытайтесь заного, либо обратитесь к Администратору'); 
        }
        // dump($films);
        // dd($response);
        return redirect()->route('home'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $rules = [    //Как по мне круче этот
            'tokenlogin' => 'required',
        ];

        $messages = [
            'tokenlogin.required' => 'You must Login',
        ];
        $validator = Validator::make($request->all(), $rules, $messages)->validate();

        if ($request['tokenlogin'] !=  session()->get('tokenlogin')){
            $tokenlogin = session()->get('tokenlogin');
            $request->session()->forget('tokenlogin'); 
            return redirect()->route('home'); 
        }

        $response = Http::withHeaders([
            'tokenheader' => $request['tokenlogin']
        ])->delete( $this->url_server . '/api/films/' . $id);
        $data = $response->json();
        // dd($data);
        if ($data['code'] == 200){

            $request->session()->flash('success', 'Данные были удалены'); 
        }
        else{

            $request->session()->flash('error', 'Что то пошло не так, попытайтесь заного, либо обратитесь к Администратору'); 
        }
        return redirect()->route('home'); 
    }

    public function logout(Request $request){
        $request->session()->forget('tokenlogin'); 
        return redirect()->route('home'); 

    }

    public function endpoint(Request $request){
        $page = $request->query('page');
        if ($page){
            $response = Http::withHeaders([
            'tokenheader' =>  session()->get('tokenlogin')
        ])->get( $this->url_server . '/api/endpoint?page=' . $page);
        }
        else{
            $response = Http::withHeaders([
            'tokenheader' => session()->get('tokenlogin')
        ])->get( $this->url_server . '/api/endpoint');
        }
        $films = $response->json();
        // dump($films);
        // dd($response);
        $pages = [
            'current_page' => $films['current_page'],
            'last_page' => $films['last_page'],
        ];
        $link = $this->url_client . '/endpoint?page=';
        return view('films.index', compact('films', 'pages', 'link'));

    }
}
