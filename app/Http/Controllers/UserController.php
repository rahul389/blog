<?php
/**
 * Created by PhpStorm.
 * User: lenovo
 * Date: 2/5/18
 * Time: 11:00 AM
 */

namespace App\Http\Controllers;
use App\User;
use Validator;
use Illuminate\Http\Request;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
class UserController
{
    /**
     * @return string
     */
    public function index(){
        $users = User::all();
        return response()->json($users);
    }


    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required'
        ];

    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public  function store(Request $request){


        if($request->isMethod('put')){
            $user = User::findOrFail($request->user_id);
            $user->id = $request->input('user_id');
            $user->name = $request->input('name');
            $user->mobile = $request->input('mobile');
            $user->address = $request->input('address');
        }
        else{
            $validator = Validator::make($request->all(), $this->rules());
            if ($validator->fails()) {
//                return Redirect::back()->withErrors(['msg', 'The Message']);

            return response()->json($validator->errors(), 422);
            }
            $user = User::create($request->all());
        }

        if ($user->save()) {
            return response()->json($user);
        }

    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if($user->delete()){
            return response()->json('Deleted successfully');
        }
    }


}