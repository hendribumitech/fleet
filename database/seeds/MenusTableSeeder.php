<?php

use App\Models\Base\MenusTree;
use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('menus')->delete();
        
        \DB::table('menus')->insert(array (
            0 => 
            array (                
                'created_at' => '2021-08-09 08:10:07',
                'description' => 'Header menu master',
                'icon' => 'cil-address-book',
                'id' => 1,
                'name' => 'Master Data',
                'parent_id' => NULL,
                'route' => NULL,
                'seq_number' => 1,
                'status' => '1',
                'updated_at' => '2021-10-29 14:51:54',
            ),            
            1 => 
            array (             
                'created_at' => '2021-08-09 08:10:07',
                'description' => 'Manage menu',
                'icon' => 'cil-address-book',
                'id' => 2,
                'name' => 'Menu',
                'parent_id' => 1,
                'route' => 'base/menus',
                'seq_number' => 1,
                'status' => '1',
                'updated_at' => '2021-10-29 14:51:53',
            ),
            3 => 
            array (                
                'created_at' => '2021-08-09 08:10:07',
                'description' => 'Manage users',
                'icon' => 'cil-address-book',
                'id' => 3,
                'name' => 'User',
                'parent_id' => 1,
                'route' => 'base/users',
                'seq_number' => 2,
                'status' => '1',
                'updated_at' => '2021-10-29 14:51:54',
            ),
            4 => 
            array (                
                'created_at' => '2021-08-09 08:10:07',
                'description' => 'Manage role',
                'icon' => 'cil-address-book',
                'id' => 4,
                'name' => 'Role',
                'parent_id' => 1,
                'route' => 'base/roles',
                'seq_number' => 3,
                'status' => '1',
                'updated_at' => '2021-10-29 14:51:54',
            ),
            5 => 
            array (                
                'created_at' => '2021-08-09 08:10:07',
                'description' => 'Manage permissions',
                'icon' => 'cil-address-book',
                'id' => 5,
                'name' => 'Permission',
                'parent_id' => 1,
                'route' => 'base/permissions',
                'seq_number' => 1,
                'status' => '1',
                'updated_at' => '2021-10-29 14:51:54',
            )            
        ));           

        MenusTree::fixTree();
    }
}