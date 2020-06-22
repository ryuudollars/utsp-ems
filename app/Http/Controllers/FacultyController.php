<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Faculty;
use App\Post;

class FacultyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web_faculty');
    }

    public function index()
    {
        return view('faculties.home');
    }


    // EDIT INFORMATION

    public function editInfo(Request $request)
    {
        $this->validatorInfo($request->all())->validate();

        $this->editAllInfo($request->all());
    }

    protected function validatorInfo(array $data)
    {
        return Validator::make($data, [
            'fname' => 'required|max:15',
            'mi' => 'nullable|max:15',
            'lname' => 'required|max:15',
            'birthdate' => 'required|max:15',
            'address' => 'required|max:15',
            'contact' => 'nullable|max:15',
            'username' => 'required|max:15',
        ],[
            'fname.required' => 'The first name field is required.',
            'fname.max' => 'The first name may not be greater than 15 characters.',
            'fname.min' => 'The first name must be at least 3 characters.',
            'mi.max' => 'The middle initial may not be greater than 1 characters.',
            'lname.required' => 'The last name field is required.',
            'lname.max' => 'The last name may not be greater than 15 characters.',
            'lname.min' => 'The last name must be at least 3 characters.'
       ]);
    }

    protected function editAllInfo(array $data)
    {
        $id = Auth::guard('web_faculty')->id();
        return Faculty::where('id', $id)
            ->update([
                'fname' => $data['fname'],
                'mi' => $data['mi'],
                'fname' => $data['fname'],
                'birthdate' => $data['birthdate'],
                'address' => $data['address'],
                'contact' => $data['contact'],
                'username' => $data['username']
        ]);
    }

    // POST

    public function postView()
    {
        $posts = Post::orderBy('id', 'DESC')->with('academic_year','semester','evaluation_form')->get();

        return response(['posts' => $posts]);
    }

    // LOGOUT

    public function logout()
    {
        auth()->logout();
        return redirect()->route('faculty.login');
    }

}
