<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;

class MedicController extends Controller
{
    public function index()
    {
        $doctors = User::medic()->paginate(10);
        return view('medic.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('medic.store');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'cedula' => 'required|digits:8',
            'address' => 'nullable|min:6',
            'phone' => 'required',
        ];

        $messages = [
            'name.required' => 'El nombre del médico es obligatorio',
            'name.min' => 'El nombre minimo debe de tener 3 caracteres',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email debe de tener el formato de email',
            'cedula.required' => 'La cédula es un campo obligatorio',
            'cedula.digits' => 'La cedula debe de tener 8 digitos',
            'address.min' => 'La dirección debe de tener minimo 6 caracteres',
            'phone.required' => 'El número de telefono es obligatorio',
        ];

        $this->validate($request, $rules, $messages);

        User::create(
            $request->only('name','email','cedula','address','phone')
            +[
                'role' => 'medico',
                'password' => bcrypt($request->input('password'))
            ]
            );
            $notification = 'El médico se ha creado correctamente';
            return redirect('/medicos')->with(compact('notification') );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $medico = User::medic()->findOrFail($id); //medico seria la variable que estoy pasando en la vista de edit y en compact la estoy llamando otra vez
        return view('medic.edit', compact('medico'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'cedula' => 'required|digits:8',
            'address' => 'nullable|min:6',
            'phone' => 'required',
        ];

        $messages = [
            'name.required' => 'El nombre del médico es obligatorio',
            'name.min' => 'El nombre minimo debe de tener 3 caracteres',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email debe de tener el formato de email',
            'cedula.required' => 'La cédula es un campo obligatorio',
            'cedula.digits' => 'La cedula debe de tener 8 digitos',
            'address.min' => 'La dirección debe de tener minimo 6 caracteres',
            'phone.required' => 'El número de telefono es obligatorio',
        ];

        $this->validate($request, $rules, $messages);
        $user = User::medic()->findOrFail($id);

        $data = $request->only('name','email','cedula','address','phone');
        $password = $request->input('password');

        if($password)
            $data['password'] = bcrypt($password);

        $user->fill($data);
        $user->save();
      
            $notification = 'El médico se ha actualizado correctamente';
            return redirect('/medicos')->with(compact('notification') );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::medic()->findOrFail($id);
        $doctorname = $user->name;
        // dd($specialty->name);
        $user->delete();
        $notification = 'El médico '. $user->name .' se ha eliminado correctamente';

        return redirect('/medicos')->with(compact('notification'));
    }
}
