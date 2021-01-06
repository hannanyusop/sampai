<?php

namespace App\Http\Controllers\Backend;

use App\Domains\Auth\Http\Requests\Backend\Office\InsertOfficeRequest;
use App\Domains\Auth\Models\Office;
use App\Domains\Auth\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\Subscribe\UpdateRequest;

class OfficeController extends Controller
{

    public function index(){

        $offices = Office::get();
        return view('backend.office.index', compact('offices'));
    }

    public function create(){

        return view('backend.office.create');
    }

    public function insert(InsertOfficeRequest $request){

        $office = new Office();

        $office->code = strtoupper($request->code);
        $office->name = strtoupper($request->name);
        $office->is_drop_point = ($request->is_drop_point)? 1 : 0;
        $office->address = $request->address;
        $office->location = $request->location;
        $office->operation_day = $request->operation_day;

        $office->save();

        return redirect()->back()->withFlashSuccess('New office created!');

    }

    public function edit($id = null){

        if(auth()->user()->can('staff.manager')){

            $office = Office::findOrFail(auth()->user()->office_id);
            return view('backend.office.manager-edit', compact('office'));

        }elseif (auth()->user()->can('admin.access.user')){

            $office = Office::findOrFail($id);
            return view('backend.office.edit', compact('office'));
        }else{
            return  redirect()->back()->withFlashError('Permission Denied');
        }

    }

    public function update(UpdateRequest $request, $id = null){


        if(auth()->user()->can('staff.manager')){

            $office = Office::findOrFail(auth()->user()->office_id);

            $office->code = strtoupper($request->code);
            $office->name = strtoupper($request->name);
            $office->is_drop_point = ($request->is_drop_point)? 1 : 0;
            $office->address = $request->address;
            $office->location = $request->location;
            $office->operation_day = $request->operation_day;

            $office->save();
            return redirect()->back()->withFlashSuccess('Office updated.');

        }elseif (auth()->user()->can('admin.access.user')){

            $office = Office::findOrFail($id);

            $office->code = strtoupper($request->code);
            $office->name = strtoupper($request->name);
            $office->is_drop_point = ($request->is_drop_point)? 1 : 0;
            $office->address = $request->address;
            $office->location = $request->location;
            $office->operation_day = $request->operation_day;

            $office->save();
            return redirect()->back()->withFlashSuccess('Office updated.');
        }else{
            return  redirect()->back()->withFlashError('Permission Denied');
        }
    }

    public function delete($id){

        $office = Office::findOrFail($id);

        $user = User::where('office_id', $office->id)->get();

        if($user->count() > 0){

            return redirect()->back()->withFlashError('Remove all user from this office before you can delete it.');
        }

        $office->delete();
        return  redirect()->back()->withFlashSuccess('Office deleted.');
    }

    public function staff(){

        $users = User::where('office_id', auth()->user()->office_id)->get();
        return view('backend.office.staff', compact('users'));
    }
}
