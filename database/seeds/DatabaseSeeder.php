<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = str_random(10);
        $user->email = str_random(10).'@gmail.com';
        $user->mobile = '13111111111';
        $user->password = bcrypt('123456');
        $user->save();

        // Create admin role.
        Role::create(['name' => 'admin']);
        $user->assignRole('admin');

        // Create default category.
        Category::create(['name' => '默认分类']);
    }
}
