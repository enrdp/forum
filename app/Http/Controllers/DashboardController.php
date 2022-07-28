<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index(User $user, Request $request)
    {
        return view('dashboard.index', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return void
     */
    public function edit(User $user)
    {
        return view('dashboard.edit', compact('user'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);
        Auth::user()->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return redirect()->route('dashboard.index')
            ->with('success','Thread Has Been updated successfully');
    }
    public function showUser(Request $request)
    {
        $searchTerm = $request->input('search');

        $searchQuery = User::search(['name', 'email'], $searchTerm)
            ->where('name', '!=', Auth::user()->name)
            ->with('roles')
            ->paginate(10);

        $user = User::all();

        return view('dashboard.showUsers',
            compact('searchTerm', 'searchQuery','user'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('showUser')
            ->with('success','Thread has been deleted successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function editUsers(User $user)
    {
        $role = DB::table('role_user')
            ->where('user_id', '=', $user->id)
            ->value('role_id');

        $rolename = Role::all();

        return view('dashboard.editUsers',compact('user', 'role','rolename'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @param \App\Models\Role $roles
     * @return \Illuminate\Http\Response
     */

    public function updateUsers(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        DB::table('role_user')
            ->where('user_id', '=', $user->id)
            ->update(['role_id' => $request['role']
            ]);

        $user['name'] = $request->name;
        $user['email'] = $request->email;
        $user->save();

        return redirect()->route('showUser')
            ->with('success','Thread Has Been updated successfully');
    }

    public function changePassword(User $user)
    {
        return view('dashboard.change-password', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with("error", "Old Password Doesn't match!");
        }

        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("status", "Password changed successfully!");
    }

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('edit_user')->only(['editUsers','show']);
        $this->middleware('can:delete')->only(['destroy']);
    }
}
