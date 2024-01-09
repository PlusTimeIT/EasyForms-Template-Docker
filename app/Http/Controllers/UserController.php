<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

/** 
 * This user controller is not meant to be copied or used. It is purely used for handling the test data.
 * 
 */
class UserController extends Controller
{
    protected $users;

    public function __construct()
    {
        $this->users = Cache::get('users', []);
    }

    public function __destruct()
    {
        Cache::set('users', $this->users);
    }


    public function get(int $userId)
    {
        if (!isset($this->users[$userId])) {
            return false;
        }
        return $this->users[$userId];
    }

    public function all()
    {
        return $this->users;
    }

    public function create(Request $request)
    {
        $this->users[] = (object) [
            'first_name' => $request->first_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'status' => 0
        ];

        return true;
    }

    public function update(Request $request)
    {
        if (!isset($this->users[$request->id])) {
            return false;
        }

        $this->users[$request->id] = (object) [
            'first_name' => $request->first_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
            'status' => $request->status
        ];
        return true;
    }

    public function delete(int $userId)
    {
        // UserID should be the index of the user in the array.
        if (!isset($this->users[$userId])) {
            return false;
        }
        unset($this->users[$userId]);
        return true;
    }
}
