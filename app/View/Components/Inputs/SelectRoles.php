<?php

namespace App\View\Components\Inputs;

use Stanfortonski\Laravelroles\Models\Role;

class SelectRoles extends Select
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($value = null)
    {
        $roles = $roles = Role::all();

        $options = [];
        foreach ($roles as $role)
            $options[$role->id] = $role->description;

        parent::__construct($options, 'roles', 'Roles', $value);
    }
}
