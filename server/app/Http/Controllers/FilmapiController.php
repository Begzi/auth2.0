<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Film;
use App\Models\OauthAuthCode;
use App\Models\OauthAuthToken;
use App\Models\OauthClient;
use App\Models\FavoriteList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;


class FilmapiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $films = Film::paginate(2);
        return $films;
    }
    public function loginForm(Request $request)
    {
        $request_uri = ($request->query('request_uri'));
        return view('user.apilogin', compact('request_uri'));
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            $query_client = OauthClient::where('name', $request->request_uri)->first();
            if ($query_client == null)
            {
                $client = new OauthClient();
                $client->name = $request->request_uri;
                $client->save();
                $query_client = $client;
            }
            $query_code = OauthAuthCode::where('client_id', $query_client->id)->where('user_id', auth()->user()->id)->first();
            if ($query_code != null)
            {
                $query_code->delete();
            }
            
            $code = bin2hex(random_bytes(5));
            OauthAuthCode::create(['user_id' => auth()->user()->id, 'client_id' => $query_client->id, 'code' => $code]);                
            
            return  Redirect::to('http://php-laravel-client.com/login?code=' . $code );
        }

        return redirect()->back();
    }
    public function access_token(Request $request)
    {
        $query_code = OauthAuthCode::where('code', $request['code'])->first();
        if ($query_code == null){
            $token = 'Присланный вами код не соответствуют тому коду, который был отправлен вам. Попытайтесь авторизоваться заного.';
        }
        else{
            $token = $query_code->client_id . $query_code->user_id . $query_code->code;
            // $token = xor_this($token);
            $token = implode(",", strToDec(($token)));
            OauthAuthToken::create(['client_id' => $query_code->client_id, 'user_id' => $query_code->user_id, 'token' => $token]);
            $query_code->delete();
        }
        $data = ['token' => $token];
        return $data;


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        if ( validateFilm($request['name'], $request['date'], $request['description']) ){
            // return $request->all();


            $data['name'] = $request['name'];
            $data['date'] = $request['date'];
            $data['description'] = $request['description'];
            $data['user_id'] = $request['token']->user_id;
            Film::create($data); 
            return 200;
        }
        else{
            return 404;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $film = Film::find($id);
        $data['id'] = $film->id;
        $data['name'] = $film->name;
        $data['description'] = $film->description;
        $data['date'] = $film->date;
        $data['user'] = $film->user->name;
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        if ( validateFilm($request['name'], $request['date'], $request['description']) ){
            // return $request->all();


            $data['name'] = $request['name'];
            $data['date'] = $request['date'];
            $data['description'] = $request['description'];
            $data['user_id'] = $request['token']->user_id;
            $film = Film::find($id);
            if ($film != null){
                $film->update($data); 
                return 200;                
            }
        }
        return 404;
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $film = Film::find($id);
        if ($film == null){
            $data['message'] = 'Не найден фильм, с id: ' . $id;
            $data['code'] = '404';
        }
        else{
            $film->delete();
            $data['message'] = 'Фильм успешно удалён';
            $data['code'] = '200';
        }
        return ($data);
    }

    public function endpoint(Request $request){
        $request['token']->user_id;
        $favoriteLists = FavoriteList::with('film')->where('user_id', '!=', $request['token']->user_id)->paginate(2);
        // return $favoriteLists;
        $data = [];
        foreach ($favoriteLists as $favoritelist){
            array_push($data, $favoritelist->film);
        }
        $sent['data'] = $data;
        $sent['current_page'] = $favoriteLists->currentPage();
        $sent['last_page'] = $favoriteLists->lastPage();
        return $sent;
    }
}

function strToDec($string)
{
    $array=[];
    for ($i=0; $i < strlen($string); $i++)
    {
        array_push($array, ord($string[$i]));
    }

    return $array;
}


function decToStr($hex)
{
    $string='';
    for ($i=0; $i < count($hex); $i++)
    {
        $string .= chr(($hex[$i]));
    }
    return $string;
}

function validateFilm($name, $date, $description){
    if ($name == null or $date == null or $description == null){
        return false;
    }
    if (gettype($date) == 'integer'){
        return false;
    }
    if (strlen($name) >= 100){
        return false;
    }
    return true;

}


