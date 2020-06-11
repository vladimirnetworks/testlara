<?php
namespace App\Http\Controllers\API;
use App\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{

     function fakelogin() {
          return array("ok"=>1);
     }
     public function register(Request $request) {


          if (preg_match('!@!is',$request->username)) {

               $user=  User::create([
                    'name' => "new",
                    'email' => $request['username'],
                    'password' => Hash::make($request['password']),
                    ]);


          } else {


              $user=  User::create([
                    'name' => "new",
                    'mobile' => $request['username'],
                    'password' => Hash::make($request['password']),
                    ]);
               
               }

     
               $accessToken = $user->createToken('authToken')->accessToken;

               return response([ 'user' => $user, 'access_token' => $accessToken]);

              



     }

     public function login(Request $request) {
        
          if (isset($request->username) && isset($request->password)) {
               
          
          if (preg_match('!@!is',$request->username)) {

               $logedin = Auth::attempt(['email' => $request->username, 'password' => $request->password]);
          } else {
               $logedin =Auth::attempt(['mobile' => $request->username, 'password' => $request->password]);
          }

     }

     if (!$logedin) {
          return response()->json([ 'message' => 'failed' ], 200);
     } else {
          $user = $request->user();
          $tokenResult = $user->createToken('Personal Access Token');
          $token = $tokenResult->token;
          $token->save();



          return response()->json(['token' => $tokenResult->accessToken,]);
     }

         

          
     }

    public function loginx(Request $request){

      $request->validate([
     'mobile' => 'required|digits:11',
     'password' => 'required|string'
    ]);


    /**/

    /**/
     $credentials = request(['mobile', 'password']);  
 
  

     if(/*!Auth::attempt($credentials)*/ !Auth::attempt(['mobile' => $request->mobile, 'password' => $request->password])){
          return response()->json([ 'message' => 'Unauthorized' ], 401);
     }


     

     dd($request->user());
    
     $user = $request->user();
    
     $tokenResult = $user->createToken('Personal Access Token');
     $token = $tokenResult->token;
          $token->save();
     return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => "cc"
     ]);
   }



   public function user(Request $request) { return response()->json($request->user()); }
 
   public function logout(Request $request) {
        $request->user()->token()->revoke();
        return response()->json([ 'message' => 'Successfully logged out' ]);
   }
}