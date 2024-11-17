<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Specialty;
use App\Http\Controllers\Controller;

class SpecialtyController extends Controller
{

    public function index(){

        $specialties = Specialty::all();
        return view('specialty.index', compact('specialties'));
    }

    public function store(){

        return view ('specialty.store');

    }

    public function sendData(Request $request){

        $rules = [

            'name' => 'required|min:3'
        ];

        $messages = [

            'name.required' => 'El nombre es obligatorio.',
            'name.min' => 'El nombre de la especialidad debe de tener minimo tres caracteres.'
        ];

        $this->validate($request, $rules, $messages);

        $specialty = new Specialty();
        $specialty->name = $request->input('name') ;
        $specialty->description = $request->input('description');
        $specialty->save();
        $notification = 'La especialidad se ha creado correctamente';

        return redirect('/especialidades')->with(compact('notification'));

    }

    public function edit(Specialty $specialty){

        return view ('specialty.update', compact('specialty'));
    }

    public function update(Request $request, Specialty $specialty){

        $rules = [

            'name' => 'required|min:3'
        ];

        $messages = [

            'name.required' => 'El nombre es obligatorio.',
            'name.min' => 'El nombre de la especialidad debe de tener minimo tres caracteres.'
        ];

        $this->validate($request, $rules, $messages);

        $specialty->name = $request->input('name') ;
        $specialty->description = $request->input('description');
        $specialty->save();
        $notification = 'La especialidad se ha actualizado correctamente';

        return redirect('/especialidades')->with(compact('notification'));

    } 

    public function destroy(Specialty $specialty){
        $deletename = $specialty->name;
        // dd($specialty->name);
        $specialty->delete();
        $notification = 'La especialidad '. $specialty->name .' se ha eliminado correctamente';

        return redirect('/especialidades')->with(compact('notification'));
    }
}
