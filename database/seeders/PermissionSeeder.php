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
        $dashboardModule = Module::updateOrCreate(['name'=>'Dashboard Permission'],['name'=>'Dashboard Permission','ordering'=>1]);
        Permission::updateOrInsert(['slug'=>'dashboard-access'],['module_id'=>$dashboardModule->id,'name'=>'Access','slug'=>'dashboard-access']);

        // User Module with Permission
        $userModule = Module::updateOrCreate(['name'=>'User Permission'],['name'=>'User Permission','ordering'=>2]);
        Permission::updateOrInsert(['slug'=>'user-access'],['module_id'=>$userModule->id,'name'=>'Access','slug'=>'user-access']);
        Permission::updateOrInsert(['slug'=>'user-create'],['module_id'=>$userModule->id,'name'=>'Create','slug'=>'user-create']);
        Permission::updateOrInsert(['slug'=>'user-edit'],['module_id'=>$userModule->id,'name'=>'Edit/Update','slug'=>'user-edit']);
        Permission::updateOrInsert(['slug'=>'user-status'],['module_id'=>$userModule->id,'name'=>'Status','slug'=>'user-status']);
        Permission::updateOrInsert(['slug'=>'user-delete'],['module_id'=>$userModule->id,'name'=>'Delete','slug'=>'user-delete']);
        Permission::updateOrInsert(['slug'=>'user-bulk-delete'],['module_id'=>$userModule->id,'name'=>'Bulk Delete','slug'=>'user-bulk-delete']);
        Permission::updateOrInsert(['slug'=>'user-view'],['module_id'=>$userModule->id,'name'=>'View','slug'=>'user-view']);

        // Blog Module with Permission
        $blogModule = Module::updateOrCreate(['name'=>'Blog Permission'],['name'=>'Blog Permission','ordering'=>10]);
        Permission::updateOrInsert(['slug'=>'blog-access'],['module_id'=>$blogModule->id,'name'=>'Access','slug'=>'blog-access']);
        Permission::updateOrInsert(['slug'=>'blog-create'],['module_id'=>$blogModule->id,'name'=>'Create','slug'=>'blog-create']);
        Permission::updateOrInsert(['slug'=>'blog-edit'],['module_id'=>$blogModule->id,'name'=>'Edit/Update','slug'=>'blog-edit']);
        Permission::updateOrInsert(['slug'=>'blog-status'],['module_id'=>$blogModule->id,'name'=>'Status','slug'=>'blog-status']);
        Permission::updateOrInsert(['slug'=>'blog-delete'],['module_id'=>$blogModule->id,'name'=>'Delete','slug'=>'blog-delete']);
        Permission::updateOrInsert(['slug'=>'blog-bulk-delete'],['module_id'=>$blogModule->id,'name'=>'Bulk Delete','slug'=>'blog-bulk-delete']);
        Permission::updateOrInsert(['slug'=>'blog-view'],['module_id'=>$blogModule->id,'name'=>'View','slug'=>'blog-view']);

        // Our Bank Module with Permission
        $bankModule = Module::updateOrCreate(['name'=>'Our Bank Permission'],['name'=>'Our Bank Permission','ordering'=>3]);
        Permission::updateOrInsert(['slug'=>'our-bank-access'],['module_id'=>$bankModule->id,'name'=>'Access','slug'=>'our-bank-access']);
        Permission::updateOrInsert(['slug'=>'our-bank-create'],['module_id'=>$bankModule->id,'name'=>'Create','slug'=>'our-bank-create']);
        Permission::updateOrInsert(['slug'=>'our-bank-edit'],['module_id'=>$bankModule->id,'name'=>'Edit/Update','slug'=>'our-bank-edit']);
        Permission::updateOrInsert(['slug'=>'our-bank-status'],['module_id'=>$bankModule->id,'name'=>'Status','slug'=>'our-bank-status']);
        Permission::updateOrInsert(['slug'=>'our-bank-delete'],['module_id'=>$bankModule->id,'name'=>'Delete','slug'=>'our-bank-delete']);
        Permission::updateOrInsert(['slug'=>'our-bank-bulk-delete'],['module_id'=>$bankModule->id,'name'=>'Bulk Delete','slug'=>'our-bank-bulk-delete']);

        // FAQ Module with Permission
        $faqModule = Module::updateOrCreate(['name'=>'FAQ Permission'],['name'=>'FAQ Permission','ordering'=>4]);
        Permission::updateOrInsert(['slug'=>'faq-access'],['module_id'=>$faqModule->id,'name'=>'Access','slug'=>'faq-access']);
        Permission::updateOrInsert(['slug'=>'faq-create'],['module_id'=>$faqModule->id,'name'=>'Create','slug'=>'faq-create']);
        Permission::updateOrInsert(['slug'=>'faq-edit'],['module_id'=>$faqModule->id,'name'=>'Edit/Update','slug'=>'faq-edit']);
        Permission::updateOrInsert(['slug'=>'faq-status'],['module_id'=>$faqModule->id,'name'=>'Status','slug'=>'faq-status']);
        Permission::updateOrInsert(['slug'=>'faq-delete'],['module_id'=>$faqModule->id,'name'=>'Delete','slug'=>'faq-delete']);
        Permission::updateOrInsert(['slug'=>'faq-bulk-delete'],['module_id'=>$faqModule->id,'name'=>'Bulk Delete','slug'=>'faq-bulk-delete']);

        // Achievement Module with Permission
        $achievementModule = Module::updateOrCreate(['name'=>'Achievement Permission'],['name'=>'Achievement Permission','ordering'=>5]);
        Permission::updateOrInsert(['slug'=>'achievement-access'],['module_id'=>$achievementModule->id,'name'=>'Access','slug'=>'achievement-access']);
        Permission::updateOrInsert(['slug'=>'achievement-create'],['module_id'=>$achievementModule->id,'name'=>'Create','slug'=>'achievement-create']);
        Permission::updateOrInsert(['slug'=>'achievement-edit'],['module_id'=>$achievementModule->id,'name'=>'Edit/Update','slug'=>'achievement-edit']);
        Permission::updateOrInsert(['slug'=>'achievement-status'],['module_id'=>$achievementModule->id,'name'=>'Status','slug'=>'achievement-status']);
        Permission::updateOrInsert(['slug'=>'achievement-delete'],['module_id'=>$achievementModule->id,'name'=>'Delete','slug'=>'achievement-delete']);
        Permission::updateOrInsert(['slug'=>'achievement-bulk-delete'],['module_id'=>$achievementModule->id,'name'=>'Bulk Delete','slug'=>'achievement-bulk-delete']);

        // Our Partner Module with Permission
        $ourPartnerModule = Module::updateOrCreate(['name'=>'Our Partner Permission'],['name'=>'Our Partner Permission','ordering'=>6]);
        Permission::updateOrInsert(['slug'=>'our-partner-access'],['module_id'=>$ourPartnerModule->id,'name'=>'Access','slug'=>'our-partner-access']);
        Permission::updateOrInsert(['slug'=>'our-partner-create'],['module_id'=>$ourPartnerModule->id,'name'=>'Create','slug'=>'our-partner-create']);
        Permission::updateOrInsert(['slug'=>'our-partner-edit'],['module_id'=>$ourPartnerModule->id,'name'=>'Edit/Update','slug'=>'our-partner-edit']);
        Permission::updateOrInsert(['slug'=>'our-partner-status'],['module_id'=>$ourPartnerModule->id,'name'=>'Status','slug'=>'our-partner-status']);
        Permission::updateOrInsert(['slug'=>'our-partner-delete'],['module_id'=>$ourPartnerModule->id,'name'=>'Delete','slug'=>'our-partner-delete']);
        Permission::updateOrInsert(['slug'=>'our-partner-bulk-delete'],['module_id'=>$ourPartnerModule->id,'name'=>'Bulk Delete','slug'=>'our-partner-bulk-delete']);

        // Department Module with Permission
        $departmentModule = Module::updateOrCreate(['name'=>'Department'],['name'=>'Department','ordering'=>7]);
        Permission::updateOrInsert(['slug'=>'department-access'],['module_id'=>$departmentModule->id,'name'=>'Access','slug'=>'department-access']);
        Permission::updateOrInsert(['slug'=>'department-create'],['module_id'=>$departmentModule->id,'name'=>'Create','slug'=>'department-create']);
        Permission::updateOrInsert(['slug'=>'department-edit'],['module_id'=>$departmentModule->id,'name'=>'Edit/Update','slug'=>'department-edit']);
        Permission::updateOrInsert(['slug'=>'department-status'],['module_id'=>$departmentModule->id,'name'=>'Status','slug'=>'department-status']);
        Permission::updateOrInsert(['slug'=>'department-delete'],['module_id'=>$departmentModule->id,'name'=>'Delete','slug'=>'department-delete']);
        Permission::updateOrInsert(['slug'=>'department-bulk-delete'],['module_id'=>$departmentModule->id,'name'=>'Bulk Delete','slug'=>'department-bulk-delete']);


        // Team Language Module with Permission
        $teamLanguageModule = Module::updateOrCreate(['name'=>'Team Language Permission'],['name'=>'Team Language Permission','ordering'=>7]);
        Permission::updateOrInsert(['slug'=>'team-language-access'],['module_id'=>$teamLanguageModule->id,'name'=>'Access','slug'=>'team-language-access']);
        Permission::updateOrInsert(['slug'=>'team-language-create'],['module_id'=>$teamLanguageModule->id,'name'=>'Create','slug'=>'team-language-create']);
        Permission::updateOrInsert(['slug'=>'team-language-edit'],['module_id'=>$teamLanguageModule->id,'name'=>'Edit/Update','slug'=>'team-language-edit']);
        Permission::updateOrInsert(['slug'=>'team-language-status'],['module_id'=>$teamLanguageModule->id,'name'=>'Status','slug'=>'team-language-status']);
        Permission::updateOrInsert(['slug'=>'team-language-delete'],['module_id'=>$teamLanguageModule->id,'name'=>'Delete','slug'=>'team-language-delete']);
        Permission::updateOrInsert(['slug'=>'team-language-bulk-delete'],['module_id'=>$teamLanguageModule->id,'name'=>'Bulk Delete','slug'=>'team-language-bulk-delete']);

        // Team Specialized Module with Permission
        $teamSpecializedModule = Module::updateOrCreate(['name'=>'Team Specialized Permission'],['name'=>'Team Specialized Permission','ordering'=>8]);
        Permission::updateOrInsert(['slug'=>'team-specialized-access'],['module_id'=>$teamSpecializedModule->id,'name'=>'Access','slug'=>'team-specialized-access']);
        Permission::updateOrInsert(['slug'=>'team-specialized-create'],['module_id'=>$teamSpecializedModule->id,'name'=>'Create','slug'=>'team-specialized-create']);
        Permission::updateOrInsert(['slug'=>'team-specialized-edit'],['module_id'=>$teamSpecializedModule->id,'name'=>'Edit/Update','slug'=>'team-specialized-edit']);
        Permission::updateOrInsert(['slug'=>'team-specialized-status'],['module_id'=>$teamSpecializedModule->id,'name'=>'Status','slug'=>'team-specialized-status']);
        Permission::updateOrInsert(['slug'=>'team-specialized-delete'],['module_id'=>$teamSpecializedModule->id,'name'=>'Delete','slug'=>'team-specialized-delete']);
        Permission::updateOrInsert(['slug'=>'team-specialized-bulk-delete'],['module_id'=>$teamSpecializedModule->id,'name'=>'Bulk Delete','slug'=>'team-specialized-bulk-delete']);;

        // Our Team Module with Permission
        $ourTeamModule = Module::updateOrCreate(['name'=>'Our Team Permission'],['name'=>'Our Team Permission','ordering'=>9]);
        Permission::updateOrInsert(['slug'=>'our-team-access'],['module_id'=>$ourTeamModule->id,'name'=>'Access','slug'=>'our-team-access']);
        Permission::updateOrInsert(['slug'=>'our-team-create'],['module_id'=>$ourTeamModule->id,'name'=>'Create','slug'=>'our-team-create']);
        Permission::updateOrInsert(['slug'=>'our-team-edit'],['module_id'=>$ourTeamModule->id,'name'=>'Edit/Update','slug'=>'our-team-edit']);
        Permission::updateOrInsert(['slug'=>'our-team-status'],['module_id'=>$ourTeamModule->id,'name'=>'Status','slug'=>'our-team-status']);
        Permission::updateOrInsert(['slug'=>'our-team-delete'],['module_id'=>$ourTeamModule->id,'name'=>'Delete','slug'=>'our-team-delete']);
        Permission::updateOrInsert(['slug'=>'our-team-bulk-delete'],['module_id'=>$ourTeamModule->id,'name'=>'Bulk Delete','slug'=>'our-team-bulk-delete']);
        Permission::updateOrInsert(['slug'=>'our-team-view'],['module_id'=>$ourTeamModule->id,'name'=>'View','slug'=>'our-team-view']);

        // Testimonial Module with Permission
        $testimonialModule = Module::updateOrCreate(['name'=>'Testimonial Permission'],['name'=>'Testimonial Permission','ordering'=>9]);
        Permission::updateOrInsert(['slug'=>'testimonial-access'],['module_id'=>$testimonialModule->id,'name'=>'Access','slug'=>'testimonial-access']);
        Permission::updateOrInsert(['slug'=>'testimonial-create'],['module_id'=>$testimonialModule->id,'name'=>'Create','slug'=>'testimonial-create']);
        Permission::updateOrInsert(['slug'=>'testimonial-edit'],['module_id'=>$testimonialModule->id,'name'=>'Edit/Update','slug'=>'testimonial-edit']);
        Permission::updateOrInsert(['slug'=>'testimonial-status'],['module_id'=>$testimonialModule->id,'name'=>'Status','slug'=>'testimonial-status']);
        Permission::updateOrInsert(['slug'=>'testimonial-delete'],['module_id'=>$testimonialModule->id,'name'=>'Delete','slug'=>'testimonial-delete']);
        Permission::updateOrInsert(['slug'=>'testimonial-bulk-delete'],['module_id'=>$testimonialModule->id,'name'=>'Bulk Delete','slug'=>'testimonial-bulk-delete']);

    }
}
