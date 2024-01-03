<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Program;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFaqRequest;
use App\Http\Requests\UpdateFaqRequest;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'List FAQ';
        $data_faqs = Faq::all();
        $programs = Program::where('is_active', 1)->get();
        return view('faq.data', [
            'title' => $title,
            'faqs' => $data_faqs,
            'programs' => $programs,
        ]);
    }

    public function getData()
    {
        if (request()->ajax()) {
            $faq = Faq::all();

            return response()->json($faq);
        }

        return abort(404);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Add FAQ';
        $data_faqs = Faq::all();
        $programs = Program::where('is_active', 1)->get();

        return view('faq.create', [
            'title' => $title,
            'faqs' => $data_faqs,
            'programs' => $programs,
        ]);
    }

    public function activateProgram($id){
        if (request()->ajax()) {
            $faq = Faq::find($id);
            $faq->update(['status' => $faq->status == 'active' ? 'deactive' : 'active']);

            return response()->json(['message' => 'Program has been updated!'], 200);
        }
        abort(404);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Faq::create($request->except(['_token']));
        $title = 'faq';
        $data_faqs = faq::all();
        $programs = Program::where('is_active', 1)->get();
        addToLog('Membuat FAQ');
        return view('faq.data', [
            'title' => $title,
            'faqs' => $data_faqs,
            'programs' => $programs,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faq
     * @return \Illuminate\Http\Response
     */
    public function edit(Faq $faq)
    {
        $title = 'Edit FAQ';

        return view('faq.edit', [
            'title' => $title,
            'faqs' => $faq
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $announcement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'question' => 'required',
            'answer' => 'required',
            'font' => 'required'
        ]);

        // Find the FAQ record by its ID
        $faq = Faq::findOrFail($id);

        // Update the FAQ record with the new data
        $faq->question = $validatedData['question'];
        $faq->answer = $validatedData['answer'];
        $faq->font = $validatedData['font'];
        $faq->save();
        addToLog('Update FAQ');

        // Redirect to the appropriate page with a success message
        return redirect()->route('faq.index')->with('success', 'FAQ updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();
        addToLog('Menghapus FAQ');
        return redirect()->route('faq.index')->with('success', 'Announcement successfully deleted.');
    }
}
