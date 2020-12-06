<?php

namespace App\Http\Controllers\Frontend\User;

use App\Domains\Auth\Models\Subscribe;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\Subscribe\AddRequest;
use App\Http\Requests\Frontend\User\Subscribe\UpdateRequest;


class SubscribeController extends Controller
{

    public function index(){

        $subscribes = Subscribe::where('user_id', auth()->user()->id)
            ->get();

        return view('frontend.user.subscribe.index', compact('subscribes'));
    }

    public function view($tracking_no){

        $sub = Subscribe::where([
            'user_id' =>  auth()->user()->id,
            'tracking_no'=> $tracking_no
        ])->firstOrFail();

        return view('frontend.user.subscribe.view', compact('sub'));
    }

    public function create(){

        return view('frontend.user.subscribe.create');
    }

    public function insert(AddRequest $request){

        $check = Subscribe::where(['user_id' => auth()->user()->id,
            'tracking_no' => $request->tracking_no])
            ->first();

        if(!$check){

            $sub = new Subscribe();
            $sub->user_id = auth()->user()->id;
            $sub->tracking_no = strtoupper($request->tracking_no);
            $sub->remark = $request->remark;
            $sub->is_notify = ($request->is_notify == "on")? 1 : 0;

            $sub->save();

            return redirect()->back()->withFlashSuccess("Parcel: $sub->tracking_no subscribe successfully!");

        }else{
            return redirect()->back()->withFlashWarning("You already subscribe this: $request->tracking_no parcel!");
        }


    }

    public function edit($id){

        $sub = Subscribe::where('user_id', auth()->user()->id)->findOrFail(decrypt($id));

        return view('frontend.user.subscribe.edit', compact('sub'));
    }

    public function update(UpdateRequest $request, $id){

        $sub = Subscribe::where('user_id', auth()->user()->id)->findOrFail(decrypt($id));

        $sub->remark = $request->remark;
        $sub->is_notify = ($request->is_notify == "on")? 1 : 0;

        $sub->save();
        return redirect()->back()->withFlashSuccess("Tracking no: $sub->tracking_no updated successfully!");
    }

    public function delete($id){

        $sub = Subscribe::where('user_id', auth()->user()->id)->findOrFail(decrypt($id));

        $sub->delete();

        return redirect()->back()->withFlashSuccess("Tracking no: $sub->tracking_no deleted successfully!");

    }

}
