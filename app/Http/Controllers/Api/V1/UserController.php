<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

// define libraries
use App\Http\Controllers\Controller;
use JWTAuth;
use JWTAuthException;

// define helper functions
use App\Helpers\Base;

// define model
use App\Models\User;

class UserController extends Controller {

    /**
     * Attribute for object user 
     * @var User $user User object attribute 
     */
    private $user;

    /**
     * Create new object user every initiate user controller class 
     * @param User $user User object attribute
     */
    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * Create new user after valid validation
     * @param Request $request
     * @return JSON Response
     */
    public function create(Request $request) {
        $email = $request->get('email');
        $password = $request->get('password');
        $full_name = $request->get('full_name');
        $birth_date = $request->get('birth_date');
        $photo = $request->get('photo');
        
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
    
    /**
     * Get user data based on its id
     * @param integer $id
     * @return JSON Response
     */
    public function get($id) {
        $user = User::find($id);
        if (!$user) {
            return Base::apiErrorResponse("User does not exist!");
        } else {
            return Base::apiSuccessResponse("", $user);
        }        
    }
    
    /**
     * Update user data refer on its id
     * @param Request $request
     * @param integer $id
     * @return JSON Response
     */
    public function update(Request $request, $id) {
        $user = User::find($id);
        if (!$user) {
            return Base::apiErrorResponse("User does not exist!");
        } else {
            $email = $request->get('email');
            $password = $request->get('password');
            $full_name = $request->get('full_name');
            $birth_date = $request->get('birth_date');
            $photo = $request->get('photo');
            
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
    
    /**
     * Delete user data based on its id
     * @param type $id
     * @return type
     */
    public function delete($id) {
        $user = User::find($id);
        if (!$user) {
            return Base::apiErrorResponse("User does not exist!");
        } else {
            $user->delete();
            
            return Base::apiSuccessResponse("User successfully deleted!");
        }
    }

    /**
     * User authentication using JWT feature
     * @param Request $request
     * @return JSON Response
     */
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

    /**
     * Testing route to test JWT token
     * @param Request $request
     * @return JSON Response
     */
    public function getAuthUser(Request $request) {
        $user = JWTAuth::toUser($request->token);
        return response()->json(['result' => $user]);
    }

}
