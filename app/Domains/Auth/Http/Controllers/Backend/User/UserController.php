<?php

namespace App\Domains\Auth\Http\Controllers\Backend\User;

use App\Domains\Auth\Http\Requests\Backend\User\AssignUserRequest;
use App\Domains\Auth\Http\Requests\Backend\User\DeleteUserRequest;
use App\Domains\Auth\Http\Requests\Backend\User\EditUserRequest;
use App\Domains\Auth\Http\Requests\Backend\User\StoreUserRequest;
use App\Domains\Auth\Http\Requests\Backend\User\UpdateUserRequest;
use App\Domains\Auth\Models\Office;
use App\Domains\Auth\Models\Permission;
use App\Domains\Auth\Models\User;
use App\Domains\Auth\Services\PermissionService;
use App\Domains\Auth\Services\RoleService;
use App\Domains\Auth\Services\UserService;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    protected $userService;
    protected $roleService;

    protected $permissionService;


    public function __construct(UserService $userService, RoleService $roleService, PermissionService $permissionService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
    }


    public function index()
    {
        $users = User::get();
        return view('backend.auth.user.index', compact('users'));
    }

    /**
     * @return mixed
     */
    public function create()
    {
        $arr = [
            'Administrator' => Permission::where('name', 'admin.access.user')->with('children')->first(),
            'Staff' => Permission::where('name', 'staff')->with('children')->first(),
        ];

        $roles = $this->roleService->get();

        return view('backend.auth.user.create', compact('roles', 'arr'));
    }

    /**
     * @param  StoreUserRequest  $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->store($request->validated());

        return redirect()->route('admin.auth.user.show', $user)->withFlashSuccess(__('The user was successfully created.'));
    }

    /**
     * @param  User  $user
     *
     * @return mixed
     */
    public function show(User $user)
    {
        return view('backend.auth.user.show')
            ->withUser($user);
    }

    public function assign(User $user){

        if($user->can('staff.inhouse')){

            $offices = Office::get();
            return view('backend.auth.user.assign', compact('user', 'offices'));

        }else{
            return redirect()->back()->withFlashWarning('Invalid user permission.');

        }
    }

    public function assignSave(AssignUserRequest $request, $id){

        $user = User::findOrFail($id);


        if($user->can('staff.inhouse')){
            $user->office_id = $request->office;
            $user->save();
            return redirect()->back()->withFlashSuccess(__('The user was successfully updated.'));
        }else{
            return redirect()->back()->withFlashWarning('Invalid user permission.');

        }


    }

    /**
     * @param  EditUserRequest  $request
     * @param  User  $user
     *
     * @return mixed
     */
    public function edit(EditUserRequest $request, User $user)
    {


        $arr = [
            'Administrator' => Permission::where('name', 'admin.access.user')->with('children')->first(),
            'Staff' => Permission::where('name', 'staff')->with('children')->first(),
        ];


        $roles = $this->roleService->get();

        return view('backend.auth.user.edit', compact('roles', 'user', 'arr'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->userService->update($user, $request->validated());

        return redirect()->route('admin.auth.user.show', $user)->withFlashSuccess(__('The user was successfully updated.'));
    }

    /**
     * @param  DeleteUserRequest  $request
     * @param  User  $user
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function destroy(DeleteUserRequest $request, User $user)
    {
        $this->userService->delete($user);

        return redirect()->route('admin.auth.user.deleted')->withFlashSuccess(__('The user was successfully deleted.'));
    }
}
