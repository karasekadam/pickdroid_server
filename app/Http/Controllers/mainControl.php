<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Matches;
use App\Models\Leagues;
use App\Models\Other_values;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\General;

class mainControl extends Controller
{

    public function __construct() {
        $this->general = new General();
    }


    public function check_login(Request $data) {
    	$this->validate($data, [
            "email"=>"required",
            "password"=>"required"
        ]);

        $user = User::where("email", $data->email)->get();
        if (!$user->first() or !(Hash::check($data->password, $user->first()->password))) {
        	return redirect()->route("login");
        }


        $matches = $this->general->getMatches();
        $leagues = $this->general->getLeagues();
        $countries = $this->general->getCountries();
        return redirect()->route("home", ["matches"=>$matches, "leagues"=>$leagues, "countries"=>$countries]);
    }

    public function check_reg(Request $data) {


    	$this->validate($data, [
            "name"=>"required",
            "password"=>"required"
        ]);

        $user = User::where("email", $data->email)->get();
        if($user->first()) {
        	return redirect()->route("login");
        }

        // checknout ostatní mrdky, délku hesla, velký písmena atd

        $user = new User();
        $user->name = $data->name;
        $user->email = $data->email;
        $user->fill([
            'password' => Hash::make($data->password)
        ])->save();
        $user->save();
        
        $leagues = $this->general->getLeagues();
        $countries = $this->general->getCountries();
        return view('success_reg', ["leagues"=>$leagues, "countries"=>$countries]);
    }

    public function update_other(Request $data) {
        $field = $data->edit_hidden;

        $others = Other_values::select("blog", "about_us")->update([$field=>$data->edit_area]);

        $leagues = $this->general->getLeagues();
        $countries = $this->general->getCountries();
        return redirect()->route('adm_blog', ["leagues"=>$leagues, "countries"=>$countries]);
    }

    public function update_match(Request $data) {
        return $data;
    }

}