<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\NumerosRomanosArabicosController;

Route::post('romano', [NumerosRomanosArabicosController::class, 'alteraParaRomano']);
Route::post('arabico', [NumerosRomanosArabicosController::class, 'alteraParaArabico']);