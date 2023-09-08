<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users.list')
            ->with('items', User::get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create_edit')
            ->with('item', new User);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|max:255',
            'email'    => 'required|unique:users|email:rfc,dns|max:255',
            'password' => 'required|confirmed|min:6|max:255'
        ]);

        $user           = new User;
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = Hash::make($request->password);

        if( ! $user->save() ) {
            return redirect()->back()->withErrors(['msg' => 'There was an error adding the user. Please try again.']);
        } else {
            return redirect( route('users.list') );
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, User $user)
    {
        return view('users.create_edit')
            ->with('item', $user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $validate_fields = [
            'name'  => 'required|max:255',
            'email' => 'required|unique:users,email,' . $id . '|max:255',
        ];

        if( $request->password ) {
            $validate_fields['password'] = 'required|confirmed|min:6|max:255';
        }

        $validated = $request->validate( $validate_fields );

        $user = User::where('id', $id)->first();
        $user->name     = $request->name;
        $user->email    = $request->email;
        if( $request->password ) {
            $user->password = Hash::make($request->password);
        }

        if( ! $user->save() ) {
            return redirect()->back()->withErrors(['msg' => 'There was an error saving the user. Please try again.']);
        } else {
            return redirect( route('users.list') )->with( 'message-success', 'Saved!' );
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $user = User::where('id', $id)->first();

        $user->delete();

        return redirect()->route('users.list')->with( 'message-success', 'Deleted!' );

    }
}
