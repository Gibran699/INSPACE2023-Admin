<?php

use App\Http\Controllers\ActiveProgramController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AddonController;
use App\Http\Controllers\AddonVariantController;
use App\Http\Controllers\AgendaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComitteeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\MedpartController;
use App\Http\Controllers\ParticipantAgendaController;
use App\Http\Controllers\ParticipantsController;
use App\Http\Controllers\TicketController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// web
Route::get('/homepage', function () {
    // $programs = Program::where('is_active', 1)->get();
    // $images = Medpart::all();
    return 'halo';
    // return view('homepage.index', [
    //     'programs' => $programs,
    //     'images' => $images,
    // ]);
});

Route::get('login', [App\Http\Controllers\Auth\ComitteeLoginController::class, 'showLoginForm'])->name('comittee.login');
Route::post('login', [App\Http\Controllers\Auth\ComitteeLoginController::class, 'login'])->name('comittee.login.post');
Route::post('logout', [App\Http\Controllers\Auth\ComitteeLoginController::class, 'logout'])->name('comittee.logout');

Route::middleware(['comittee','preventBack'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::group(['prefix' => 'comittees', 'as' => 'comittees.','middleware' => 'accessMenu:comittees'], function (){
        Route::get('/', [ComitteeController::class, 'index'])->name('index');
        Route::get('/get-data', [ComitteeController::class, 'getData'])->name('getData');
        Route::get('/show/{comittee}', [ComitteeController::class, 'show'])->name('show');
        Route::post('/update/{comittee}', [ComitteeController::class, 'update'])->name('update');
        Route::post('/reset-password/{comittee}', [ComitteeController::class, 'reset_password'])->name('reset_password');
        Route::get('/import-form', [ComitteeController::class, 'importForm'])->name('importForm');
        Route::post('/import-form', [ComitteeController::class, 'import'])->name('import');
    });
    Route::get('comittees/settings', [ComitteeController::class, 'settings'])->name('comittees.settings');
    Route::post('comittees/settings', [ComitteeController::class, 'update_settings'])->name('comittees.update_settings');
    Route::get('comittees/settings/password', [ComitteeController::class, 'settings_password'])->name('comittees.settings_password');
    Route::post('comittees/settings/password', [ComitteeController::class, 'update_settings_password'])->name('comittees.update_settings_password');

    Route::group(['prefix' => 'participants', 'as' => 'participants.', 'middleware' => 'accessMenu:participants'], function (){
        Route::get('/', [ParticipantsController::class, 'index'])->name('index');
        Route::put('/{user}/reset-password', [ParticipantsController::class, 'resetPassword'])->name('resetPassword');
        Route::put('/{user}', [ParticipantsController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'programs', 'as' => 'programs.', 'middleware' => 'accessMenu:programs'], function (){
        Route::get('/', [ProgramController::class, 'index'])->name('index');
        Route::get('/get-data', [ProgramController::class, 'getData'])->name('getData');
        Route::get('/create', [ProgramController::class, 'create'])->name('create');
        Route::post('/store', [ProgramController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [ProgramController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [ProgramController::class, 'update'])->name('update');
        Route::get('/export-active-program', [ProgramController::class, 'exportActiveProgram'])->name('exportActiveProgram')->withoutMiddleware('preventBack');
        Route::post('/toggle-activate/{id}', [ProgramController::class, 'activateProgram'])->name('activateProgram');
        Route::get('/timeline/{program}', [ProgramController::class, 'makeOrEditTimeline'])->name('makeOrEditTimline');
        Route::post('/timeline/{program}', [ProgramController::class, 'saveTimeline'])->name('saveTimeline');
    });

    Route::group(['prefix' => 'active/{program:slug}', 'as' => 'active.', 'middleware' => 'accessMenu:active'], function (){
        Route::get('/', [ActiveProgramController::class, 'index'])->name('program');
        Route::get('/individual/{user}/details', [ActiveProgramController::class, 'user_details'])->name('program.user.details');
        Route::get('/{uKey}/details', [ActiveProgramController::class, 'details'])->name('program.details');
        Route::get('/generate-otp', [ActiveProgramController::class, 'generateManageOtp']);
        Route::post('/manage/{program_team}', [ActiveProgramController::class, 'ManageProgramTeam']);

        Route::get('/selection/{no_stage}', [ActiveProgramController::class, 'selection'])->name('program.selection');
        Route::post('/selection/{no_stage}', [ActiveProgramController::class, 'update_selection'])->name('program.selection.update');
        Route::get('/winner', [ActiveProgramController::class, 'winner'])->name('program.winner');
        Route::get('/add-winner', [ActiveProgramController::class, 'add_winner'])->name('program.add_winner');
        Route::post('/add-winner', [ActiveProgramController::class, 'save_winner'])->name('program.add_winner.save');

        Route::post('/{uKey}/accept-payment', [ActiveProgramController::class, 'accept_payment'])->name('program.accept_payment');
        Route::post('/individual/{user}/accept-payment', [ActiveProgramController::class, 'user_accept_payment'])->name('program.accept_payment.user');

        Route::get('/{team:code}/files', [ActiveProgramController::class, 'download_files'])->name('program.download_files');
        Route::get('/individual/{user}/files', [ActiveProgramController::class, 'user_download_files'])->name('program.download_files.user');
    });

    Route::resource('announcements', App\Http\Controllers\AnnouncementController::class)->middleware('accessMenu:announcements');

    Route::group(['prefix' => 'medpart', 'as' => 'medpart.', 'middleware' => 'accessMenu:medpart'], function(){
        Route::get('/get-data', [MedpartController::class, 'getData'])->name('getData');
        Route::post('/toggle-active/{id}', [App\Http\Controllers\MedpartController::class, 'toggleActive'])->name('toggleActive');
        Route::get('/', [MedpartController::class, 'index'])->name('index');
        Route::get('/create', [MedpartController::class, 'create'])->name('create');
        Route::post('/store', [MedpartController::class, 'store'])->name('store');
        Route::get('/{medpart}/edit', [MedpartController::class, 'edit'])->name('edit');
        Route::put('/{medpart}', [MedpartController::class, 'update'])->name('update');
        Route::delete('/{medpart}', [MedpartController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'faq', 'as' => 'faq.', 'middleware' => 'accessMenu:faq'], function (){
        Route::get('/get-data', [FaqController::class, 'getData'])->name('getData');
        Route::post('/toggle-active/{id}', [FaqController::class, 'activateProgram'])->name('toogleActive');
        Route::get('/', [FaqController::class, 'index'])->name('index');
        Route::get('/create', [FaqController::class, 'create'])->name('create');
        Route::post('/store', [FaqController::class, 'store'])->name('store');
        Route::get('/{faq}/edit', [FaqController::class, 'edit'])->name('edit');
        Route::put('/{faq}', [FaqController::class, 'update'])->name('update');
        Route::delete('/{faq}', [FaqController::class, 'destroy'])->name('destroy');
    });

    Route::resource('deskripsi', App\Http\Controllers\DeskripsiController::class)->middleware('accessMenu:deskripsi');

    Route::group(['prefix' => 'division', 'as' => 'divisions.'], function (){
        Route::get('/', [DivisionController::class, 'index'])->name('index');
        Route::get('/get-data', [DivisionController::class, 'getData'])->name('getData');
        Route::post('/store', [DivisionController::class, 'store'])->name('store');
        Route::get('/{division}', [DivisionController::class, 'show'])->name('show');
        Route::post('/{division}/update', [DivisionController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'activity-log', 'as' => 'activitylogs.'], function (){
        Route::get('/', [ActivityLogController::class, 'index'])->name('index');
        Route::get('/export', [ActivityLogController::class, 'export'])->name('export')->withoutMiddleware('preventBack');
        Route::delete('/delete', [ActivityLogController::class, 'deleteAll'])->name('delete');
    });

    Route::group(['prefix' => 'agenda', 'as' => 'agenda.', 'middleware' => 'accessMenu:agenda'], function (){
        Route::get('/', [AgendaController::class, 'index'])->name('index');
        Route::get('/get-data', [AgendaController::class, 'getData'])->name('getData');
        Route::post('/store', [AgendaController::class, 'store'])->name('store');
        Route::get('/{agenda}', [AgendaController::class, 'show'])->name('show');
        Route::post('/{agenda}/export', [AgendaController::class, 'export'])->name('export')->withoutMiddleware('preventBack');
        Route::post('/{agenda}/update', [AgendaController::class, 'update'])->name('update');
        Route::post('/toggle-active/{agenda}', [AgendaController::class, 'activateAgenda'])->name('toogleActive');


        Route::group(['prefix' => '{agenda}/ticket', 'as' => 'ticket.'], function (){
            Route::get('/', [TicketController::class, 'index'])->name('index');
            Route::get('/get-data', [TicketController::class, 'getData'])->name('getData');
            Route::get('/{ticket}/participant', [TicketController::class, 'participant'])->name('participant');
            Route::post('/{ticket}/participant/{participant}/re-send', [TicketController::class, 'reSend'])->name('reSend');
            Route::post('/{ticket}/participant/{participant_ticket}/accept', [TicketController::class, 'acceptProof'])->name('acceptProof');
            Route::post('/{ticket}/participant/{participant_ticket}/decline', [TicketController::class, 'declineProof'])->name('declineProof');
            Route::post('/{ticket}/participant/{participant_ticket}/{participant}/check-in', [TicketController::class, 'comitteCheckIn'])->name('comitteCheckIn');
            Route::post('/store', [TicketController::class, 'store'])->name('store');
            Route::get('/{ticket}', [TicketController::class, 'show'])->name('show');
            Route::post('/{ticket}/update', [TicketController::class, 'update'])->name('update');
        });
    });

    Route::group(['prefix' => 'addon-variant', 'as' => 'addonVariant.', 'middleware' => 'accessMenu:addon-variant'], function (){
        Route::get('/', [AddonVariantController::class, 'index'])->name('index');
        Route::get('/get-data', [AddonVariantController::class, 'getData'])->name('getData');
        Route::post('/store', [AddonVariantController::class, 'store'])->name('store');
        Route::get('/{variant}', [AddonVariantController::class, 'show'])->name('show');
        Route::post('/{variant}/update', [AddonVariantController::class, 'update'])->name('update');
        Route::post('/toggle-active/{variant}', [AddonVariantController::class, 'activateAddon'])->name('toogleActive');

        Route::group(['prefix' => '{variant}/addon', 'as' => 'addon.'], function () {
            Route::get('/', [AddonController::class, 'index'])->name('index');
            Route::get('/get-data', [AddonController::class, 'getData'])->name('getData');
            Route::post('/store', [AddonController::class, 'store'])->name('store');
            Route::get('/{addon}', [AddonController::class, 'show'])->name('show');
            Route::post('/{addon}/update', [AddonController::class, 'update'])->name('update');
        });
    });

});

Route::get('/agenda/ticket/check-in/{data}', [TicketController::class, 'checkIn'])->name('ticket.checkIn');
Route::get('/agenda/ticket/check-in-sample', [TicketController::class, 'sampleCheckIn'])->name('ticket.sampleCheckIn');

Route::prefix('playground')->group(function () {
    Route::get('registration', [App\Http\Controllers\Playground\RegistrationController::class, 'index'])->name('registration');
    Route::post('registration', [App\Http\Controllers\Playground\RegistrationController::class, 'store'])->name('registration.store');

    Route::get('registration/user', [App\Http\Controllers\Playground\RegistrationController::class, 'user_index'])->name('registration.user');
    Route::post('registration/user', [App\Http\Controllers\Playground\RegistrationController::class, 'user_store'])->name('registration.store.user');

    Route::get('registration/{program:slug}/{team:code}/upload', [App\Http\Controllers\Playground\RegistrationController::class, 'upload'])->name('registration.upload');
    Route::post('registration/{program:slug}/{team:code}/upload', [App\Http\Controllers\Playground\RegistrationController::class, 'store_upload'])->name('registration.upload.save');

    Route::get('registration/{program:slug}/user/{user}/upload', [App\Http\Controllers\Playground\RegistrationController::class, 'user_upload'])->name('registration.upload.user');
    Route::post('registration/{program:slug}/user/{user}/upload', [App\Http\Controllers\Playground\RegistrationController::class, 'user_store_upload'])->name('registration.upload.save.user');

    Route::get('send-mail', function () {

        $details = [
            'title' => 'Mail from INSPACE',
            'body' => 'This is for testing email using smtp'
        ];

        // \Mail::to('priandani25@gmail.com')->send(new \App\Mail\MyTestMail($details));

        // if (\Mail::failures()) {
        //     return response()->json(['msg' => 'Sorry! Please try again latter']);
        // } else {
        //     return response()->json(['msg' => 'Great! Successfully send in your mail']);
        // }
    });

    Auth::routes(['verify' => true]);
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    });
});
