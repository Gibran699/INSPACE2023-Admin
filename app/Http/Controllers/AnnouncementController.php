<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Program;
use App\Http\Requests\AnnouncementStoreRequest;
use App\Http\Requests\AnnouncementUpdateRequest;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Announcement';
        $data_announcement = Announcement::all();
        return view('announcements.index', [
            'title' => $title,
            'announcement' => $data_announcement,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Add Announcement';
        $data_announcement = Announcement::all();
        $programs = Program::where('is_active', 1)->get();

        return view('announcements.create', [
            'title' => $title,
            'announcement' => $data_announcement,
            'programs' => $programs,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnnouncementStoreRequest $request)
    {
        try {
            Announcement::create([
                'title' => $request->title,
                'description' => $request->description,
                'short_description' => $request->short_description,
                // 'program_id' => $request->program_id,
                'datetime' => $request->datetime,
            ]);
            addToLog('Membuat pengumuman');
            return redirect()->route('announcements.index')->with('success', 'Announcement successfully added.');
        } catch (\Throwable $th) {
            return redirect()->route('announcements.create')->with('error', 'Something went wrong. Make sure the data you have entered is correct and there is no duplication. ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function show(Announcement $announcement)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function edit(Announcement $announcement)
    {
        $title = 'Edit Announcement';

        return view('announcements.edit', [
            'title' => $title,
            'announcement' => $announcement,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function update(AnnouncementUpdateRequest $request, Announcement $announcement)
    {
        try {
            $announcement->title = $request->title;
            $announcement->description = $request->description;
            $announcement->short_description = $request->short_description;
            $announcement->program_id = $request->program_id;
            $announcement->datetime = $request->datetime;
            $announcement->update();

            addToLog('Update pengumuman');
            return redirect()->route('announcements.index')->with('success', 'Announcement successfully updated.');
        } catch (\Throwable $th) {
            return redirect()->route('announcements.edit')->with('error', 'Something went wrong. Make sure the data you have entered is correct and there is no duplication.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        addToLog('Menghapus pengumuman');
        return redirect()->route('announcements.index')->with('success', 'Announcement successfully deleted.');
    }
}
