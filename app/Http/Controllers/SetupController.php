<?php

namespace App\Http\Controllers;

use App\Models\Church;
use App\Models\Group;
use App\Services\KonfiApp;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SetupController extends Controller
{

    public function index()
    {
        return Inertia::render('Setup/Index');
    }


    /**
     * Store inital church data
     * @param Request $request
     */
    public function church(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'token' => 'required|string',
            'zip' => 'nullable|string',
            'city' => 'nullable|string',
        ]);

        $church = Church::create($data);
        return redirect()->route('setup.groups', strtolower($church->name));
    }

    public function groups(Church $church)
    {
        $groups = (new KonfiApp($church->token))->groups();
        return Inertia::render('Setup/Groups', compact('church', 'groups'));
    }

    public function storeGroups(Request $request, Church $church)
    {
        $data = $request->validate([
            'groups.*.name' => 'string|required',
            'groups.*.group_id' => 'string|required',
            'groups.*.description' => 'string|nullable',
        ]);
        foreach ($data['groups'] as $group) {
            $group['church_id'] = $church->id;
            Group::create($group);
        }

        return redirect()->route('form', $church);
    }
}
