<?php

namespace App\Http\Controllers\Management;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{
    public function index() {
        $users = User::all();
        $positions = Company::all();
        return view('management.employees', [
            'title'=> 'Staff Tersedia',
            'users' => $users,
            'positions' => $positions,
        ]);
    }
    
    public function store(Request $request) {
        $data = $request->all();
        $data['name'] = Str::slug($request->name);
        Company::create($data);
        return redirect()->back();
    }
    
    public function update(Request $request, string $identifier) {
        $data = $request->all();
        $id = explode('-',$identifier)[1];
        $from = explode('-',$identifier)[0];
        if ($from == 'pos'){
            $data['name'] = Str::slug($request->name);
            Company::findOrFail($id)->update($data);
        } else {
            $data['name'] = Str::title($request->name);
            $data['position_id'] = (integer)$request->position_id;
            //dd($data);
            User::findOrFail($id)->update($data);
        }
        return redirect()->back();
    }

    public function destroy(string $identifier) {
        $id = explode('-',$identifier)[1];
        $from = explode('-',$identifier)[0];
        if ($from == 'pos') {
            $position = Company::findOrFail($id);
            if ($position->users->count() > 0) {
                $userlist = User::all()->where('position_id', '=', $id);
                $position->delete();
                //dd($userlist);
                foreach ($userlist as $user) {
                    //dd($user);
                    if ($id > 1) {
                        if (Company::where('id','=',1)->exists()) {
                            $user->position_id = 1;
                            $user->save();
                            //dd($defaultpos);
                        } else {
                            $user->position_id = null;
                            $user->save();
                        }
                    } else {
                        $user->position_id = null;
                        $user->save();
                    }
                }
            } else {
                $position->delete();
            }
        } else {
            $user = User::findOrFail($id);
            $user->delete();
        }
        return redirect()->back();
    }
}
