<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Ramsey\Uuid\Uuid;

class UserController extends Controller
{

    public function index()
    {
        $getAllUser = User::latest()->get();

        return view('user.index', compact('getAllUser'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(CreateUserRequest $request)
    {
        $validateData = $request->validated();
        $getPasswordFromRequest = $request->password;
        $validateData['password'] = bcrypt($getPasswordFromRequest);
        $validateData['uuid'] = Uuid::uuid4()->toString();
        User::create($validateData);
        return redirect('/user');
    }

    public function show($saveUuidUserFromRoute)
    {
        $getDataUser = User::where('uuid', $saveUuidUserFromRoute)->first();
        return view('user.show', compact('getDataUser'));
    }

    public function edit($saveUuidUserFromRoute)
    {
        $getDataUser = User::where('uuid', $saveUuidUserFromRoute)->first();
        return view('user.edit', compact('getDataUser'));
    }

    public function update(UpdateUserRequest $request)
    {
        $validateData = $request->validated();
        $getPasswordFromRequest = $request->password;
        $validateData['password'] = bcrypt($getPasswordFromRequest);
        User::where('uuid', $request->uuid)->update($validateData);
        return redirect('/user');
    }

    public function delete($saveUuidUserFromRoute)
    {
        $findTheUserToDelete = User::where('uuid', $saveUuidUserFromRoute)->first();
        User::destroy($findTheUserToDelete->id);
        return redirect('/user');
    }
}
