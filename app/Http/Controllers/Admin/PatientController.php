<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;

class PatientController extends Controller
{
    public function index()
    {
        $patients = User::patients()->paginate(10);
        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('patients.store');
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
            'name.required' => 'El nombre del paciente es obligatorio',
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
                'role' => 'paciente',
                'password' => bcrypt($request->input('password'))
            ]
            );
            $notification = 'El paciente se ha creado correctamente';
            return redirect('/pacientes')->with(compact('notification') );
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
        $patients = User::patients()->findOrFail($id); //patients seria la variable que estoy pasando en la vista de edit y en compact la estoy llamando otra vez
        return view('patients.edit', compact('patients'));
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
            'name.required' => 'El nombre del paciente es obligatorio',
            'name.min' => 'El nombre minimo debe de tener 3 caracteres',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email debe de tener el formato de email',
            'cedula.required' => 'La cédula es un campo obligatorio',
            'cedula.digits' => 'La cedula debe de tener 8 digitos',
            'address.min' => 'La dirección debe de tener minimo 6 caracteres',
            'phone.required' => 'El número de telefono es obligatorio',
        ];

        $this->validate($request, $rules, $messages);
        $user = User::patients()->findOrFail($id);

        $data = $request->only('name','email','cedula','address','phone');
        $password = $request->input('password');

        if($password)
            $data['password'] = bcrypt($password);

        $user->fill($data);
        $user->save();
      
            $notification = 'El paciente se ha actualizado correctamente';
            return redirect('/pacientes')->with(compact('notification') );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::patients()->findOrFail($id);
        $pacientename = $user->name;
        // dd($specialty->name);
        $user->delete();
        $notification = 'El paciente '. $user->name .' se ha eliminado correctamente';

        return redirect('/pacientes')->with(compact('notification'));
    }

}
