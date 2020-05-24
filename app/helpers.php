<?php

if (!function_exists('tenant')) {
	/**
	 * Gets the current tenant of the application
	 *
	 * @return \App\Tenant
	 * 
	 * @throws \Illuminate\Contracts\Container\BindingResolutionException
	 */
	function tenant()
	{
		$currentTenantKey = config(
			'multitenancy.current_tenant_container_key'
		);

		return app($currentTenantKey);
	}
}
