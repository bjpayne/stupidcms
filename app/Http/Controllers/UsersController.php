<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserAvatar;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $users = null;

        $search = '';

        if ($request->get('search')) {
            $search = $request->get('search');

            $users = User::without('avatar')
                ->orWhere('first_name', 'LIKE', '%'.$search.'%')
                ->orWhere('last_name', 'LIKE', '%'.$search.'%')
                ->orWhere('email', 'LIKE', '%'.$search.'%')
                ->paginate(20);
        }

        if (empty($users)) {
            $users = User::paginate(20);
        }

        return Inertia::render('Users', compact('users', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => \Hash::make($request->password),
        ]);

        $avatar = $request->file('avatar');

        $userAvatar = new UserAvatar;

        $userAvatar->user_id = $user->id;
        $userAvatar->avatar = base64_encode($avatar->get());

        $userAvatar->save();

        event(new Registered($user));

        return redirect()
            ->route('users.index')
            ->with('User saved!');
    }
}