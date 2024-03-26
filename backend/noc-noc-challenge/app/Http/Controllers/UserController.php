<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getAll()
    {
        $user = Auth::user();

        $users = User::all()->except($user->id);

        return response()->json(['users'=>$users]);
    }
}
