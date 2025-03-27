<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $userToUpdate = User::findOrFail($id);

        $newRole = $userToUpdate->role === 'admin' ? 'user' : 'admin';


    }

    public function confirmPassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'user_id' => 'required|exists:users,id',
            'new_role' => 'required|in:admin,user'
        ]);

        $currentUser = Auth::user();

        if (!Hash::check($request->password, $currentUser->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Mật khẩu không đúng'
            ], 401);
        }

        $user = User::findOrFail($request->user_id);
        $user->update(['role' => $request->new_role]);

        return response()->json([
            'success' => true,
            'message' => 'Đã thay đổi role thành công!'
        ]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return response()->json([]);
        }

        $users = User::where('name', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->select(['id', 'name', 'email', 'role'])
            ->get();

        return response()->json($users);
    }

}
