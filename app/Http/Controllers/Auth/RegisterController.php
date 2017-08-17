<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/register';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
        $this->middleware('preventBackHistory');
        $this->middleware('auth');
    }

    public function guardianAttribute()
    {
        return \View::make('auth.partials.relationship-column');
    }


     /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function register(Request $request)
    {
        $this->validate(request(),[
            'first_name' => 'required|string|max:200|regex:/^[a-z ,.\'-]+$/i',
            'surname' => 'required|string|max:200|regex:/^[a-z ,.\'-]+$/i',
            'date_of_birth' => 'required',
            'gender' => 'required|string',
            'education' => 'required|string',
            'address' => 'required|string|max:255|regex:/^[a-z ,.\'-]+$/i',
            'country' => 'required|string|regex:/^[a-z ,.\'-]+$/i',
            'phone' => 'required',
            'user_name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'type' => 'required|string',
            'password' => 'required|string|min:6|confirmed'
        ]);

        if (request('type') === 'guardian'){
            $user = User::create([
                'first_name' => request('first_name'),
                'surname' => request('surname'),
                'date_of_birth' => request('date_of_birth'),
                'gender' => request('gender'),
                'education' => request('education'),
                'address' => request('address'),
                'country' => request('country'),
                'phone' => request('phone'),
                'user_name' => request('user_name'),
                'email' => request('email'),
                'type' => '\App\Guardian',
                'password' => bcrypt(request('password'))
            ]);

            // specify user guardian relationship
            $user->data()->create([
                'relationship' => request('relationship'), 
                'user_id' => $user->id
            ]);

            // send a message to the session that greets/ thank user
            session()->flash('message', $user->first_name." ".$user->surname);
            return redirect($this->redirectTo);

        } else if (request('type') === 'admin'){
            $user = User::create([
                'first_name' => request('first_name'),
                'surname' => request('surname'),
                'date_of_birth' => request('date_of_birth'),
                'gender' => request('gender'),
                'education' => request('education'),
                'address' => request('address'),
                'country' => request('country'),
                'phone' => request('phone'),
                'user_name' => request('user_name'),
                'email' => request('email'),
                'type' => request('type'),
                'password' => bcrypt(request('password'))
            ]);

            // send a message to the session that greets/ thank user
            session()->flash('message', $user->first_name." ".$user->surname);
            return redirect($this->redirectTo);
        }
    }
}
