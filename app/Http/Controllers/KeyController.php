<?php

namespace App\Http\Controllers;

use App\Http\Requests\KeyStoreRequest;
use App\Http\Requests\KeyUpdateRequest;
use App\Models\Key;
use Illuminate\Http\Request;

class KeyController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keys = Key::all();

        return view('key.index', compact('keys'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('key.create');
    }

    /**
     * @param \App\Http\Requests\KeyStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(KeyStoreRequest $request)
    {
        $key = Key::create($request->validated());

        $request->session()->flash('key.id', $key->id);

        return redirect()->route('key.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Key $key
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Key $key)
    {
        return view('key.show', compact('key'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Key $key
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Key $key)
    {
        return view('key.edit', compact('key'));
    }

    /**
     * @param \App\Http\Requests\KeyUpdateRequest $request
     * @param \App\Models\Key $key
     * @return \Illuminate\Http\Response
     */
    public function update(KeyUpdateRequest $request, Key $key)
    {
        $key->update($request->validated());

        $request->session()->flash('key.id', $key->id);

        return redirect()->route('key.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Key $key
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Key $key)
    {
        $key->delete();

        return redirect()->route('key.index');
    }
}
