<?php

namespace Modules\Superadmin\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MainPageController extends Controller
{

    public function GlobalSettings(){

        $pages = [
            [
                'show' => auth()->user('admin')->isAbleTo('admin_read-settings'),
                'title' => __('lang.main_settings'),
                'description' => __('lang.manage_site_settings'),
                'url' => route('admin.setting.index'),
                'image' => asset('icons/settings.png'),
            ],
            [
                'show' => auth()->user('admin')->isAbleTo('admin_read-country'),
                'title' => __('lang.countries'),
                'description' => __('lang.add') . ' ' .__('lang.country') . ' , ' . __('lang.edit') . ' ' .__('lang.country'),
                'url' => route('admin.country.index'),
                'image' => asset('icons/country.png'),
            ],
            [
                'show' => auth()->user('admin')->isAbleTo('admin_read-city'),
                'title' => __('lang.cities'),
                'description' => __('lang.add') . ' ' .__('lang.city') . ' , ' . __('lang.edit') . ' ' .__('lang.city'),
                'url' => route('admin.city.index'),
                'image' => asset('icons/map.png'),
            ],

            // [
            //     'show' => auth()->user('admin')->isAbleTo('admin_read-copons'),
            //     'title' => __('lang.copons'),
            //     'description' => __('lang.add') . ' ' .__('lang.copon') . ' , ' . __('lang.edit') . ' ' .__('lang.copon'),
            //     'url' => route('admin.copon.index'),
            //     'image' => asset('icons/copon.png'),
            // ],


        ];
        return view('superadmin::main_pages.setting_page',[
            'pages' =>$pages
        ]);
    }



    public function mainPageForProducts(){

        $pages = [
            [
                'show' => auth()->user('admin')->isAbleTo('admin_read-brands'),
                'title' => __('lang.brands'),
                'count'=> Brand::ForDrobDown()->count(),
                'description' => __('lang.add') . ' ' .__('lang.brand') . ' , ' . __('lang.edit') . ' ' .__('lang.brand'),
                'url' => route('admin.brand.index'),
                'image' => asset('icons/brand.png'),
            ],
            [
                'show' => auth()->user('admin')->isAbleTo('admin_read-categories'),
                'title' => __('lang.categories'),
                'count'=> Category::ForDrobDown()->parent()->count(),
                'description' => __('lang.add') . ' ' .__('lang.category') . ' , ' . __('lang.edit') . ' ' .__('lang.category'),
                'url' => route('admin.category.index'),
                'image' => asset('icons/cat.png'),
            ],
            [
                'show' => auth()->user('admin')->isAbleTo('admin_read-colors'),
                'title' => __('lang.colors'),
                'count'=> Color::count(),
                'description' => __('lang.add') . ' ' .__('lang.color') . ' , ' . __('lang.edit') . ' ' .__('lang.color'),
                'url' => route('admin.color.index'),
                'image' => asset('icons/color.png'),
            ],
            [
                'show' => auth()->user('admin')->isAbleTo('admin_read-sizes'),
                'title' => __('lang.sizes'),
                'count'=> Size::count(),
                'description' => __('lang.add') . ' ' .__('lang.size') . ' , ' . __('lang.edit') . ' ' .__('lang.size'),
                'url' => route('admin.size.index'),
                'image' => asset('icons/size.png'),
            ],
            [
                'show' => auth()->user('admin')->isAbleTo('admin_read-products'),
                'title' => __('lang.products'),
                'count'=> Product::ForDrobDown()->count(),
                'description' => __('lang.add') . ' ' .__('lang.product') . ' , ' . __('lang.edit') . ' ' .__('lang.product'),
                'url' => route('admin.product.index'),
                'image' => asset('icons/product.png'),
            ],


        ];
        return view('superadmin::main_pages.index',[
            'pages' =>$pages,
            'title' => __('lang.product_categories')
        ]);
    }


