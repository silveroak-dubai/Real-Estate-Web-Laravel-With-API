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

        // Our Banks Module
        $ourBanksModule = Module::updateOrCreate(['name'=>'Our Banks Permission'],['name'=>'Our Banks Permission']);
        Permission::updateOrInsert(['slug'=>'our-banks-access'],['module_id'=>$ourBanksModule->id,'name'=>'Access','slug'=>'our-banks-access']);
        Permission::updateOrInsert(['slug'=>'our-banks-create'],['module_id'=>$ourBanksModule->id,'name'=>'Create','slug'=>'our-banks-create']);
        Permission::updateOrInsert(['slug'=>'our-banks-edit'],['module_id'=>$ourBanksModule->id,'name'=>'Edit/Update','slug'=>'our-banks-edit']);
        Permission::updateOrInsert(['slug'=>'our-banks-active'],['module_id'=>$ourBanksModule->id,'name'=>'Is Active','slug'=>'our-banks-active']);
        Permission::updateOrInsert(['slug'=>'our-banks-delete'],['module_id'=>$ourBanksModule->id,'name'=>'Delete','slug'=>'our-banks-delete']);
        Permission::updateOrInsert(['slug'=>'our-banks-bulk-delete'],['module_id'=>$ourBanksModule->id,'name'=>'Bulk Delete','slug'=>'our-banks-bulk-delete']);
        Permission::updateOrInsert(['slug'=>'our-banks-view'],['module_id'=>$ourBanksModule->id,'name'=>'View','slug'=>'our-banks-view']);

        // Faq Module
        $faqModule = Module::updateOrCreate(['name'=>'Faq Permission'],['name'=>'Faq Permission']);
        Permission::updateOrInsert(['slug'=>'faq-access'],['module_id'=>$faqModule->id,'name'=>'Access','slug'=>'faq-access']);
        Permission::updateOrInsert(['slug'=>'faq-create'],['module_id'=>$faqModule->id,'name'=>'Create','slug'=>'faq-create']);
        Permission::updateOrInsert(['slug'=>'faq-edit'],['module_id'=>$faqModule->id,'name'=>'Edit/Update','slug'=>'faq-edit']);
        Permission::updateOrInsert(['slug'=>'faq-active'],['module_id'=>$faqModule->id,'name'=>'Is Active','slug'=>'faq-active']);
        Permission::updateOrInsert(['slug'=>'faq-delete'],['module_id'=>$faqModule->id,'name'=>'Delete','slug'=>'faq-delete']);
        Permission::updateOrInsert(['slug'=>'faq-bulk-delete'],['module_id'=>$faqModule->id,'name'=>'Bulk Delete','slug'=>'faq-bulk-delete']);
        Permission::updateOrInsert(['slug'=>'faq-view'],['module_id'=>$faqModule->id,'name'=>'View','slug'=>'faq-view']);
    }
}
