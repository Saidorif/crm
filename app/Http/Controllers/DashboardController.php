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
        //Tests count by months
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
            if($key == 12){
                $nextM = $key;
            }else{
                $nextM = $key + 1;
            }
            $date_from = date('Y-'.$key.'-01 00:00:00');
            $date_to = date('Y-'.$nextM.'-01 23:59:59');
            $test = DB::table('attestats')
                 ->whereBetween('ended_at', [$date_from, $date_to])
                 ->count();
            $testsByMonth[$value] = $test;
        }
        //Users
        $users = Db::table('users')->get();

        //Users by age
        $attestats = Attestat::all();
        $result['ages']['18-30']['count'] = 0;
        $result['ages']['18-30']['percent'] = 0;
        $result['ages']['31-45']['count'] = 0;
        $result['ages']['31-45']['percent'] = 0;
        $result['ages']['46-60']['count'] = 0;
        $result['ages']['46-60']['percent'] = 0;
        $result['ages']['60-100']['count'] = 0;
        $result['ages']['60-100']['percent'] = 0;

        foreach ($attestats as $key => $a) {
            $age = $a->getAge();
            //Sort by age
            if($age > 18 && $age <= 30){
                $result['ages']['18-30']['count'] = $result['ages']['18-30']['count'] + 1;
                $percent = ($a->true_answers / $a->limit) * 100;
                $result['ages']['18-30']['percent'] = ($result['ages']['18-30']['percent'] + $percent) / $result['ages']['18-30']['count'];
            }
            if($age > 30 && $age <= 45){
                $result['ages']['31-45']['count'] = $result['ages']['31-45']['count'] + 1;
                $percent = ($a->true_answers / $a->limit) * 100;
                $result['ages']['31-45']['percent'] = ($result['ages']['31-45']['percent'] + $percent) / $result['ages']['31-45']['count'];
            }
            if($age > 45 && $age <= 60){
                $result['ages']['46-60']['count'] = $result['ages']['46-60']['count'] + 1;
                $percent = ($a->true_answers / $a->limit) * 100;
                $result['ages']['46-60']['percent'] = ($result['ages']['46-60']['percent'] + $percent) / $result['ages']['46-60']['count'];
            }
            if($age > 60){
                $result['ages']['60-100']['count'] = $result['ages']['60-100']['count'] + 1;
                $percent = ($a->true_answers / $a->limit) * 100;
                $result['ages']['60-100']['percent'] = ($result['ages']['60-100']['percent'] + $percent) / $result['ages']['60-100']['count'];
            }
        }

        $result['tests'] = $testsByMonth;
        return response()->json(['success' => true, 'result' => $result]);
    }
}
