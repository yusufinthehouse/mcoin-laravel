<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use JWTAuth;
use JWTAuthException;

use App\Helpers\Base;

use App\Models\User;

class UserController extends Controller {

    private $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function create(Request $request) {
        $email = $request->get('email');
        $password = $request->get('password');
        $full_name = $request->get('full_name');
        $birth_date = $request->get('birth_date');
        $photo = '';
        
        $checkuser = $this->user::where("email", $email)->first(); 
        if ($checkuser) {
            return Base::apiErrorResponse("User already exist!");
        } else { 
            $this->user->create([
                'email' => $email,
                'password' => bcrypt($password),
                'full_name' => $full_name,
                'birth_date' => $birth_date,
                'photo' => $photo
            ]);

            return Base::apiSuccessResponse("User successfully registered!");
        }
    }
    
    public function get($id) {
        $user = User::find($id);
        if (!$user) {
            return Base::apiErrorResponse("User does exist!");
        } else {
            return Base::apiSuccessResponse("", $user);
        }        
    }
    
    public function update(Request $request, $id) {
        $user = User::find($id);
        if (!$user) {
            return Base::apiErrorResponse("User does exist!");
        } else {
            $email = $request->get('email');
            $password = $request->get('password');
            $full_name = $request->get('full_name');
            $birth_date = $request->get('birth_date');
            $photo = '';
            
            $user->update([
                'email' => $email,
                'password' => bcrypt($password),
                'full_name' => $full_name,
                'birth_date' => $birth_date,
                'photo' => $photo
            ]);
            
            return Base::apiSuccessResponse("User successfully updated!");
        }  
    }
        
    public function delete($id) {
        $user = User::find($id);
        if (!$user) {
            return Base::apiErrorResponse("User does exist!");
        } else {
            $user->delete();
            
            return Base::apiSuccessResponse("User successfully deleted!");
        }
    }

    public function login(Request $request) {
        $credentials = $request->only('email', 'password');
        $token = null;
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return Base::apiErrorResponse("Invalid username or password!");
            }
        } catch (JWTAuthException $e) {
            return Base::apiErrorResponse("System error. Failed to create token.");
        }
        
        return Base::apiSuccessResponse("", [], $token);
    }

    public function getAuthUser(Request $request) {
        $user = JWTAuth::toUser($request->token);
        return response()->json(['result' => $user]);
    }

}
