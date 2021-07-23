<?php

namespace App\Http\Controllers;

use App\Actor;
use App\Category;
use App\Movie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
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
        $movies = Movie::with('featuredPhoto')->orderBy('release_date', 'desc')->get();
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //validate user's input
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
            'images' => 'array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'videos' => 'array',
            'videos.*'  => 'mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi'
        ]);


        //setting Movie's general data & creating it
        $movie = new Movie();
        $movie->title = $request->title;
        $movie->description = $request->description;
        $movie->release_date = $request->release_date;
        $movie->production_date = $request->production_date;
        $movie->save();

        //attach movie's categories
        $movie->categories()->attach($request->categories);

        //prepare movie's actors data and attach them
        $attach_actors_data = [];
        foreach($request->actors as $key => $actor)
            $attach_actors_data[$actor] = ['name_in_movie' => $request->names_in_movie[$key]];
        $movie->actors()->attach($attach_actors_data);


        //uploading movie's medias (images,videos) & saving to db

        $medias = [];
        if($request->images) {
            foreach ($request->images as $image) {
                $ext = $image->extension();
                $newName = $movie->id . "-" . md5(time()) . explode('.', $image->getClientOriginalName())[0] . "." . $ext;
                $image->storeAs('movies-medias', $newName, ['disk' => 'public']);
                $medias[] = ['type' => 'image', 'media_name' => $newName];
            }
        }

        if($request->videos) {
            foreach ($request->videos as $video) {
                $ext = $video->extension();
                $newName = $movie->id . "-" . md5(time()) . explode('.', $video->getClientOriginalName())[0] . "." . $ext;
                $video->storeAs('movies-medias', $newName, ['disk' => 'public']);
                $medias[] = ['type' => 'video', 'media_name' => $newName];
            }
        }

        if(isset($medias))
            $movie->medias()->createMany($medias);


        //saving again
        $movie->save();

        session()->flash('success' , 'Movie created successfully');
        return redirect()->route('movies.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show($id)
    {

        $movie = Movie::with('categories')->with('actors')->with('medias')->find($id);
        return view('movies.show')->with('movie',$movie);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        $movie = Movie::find($id);
        $categories = Category::all();
        $actors = Actor::all();

        //get selected categories  ids - for frontend usage
        $movie_categories_ids = array();
        $movie_categories = $movie->categories()->get();
        foreach($movie_categories as $cat){
            array_push($movie_categories_ids,$cat->id);
        }

        //get selected actors  ids & their names in the movie - for frontend usage
        $movie_actors_ids = array();
        $movie_actors = $movie->actors()->get();
        foreach($movie_actors as $movie_actor){
            $movie_actors_ids[$movie_actor->id] = $movie_actor->pivot->name_in_movie;
        }

        //get current movie's medias for frontend usage
        $medias = $movie->medias()->get();

        //return edit view with all data
        return view('cms.movies.edit')
            ->with('movie',$movie)
            ->with('categories',$categories)
            ->with('actors',$actors)
            ->with('movie_categories',$movie_categories_ids)
            ->with('movie_actors',$movie_actors_ids)
            ->with('medias',$medias);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {

        //validate user's input
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
            'medias_to_delete_ids' => 'array',
            'medias_to_delete_ids.*' => 'integer',
            'medias_to_delete_names' => 'array',
            'medias_to_delete_names.*' => 'string',
            'images' => 'array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'videos' => 'array',
            'videos.*'  => 'mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi'
        ]);


        //Find movie and change its general  data
        $movie = Movie::find($id);
        $movie->title = $request->title;
        $movie->description = $request->description;
        $movie->release_date = $request->release_date;
        $movie->production_date = $request->production_date;

        //sync movie's categories (insert new ones and delete not mentioned ones)
        $movie->categories()->sync($request->categories);

        //prepare movie's actors data and sync them (insert new ones and delete not mentioned ones)
        $attach_actors_data = [];
        foreach($request->actors as $key => $actor)
            $attach_actors_data[$actor] = ['name_in_movie' => $request->names_in_movie[$key]];
        $movie->actors()->sync($attach_actors_data);


        //deleting media requested to be deleted (from files & db records)
        if($request->medias_to_delete_ids && $request->medias_to_delete_names) {
            foreach ($request->medias_to_delete_ids as $key => $id) {
                //delete  image
                $media_path = "storage/movies-medias/" . $request->medias_to_delete_names[$key];
                if (File::exists($media_path)) {
                    File::delete($media_path);
                }
            }
            $movie->medias()->whereIn('id', $request->medias_to_delete_ids)->delete();
        }


        //uploading new movie medias(images,videos) & saving to db

        $medias = [];

        if($request->images) {
            foreach ($request->images as $image) {
                $ext = $image->extension();
                $newName = $movie->id . "-" . md5(time()) . explode('.', $image->getClientOriginalName())[0] . "." . $ext;
                $image->storeAs('movies-medias', $newName, ['disk' => 'public']);
                $medias[] = ['type' => 'image', 'media_name' => $newName];
            }
        }

        if($request->videos) {
            foreach ($request->videos as $video) {
                $ext = $video->extension();
                $newName = $movie->id . "-" . md5(time()) . explode('.', $video->getClientOriginalName())[0] . "." . $ext;
                $video->storeAs('movies-medias', $newName, ['disk' => 'public']);
                $medias[] = ['type' => 'video', 'media_name' => $newName];
            }

        }
        if(isset($medias))
            $movie->medias()->createMany($medias);

        //saving to db
        $movie->save();

        session()->flash('success' , 'Movie updated successfully');
        return redirect()->route('movies.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $movie = Movie::find($id);


        //remove movie's attached categories and actors from db
        $movie->categories()->detach();
        $movie->actors()->detach();

        //delete movie's media from storage & db
        $medias_to_delete_ids = [];
        $medias_to_delete_names = [];
        $medias = $movie->medias()->get();
        foreach ($medias as $media){
            $medias_to_delete_ids[] = $media->id;
            $medias_to_delete_names[] = $media->media_name;
        }

        if(isset($medias_to_delete_ids) && isset($medias_to_delete_names)) {
            //deleting media from storage
            foreach ($medias_to_delete_names as $medias_to_delete_name) {
                //delete  image
                $media_path = "storage/movies-medias/" . $medias_to_delete_name;
                if (File::exists($media_path)) {
                    File::delete($media_path);
                }
            }
            //deleting media from db
            $movie->medias()->whereIn('id', $medias_to_delete_names)->delete();
        }

        //delete movie record from db
        $movie->delete();

        session()->flash('success', 'Actor deleted successfully');
        return redirect()->route('movies.index');
    }

    public function get_movies(){
        $movies = Movie::with('featuredPhoto')->orderBy('release_date', 'desc')->paginate(3);
        return view('movies.index')->with('movies',$movies);
    }

    public function search_movies(Request $request){
        $movies = Movie::with('featuredPhoto')->where('title','LIKE','%' . $request->title . '%')->orderBy('release_date', 'desc')->paginate(5);
        session()->flash('success', 'Displaying Search Results');
        return view('movies.index')->with('movies',$movies);
    }
}
