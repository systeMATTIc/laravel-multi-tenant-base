<?php

namespace App\Http\Controllers\Admin;

use App\Administrator;
use App\Http\Controllers\Controller;

class AdministratorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view-administrator-list');

        return view('admin.users.index', [
            'administrators' => Administrator::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-administrator');

        return view('admin.users.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Administrator  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Administrator $user)
    {
        $this->authorize('edit-administrator');

        return view('admin.users.edit', [
            'administrator' => $user 
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Administrator  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Administrator $user)
    {
        $this->authorize('delete-administrator');

        $user->delete();

        session()->flash('message', 'Administrator Deleted');

        return redirect()->action([self::class, 'index']);
    }
}
