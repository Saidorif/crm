<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attestat;
use App\User;
use DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $result = [];
        //Tests count by status
        $tests = DB::table('attestats')
                 ->select('status', DB::raw('count(*) as total'))
                 ->groupBy('status')
                 ->get();
        
        //Users count by gender
        $users = Db::table('users')
                ->select('gender', DB::raw('count(*) as total'))
                ->groupBy('gender')
                ->get();

        //Users by age
        $empls = User::all();
        $result['ages']['18-30'] = 0;
        $result['ages']['31-45'] = 0;
        $result['ages']['46-60'] = 0;
        $result['ages']['60-100'] = 0;

        foreach ($empls as $key => $e) {
            $age = $e->getAge();
            if($age > 18 && $age <= 30){
                $result['ages']['18-30'] = $result['ages']['18-30'] + 1;
            }
            if($age > 30 && $age <= 45){
                $result['ages']['31-45'] = $result['ages']['31-45'] + 1;
            }
            if($age > 45 && $age <= 60){
                $result['ages']['46-60'] = $result['ages']['46-60'] + 1;
            }
            if($age > 60){
                $result['ages']['60-100'] = $result['ages']['60-100'] + 1;
            }
        }

        $result['tests'] = $tests;
        $result['users'] = $users;
        return response()->json(['success' => true, 'result' => $result]);
    }
}
