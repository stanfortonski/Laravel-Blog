<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class BladeServiceProvider extends ServiceProvider
{
    protected $components = [
        'search' => \App\View\Components\Inputs\Search::class,
        'select-categories' => \App\View\Components\Inputs\SelectCategories::class,
        'select-roles' => \App\View\Components\Inputs\SelectRoles::class,
        'input-thumbnail' => \App\View\Components\Inputs\InputThumbnail::class,
        'no-image' => \App\View\Components\NoImage::class,
        'post-item' => \App\View\Components\PostItem::class,
        'category-item' => \App\View\Components\CategoryItem::class,
        'author-note' => \App\View\Components\AuthorNote::class,
        'two-factor-manage' => \App\View\Components\TwoFactorManage::class,
        'choose-lang-admin' => \App\View\Components\ChooseLangAdmin::class
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->components as $key => $value)
            Blade::component($key, $value);
    }
}
