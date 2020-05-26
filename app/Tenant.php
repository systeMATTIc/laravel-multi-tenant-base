<?php

namespace App;

use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
use Spatie\Multitenancy\Models\Tenant as TenantManager;

class Tenant extends TenantManager
{
    protected $guarded = [];

    public static function uniqueRule($table, $column = 'NULL', $scope = 'tenant_id')
    {
        $unique = new Unique($table, $column);

        return $unique->where($scope, tenant()->id);
    }

    public static function existsRule($table, $column = 'NULL')
    {
        $unique = new Exists($table, $column);

        return $unique->where('tenant_id', tenant()->id);
    }

    public static function search($query)
    {
        return empty($query) ? static::query() : static::query()
            ->where('name', 'like', "%$query%")
            ->orWhere('domain', 'like', "%$query%")
        ;
    }
}
