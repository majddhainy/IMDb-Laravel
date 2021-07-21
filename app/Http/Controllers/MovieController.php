<?php

namespace App\Http\Controllers;

use App\Actor;
use App\Category;
use App\Movie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $movies = Movie::all();
        return view('cms.movies.index')->with('movies',$movies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::all();
        $actors = Actor::all();

        return view('cms.movies.create')->with('categories',$categories)->with('actors',$actors);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'title' => 'required|string',
            'description' => 'required|string',
            'release_date' => 'required|date',
            'production_date' => 'required|date',
            'categories' => 'required|array',
            'categories.*' => 'integer',
            'actors' => 'required|array',
            'actors.*' => 'integer',
            'names_in_movie' => 'required|array',
            'names_in_movie.*' => 'string',
        ]);

        //dd($request->all());

        //setting Movie's main data & creating it
        $movie = new Movie();
        $movie->title = $request->title;
        $movie->description = $request->description;
        $movie->release_date = $request->release_date;
        $movie->production_date = $request->production_date;
        $movie->save();

        //attach movie categories
        $movie->categories()->attach($request->categories);

        //preapare movie's actors data and attach them
        $attach_actors_data = [];
        foreach($request->actors as $key => $actor)
            $attach_actors_data[$actor] = ['name_in_movie' => $request->names_in_movie[$key]];
        $movie->actors()->attach($attach_actors_data);

        //saving again
        $movie->save();

        session()->flash('success' , 'Movie created successfully');
        return redirect()->route('movies.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $movie = Movie::find($id);
        $movie_categories = $movie->categories()->get();
        $movie_categories_ids = array();
        foreach($movie_categories as $cat){
            array_push($movie_categories_ids,$cat->id);
        }
        $movie_actors = $movie->actors()->get();
        //dd($movie_categories_ids);
        $categories = Category::all();
        $actors = Actor::all();
        return view('cms.movies.edit')
            ->with('movie',$movie)
            ->with('movie_categories',$movie_categories_ids)
            ->with('movie_actors',$movie_actors)
            ->with('categories',$categories)
            ->with('actors',$actors);
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
