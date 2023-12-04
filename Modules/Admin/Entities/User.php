<?php

namespace Modules\Admin\Entities;

/**
 * @method static paginate(int $int)
 * @method static find(int $id)
 */
class User extends \App\Models\User{
    public string $guard_name = 'admin';
}