    public function mainPageForEducation(){

        $pages = [
            [
                'show' => auth()->user('admin')->isAbleTo('admin_read-courses'),
                'title' => __('lang.courses'),
                'description' => __('lang.add') . ' ' .__('lang.course') . ' , ' . __('lang.edit') . ' ' .__('lang.course'),
                'url' => route('admin.course.index'),
                'image' => asset('icons/course.png'),
            ],
            [
                'show' => auth()->user('admin')->isAbleTo('admin_read-lectures'),
                'title' => __('lang.lectures'),
                'description' => __('lang.add') . ' ' .__('lang.lecture') . ' , ' . __('lang.edit') . ' ' .__('lang.lecture'),
                'url' => route('admin.lecture.index'),
                'image' => asset('icons/lecture.png'),
            ],
            [
                'show' => auth()->user('admin')->isAbleTo('admin_read-courses'),
                'title' => __('lang.assignments'),
                'description' => __('lang.add') . ' ' .__('lang.assignment') . ' , ' . __('lang.correct') . ' ' .__('lang.assignments'),
                'url' => route('admin.assignment.index'),
                'image' => asset('icons/assing.png'),
            ],
            [
                'show' => auth()->user('admin')->isAbleTo('admin_read-courses'),
                'title' => __('lang.exams'),
                'description' => __('lang.add') . ' ' .__('lang.exam') . ' , ' . __('lang.manage') . ' ' .__('lang.exams'),
                'url' => route('admin.exam.index'),
                'image' => asset('icons/assing.png'),
            ],
            [
                'show' => auth()->user('admin')->isAbleTo('admin_read-courses'),
                'title' => __('lang.files'),
                'description' => __('lang.add') . ' ' .__('lang.file') . ' , ' . __('lang.manage') . ' ' .__('lang.files'),
                'url' => route('admin.file.index'),
                'image' => asset('icons/lecture.png'),
            ],

        ];
        return view('superadmin::main_pages.index',[
            'pages' =>$pages,
            'title' => __('lang.educations')
        ]);
    }

    /**
     * Returns the website settings.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function websiteSettings()
    {

        $pages = [
            [
                'show' => auth()->user('admin')->isAbleTo('admin_read-sliders'),
                'title' => __('lang.sliders'),
                'description' => __('lang.add') . ' ' . __('lang.slider') . ', ' . __('lang.edit') . ' ' .__('lang.slider'),
                'url' => route('admin.slider.index'),
                'image' => asset('icons/slider.png'),
            ],
            [
                'show' => auth()->user('admin')->isAbleTo('admin_read-features'),
                'title' => __('lang.features'),
                'description' => __('lang.add') .' ' .__('lang.feature') . ', ' . __('lang.edit') .' ' .__('lang.feature'),
                'url' => route('admin.feature.index'),
                'image' => asset('icons/feature.png'),
            ],
            [
                'show' => auth()->user('admin')->isAbleTo('admin_read-about-us'),
                'title' => __('lang.about_us'),
                'description' => __('lang.manage_info_of_about_us'),
                'url' => route('admin.about.index'),
                'image' => asset('icons/about.png'),
            ],


        ];
        return view('superadmin::main_pages.index',[
            'pages' =>$pages,
            'title' => __('lang.website_settings')
        ]);
    }



    /**
     * Returns the website settings.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function security()
    {

        $pages = [
            [
                'show' => auth()->user('admin')->isAbleTo('admin_read-roles'),
                'title' => __('lang.roles'),
                'description' => __('lang.add') . ' ' . __('lang.role') . ', ' . __('lang.edit') . ' ' .__('lang.role'),
                'url' => route('admin.role.index'),
                'image' => asset('icons/role.png'),
            ],
            [
                'show' => auth()->user('admin')->isAbleTo('admin_read-admins'),
                'title' => __('lang.admins'),
                'description' => __('lang.add') . ' ' . __('lang.admin') . ', ' . __('lang.edit') . ' ' .__('lang.admin'),
                'url' => route('admin.admin.index'),
                'image' => asset('icons/admin.png'),
            ],

        ];
        return view('superadmin::main_pages.index',[
            'pages' =>$pages,
            'title' => __('lang.security')
        ]);
    }


}
