<?php

use Illuminate\Database\Seeder;
use App\Conts;
use App\Action;

class ControllerActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $controllers = [
            'RoleController' => [
                'index',
                'store',
                'list',
                'edit',
                'update',
                'destroy',
            ],
            'EmployeeController' => [
                'index',
                'checkemail',
                'store',
                'list',
                'edit',
                'update',
                'destroy',
            ],
            'ContsController' => [
                'index',
                'find',
                'store',
                'update',
                'edit',
                'allContActions',
            ],
            'ActionController' => [
                'edit',
                'store',
                'update',
                'index',
            ],
            'PermissionController' => [
                'index',
                'store',
            ],
            'PositionController' => [
                'index',
                'list',
                'store',
                'edit',
                'update',
                'destroy',
            ],
            'UserController' => [
                'profile',
                'changePasword',
                'update',
            ],
            'DashboardController' => [
                'index',
            ],
            'TestCategoryController' => [
                'index',
                'store',
                'edit',
                'list',
                'update',
                'destroy',
            ],
            'QuestionController' => [
                'index',
                'store',
                'edit',
                'update',
                'destroy',
            ],
            'AttestatController' => [
                'index',
                'userindex',
                'attestat',
                'startTestUser',
                'complete',
                'show',
            ],
        ];
        foreach($controllers as $key => $controller){
            $cont = Conts::create([
                'name' => $key,
                'label' => $key,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            if($cont){
                foreach($controller as $key => $item){
                    $ation = DB::table('actions')->insert([
                        'conts_id' => $cont->id,
                        'code' => $item,
                        'name' => $item,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
