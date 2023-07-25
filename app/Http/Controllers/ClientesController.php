<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Clientes;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class ClientesController extends Controller
{
    public function index(Request $request)
    {   
        $length = $request->input('length');
        $sortBy = $request->input('column');
        $orderBy = $request->input('dir');
        $searchValue = $request->input('search');
        
        $query = Clientes::eloquentQuery($sortBy, $orderBy, $searchValue);

        $data = $query->paginate($length);
        
        return new DataTableCollectionResource($data);
    }
}
