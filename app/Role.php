<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Silber\Bouncer\Database\Role as BouncerRole;
use Silber\Bouncer\Database\Scope\TenantScope;

class Role extends BouncerRole
{
    public static function search($query, $tenantId = null)
    {
        return empty($query)
            ? static::query()->withoutGlobalScope(TenantScope::class)->where(
                function (Builder $q) use ($tenantId) {
                    return $q->where('scope', '=', $tenantId);
                }
            ) : static::query()->withoutGlobalScope(TenantScope::class)->where(
                function (Builder $q) use ($tenantId) {
                    return $q->where('scope', '=', $tenantId);
                }
            )->where(function (Builder $q) use ($query) {
                $q->where('name', 'like', "%$query%")
                    ->orWhere('title', 'like', "%$query%");
            });
    }
}
