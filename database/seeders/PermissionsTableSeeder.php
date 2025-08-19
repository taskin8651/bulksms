<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'audit_log_show',
            ],
            [
                'id'    => 18,
                'title' => 'audit_log_access',
            ],
            [
                'id'    => 19,
                'title' => 'contact_create',
            ],
            [
                'id'    => 20,
                'title' => 'contact_edit',
            ],
            [
                'id'    => 21,
                'title' => 'contact_show',
            ],
            [
                'id'    => 22,
                'title' => 'contact_delete',
            ],
            [
                'id'    => 23,
                'title' => 'contact_access',
            ],
            [
                'id'    => 24,
                'title' => 'campaign_access',
            ],
            [
                'id'    => 25,
                'title' => 'template_access',
            ],
            [
                'id'    => 26,
                'title' => 'credit_access',
            ],
            [
                'id'    => 27,
                'title' => 'wallet_create',
            ],
            [
                'id'    => 28,
                'title' => 'wallet_edit',
            ],
            [
                'id'    => 29,
                'title' => 'wallet_show',
            ],
            [
                'id'    => 30,
                'title' => 'wallet_delete',
            ],
            [
                'id'    => 31,
                'title' => 'wallet_access',
            ],
            [
                'id'    => 32,
                'title' => 'transaction_create',
            ],
            [
                'id'    => 33,
                'title' => 'transaction_edit',
            ],
            [
                'id'    => 34,
                'title' => 'transaction_show',
            ],
            [
                'id'    => 35,
                'title' => 'transaction_delete',
            ],
            [
                'id'    => 36,
                'title' => 'transaction_access',
            ],
            [
                'id'    => 37,
                'title' => 'sms_template_create',
            ],
            [
                'id'    => 38,
                'title' => 'sms_template_edit',
            ],
            [
                'id'    => 39,
                'title' => 'sms_template_show',
            ],
            [
                'id'    => 40,
                'title' => 'sms_template_delete',
            ],
            [
                'id'    => 41,
                'title' => 'sms_template_access',
            ],
            [
                'id'    => 42,
                'title' => 'email_template_create',
            ],
            [
                'id'    => 43,
                'title' => 'email_template_edit',
            ],
            [
                'id'    => 44,
                'title' => 'email_template_show',
            ],
            [
                'id'    => 45,
                'title' => 'email_template_delete',
            ],
            [
                'id'    => 46,
                'title' => 'email_template_access',
            ],
            [
                'id'    => 47,
                'title' => 'whats_app_template_create',
            ],
            [
                'id'    => 48,
                'title' => 'whats_app_template_edit',
            ],
            [
                'id'    => 49,
                'title' => 'whats_app_template_show',
            ],
            [
                'id'    => 50,
                'title' => 'whats_app_template_delete',
            ],
            [
                'id'    => 51,
                'title' => 'whats_app_template_access',
            ],
            [
                'id'    => 52,
                'title' => 'sms_create',
            ],
            [
                'id'    => 53,
                'title' => 'sms_edit',
            ],
            [
                'id'    => 54,
                'title' => 'sms_show',
            ],
            [
                'id'    => 55,
                'title' => 'sms_delete',
            ],
            [
                'id'    => 56,
                'title' => 'sms_access',
            ],
            [
                'id'    => 57,
                'title' => 'email_create',
            ],
            [
                'id'    => 58,
                'title' => 'email_edit',
            ],
            [
                'id'    => 59,
                'title' => 'email_show',
            ],
            [
                'id'    => 60,
                'title' => 'email_delete',
            ],
            [
                'id'    => 61,
                'title' => 'email_access',
            ],
            [
                'id'    => 62,
                'title' => 'whats_app_create',
            ],
            [
                'id'    => 63,
                'title' => 'whats_app_edit',
            ],
            [
                'id'    => 64,
                'title' => 'whats_app_show',
            ],
            [
                'id'    => 65,
                'title' => 'whats_app_delete',
            ],
            [
                'id'    => 66,
                'title' => 'whats_app_access',
            ],
            [
                'id'    => 67,
                'title' => 'setup_master_access',
            ],
            [
                'id'    => 68,
                'title' => 'sms_setup_create',
            ],
            [
                'id'    => 69,
                'title' => 'sms_setup_edit',
            ],
            [
                'id'    => 70,
                'title' => 'sms_setup_show',
            ],
            [
                'id'    => 71,
                'title' => 'sms_setup_delete',
            ],
            [
                'id'    => 72,
                'title' => 'sms_setup_access',
            ],
            [
                'id'    => 73,
                'title' => 'email_setup_create',
            ],
            [
                'id'    => 74,
                'title' => 'email_setup_edit',
            ],
            [
                'id'    => 75,
                'title' => 'email_setup_show',
            ],
            [
                'id'    => 76,
                'title' => 'email_setup_delete',
            ],
            [
                'id'    => 77,
                'title' => 'email_setup_access',
            ],
            [
                'id'    => 78,
                'title' => 'whats_app_setup_create',
            ],
            [
                'id'    => 79,
                'title' => 'whats_app_setup_edit',
            ],
            [
                'id'    => 80,
                'title' => 'whats_app_setup_show',
            ],
            [
                'id'    => 81,
                'title' => 'whats_app_setup_delete',
            ],
            [
                'id'    => 82,
                'title' => 'whats_app_setup_access',
            ],
            [
                'id'    => 83,
                'title' => 'organizer_create',
            ],
            [
                'id'    => 84,
                'title' => 'organizer_edit',
            ],
            [
                'id'    => 85,
                'title' => 'organizer_show',
            ],
            [
                'id'    => 86,
                'title' => 'organizer_delete',
            ],
            [
                'id'    => 87,
                'title' => 'organizer_access',
            ],
            [
                'id'    => 88,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
