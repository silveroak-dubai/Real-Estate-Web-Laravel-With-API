<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Dashboard Module with Permission
        $dashboardModule = Module::updateOrCreate(['name'=>'Dashboard Permission'],['name'=>'Dashboard Permission']);
        Permission::updateOrInsert(['slug'=>'dashboard-access'],['module_id'=>$dashboardModule->id,'name'=>'Access','slug'=>'dashboard-access']);

        // User Module with Permission
        $userModule = Module::updateOrCreate(['name'=>'User Permission'],['name'=>'User Permission']);
        Permission::updateOrInsert(['slug'=>'user-access'],['module_id'=>$userModule->id,'name'=>'Access','slug'=>'user-access']);
        Permission::updateOrInsert(['slug'=>'user-create'],['module_id'=>$userModule->id,'name'=>'Create','slug'=>'user-create']);
        Permission::updateOrInsert(['slug'=>'user-edit'],['module_id'=>$userModule->id,'name'=>'Edit/Update','slug'=>'user-edit']);
        Permission::updateOrInsert(['slug'=>'user-active'],['module_id'=>$userModule->id,'name'=>'Is Active','slug'=>'user-active']);
        Permission::updateOrInsert(['slug'=>'user-delete'],['module_id'=>$userModule->id,'name'=>'Delete','slug'=>'user-delete']);
        Permission::updateOrInsert(['slug'=>'user-bulk-delete'],['module_id'=>$userModule->id,'name'=>'Bulk Delete','slug'=>'user-bulk-delete']);
        Permission::updateOrInsert(['slug'=>'user-view'],['module_id'=>$userModule->id,'name'=>'View','slug'=>'user-view']);

        // Blog Module
        $blogModule = Module::updateOrCreate(['name'=>'Blog Permission'],['name'=>'Blog Permission']);
        Permission::updateOrInsert(['slug'=>'blog-access'],['module_id'=>$blogModule->id,'name'=>'Access','slug'=>'blog-access']);
        Permission::updateOrInsert(['slug'=>'blog-create'],['module_id'=>$blogModule->id,'name'=>'Create','slug'=>'blog-create']);
        Permission::updateOrInsert(['slug'=>'blog-edit'],['module_id'=>$blogModule->id,'name'=>'Edit/Update','slug'=>'blog-edit']);
        Permission::updateOrInsert(['slug'=>'blog-active'],['module_id'=>$blogModule->id,'name'=>'Is Active','slug'=>'blog-active']);
        Permission::updateOrInsert(['slug'=>'blog-delete'],['module_id'=>$blogModule->id,'name'=>'Delete','slug'=>'blog-delete']);
        Permission::updateOrInsert(['slug'=>'blog-bulk-delete'],['module_id'=>$blogModule->id,'name'=>'Bulk Delete','slug'=>'blog-bulk-delete']);
        Permission::updateOrInsert(['slug'=>'blog-view'],['module_id'=>$blogModule->id,'name'=>'View','slug'=>'blog-view']);
    }
}
