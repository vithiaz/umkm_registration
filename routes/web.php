<?php

use App\Http\Livewire\Base\Homepage;
use App\Http\Livewire\Notifications;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\UmkmVerification;
use App\Http\Livewire\Admin\AddNewsPage;
use App\Http\Livewire\Base\Registration;
use App\Http\Livewire\User\UmkmPrograms;
use App\Http\Livewire\User\ProfileSettings;
use App\Http\Livewire\User\UmkmRegistration;
use App\Http\Livewire\Admin\UmkmProgramDetails;
use App\Http\Livewire\Admin\AccountVerification;
use App\Http\Livewire\Admin\UmkmPrograms as AdminUmkmPrograms;


// Auth::routes();

Route::get('/', Homepage::class)->name('homepage'); 
Route::get('/register', Registration::class)->name('register');

Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('homepage');
})->name('logout');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// User Middleware
Route::middleware('auth')->group(function () {
    Route::get('/profile-settings', ProfileSettings::class)->name('profile');
    Route::get('/programs', UmkmPrograms::class)->name('umkm-programs');        
    Route::get('/notifications', Notifications::class)->name('notifications');        
    
    Route::middleware(['is_verified'])->group(function () {
        Route::get('/registration', UmkmRegistration::class)->name('umkm-registration');
    });
    
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/account-verification', AccountVerification::class)->name('admin.account-verify');
        Route::get('/umkm-verification', UmkmVerification::class)->name('admin.umkm-verify');
        Route::get('/programs', AdminUmkmPrograms::class)->name('admin.umkm-programs');        
        Route::get('/program/{program_id}', UmkmProgramDetails::class)->name('admin.umkm-program-details');        
        Route::get('/news', AddNewsPage::class)->name('admin.news');
    });
});



