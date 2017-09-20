<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class GuardianLoginController extends Controller
{
    // only people who are admins and are not login can access this
    public function __construct()
    {
        $this->middleware('guest:guardian');
    }

    public function showLoginForm()
    {
    	return view('auth.guardian-login');
    }

    public function login(Request $request)
    {
        // validate login data
        $this->validate($request, [
            'phone' => 'required|min:10|max:13',
            'password' => 'required|min:6'
        ]);

        // attempt to log the user in
        if (Auth::guard('guardian')->attempt(['phone' => $request->phone, 'password' => $request->password], $request->remember)) {
            // if successful redirect to intended location
            return redirect()->intended(route('guardian.dashboard'));
        }

        // if unseccessful redirect to login with input data 
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'phone';
    }
}
