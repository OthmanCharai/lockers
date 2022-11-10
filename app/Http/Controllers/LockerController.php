<?php

namespace App\Http\Controllers;

use App\Http\Requests\LockerStoreRequest;
use App\Http\Requests\LockerUpdateRequest;
use App\Models\Locker;
use Illuminate\Http\Request;

class LockerController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $lockers = Locker::all();

        return view('locker.index', compact('lockers'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('locker.create');
    }

    /**
     * @param \App\Http\Requests\LockerStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(LockerStoreRequest $request)
    {
        $locker = Locker::create($request->validated());

        $request->session()->flash('locker.id', $locker->id);

        return redirect()->route('locker.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Locker $locker
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Locker $locker)
    {
        return view('locker.show', compact('locker'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Locker $locker
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Locker $locker)
    {
        return view('locker.edit', compact('locker'));
    }

    /**
     * @param \App\Http\Requests\LockerUpdateRequest $request
     * @param \App\Models\Locker $locker
     * @return \Illuminate\Http\Response
     */
    public function update(LockerUpdateRequest $request, Locker $locker)
    {
        $locker->update($request->validated());

        $request->session()->flash('locker.id', $locker->id);

        return redirect()->route('locker.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Locker $locker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Locker $locker)
    {
        $locker->delete();

        return redirect()->route('locker.index');
    }
}
