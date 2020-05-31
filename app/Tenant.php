<?php

namespace App;

use Illuminate\Validation\Rules\Exists;
use Illuminate\Validation\Rules\Unique;
use Spatie\Multitenancy\Models\Tenant as TenantManager;
use Illuminate\Support\Str;

class Tenant extends TenantManager
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function (self $tenant) {
            $tenant->uuid = Str::uuid();
            return $tenant;
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public static function uniqueRule($table, $column = 'NULL', $scope = 'tenant_id')
    {
        $unique = new Unique($table, $column);

        return $unique->where($scope, tenant()->id);
    }

    public static function existsRule($table, $scope = 'tenant_id', $column = 'NULL')
    {
        $unique = new Exists($table, $column);

        return $unique->where($scope, tenant()->id);
    }

    public static function search($query)
    {
        return empty($query) ? static::query() : static::query()
            ->where('name', 'like', "%$query%")
            ->orWhere('domain', 'like', "%$query%");
    }
}
