<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Matches;
use App\Models\Leagues;
use App\Models\Clubs;
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
            $divided = explode("T", $value);
            $value = $divided[0];
        }

        if ($column_name == "prob1" || $column_name == "prob2" || $column_name == "prob3") {
            if (str_contains($column_name, ",")) {
                $column_name = str_replace(",", ".", $column);
            }
        }

        if ($column_name == "team1" or $column_name == "team2") {
            $team_name = Matches::where("id", $data->output_id)->get();
            $team_name = $team_name[0]->$column_name;
            $update_team1 = Matches::where("team1", $team_name)->select("team1")->update(["team1"=>$value]);
            $update_team2 = Matches::where("team2", $team_name)->select("team2")->update(["team2"=>$value]);
            $clubs = Clubs::where("538_name", $team_name)->get();
            $name_col = "538_name";
            if (count($clubs) == 0) {
                $clubs = Clubs::where("our_name", $team_name)->get();
                $name_col = "our_name";
            }



            $update_clubs = Clubs::where($name_col, $team_name)->select("our_name")->update(["our_name"=>$value]);

            
        } else {
            $update_value = Matches::where("id", $data->output_id)->update([$column_name=>$value]);
        }

        return redirect()->route('adm_home');
    }

    public function update_league(Request $data) {
        $old_league_name = $data->old_leag_name;
        //$update_matches = Matches::where("league", $old_league_name)->update(["league"=>$data->new_leag_name]);
        $update_value = Leagues::where("name_538", $old_league_name)->update(["our_name"=>$data->new_leag_name]);
        return redirect()->route('adm_home');
    }

    public function new_match(Request $data) {
        $league_id = Leagues::where("name_538", $data->league)->select("538_league_id")->get();
        if (count($league_id) == 0) {
            $league_id = Leagues::where("our_name", $data->league)->select("538_league_id")->get();
        }

        $new_match = new Matches();
        $date = $data->date;
        if (!is_null($date)) {
            $divided = explode("T", $date);
            $new_match->date = $divided[0];
        }

        $new_match->team1 = $data->team;
        $new_match->team2 = $data->team2;
        $new_match->league = $data->league;
        $new_match->prob1 = $data->prob1;
        $new_match->probtie = $data->probtie;
        $new_match->prob2 = $data->prob2;
        $new_match->season = 2021;
        $new_match->league_id = $league_id[0]->{'538_league_id'};
        $new_match->save();
        return redirect()->route('adm_home');
    }

    public function new_team(Request $data) {
        
        $country_list = Leagues::where("name_538", $data->team_league_name)->get();

        if (count($country_list) == 0) {
            $country_list = Leagues::where("our_name", $data->team_league_name)->get();
        }


        $country = $country_list[0]->country;
        $new_team = new Clubs();
        $new_team->league = $data->team_league_name;
        $new_team->our_name = $data->new_team;
        $new_team->save();

        $data->session()->put("team_country", $country);
        $data->session()->put("leag_country", "");
        $data->session()->put("league", $data->team_league_name);
        return redirect()->route('adm_add');
    }

    public function new_league(Request $data) {
        // zatím bude custom league_id s random číslem, později to nějak vyřešíme
        $old_country = Leagues::where("country", $data->leag_country_name)->whereNull("538_league_id")->delete();
        $league_id = Leagues::orderBy("id", "DESC")->take(1)->select("id")->get();
        $new_league = new Leagues();
        $new_league->sport = "Football";
        $new_league->country = $data->leag_country_name;
        $new_league->our_name = $data->new_league;
        $new_league->{'538_league_id'} = $league_id[0]->id;
        $new_league->save();
        $data->session()->put("team_country", "");
        $data->session()->put("leag_country", $data->leag_country_name);
        $data->session()->put("league", "");
        return redirect()->route('adm_add');
    }

    public function new_country(Request $data) {
        $country = $data->new_country;
        $leag = new Leagues();
        $leag->country = $country;
        $leag->save();
        return redirect()->route('adm_add_country');
    }

    public function upload_logo(Request $data) {
        $this->validate($data, [
            "new_logo"=>"required"
        ]);
        $team = $data->team_hidden . ".png";
        $path = $data->file("new_logo")->storeAs("", $team);
        $data->session()->put("team_logo", $data->team_hidden);
        $data->session()->put("league_logo", $data->league_hidden);
        $data->session()->put("country_logo", $data->country_hidden);
        return redirect()->route("adm_logo");
    }

    public function update_lock(Request $data) {
        $match = Matches::where("id", $data->match_id)->get();
        if ($match[0]->changeable == 1) {
            $match[0]->changeable = 0;
        } else {
            $match[0]->changeable = 1;
        }

        $match[0]->save();

        return redirect()->route("adm_home");
    }

    public function country_fill(Request $data) {
        $empty_countries = Leagues::where("country", "Default")->get();
        foreach ($empty_countries as $country) {
            $name = $country->name_538;
            $new_name = str_replace(" ", "_", $name);
            $value = $data->$new_name;
            if (!is_null($value)) {
                $country->country = $value;
                $country->save();
            }
        }
    }
}