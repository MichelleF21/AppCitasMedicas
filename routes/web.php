<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('/auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'admin'])->group(function () {
            
            //Especialidades
        Route::get('/especialidades', [App\Http\Controllers\Admin\SpecialtyController::class, 'index']);
        Route::get('/especialidades/create', [App\Http\Controllers\Admin\SpecialtyController::class, 'store']);
        Route::get('/especialidades/{specialty}/edit', [App\Http\Controllers\Admin\SpecialtyController::class, 'edit']);
        Route::put('/especialidades/{specialty}', [App\Http\Controllers\Admin\SpecialtyController::class, 'update']);
        Route::post('/especialidades', [App\Http\Controllers\Admin\SpecialtyController::class, 'sendData']);
        Route::delete('/especialidades/{specialty}', [App\Http\Controllers\Admin\SpecialtyController::class, 'destroy']);

        //Médicos
        Route::resource('medicos', 'App\Http\Controllers\Admin\MedicController');

        //Pacientes
        Route::resource('pacientes', 'App\Http\Controllers\Admin\PatientController');

});

Route::middleware(['auth', 'medico'])->group(function () {

    Route::get('/horarios', [App\Http\Controllers\Doctor\HorariosController::class, 'edit']);
    Route::post('/horarios', [App\Http\Controllers\Doctor\HorariosController::class, 'store']);
    
});

// Route::middleware(['auth', 'paciente'])->group(function () {

//     Route::get('/horarios', [App\Http\Cotnrollers\Patient\Controller::class, 'edit']);
    
// });