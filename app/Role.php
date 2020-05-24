<?php

namespace App;

use Silber\Bouncer\Database\Role as BouncerRole;

class Role extends BouncerRole
{
    public static function search($query)
    {
        return empty($query) ? static::query() : static::query()
            ->where('name', 'like', "%$query%")
            ->orWhere('title', 'like', "%$query%")
        ;
    }
}
