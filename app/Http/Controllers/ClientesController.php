<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\SpladeTable;
use App\Models\Clientes;

class ClientesController extends Controller
{
    
    public function retorna(){
        $clientes = Clientes::get();

        return view('clientes' , [
            'clientes' => SpladeTable::for($clientes)
                ->column('id')
                ->column('nome')
        ]);
        
    }
}
