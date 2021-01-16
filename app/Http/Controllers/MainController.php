<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use App\Models\Word;
use App\Models\Score;
use App\Models\Log;
use stdClass;

class MainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $uid = Cookie::get('userid');
        if (!$uid) {
            $response = new Response('Set Cookie');
            $random = Str::random(10);
            Cookie::queue(Cookie::make('userid', $random));
        }
        $scrambledwords = str_split("NIAVTCOAU", 1);
        $score = Score::where('user_id', $uid)->first();
        return view('welcome', compact('scrambledwords', 'uid', 'score'));
    }

    public function check(Request $request)
    {
        $check = Word::where('name', $request->word)->count();
        $uid = Cookie::get('userid');
        $score = Score::where('user_id', $uid)->first();
        $logExist = Log::where('user_id', $uid)->where('word', $request->word)->count();

        $result = new stdClass();
        $result->status = $check ? true : false;
        
        if ($logExist) {
            $result->status = false;
            $result->message = "This word already submited";
            return response()->json($result);
        }

        if ($check) {
            $value = $score ? $score->score : 0;
            Score::updateOrCreate(
                ['user_id' => $uid],
                ['score' => $value + 50]
            );
            $result->message = "Correct!";
        } else {
            $value = $score ? $score->score -30 : 0;
            if ($value < 0) {
                $value = 0;
            }
            Score::updateOrCreate(
                ['user_id' => $uid],
                ['score' => $value]
            );
            $result->message = "Incorrect!";
        }
        Log::create([
            'user_id' => $uid,
            'word' => $request->word
        ]);
        $result->score = Score::where('user_id', $uid)->first();
        return response()->json($result);
    }

    public function score(Request $request)
    {
        return Score::where('user_id', $request->id)->first();
    }

    public function dashboard(Request $request)
    {
        $data = Score::get();
        return view('dashboard', compact(('data')));
    }
}
