<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\student;

class studentController extends Controller
{
    public function index(){
    	return view('welcome');
    }
    public function create(Request $request){
    	$request->validate([
            'name' => 'required',
            'roll_no' => 'required|unique:students',
            'image' => 'required',
    	]);
    	if ($request->hasFile('image')) {
    		$image = $request->file('image');
    		$orignal_name = $image->getClientOriginalName();
    		$ext = $image->getClientOriginalExtension();
    		$w_md5 = md5($orignal_name.time());
    		$img_name = $w_md5.'.'.$ext;
    		$image->move(public_path().'/images', $img_name);
    	}
        $data = new student;
        $data->name = $request->get('name');
        $data->roll_no = $request->get('roll_no');
        $data->img_name = $img_name;
        $data->save();
        return $data;
    }
    public function show(){
        $data = student::all();
        return $data;
    }
    public function delete($id){
        $data = student::find($id);
        $img_name = $data->img_name;
        unlink(public_path().'/images/'.$img_name);
        $data->delete();
        return $data;
    }
    public function profile($id){
    	$data = student::find($id);
    	return view('profile', compact('data'));
    }
    public function findStudent($id){
    	$data = student::find($id);
    	return $data;
    }
    public function update(Request $request, $id){
    	$request->validate([
        'name' => 'required',
    	'roll_no' => 'required',
    	'image' => 'required',
    ]);
    	if ($request->hasFile('image')) {
    		$image = $request->file('image');
    		$orignal_name = $image->getClientOriginalName();
    		$ext = $image->getClientOriginalExtension();
    		$w_md5 = md5($orignal_name.time());
    		$img_name = $w_md5.'.'.$ext;
    		$image->move(public_path().'/images', $img_name);
    	}
    	$data = student::find($id);
    	$prv_img = $data->img_name;
    	$count = $data->count();
    	if ($count > 0) {
    		unlink(public_path().'/images/'.$prv_img);
    	}
    	$data->name = $request->get('name');
    	$data->roll_no = $request->get('roll_no');
    	$data->img_name = $img_name;
    	$data->save();
        return $data;
    }
}
