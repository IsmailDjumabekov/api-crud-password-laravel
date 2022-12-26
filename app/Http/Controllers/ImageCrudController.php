<?php

namespace App\Http\Controllers;

use App\Models\ImageCrud;
use App\Models\User;
use Illuminate\Http\Request;
use Facade\FlareClient\Stacktrace\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ImageCrudController extends Controller
{
    public function create(Request $request)
    {
        $images = new ImageCrud();
        $request->validate([
            'title' => 'required',
            'image' => 'required',
            'description' => 'required',
        ]);
        $filename = "";
        if($request->hasFile('image')){
            $filename = $request->file('image')->store('posts', 'public');
        }else{
            $filename = Null;
        }

        $images->title = $request->title;
        $images->image = $filename;
        $images->description = $request->description;
        $result = $images->save();
        if($result){
            return response()->json([
                'success' => true
            ]);
        }else{
            return response()->json([
                'success' => false
            ]);
        }
    }
    public function get()
    {
        $images = ImageCrud::orderBy('id', 'DESC')->get();
        return response()->json($images);
    }
    public function edit($id)
    {
        $images = ImageCrud::findOrFail($id);
        return response()->json($images);
    }
    public function update(Request $request, $id)
    {
        $images = ImageCrud::findOrFail($id);

        $destination = public_path("storage\\".$images->image);
        $filename = "";
        if($request->hasFile('new_file')){
            if(File::exists($destination)){
                File::delete($destination);
            }
            $filename = $request->file('new_file')->store('posts', 'public');
        }else{
            $filename = $request->image;
        }
        $images->title = $request->title;
        $images->image = $filename;
        $images->description = $request->description;
        $result = $images->save();
        if($result){
            return response()->json([
                'success' => true
            ]);
        }else{
            return response()->json([
                'success' => false
            ]);
        }
    }
    public function delete($id)
    {
        $images=ImageCrud::findOrFail($id);
        $destination=public_path("storage\\".$images->image);
        if(File::exists($destination)){
            File::delete($destination);
        }
        $result=$images->delete();
        if($result){
            return response()->json(['success'=>true]);
        }else{
            return response()->json(['success'=>false]);
        }
    }
    public function register(Request  $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        if($validator->fails()){
            return response()->json(['status' => 'fail', 'validation_errors' => $validator->errors()]);
        }
        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);

        if($user){
            return response()->json(['status' => 'success', 'message' => 'User registration successfully completed,', 'data' => $user]);
        }
        return response()->json(['status' => 'fail', 'message' => 'User registration fail! ']);
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();
        if(!$user){
            return response()->json([
                'success'=> false,
                'message'=>'This email is not registered'
            ]);
        }
        if(Auth::attempt($credentials)){
            return response()->json([
                'success'=> true,
                'token'=>$user->createToken($user->email)->accessToken
            ]);
        }
        return response()->json([
            'success'=> false,
            'message'=>'Email or password is invalid!'
        ]);}
}
