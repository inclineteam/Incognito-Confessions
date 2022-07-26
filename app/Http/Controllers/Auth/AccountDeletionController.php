<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class AccountDeletionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {

        if(auth()->user()){
            return view('pages.auth.account-deletion');
        }
        else{
            return Redirect::to('/');
        }
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, $user)
    {
        
        auth()->guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $user = User::find($user);
        $user->delete();

        return redirect('/');
    }

    public function ban(Request $request){

        $user = $request->validate([
            'ban' => ['required'],
        ]);

        DB::table('users')->where("id", $user['ban'])->update(['banned' => true]);
        return redirect()->back();
    }

    public function unban(Request $request){

        $user = $request->validate([
            'ban' => ['required'],
        ]);

        DB::table('users')->where("id", $user['ban'])->update(['banned' => false]);
        return redirect()->back();
    }
}
