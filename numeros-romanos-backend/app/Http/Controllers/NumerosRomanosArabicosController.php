<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NumerosRomanosArabicos;

class NumerosRomanosArabicosController extends Controller
{
    public function alteraParaRomano(Request $request)
    {
        $regras = [
            'numero_arabico' => 'required|integer|min:1|max:3999'
        ];

        $feedback = [
            'numero_arabico.required' => 'O numero_arabico é obrigatório.',
            'numero_arabico.integer' => 'O campo numero_arabico deve ser um inteiro.',
            'numero_arabico.min' => 'O campo numero_arabico deve ser no mínimo 1.',
            'numero_arabico.max' => 'O campo numero_arabico deve ser no máximo 3999.'
        ];

        $request->validate($regras, $feedback);

        $numeroArabico = $request->input('numero_arabico');

        $converter = new NumerosRomanosArabicos();
        
        $numeroRomano = $converter->transformaParaRomanos($numeroArabico);

        return response()->json([
            'numero_romano' => $numeroRomano
        ]);
    }

    public function alteraParaArabico(Request $request)
    {
        $regras = [
            'numero_romano' => 'required|regex:/^[MDCLXVI]+$/i'
        ];

        $feedback = [
            'numero_romano.required' => 'O campo numero_romano é obrigatório.',
            'numero_romano.regex' => 'O campo número romano deve conter apenas os caracteres M, D, C, L, X, V, I.'
        ];

        $request->validate($regras, $feedback);

        $numeroRomano = $request->input('numero_romano');

        $converter = new NumerosRomanosArabicos();

        $numeroArabico = $converter->transformaParaArabicos($numeroRomano);

        return response()->json([
            'numero_arabico' => $numeroArabico
        ]);
    }
}