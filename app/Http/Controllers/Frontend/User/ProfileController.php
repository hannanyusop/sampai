<?php

namespace App\Http\Controllers\Frontend\User;

use App\Domains\Auth\Http\Requests\Frontend\Auth\UpdateImageRequest;
use App\Domains\Auth\Http\Requests\Frontend\Auth\UpdatePasswordRequest;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Services\UserService;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\User\UpdateProfileRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

/**
 * Class ProfileController.
 */
class ProfileController extends Controller
{
    /**
     * @param  UpdateProfileRequest  $request
     * @param  UserService  $userService
     *
     * @return mixed
     */
    public function update(UpdateProfileRequest $request, UserService $userService)
    {
        $userService->updateProfile($request->user(), $request->validated());

//        if (session()->has('resent')) {
//            return redirect()->route('frontend.auth.verification.notice')->withFlashInfo(__('You must confirm your new e-mail address before you can go any further.'));
//        }

        return redirect()->route('frontend.user.account', ['#information'])->withFlashSuccess(__('Profile successfully updated.'));
    }

    public function password(UpdatePasswordRequest $request){

        $user = User::findOrFail(auth()->user()->id);

        throw_if(
            ! Hash::check($request->current_password, $user->password),
            new GeneralException(__('That is not your old password.'))
        );

        $user->password_changed_at = now();
        $user->password = $request->password;
        $user->save();

        return redirect()->back()->withFlashSuccess('Password updated!');
    }

    public function image(UpdateImageRequest $request){

        $user = auth()->user();
        Storage::disk('public')->delete($user->image);
        $image = $request->file('image');
        $name = time().".".$image->getClientOriginalExtension();
        $folder = '/uploads/images/';
        $filePath = $folder . $name;
        $image->storeAs($folder, $name, 'public');

        $user->image = $filePath;
        $user->save();

        return redirect()->back()->withFlashSuccess('Profile image updated!');




    }
}
