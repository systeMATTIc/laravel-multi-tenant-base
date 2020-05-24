<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Tenant;

class TenantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view-tenant-list');

        return view('admin.tenants.index', [
            'tenants' => Tenant::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-tenant');

        return view('admin.tenants.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function edit(Tenant $tenant)
    {
        $this->authorize('edit-tenant');

        return view('admin.tenants.edit', [
            'tenant' => $tenant 
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tenant  $tenant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tenant $tenant)
    {
        $this->authorize('delete-tenant');

        $tenant->delete();

        session()->flash('message', 'Tenant Deleted');

        return redirect()->action([self::class, 'index']);
    }
}
