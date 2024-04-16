<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Label::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $labels = Label::orderBy('id')->paginate();
        return view('label.index', compact('labels'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('label.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|unique:labels',
            'description' => 'nullable',
        ], [
            'name.required' => __('label.validation.required'),
            'name.unique' => __('label.validation.unique'),
        ]);

        $label = new Label($data);
        $label->save();
        flash(__('label.flash.store'))->success();

        return redirect()->route('labels.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Label $label)
    {
        return view('label.edit', compact('label'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Label $label)
    {
        $data = $this->validate($request, [
            'name' => 'required|unique:labels,name,' . $label->id,
            'description' => 'nullable',
        ], [
            'name.required' => __('label.validation.required'),
            'name.unique' => __('label.validation.unique'),
        ]);

        $label->fill($data);
        $label->save();
        flash(__('label.flash.update'))->success();

        return redirect()->route('labels.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Label $label)
    {
        if ($label->tasks()->exists()) {
            flash(__('label.flash.delete_error'))->error();
            return back();
        }

        $label->delete();
        flash(__('label.flash.delete'))->success();

        return redirect()->route('labels.index');
    }
}
