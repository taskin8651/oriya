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
                'title' => 'artical_access',
            ],
            [
                'id'    => 20,
                'title' => 'category_create',
            ],
            [
                'id'    => 21,
                'title' => 'category_edit',
            ],
            [
                'id'    => 22,
                'title' => 'category_show',
            ],
            [
                'id'    => 23,
                'title' => 'category_delete',
            ],
            [
                'id'    => 24,
                'title' => 'category_access',
            ],
            [
                'id'    => 25,
                'title' => 'tag_create',
            ],
            [
                'id'    => 26,
                'title' => 'tag_edit',
            ],
            [
                'id'    => 27,
                'title' => 'tag_show',
            ],
            [
                'id'    => 28,
                'title' => 'tag_delete',
            ],
            [
                'id'    => 29,
                'title' => 'tag_access',
            ],
            [
                'id'    => 30,
                'title' => 'post_create',
            ],
            [
                'id'    => 31,
                'title' => 'post_edit',
            ],
            [
                'id'    => 32,
                'title' => 'post_show',
            ],
            [
                'id'    => 33,
                'title' => 'post_delete',
            ],
            [
                'id'    => 34,
                'title' => 'post_access',
            ],
            [
                'id'    => 35,
                'title' => 'gallery_create',
            ],
            [
                'id'    => 36,
                'title' => 'gallery_edit',
            ],
            [
                'id'    => 37,
                'title' => 'gallery_show',
            ],
            [
                'id'    => 38,
                'title' => 'gallery_delete',
            ],
            [
                'id'    => 39,
                'title' => 'gallery_access',
            ],
            [
                'id'    => 40,
                'title' => 'comment_create',
            ],
            [
                'id'    => 41,
                'title' => 'comment_edit',
            ],
            [
                'id'    => 42,
                'title' => 'comment_show',
            ],
            [
                'id'    => 43,
                'title' => 'comment_delete',
            ],
            [
                'id'    => 44,
                'title' => 'comment_access',
            ],
            [
                'id'    => 45,
                'title' => 'website_setup_access',
            ],
            [
                'id'    => 46,
                'title' => 'header_logo_create',
            ],
            [
                'id'    => 47,
                'title' => 'header_logo_edit',
            ],
            [
                'id'    => 48,
                'title' => 'header_logo_show',
            ],
            [
                'id'    => 49,
                'title' => 'header_logo_delete',
            ],
            [
                'id'    => 50,
                'title' => 'header_logo_access',
            ],
            [
                'id'    => 51,
                'title' => 'footer_logo_create',
            ],
            [
                'id'    => 52,
                'title' => 'footer_logo_edit',
            ],
            [
                'id'    => 53,
                'title' => 'footer_logo_show',
            ],
            [
                'id'    => 54,
                'title' => 'footer_logo_delete',
            ],
            [
                'id'    => 55,
                'title' => 'footer_logo_access',
            ],
            [
                'id'    => 56,
                'title' => 'contact_detail_create',
            ],
            [
                'id'    => 57,
                'title' => 'contact_detail_edit',
            ],
            [
                'id'    => 58,
                'title' => 'contact_detail_show',
            ],
            [
                'id'    => 59,
                'title' => 'contact_detail_delete',
            ],
            [
                'id'    => 60,
                'title' => 'contact_detail_access',
            ],
            [
                'id'    => 61,
                'title' => 'contact_us_create',
            ],
            [
                'id'    => 62,
                'title' => 'contact_us_edit',
            ],
            [
                'id'    => 63,
                'title' => 'contact_us_show',
            ],
            [
                'id'    => 64,
                'title' => 'contact_us_delete',
            ],
            [
                'id'    => 65,
                'title' => 'contact_us_access',
            ],
            [
                'id'    => 66,
                'title' => 'newsletter_create',
            ],
            [
                'id'    => 67,
                'title' => 'newsletter_edit',
            ],
            [
                'id'    => 68,
                'title' => 'newsletter_show',
            ],
            [
                'id'    => 69,
                'title' => 'newsletter_delete',
            ],
            [
                'id'    => 70,
                'title' => 'newsletter_access',
            ],
            [
                'id'    => 71,
                'title' => 'seo_create',
            ],
            [
                'id'    => 72,
                'title' => 'seo_edit',
            ],
            [
                'id'    => 73,
                'title' => 'seo_show',
            ],
            [
                'id'    => 74,
                'title' => 'seo_delete',
            ],
            [
                'id'    => 75,
                'title' => 'seo_access',
            ],
            [
                'id'    => 76,
                'title' => 'epaper_create',
            ],
            [
                'id'    => 77,
                'title' => 'epaper_edit',
            ],
            [
                'id'    => 78,
                'title' => 'epaper_show',
            ],
            [
                'id'    => 79,
                'title' => 'epaper_delete',
            ],
            [
                'id'    => 80,
                'title' => 'epaper_access',
            ],
            [
                'id'    => 81,
                'title' => 'ad_create',
            ],
            [
                'id'    => 82,
                'title' => 'ad_edit',
            ],
            [
                'id'    => 83,
                'title' => 'ad_show',
            ],
            [
                'id'    => 84,
                'title' => 'ad_delete',
            ],
            [
                'id'    => 85,
                'title' => 'ad_access',
            ],
            [
                'id'    => 86,
                'title' => 'events_management_access',
            ],
            [
                'id'    => 87,
                'title' => 'create_event_create',
            ],
            [
                'id'    => 88,
                'title' => 'create_event_edit',
            ],
            [
                'id'    => 89,
                'title' => 'create_event_show',
            ],
            [
                'id'    => 90,
                'title' => 'create_event_delete',
            ],
            [
                'id'    => 91,
                'title' => 'create_event_access',
            ],
            [
                'id'    => 92,
                'title' => 'venue_create',
            ],
            [
                'id'    => 93,
                'title' => 'venue_edit',
            ],
            [
                'id'    => 94,
                'title' => 'venue_show',
            ],
            [
                'id'    => 95,
                'title' => 'venue_delete',
            ],
            [
                'id'    => 96,
                'title' => 'venue_access',
            ],
            [
                'id'    => 97,
                'title' => 'seat_management_create',
            ],
            [
                'id'    => 98,
                'title' => 'seat_management_edit',
            ],
            [
                'id'    => 99,
                'title' => 'seat_management_show',
            ],
            [
                'id'    => 100,
                'title' => 'seat_management_delete',
            ],
            [
                'id'    => 101,
                'title' => 'seat_management_access',
            ],
            [
                'id'    => 102,
                'title' => 'bookin_seat_create',
            ],
            [
                'id'    => 103,
                'title' => 'bookin_seat_edit',
            ],
            [
                'id'    => 104,
                'title' => 'bookin_seat_show',
            ],
            [
                'id'    => 105,
                'title' => 'bookin_seat_delete',
            ],
            [
                'id'    => 106,
                'title' => 'bookin_seat_access',
            ],
            [
                'id'    => 107,
                'title' => 'crousel_create',
            ],
            [
                'id'    => 108,
                'title' => 'crousel_edit',
            ],
            [
                'id'    => 109,
                'title' => 'crousel_show',
            ],
            [
                'id'    => 110,
                'title' => 'crousel_delete',
            ],
            [
                'id'    => 111,
                'title' => 'crousel_access',
            ],
            [
                'id'    => 112,
                'title' => 'breaking_news_create',
            ],
            [
                'id'    => 113,
                'title' => 'breaking_news_edit',
            ],
            [
                'id'    => 114,
                'title' => 'breaking_news_show',
            ],
            [
                'id'    => 115,
                'title' => 'breaking_news_delete',
            ],
            [
                'id'    => 116,
                'title' => 'breaking_news_access',
            ],
            [
                'id'    => 117,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
