# Laravel-Blog
Laravel Blog 8.x

## About
Laravel Blog application.

## Installation
1. Everyting like standard Laravel installation (more in https://laravel.com/docs/8.x#installation):
    - download release or clone this repo
    - setup your blog in .env file.
3. Run artisan `php artisan storage:link` (necessary for store images).
2. Fill correctly `APP_DISQUS` - your embed.js provided by Disqus and `SESSION_DOMAIN` - your domain.
3. Add some users in database/seeders/UserSeeder.php for example:
```php
DB::table('users')->insert([
    'name' => 'your_user_name',
    'first_name' => 'your_first_name',
    'last_name' => 'your_last_name',
    'email' => 'your_email@domain.test',
    'website' => 'your_website',
    'description' => 'your_description',
    'password' => Hash::make('your_password'),
    'email_verified_at' => now(),
    'remember_token' => ''
]);
```
4. Migrate database using artisan `php artisan migrate --seed`.

Have fun :)

## Languages
- Two languages are available by default English and Polish.
- If you want to add new language you will make new folder for example de in resources/lang and copy everyting form resources/lang/en to this folder and create de.json in resources/lang folder. And then translate and set 'locale' and 'fallback_locale' in config/app.php to your language for example de.

## Libraries
- [Laravel 8.x](https://laravel.com/docs/8.x)
- [Laravel Fortify](https://github.com/laravel/fortify)
- [Laravel-Roles](https://github.com/stanfortonski/Laravel-Roles)
- [Laravel-Feed](https://github.com/spatie/laravel-feed)
- [CoreUI 3.x](https://coreui.io)
- [CKEditor5](https://ckeditor.com/ckeditor-5/)
- [Disqus](https://disqus.com)
- [Sass](https://sass-lang.com)
- [Laravel-Debugbar](https://github.com/barryvdh/laravel-debugbar)
