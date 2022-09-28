<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\User;
use App\Models\FavoriteList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        return view('home');
    }
    public function favoriteShow()
    {
        $favoriteLists = FavoriteList::with('film')->where('user_id', auth()->user()->id)->paginate(2);
        
        return view('films.favorite', compact('favoriteLists'));
    }
    public function index()
    {
        $films = Film::paginate(2);
        dump(get_class_methods($films));
        dd($films);
        return view('films.index', compact('films'));
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
        ];

        $messages = [
            'name.required' => 'Add name',
            'name.max' => 'Name max 100 char',
            'description.required' => 'Add description',
            'date.integer' => 'Date must be number',
        ];
        $validator = Validator::make($request->all(), $rules, $messages)->validate();
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        Film::create($data); 
        $request->session()->flash('success', 'Data saved!'); 

        return redirect()->route('films.index'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $film = Film::where('id', $id)->with('user')->firstOrFail();
        $favorite = FavoriteList::where('user_id', auth()->user()->id)->where('film_id', $id)->first();
        return view('films.show', compact('film', 'favorite'));
    }
    public function ajax(Request $request)
    {
        // $film = Film::where('id', $id)->with('user')->firstOrFail();
        // $favorite = FavoriteList::where('user_id', auth()->user->id);
        $user = User::where('name', $request['user_name'])->first();
        $favorite = FavoriteList::where('user_id', $user->id)->where('film_id', $request->input('film_id'))->first();
        if ($favorite){
            $favorite->delete();
        }
        else{
            FavoriteList::create(['user_id' => $user->id, 'film_id' => $request['film_id']]); 

        }
        return response()->json(['success'=>'Form is successfully submitted!', 'request' => $request]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
