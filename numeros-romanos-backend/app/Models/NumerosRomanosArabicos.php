<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NumerosRomanosArabicos extends Model {
    private $numerosRomanos = [
        'M'  => 1000, 
        'CM' => 900, 
        'D'  => 500, 
        'CD' => 400, 
        'C'  => 100, 
        'XC' => 90, 
        'L'  => 50, 
        'XL' => 40, 
        'X'  => 10, 
        'IX' => 9, 
        'V'  => 5, 
        'IV' => 4, 
        'I'  => 1
    ];

    public function transformaParaRomanos($num) { 
        $numeroEnviado = $num; 
        $numeroConvertido = ''; 
    
        foreach ($this->numerosRomanos as $romano => $numero){ 
            $entrontrados = intdiv($numeroEnviado, $numero); 

            $numeroConvertido .= str_repeat($romano, $entrontrados); 

            $numeroEnviado = $numeroEnviado % $numero; 
        } 
    
        return $numeroConvertido; 
    }

    public function transformaParaArabicos($romano) {
        $numeroEnviado = $romano; 
        $numeroConvertido = 0; 
        $i = 0;
    
        while ($i < strlen($numeroEnviado)) {
            if ($i + 1 < strlen($numeroEnviado) && isset($this->numerosRomanos[$numeroEnviado[$i] . $numeroEnviado[$i + 1]])) {
                $numeroConvertido += $this->numerosRomanos[$numeroEnviado[$i] . $numeroEnviado[$i + 1]];
                $i += 2;
            } else {
                $numeroConvertido += $this->numerosRomanos[$numeroEnviado[$i]];
                $i++;
            }
        }
    
        return $numeroConvertido; 
    }
}