<?php

namespace App\Http\Controllers\api\v1;

use App\Enums\RegistrationStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Login
    public function login(Request $request)
    {
        // Validate email and password
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // Return errors if validation failed
        if ($validator->fails()) {
            return $this->return_api(false, Response::HTTP_UNPROCESSABLE_ENTITY, null, null, $validator->errors());
        }

        // If login successfull
        if (Auth::attempt($validator->validated(), true)) {
            // Get user using auth
            $user = Auth::user();
            $userTemp = new User();
            $userTemp->email = $user->email;

            // //check if user is lecturer
            if ($user->hasRole('lecturer')) {

                // If user email already verified
                if ($user->hasVerifiedEmail()) {
                    // Already approve by admin
                    if ($user->registration_status  == (string) RegistrationStatusEnum::Approved()) {
                        // Create access token
                        $user->accessToken =  $user->createToken('authToken')->accessToken;

                        // Return response with user resource model
                        return $this->return_api(true, Response::HTTP_OK, null, new UserResource($user), null);
                    } else if ($user->registration_status == (string) RegistrationStatusEnum::Rejected()) {
                        return $this->return_api(false, Response::HTTP_UNAUTHORIZED, __("Your account registration has been rejected, please contact the admin."), $userTemp, null);
                    } else {
                        return $this->return_api(false, Response::HTTP_UNAUTHORIZED, __("Your account registration has not yet been approved."), $userTemp, null);
                    }
                } else {
                    // Email not verified
                    return $this->return_api(false, Response::HTTP_FORBIDDEN, trans("auth.email_not_verified"), $userTemp, null);
                }
            } else {

                return $this->return_api(false, Response::HTTP_UNAUTHORIZED, "Unauthorized. Please Contact Admin.", null, null);
            }
        }
        return $this->return_api(false, Response::HTTP_UNAUTHORIZED, trans("auth.failed"), null, null);
    }

    public function logout()
    {
        $user = Auth::user()->token();

        $user->revoke();
        return $this->return_api(true, Response::HTTP_OK, null, null, null);
    }
}
