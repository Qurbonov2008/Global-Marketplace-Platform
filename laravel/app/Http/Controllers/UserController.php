<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAuthRequest;
use App\Models\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        if (!auth()->user()->is_admin) {
            return response()->json(['message' => 'Afsuski siz admin emassiz']);
        }
        return Auth::all();
    }
    public function show()
    {
        return auth()->user();
    }


    public function edit(UpdateAuthRequest $request, $id)
    {
        if (!auth()->user()) {
            return response()->json(['message' => "Siz hali ro'yxatdan o'tmagansiz"]);
        }
        try {
            $auth = Auth::where('email', request('email'))->first();
            if ($auth) {
                return response()->json(['message' => 'Bunday email bor']);
            }
            $user = Auth::findOrFail($id);
            $user->update([$request->validated()]);
            return response()->json(['message' => 'Muvaffaqiyatli yangilandi']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Bunday id dagi foydalanuvchi mavjud emas']);
        }
    }
}
