<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showStepOneForm()
    {
        return view('auth.register-step-one');
    }

    public function postStepOneForm(Request $request)
    {
        $validator = $this->validatorStepOne($request->all());

        // Check if NIC is unique
        $nic = $request->input('nic');
        $nicExists = User::where('nic', $nic)->exists();

        if ($nicExists) {
            return redirect()->back()->withErrors(['nic' => 'The NIC has already been taken.'])->withInput();
        }

        $validator->validate();
        $request->session()->put('register', $request->all());

        return redirect()->route('register.step.two');
    }

    public function showStepTwoForm()
    {
        return view('auth.register-step-two');
    }

    public function postStepTwoForm(Request $request)
    {
        $this->validatorStepTwo($request->all())->validate();

        $data = array_merge($request->session()->get('register'), $request->all());

        $user = $this->create($data);

        $request->session()->forget('register');

        auth()->login($user);

        return redirect()->route('home');
    }

    protected function validatorStepOne(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:255'],
            'nic' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function validatorStepTwo(array $data)
    {
        return Validator::make($data, [
            'nic_front' => ['required', 'image'],
            'nic_back' => ['required', 'image'],
            'student_id_front' => ['required', 'image'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'phone_number' => $data['phone_number'],
            'nic' => $data['nic'],
            'address' => $data['address'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'nic_front' => $data['nic_front']->store('nic_front'),
            'nic_back' => $data['nic_back']->store('nic_back'),
            'student_id_front' => $data['student_id_front']->store('student_id_front'),
            'role' => 'user',  // Default role
        ]);
    }
}
