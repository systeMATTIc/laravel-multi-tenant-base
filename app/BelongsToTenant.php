<?php

namespace App;

use App\Scopes\TenantScope;

trait BelongsToTenant
{
    public static function bootBelongsToTenant()
    {
        static::addGlobalScope(new TenantScope);

        static::creating(function ($model) {
            if (!$model->tenant_id && !$model->relationLoaded('tenant')) {
                $tenant = tenant();
                $model->setRelation('tenant', $tenant);
                $model->tenant_id = $tenant->id;
            }

            return $model;
        });
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }
}
