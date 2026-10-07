<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /**
     * Display all normal users.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::query()
            ->where('role', 'user')

            ->when($search, function ($query, $search) {

                $query->where(function ($q) use ($search) {

                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%")
                        ->orWhere('country', 'like', "%{$search}%");

                });

            })

            ->latest()
            ->paginate(15)
            ->withQueryString();

        $totalUsers = User::where('role', 'user')->count();

        return view(
            'admin.users.index',
            compact(
                'users',
                'totalUsers',
                'search'
            )
        );
    }


    /**
     * Display a single user.
     */
    public function show(User $user)
    {
        abort_unless(
            $user->role === 'user',
            404
        );

        return view(
            'admin.users.show',
            compact('user')
        );
    }


    /**
     * Display user edit form.
     */
    public function edit(User $user)
    {
        abort_unless(
            $user->role === 'user',
            404
        );

        return view(
            'admin.users.edit',
            compact('user')
        );
    }
}