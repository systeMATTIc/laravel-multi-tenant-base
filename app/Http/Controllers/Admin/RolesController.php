<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Silber\Bouncer\Bouncer;

class RolesController extends Controller
{
    protected $bouncer;

    public function __construct(Bouncer $bouncer)
    {
        $this->bouncer = $bouncer;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view-roles');

        return view('admin.roles.index', [
            'roles' => $this->bouncer->role()->all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-role');

        return view('admin.roles.create', [
            'abilities' => $this->bouncer->ability()->all()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('edit-role');

        return view('admin.roles.edit', [
            'abilities' => $this->bouncer->ability()->all(),
            'role' => $this->bouncer->role()->with('abilities')->findOrFail($id)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete-role');

        /** @var \Silber\Bouncer\Database\Role */
        $role = $this->bouncer->role()->findOrFail($id);

        $role->delete();

        return redirect()->action([self::class, 'index']);
    }
}
