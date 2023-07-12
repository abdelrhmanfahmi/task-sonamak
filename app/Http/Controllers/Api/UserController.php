<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Http\Resources\UserResource;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Mail\UserMail;

class UserController extends Controller
{
    public function __construct(private UserRepository $userRepository)
    {

    }

    public function index(Request $request)
    {
        $users = $this->userRepository->get([], false , [] , [] , 15 , 'created_at' , 'asc' , false);
        return UserResource::collection($users);
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $user = $this->userRepository->store($data);
        $user->assignRole($data['role']);
        \Mail::to($data['email'])->send(new UserMail($user));
        return response()->json(['message' => 'User Saved Successfully'] , 201);
    }

    public function update(UpdateUserRequest $request , $id)
    {
        $data = $request->validated();
        $this->userRepository->update($data , $id);
        if($request->has('role')){
            $user = $this->userRepository->find($id)->syncRoles($data['role']);
        }
        if($request->has('email')){
            \Mail::to($data['email'])->send(new UserMail($user));
        }
        return response()->json(['message' => 'User Updated Successfully'] , 202);
    }

    public function destroy($id)
    {
        try{
            $user = $this->userRepository->find($id);
            $user->roles()->detach();
            $user->destroy($id);
        }
        catch(\Exception $e){
            //do nothing
        }

        return response()->json(['message' => 'User Deleted Successfully'] , 200);
    }
}
