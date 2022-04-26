<?php

namespace App\Http\Controllers;

use App\Mail\KonfiMail;
use App\Mail\NewRegistrationMail;
use App\Mail\ParentMail;
use App\Models\Church;
use App\Services\CSVTable;
use App\Services\KonfiApp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use niklasravnsborg\LaravelPdf\Facades\Pdf as PDF;

class FrontendController extends Controller
{

    public function form(Church $church)
    {
        $church->load('groups');

        foreach ($church->groups as $key => $group) {
            $myMembers= [];
            $members = (new KonfiApp($church->token))->groupMembers($group->group_id) ?? [];
            foreach ($members as $member) {
                $myMembers[] = $member['vorname'].' '.substr($member['nachname'], 0, 1).'.';
            }
            $church->groups[$key]['members'] = $myMembers;
        }

        return Inertia::render('Frontend/Form', compact('church'));
    }

    public function register(Request $request, Church $church)
    {
        $data = $request->validate([
            'group' => 'nullable|string|exists:groups,group_id',
            'konfi.vorname' => 'required|string',
            'konfi.nachname' => 'required|string',
            'konfi.email' => 'nullable|string',
            'konfi.details.address.street' => 'required|string',
            'konfi.details.address.plz' => 'required|string',
            'konfi.details.address.city' => 'required|string',
            'konfi.details.personal.birthdate' => 'required|date',
            'konfi.details.personal.birthplace' => 'required|string',
            'konfi.details.personal.middlename' => 'required|string',
            'konfi.details.personal.school' => 'required|string',
            'konfi.details.personal.class' => 'required|string',
            'konfi.details.personal.tel' => 'required|string',
            'konfi.details.taufe.date' => 'nullable|date',
            'konfi.details.taufe.paten' => 'nullable|string',
            'konfi.details.taufe.spruch' => 'nullable|string',
            'parents.*.vorname' => 'nullable|string',
            'parents.*.nachname' => 'nullable|string',
            'parents.*.mail' => 'nullable|email',
            'parents.*.phone' => 'nullable|string',
        ]);

        $data['konfi']['details']['personal']['birthdate'] = Carbon::parse($data['konfi']['details']['personal']['birthdate'], 'UTC')->setTimezone('Europe/Berlin')->format('Y-m-d');
        if (!empty($data['konfi']['details']['taufe']['date'] ?? '')) {
            $data['konfi']['details']['taufe']['date'] = Carbon::parse($data['konfi']['details']['taufe']['date'], 'UTC')->setTimezone('Europe/Berlin')->format('Y-m-d');
        }

        $konfiApp = new KonfiApp($church->token);

        // create parents
        $parentIds = [];
        $parents = [];
        foreach ($data['parents'] as $parent) {
            $parentResult = $konfiApp->createParent($parent);
            if ($parentResult == 'already_exists') {
                $parentResult = $konfiApp->findParent($parent);
            }
            if ($parentResult) {
                $parent['id'] = $parentResult['id'];
                $parent['username'] = $parentResult['username'] ?? '';
                $parents[] = $parent;
                $parentIds[] = $parentResult['id'];
            }
        }


        $record = [
            'vorname' => $data['konfi']['vorname'],
            'nachname' => $data['konfi']['nachname'],
            'groups' => $data['group'] ?? $church->groups[0]->group_id,
            'details' => array_merge(
                $this->subset($data['konfi']['details'], 'address'),
                $this->subset($data['konfi']['details'], 'personal'),
                $this->subset($data['konfi']['details'], 'taufe')
            ),
            'parents' => join(',', $parentIds),
        ];

        $record['details']['personal.school.class'] = $record['details']['personal.class'];
        unset($record['details']['personal.class']);


        // create Konfi
        $result = $konfiApp->createKonfi($record);
        $record['username'] = $result['username'];

        if ($data['konfi']['email']) $record['email'] = $data['konfi']['email'];


        // add to CSV
        $csv = new CSVTable($church);
        $csv->storeRecord($record, $parents);

        $pdf = PDF::loadView('pdf.confirm', compact('record', 'parents', 'church'));
        $fileName = Carbon::now()->year.' '.$church->name.' '.$record['nachname'].', '.$record['vorname'].'.pdf';
        $pdf->save(storage_path('app/pdf/'.$fileName));

        // get group name
        $groupName = '';
        foreach ($church->groups as $group) {
            if ($group->group_id == $record['groups']) $groupName = $group->name;
        }


        // send notifications
        foreach (explode(',', $church->email) as $email) {
            Mail::to(trim($email))->send(new NewRegistrationMail($record, $parents, $church, $groupName, $fileName));
        }

        // send Konfi mail
        if ($record['email']) {
            Mail::to(trim($record['email']))->cc(explode(',', $church->email) ?? [])
                ->send(new KonfiMail($record, $parents, $church, $groupName, $fileName));
        }

        // send parents mail
        foreach ($parents as $parent) {
            if ($parent['mail'] ?? false) {
                Mail::to(trim($record['email']))->cc(explode(',', $church->email) ?? [])
                    ->send(new ParentMail($record, $parents, $church, $groupName, $fileName));
            }
        }

        return response()->json($fileName);
    }

    protected function subset($data, $key) {
        $record = [];
        foreach ($data[$key] as $subKey => $value) {
            $record[$key.'.'.$subKey] = $value;
        }
        return $record;
    }

    public function list(Church $church)
    {
        $fileName = Carbon::now()->year.'-'.$church->name.'.csv';
        if (!file_exists(storage_path('app/'.$fileName))) abort(404);

        return Storage::response($fileName);
    }

}
