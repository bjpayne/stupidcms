<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\UserAvatar;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
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
                ->where('id', '<>', $request->user()->id)
                ->where(function (Builder $builder) use ($search) {
                    $builder->orWhere('first_name', 'LIKE', '%'.$search.'%')
                        ->orWhere('last_name', 'LIKE', '%'.$search.'%')
                        ->orWhere('email', 'LIKE', '%'.$search.'%');
                })
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        }

        if (empty($users)) {
            $users = User::where('id', '<>', $request->user()->id)
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        }

        return Inertia::render('Users/Index', compact('users', 'search'));
    }

    public function edit(Request $request)
    {
        $user_id = $request->input('user_id');

        $user = User::find($user_id);

        if (! $user) {
            return redirect(route('users.index'), 400);
        }

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');

        $user->save();

        return redirect()
            ->route('users.index');
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email'     => $request->email,
            'password'  => \Hash::make($request->password),
        ]);

        $avatar = $request->file('avatar');

        if (! empty($avatar)) {
            $userAvatar = new UserAvatar;

            $userAvatar->user_id = $user->id;
            $userAvatar->avatar = base64_encode($avatar->get());

            $userAvatar->save();
        }

        event(new Registered($user));

        return redirect()
            ->route('users.index')
            ->with('User saved!');
    }

    public function update(UpdateUserRequest $request)
    {

    }

    public function destroy(Request $request)
    {

    }
}
