<?php

namespace App\Http\Controllers\API\V1;

use App\Domains\Auth\Models\Office;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HelperController extends Controller
{


    public function dropPoint(Request $request)
    {

        $drop_points = Office::where([
            'is_drop_point' => 1
        ])
            ->when($request->has('code'), function ($query) use ($request) {
                $query->where('code', 'like', '%' . $request->code . '%');
            })
            ->when($request->has('name'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->name . '%');
            })
            ->get();

        return response(['data' => $drop_points], 200);
    }
}
