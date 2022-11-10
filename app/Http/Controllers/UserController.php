<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $users = User::all();

        return view('user.index', compact('users'));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        return view('user.create');
    }

    /**
     * @param \App\Http\Requests\UserStoreRequest $request
     * @return Response
     */
    public function store(UserStoreRequest $request)
    {
        $user = User::create($request->validated());

        $request->session()->flash('user.id', $user->id);

        return redirect()->route('user.index');
    }

    /**
     * @param Request $request
     * @param \App\Models\User $user
     * @return Response
     */
    public function show(Request $request, User $user)
    {
        return view('user.show', compact('user'));
    }

    /**
     * @param Request $request
     * @param \App\Models\User $user
     * @return Response
     */
    public function edit(Request $request, User $user)
    {
        return view('user.edit', compact('user'));
    }

    /**
     * @param \App\Http\Requests\UserUpdateRequest $request
     * @param \App\Models\User $user
     * @return Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->validated());

        $request->session()->flash('user.id', $user->id);

        return redirect()->route('user.index');
    }

    /**
     * @param Request $request
     * @param \App\Models\User $user
     * @return Response
     */
    public function destroy(Request $request, User $user)
    {
        $user->delete();

        return redirect()->route('user.index');
    }
}
