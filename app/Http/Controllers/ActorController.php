<?php

namespace App\Http\Controllers;

use App\Actor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $actors = Actor::all();
        return view('cms.actors.index')->with('actors',$actors);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        return view('cms.actors.create');
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
            'fname' => 'required|string',
            'lname' => 'required|string',
            'gender' => 'required|in:male,female,other',
            'dob' => 'required|date',
            'country' =>  ['required',Rule::in(["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua  Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia &amp; Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Cape Verde","Cayman Islands","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cruise Ship","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kuwait","Kyrgyz Republic","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Mauritania","Mauritius","Mexico","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Namibia","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Norway","Oman","Pakistan","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre &amp; Miquelon","Samoa","San Marino","Satellite","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","South Africa","South Korea","Spain","Sri Lanka","St Kitts &amp; Nevis","St Lucia","St Vincent","St. Lucia","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad &amp; Tobago","Tunisia","Turkey","Turkmenistan","Turks &amp; Caicos","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","Uruguay","Uzbekistan","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"]) ],
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096'
            ]);


        //set actor general data
        $actor = new Actor();
        $actor->first_name = $request->fname;
        $actor->last_name = $request->lname;
        $actor->gender = $request->gender;
        $actor->date_of_birth = $request->dob;
        $actor->country = $request->country;

        //upload and set image if requested
        if($request->image){
            $ext = $request->image->extension();
            $newName = $request->fname . "-" . $request->lname . "-" . md5(time()) . "." . $ext;
            $request->image->storeAs('actors-images',$newName,['disk' => 'public']);
            $actor->image_name = $newName;
        }

        //save record to db
        $actor->save();

        session()->flash('success' , 'Actor created successfully');
        return redirect()->route('actors.index');

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit($id)
    {
        $actor = Actor::find($id);
        return view('cms.actors.edit')->with('actor',$actor);
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
            'fname' => 'required|string',
            'lname' => 'required|string',
            'gender' => 'required|in:male,female,other',
            'dob' => 'required|date',
            'country' =>  ['required',Rule::in(["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua  Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia &amp; Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Cape Verde","Cayman Islands","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cruise Ship","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kuwait","Kyrgyz Republic","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Mauritania","Mauritius","Mexico","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Namibia","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Norway","Oman","Pakistan","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre &amp; Miquelon","Samoa","San Marino","Satellite","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","South Africa","South Korea","Spain","Sri Lanka","St Kitts &amp; Nevis","St Lucia","St Vincent","St. Lucia","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad &amp; Tobago","Tunisia","Turkey","Turkmenistan","Turks &amp; Caicos","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States","Uruguay","Uzbekistan","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"]) ],
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096'
        ]);


        //find actor and change general data
        $actor = Actor::find($id);
        $actor->first_name = $request->fname;
        $actor->last_name = $request->lname;
        $actor->gender = $request->gender;
        $actor->date_of_birth = $request->dob;
        $actor->country = $request->country;

        //change image if requested
        if($request->image){
            //delete old image if it exists
            $image_path = "storage/actors-images/" . $actor->image_name;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            //insert new one
            $ext = $request->image->extension();
            $newName = $request->fname . "-" . $request->lname . "-" . md5(time()) . "." . $ext;
            $request->image->storeAs('actors-images',$newName,['disk' => 'public']);
            $actor->image_name = $newName;
        }

        //save record to db
        $actor->save();

        session()->flash('success' , 'Actor updated successfully');
        return redirect()->route('actors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $actor = Actor::find($id);
        if($actor->movies()->count() != 0)
            return redirect()->route('actors.index')->withErrors('Can not delete this actor, he/she is included in some movies !');

        else {
            //delete  image
            $image_path = "storage/actors-images/" . $actor->image_name;
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
            //delete actor from fb
            $actor->delete();

            session()->flash('success', 'Actor deleted successfully');
            return redirect()->route('actors.index');
        }
    }

    public function get_actors(){
        $actors =  Actor::paginate(3);
        return view('actors.index')->with('actors',$actors);
    }

    public function search_actors(Request $request){
        $this->validate($request,[
            'name' => 'required|string|max:255'
        ]);


        //does not work in this laravel version
        //$actors = Actor::whereRaw("concat(first_name, ' ', last_name) LIKE '%:name%' ",['name' => $request->name])->get();
        //$actors = DB::raw('select * from actors where concat(first_name, \' \', last_name) LIKE :name', ['name' => $request->name]);

        $actors = Actor::where('first_name','LIKE','%' . $request->name . '%')->orWhere('last_name','LIKE','%' . $request->name . '%')->paginate(5);
        return view('actors.index')->with('actors',$actors);
    }
}
