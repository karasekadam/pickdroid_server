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

        $data->session()->put("user", $data->email);

        $matches = $this->general->getMatches();
        $leagues = $this->general->getLeagues();
        $countries = $this->general->getCountries();
        return redirect()->route("home");
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
        return redirect()->route('adm_blog');
    }

    public function update_match(Request $data) {
        $column_name = $data->column_name;
        $update_value = Matches::where("id", $data->output_id)->update([$column_name=>$data->$column_name]);
        return redirect()->route('adm_home');
    }

    public function new_match(Request $data) {
        $new_match = new Matches();
        $new_match->date = $data->date;
        $new_match->team1 = $data->team1;
        $new_match->team2 = $data->team2;
        $new_match->spi1 = $data->spi1;
        $new_match->spi2 = $data->spi2;
        $new_match->prob1 = $data->prob1;
        $new_match->save();
        return redirect()->route('adm_home');
    }

}