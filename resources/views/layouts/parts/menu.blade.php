<a class="dropdown-item" href="{{ route('index', app()->getLocale()) }}">
    {{ __('Main Page') }} <i class="ml-2 fas fa-home"></i>
</a>

<a class="dropdown-item" href="{{ route('admin.index') }}">
    {{ __('Admin Panel') }} <i class="ml-2 fas fa-desktop"></i>
</a>

<a class="dropdown-item" href="{{ route('index', app()->getLocale()) }}">
    {{ __('User Panel') }} <i class="ml-2 fas fa-user-cog"></i>
</a>

<a class="dropdown-item" href="{{ route('admin.posts.create') }}">
    {{ __('Add Post') }} <i class="ml-2 fas fa-plus"></i>
</a>

<div class="dropdown-divider"></div>

<a class="dropdown-item" href="{{ route('logout', app()->getLocale()) }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    {{ __('Logout') }} <i class="ml-2 fas fa-sign-out-alt"></i>
</a>

<form id="logout-form" action="{{ route('logout', app()->getLocale()) }}" method="POST" class="d-none">
    @csrf
</form>
