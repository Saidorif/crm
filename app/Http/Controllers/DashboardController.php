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
        $months = [
            1 => 'Январь',
            2 => 'Февраль',
            3 => 'Март',
            4 => 'Апрель',
            5 => 'Май',
            6 => 'Июнь',
            7 => 'Июль',
            8 => 'Август',
            9 => 'Сентябр',
            10 => 'Октябр',
            11 => 'Ноябр',
            12 => 'Декабр'
        ];
        $testsByMonth = [];
        foreach ($months as $key => $value) {
            $nextM = $key + 1;
            $date_from = date('Y-'.$key.'-01 00:00:00');
            $date_to = date('Y-'.$nextM.'-01 23:59:59');
            $test = DB::table('attestats')
                 ->whereBetween('ended_at', [$date_from, $date_to])
                 ->count();
            $testsByMonth[$value] = $test;
        }
        // $testsByMonth = DB::table('attestats')
        //          ->select('status', DB::raw('count(*) as total'))
        //          ->groupBy('status')
        //          ->get();
        
        //Users count by gender
        $users = Db::table('users')
                // ->select('gender', DB::raw('count(*) as total'))
                // ->groupBy('gender')
                ->get();

        //Users by age
        $attestats = Attestat::all();
        $result['ages']['18-30'] = 0;
        $result['ages']['31-45'] = 0;
        $result['ages']['46-60'] = 0;
        $result['ages']['60-100'] = 0;

        // $result['staj']['0-1'] = 0;
        // $result['staj']['1-3'] = 0;
        // $result['staj']['3-5'] = 0;
        // $result['staj']['5-7'] = 0;
        // $result['staj']['7-10'] = 0;
        // $result['staj']['10-50'] = 0;

        foreach ($attestats as $key => $a) {
            $age = $a->getAge();
            //Sort by age
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

            //Sort by staj
            // if($staj <= 1){
            //     $result['staj']['0-1'] = $result['staj']['0-1'] + 1;
            // }
            // if($staj > 1 && $staj <= 3){
            //     $result['staj']['1-3'] = $result['staj']['1-3'] + 1;
            // }
            // if($staj > 3 && $staj <= 5){
            //     $result['staj']['3-5'] = $result['staj']['3-5'] + 1;
            // }
            // if($staj > 5 && $staj <= 7){
            //     $result['staj']['5-7'] = $result['staj']['5-7'] + 1;
            // }
            // if($staj > 7 && $staj <= 10){
            //     $result['staj']['7-10'] = $result['staj']['7-10'] + 1;
            // }
            // if($staj > 10){
            //     $result['staj']['10-50'] = $result['staj']['10-50'] + 1;
            // }
        }

        $result['tests'] = $testsByMonth;
        // $result['attestats'] = $attestats;
        return response()->json(['success' => true, 'result' => $result]);
    }
}
