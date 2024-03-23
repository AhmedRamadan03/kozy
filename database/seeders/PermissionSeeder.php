<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{


    public $permissions = [];

    public function initPermissions() {
        $perfix = "admin_";

        $this->permissions = [
            ['name' => $perfix . 'read-dashboard','display_name' => 'Read Dashboard','description' => 'عرض لوحة التحكم','path' => 'dashboard'],
            ['name' => $perfix . 'read-activity_logs','display_name' => 'Read Activity Logs','description' => 'عرض  تقرير سجل النشاط','path' => 'dashboard'],

             //setting
            ['name' => $perfix . 'read-settings','display_name' => 'Read Setting','description' => 'عرض  الاعدادات','path' => 'settings'],
            ['name' => $perfix . 'update-settings','display_name' => 'Update Setting','description' => 'تعديل  الاعدادات','path' => 'settings'],

            //about us
            ['name' => $perfix . 'read-about-us','display_name' => 'Read About Us','description' => 'عرض من نحن','path' => 'about_us'],
            ['name' => $perfix . 'update-about-us','display_name' => 'Update About Us','description' => 'تعديل من نحن','path' => 'about_us'],

            //admins
            ['name' => $perfix . 'read-admins','display_name' => 'Read Admins','description' => 'عرض المسؤلين','path' => 'admins'],
            ['name' => $perfix . 'create-admins','display_name' => 'Create Admins','description' => 'اضافة المسؤلين','path' => 'admins'],
            ['name' => $perfix . 'update-admins','display_name' => 'Update Admins','description' => 'تعديل المسؤلين','path' => 'admins'],
            ['name' => $perfix . 'delete-admins','display_name' => 'Delete Admins','description' => 'حذف المسؤلين','path' => 'admins'],

            //countries
            ['name' => $perfix . 'read-countries','display_name' => 'Read Country','description' => 'عرض دولة','path' => 'countries'],
            ['name' => $perfix . 'create-countries','display_name' => 'Create Country','description' => 'اضافة دولة','path' => 'countries'],
            ['name' => $perfix . 'update-countries','display_name' => 'Update Country','description' => 'تعديل دولة','path' => 'countries'],
            ['name' => $perfix . 'delete-countries','display_name' => 'Delete Country','description' => 'حذف دولة','path' => 'countries'],
            // ['name' => $perfix . 'filter-countries','display_name' => 'Filter Country','description' => 'فلتر دولة','path' => 'countries'],

            //cities
            ['name' => $perfix . 'read-cities','display_name' => 'Read city','description' => 'عرض  مدينة','path' => 'cities'],
            ['name' => $perfix . 'create-cities','display_name' => 'create city','description' => 'اضافة  مدينة','path' => 'cities'],
            ['name' => $perfix . 'update-cities','display_name' => 'Update city  ','description' => 'تعديل  مدينة','path' => 'cities'],
            ['name' => $perfix . 'delete-cities','display_name' => 'Delete city','description' => 'حذف  مدينة','path' => 'cities'],



            //brands
            ['name' => $perfix . 'read-brands','display_name' => 'Read Brand','description' => 'عرض  العلامات التجارية','path' => 'brands'],
            ['name' => $perfix . 'create-brands','display_name' => 'Update Brand','description' => 'اضافة  علامة تجارية','path' => 'brands'],
            ['name' => $perfix . 'update-brands','display_name' => 'Update Brand  ','description' => 'تعديل   علامة تجارية','path' => 'brands'],
            ['name' => $perfix . 'delete-brands','display_name' => 'Delete Brand','description' => 'حذف  علامة تجارية','path' => 'brands'],



            //categories
            ['name' => $perfix . 'read-categories','display_name' => 'Read  Category','description' => 'عرض الأقسام الرئيسية ','path' => 'categories'],
            ['name' => $perfix . 'create-categories','display_name' => 'Create  Category','description' => 'اضافة الأقسام الرئيسية ','path' => 'categories'],
            ['name' => $perfix . 'update-categories','display_name' => 'Update  Category','description' => 'تعديل الأقسام الرئيسية ','path' => 'categories'],
            ['name' => $perfix . 'delete-categories','display_name' => 'Delete  Category','description' => 'حذف الأقسام الرئيسية ','path' => 'categories'],

            //sub categories
            ['name' => $perfix . 'read-sub_categories','display_name' => 'Read Sub Category','description' => 'عرض الأقسام الفرعية ','path' => 'sub_categories'],
            ['name' => $perfix . 'create-sub_categories','display_name' => 'Create Sub Category','description' => 'اضافة الأقسام الفرعية ','path' => 'sub_categories'],
            ['name' => $perfix . 'update-sub_categories','display_name' => 'Update Sub Category','description' => 'تعديل الأقسام الفرعية ','path' => 'sub_categories'],
            ['name' => $perfix . 'delete-sub_categories','display_name' => 'Delete Sub Category','description' => 'حذف الأقسام الفرعية ','path' => 'sub_categories'],

            //colors
            ['name' => $perfix . 'read-colors','display_name' => 'Read Color','description' => 'عرض الألوان','path' => 'colors'],
            ['name' => $perfix . 'create-colors','display_name' => 'Create Color','description' => 'اضافة لون','path' => 'colors'],
            ['name' => $perfix . 'update-colors','display_name' => 'Update Color','description' => 'تعديل لون','path' => 'colors'],
            ['name' => $perfix . 'delete-colors','display_name' => 'Delete Color','description' => 'حذف لون','path' => 'colors'],

            //sizes
            ['name' => $perfix . 'read-sizes','display_name' => 'Read Size','description' => 'عرض  مقاسات','path' => 'sizes'],
            ['name' => $perfix . 'create-sizes','display_name' => 'Create Size','description' => 'اضافة  مقاسات','path' => 'sizes'],
            ['name' => $perfix . 'update-sizes','display_name' => 'Update Size','description' => 'تعديل  مقاسات','path' => 'sizes'],
            ['name' => $perfix . 'delete-sizes','display_name' => 'Delete Size','description' => 'حذف  مقاسات','path' => 'sizes'],


            //products
            ['name' => $perfix . 'read-products_report','display_name' => 'Read Products Report','description' => 'عرض  تقرير المنتجات','path' => 'products'],
            ['name' => $perfix . 'read-products','display_name' => 'Read Products','description' => 'عرض المنتجات','path' => 'products'],
            ['name' => $perfix . 'create-products','display_name' => 'Create Products','description' => 'اضافة المنتجات','path' => 'products'],
            ['name' => $perfix . 'update-products','display_name' => 'Update Products','description' => 'تعديل المنتجات','path' => 'products'],
            ['name' => $perfix . 'delete-products','display_name' => 'Delete Products','description' => 'حذف المنتجات','path' => 'products'],

            //roles
            ['name' => $perfix . 'read-roles','display_name' => 'Read Roles','description' => 'عرض الادوار','path' => 'roles'],
            ['name' => $perfix . 'create-roles','display_name' => 'Create Roles','description' => 'اضافة الادوار','path' => 'roles'],
            ['name' => $perfix . 'update-roles','display_name' => 'Update Roles','description' => 'تعديل الادوار','path' => 'roles'],
            ['name' => $perfix . 'delete-roles','display_name' => 'Delete Roles','description' => 'حذف الادوار','path' => 'roles'],

            // //copons
            // ['name' => $perfix . 'read-copons','display_name' => 'Read Copons','description' => 'عرض كوبونات الخصم','path' => 'copons'],
            // ['name' => $perfix . 'create-copons','display_name' => 'Create Copons','description' => 'اضافة كوبون خصم','path' => 'copons'],
            // ['name' => $perfix . 'update-copons','display_name' => 'Update Copons','description' => 'تعديل كوبون خصم','path' => 'copons'],
            // ['name' => $perfix . 'delete-copons','display_name' => 'Delete Copons','description' => 'حذف كوبون خصم','path' => 'copons'],


            //sliders
            ['name' => $perfix . 'read-sliders','display_name' => 'Read Sliders','description' => 'عرض  السلايدر','path' => 'sliders'],
            ['name' => $perfix . 'create-sliders','display_name' => 'Create Sliders','description' => 'اضافة  السلايدر','path' => 'sliders'],
            ['name' => $perfix . 'update-sliders','display_name' => 'Update Sliders','description' => 'تعديل  السلايدر','path' => 'sliders'],
            ['name' => $perfix . 'delete-sliders','display_name' => 'Delete Sliders','description' => 'حذف  السلايدر','path' => 'sliders'],

            //features
            ['name' => $perfix . 'read-features','display_name' => 'Read Features','description' => 'عرض المميزات','path' => 'features'],
            ['name' => $perfix . 'create-features','display_name' => 'Create Features','description' => 'اضافة المميزات','path' => 'features'],
            ['name' => $perfix . 'update-features','display_name' => 'Update Features','description' => 'تعديل المميزات','path' => 'features'],
            ['name' => $perfix . 'delete-features','display_name' => 'Delete Features','description' => 'حذف المميزات','path' => 'features'],

            //todos
            ['name' => $perfix . 'read-todos','display_name' => 'Read Todos','description' => 'عرض التسكات','path' => 'todos'],
            ['name' => $perfix . 'create-todos','display_name' => 'Create Todos','description' => 'اضافة التسكات','path' => 'todos'],
            ['name' => $perfix . 'update-todos','display_name' => 'Update Todos','description' => 'تعديل التسكات','path' => 'todos'],
            ['name' => $perfix . 'delete-todos','display_name' => 'Delete Todos','description' => 'حذف التسكات','path' => 'todos'],

            //offers
            ['name' => $perfix . 'read-offers','display_name' => 'Read Offer','description' => 'عرض العروض','path' => 'offers'],
            ['name' => $perfix . 'create-offers','display_name' => 'Create Offer','description' => 'اضافة العروض','path' => 'offers'],
            ['name' => $perfix . 'update-offers','display_name' => 'Update Offer','description' => 'تعديل العروض','path' => 'offers'],
            ['name' => $perfix . 'delete-offers','display_name' => 'Delete Offer','description' => 'حذف العروض','path' => 'offers'],

            //orders
            ['name' => $perfix . 'read-orders','display_name' => 'Read Orders','description' => 'عرض الطلبات','path' => 'orders'],
            ['name' => $perfix . 'export-orders','display_name' => 'Export Orders','description' => 'تصدير الطلبات','path' => 'orders'],
            ['name' => $perfix . 'read-orders_report','display_name' => 'Read Orders Report','description' => 'عرض تقرير الطلبات','path' => 'orders'],
            ['name' => $perfix . 'update-orders','display_name' => 'Update Orders','description' => 'تعديل الطلبات','path' => 'orders'],
            ['name' => $perfix . 'delete-orders','display_name' => 'Delete Orders','description' => 'حذف الطلبات','path' => 'orders'],



        ];
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->initPermissions();

        foreach($this->permissions as $item) {
            if (!DB::table('permissions')->where('name', $item['name'])->exists()) {
                Permission::updateOrCreate($item);
            }
        }
    }
}
