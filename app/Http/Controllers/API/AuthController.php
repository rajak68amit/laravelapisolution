<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use DB;
use App\Model\Usersxml;

class AuthController extends Controller {

    public function signup(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $user->save();
        return response()->json([
                    'message' => 'Successfully created user!'
                        ], 201);
    }

    public function storexml(Request $request) {
        try {
            $out = array();
            $dbarray = array();
            $uploads = $request->file('xml');
            $filePath = $uploads->getRealPath();
            $xmlObject = simplexml_load_file($filePath);
            $array = json_decode(json_encode((array) $xmlObject), TRUE);
            foreach ((array) $array as $index => $node) {
                $out[$index] = ( is_object($node) ) ? xml2array($node) : $node;
            }
            foreach ($out as $key => $outIteam) {
                $i = 0;
                foreach ($outIteam as $outIteams) {
                    foreach ($outIteams as $key => $gdata) {
                        $dbarray[$i][$key] = $gdata;
                    }
                    $i++;
                }
            }
            $Data = DB::table('userxml')->insert($dbarray);
            if ($Data) {
                return response()->json([
                            'message' => 'Successfully created users Data!'
                                ], 201);
            } else {
                return response()->json([
                            'message' => 'Something went wrong'
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                        'message' => 'Something went wrong.',
                        'status' => false,
                        "data" => null,
                        'code' => 500,
                            ], 500);
        }
    }

    public function activeinactive(Request $request) {
        try {
            $request->validate([
                'id' => 'required|integer',
                'status' => 'required|string',
            ]);

            $update = DB::table('userxml')->where('id', $request->id)->update(array('status' => $request->status));
            if ($update) {
                return response()->json([
                            'message' => 'Successfully updated users status!'
                                ], 201);
            }
        } catch (Exception $e) {
            return response()->json([
                        'message' => 'Something went wrong.',
                        'status' => false,
                        "data" => null,
                        'code' => 500,
                            ], 500);
        }
    }

    public function userList() {
        try {
            $users = DB::table('users')->select('userxml.userid', 'userxml.name', 'userxml.address', 'userxml.gender', 'userxml.status')
                    ->join('userxml', 'users.id', '=', 'userxml.userid')
                    ->get();
            return response()->json(
                            [
                                'message' => 'user Lists.',
                                'status' => true,
                                'code' => 201,
                                "data" => $users,
            ]);
        } catch (Exception $e) {
            return response()->json([
                        'message' => 'Something went wrong.',
                        'status' => false,
                        "data" => null,
                        'code' => 500,
                            ], 500);
        }
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials))
            return response()->json([
                        'message' => 'Unauthorized'
                            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse(
                            $tokenResult->token->expires_at
                    )->toDateTimeString()
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request) {
        $request->user()->token()->revoke();
        return response()->json([
                    'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request) {
        return response()->json($request->user());
    }

}
