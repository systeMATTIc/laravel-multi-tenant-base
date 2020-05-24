<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
	public function apply(Builder $builder, Model $model)
	{
		try {
			$builder->where('tenant_id', '=', tenant()->id);
		} catch (\Throwable $e) {
			//
		}
	}

	public function extend(Builder $builder)
	{
		$builder->macro('withoutTenancy', function (Builder $builder) {
            return $builder->withoutGlobalScope($this);
        });
	}
}