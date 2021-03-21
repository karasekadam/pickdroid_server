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
        if ($data->email == "admin") {
            return redirect()->route("adm_home");
        }
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
        $top_leagues = $this->general->getTopLeagues();
        $countries = $this->general->getCountries();
        return view('success_reg', ["leagues"=>$leagues, "top_leagues"=>$top_leagues, "countries"=>$countries]);
    }

    public function logout(Request $data) {
        $data->session()->put("user", "");
        return redirect()->route("home");
    }

    public function update_other(Request $data) {
        $field = $data->edit_hidden;


        $others = Other_values::select("blog", "about_us")->update([$field=>$data->edit_area]);

        $leagues = $this->general->getLeagues();
        $countries = $this->general->getCountries();
        $route = str_replace("_", "", $field);
        return redirect()->route('adm_' . $route);
    }

    public function update_match(Request $data) {
        $column_name = $data->column_name;
        $value = $data->$column_name;
        if ($column_name == "date") {
            $splitted = explode(".", $value);
            if ($splitted[1] < 10 and (substr($splitted[1], 0, 1) != "0")) {
                $splitted[1] = "0" . $splitted[1];
            }

            $value = "2021-" . $splitted[1] . "-" . $splitted[0];
        }
        $update_value = Matches::where("id", $data->output_id)->update([$column_name=>$value]);
        return redirect()->route('adm_home');
    }

    public function update_league(Request $data) {
        $league_name = $data->old_leag_name;
        $update_value = Leagues::where("name_538", $league_name)->update(["name_538"=>$data->new_leag_name]);
        return redirect()->route('adm_home');
    }

    public function new_match(Request $data) {
        $date = $data->date;
        if (!is_null($date)) {
            $splitted = explode(".", $date);
            if ($splitted[1] < 10 and (substr($splitted[1], 0, 1) != "0")) {
                $splitted[1] = "0" . $splitted[1];
            }
            
            $date = "2021-" . $splitted[1] . "-" . $splitted[0];
        }

        $new_match = new Matches();
        $new_match->date = $date;
        $new_match->team1 = $data->team1;
        $new_match->team2 = $data->team2;
        $new_match->prob1 = $data->prob1;
        $new_match->probtie = $data->probtie;
        $new_match->prob2 = $data->prob2;
        $new_match->save();
        return redirect()->route('adm_home');
    }
}