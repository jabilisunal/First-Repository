<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     */
    public function run(): void
    {
        $permissions =  [
            [
                'name' => 'dashboard:index',
                'guard_name' => 'admin',
                'description' => 'Admin Dashboard',
            ],
            [
                'name' => 'permission:manage',
                'guard_name' => 'admin',
                'description' => 'İcazələri idarə etmək',
            ],
            [
                'name' => 'user:user-index',
                'guard_name' => 'admin',
                'description' => 'İstifadəçi siyahısı səhifəsi',
            ],
            [
                'name' => 'user:user-create',
                'guard_name' => 'admin',
                'description' => 'İstifadəçi əlavə etmək səhifəsi',
            ],
            [
                'name' => 'user:user-store',
                'guard_name' => 'admin',
                'description' => 'İstifadəçi əlavə etmək',
            ],
            [
                'name' => 'user:user-edit',
                'guard_name' => 'admin',
                'description' => 'İstifadəçiyə düzəliş etmək səhifəsi',
            ],
            [
                'name' => 'user:user-update',
                'guard_name' => 'admin',
                'description' => 'İstifadəçiyə düzəliş etmək',
            ],
            [
                'name' => 'user:user-destroy',
                'guard_name' => 'admin',
                'description' => 'İstifadəçi silmək',
            ],
            [
                'name' => 'user:user-account-settings',
                'guard_name' => 'admin',
                'description' => 'İstifadəçi şifrəsini yenilənməsi',
            ],
            [
                'name' => 'settings:settings-index',
                'guard_name' => 'admin',
                'description' => 'Tənzimləmələr paneli',
            ],
            [
                'name' => 'settings:general-index',
                'guard_name' => 'admin',
                'description' => 'Tənzimləmələr siyahısı səhifəsi',
            ],
            [
                'name' => 'settings:general-create',
                'guard_name' => 'admin',
                'description' => 'Tənzimləmə əlavə etmək səhifəsi',
            ],
            [
                'name' => 'settings:general-store',
                'guard_name' => 'admin',
                'description' => 'Tənzimləmə əlavə etmək',
            ],
            [
                'name' => 'settings:general-edit',
                'guard_name' => 'admin',
                'description' => 'Tənzimləmə parametrlərinə düzəliş etmək səhifəsi',
            ],
            [
                'name' => 'settings:general-update',
                'guard_name' => 'admin',
                'description' => 'Tənzimləmə parametrlərinə düzəliş etmək',
            ],
            [
                'name' => 'settings:general-destroy',
                'guard_name' => 'admin',
                'description' => 'Tənzimləməni silmək',
            ],
            [
                'name' => 'localization:localization-index',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'localization:language-index',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'localization:language-create',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'localization:language-store',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'localization:language-show',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'localization:language-edit',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'localization:language-update',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'localization:language-destroy',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:content-index',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:partner-index',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:partner-create',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:partner-store',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:partner-show',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:partner-edit',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:partner-update',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:partner-destroy',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:banner-index',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:banner-create',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:banner-store',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:banner-show',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:banner-edit',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:banner-update',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:banner-destroy',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:menu-index',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:menu-create',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:menu-store',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:menu-show',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:menu-edit',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:menu-update',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:menu-destroy',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:features-index',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:features-create',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:features-store',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:features-show',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:features-edit',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:features-update',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:features-destroy',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:faqs-index',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:faqs-create',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:faqs-store',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:faqs-show',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:faqs-edit',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:faqs-update',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:faqs-destroy',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:pages-index',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:pages-create',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:pages-store',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:pages-show',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:pages-edit',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:pages-update',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:pages-destroy',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:post-index',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:post-create',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:post-store',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:post-show',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:post-edit',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:post-update',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:post-destroy',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:banner-type-index',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:banner-type-create',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:banner-type-store',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:banner-type-show',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:banner-type-edit',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:banner-type-update',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:banner-type-destroy',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:menu-type-index',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:menu-type-create',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:menu-type-store',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:menu-type-show',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:menu-type-edit',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:menu-type-update',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'content:menu-type-destroy',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'filemanager:filemanager-index',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'ecommerce:ecommerce-index',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'ecommerce:brand-index',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'ecommerce:brand-create',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'ecommerce:brand-store',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'ecommerce:brand-show',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'ecommerce:brand-edit',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'ecommerce:brand-update',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'ecommerce:brand-destroy',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'ecommerce:category-index',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'ecommerce:category-create',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'ecommerce:category-store',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'ecommerce:category-show',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'ecommerce:category-edit',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'ecommerce:category-update',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'ecommerce:category-destroy',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'ecommerce:destinations-create',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'ecommerce:destinations-store',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'ecommerce:destinations-show',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'ecommerce:destinations-edit',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'ecommerce:destinations-update',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'ecommerce:destinations-destroy',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'ecommerce:facilities-create',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'ecommerce:facilities-store',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'ecommerce:facilities-show',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'ecommerce:facilities-edit',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'ecommerce:facilities-update',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'ecommerce:facilities-destroy',
                'guard_name' => 'admin',
                'description' => '',
            ],
            [
                'name' => 'ecommerce:product-index',
                'guard_name' => 'admin',
                'description' => '',
            ]
        ];

        Permission::insert($permissions);
    }
}
