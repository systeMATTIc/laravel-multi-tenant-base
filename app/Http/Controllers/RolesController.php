<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

        return view('roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-role');

        $abilites = $this->bouncer->ability()->query()->where([
            'scope' => tenant()->id
        ])->get();

        return view('roles.create', [
            'abilities' => $abilites
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

        $abilites = $this->bouncer->ability()->query()->where([
            'scope' => tenant()->id
        ])->get();

        return view('roles.edit', [
            'abilities' => $abilites,
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
