<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Student;
use App\EvaluationForm;
use App\Faculty;
use App\Question;
use App\Post;
use App\TeacherEvaluation;
use App\Assign;
use App\QuestionInForm;
use App\TeacherRating;

class StudentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web_student');
    }

    public function index()
    {
        return view('students.home');
    }

    public function evaluation()
    {
        return view('students.evaluation');
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
            'stu_id' => 'required|max:15',
        ],[
            'fname.required' => 'The first name field is required.',
            'fname.max' => 'The first name may not be greater than 15 characters.',
            'fname.min' => 'The first name must be at least 3 characters.',
            'mi.max' => 'The middle initial may not be greater than 1 characters.',
            'lname.required' => 'The last name field is required.',
            'lname.max' => 'The last name may not be greater than 15 characters.',
            'lname.min' => 'The last name must be at least 3 characters.',
            'stu_id.required' => 'The student id field is required.',
            'stu_id.max' => 'The student id may not be greater than 15 characters.',
       ]);
    }

    protected function editAllInfo(array $data)
    {
        $id = Auth::guard('web_student')->id();
        return Student::where('id', $id)
            ->update([
                'fname' => $data['fname'],
                'mi' => $data['mi'],
                'fname' => $data['fname'],
                'birthdate' => $data['birthdate'],
                'address' => $data['address'],
                'contact' => $data['contact'],
                'stu_id' => $data['stu_id']
        ]);
    }

    // POST

    public function postView()
    {
        $posts = Post::orderBy('id', 'DESC')->with('academic_year','semester','evaluation_form')->get();

        return response(['posts' => $posts]);
    }

    // TEACHER EVALUATION VIEW

    public function teacherEvaluationView()
    {
        $teacher_evaluations = TeacherEvaluation::orderBy('id', 'DESC')->with('assign','evaluation')
        ->whereHas('evaluation', function($q) {
            $q->whereDate('start_date','<=',NOW());
            $q->whereDate('end_date','>=',NOW());
        })->get();


        $id = Auth::guard('web_student')->id();
        $student = Student::find($id);
        $sec_id = $student->sec_id;

        $assigns = Assign::where('sec_id', $sec_id)->with('section','subject','teacher')->get();
        $question_forms = QuestionInForm::orderBy('id', 'DESC')->with('question_form','question_details')->get();

        return response(['teacher_evaluations' => $teacher_evaluations, 'assigns' => $assigns,
        'question_forms' => $question_forms]);
    }

    // TEACHER EVALUATION CREATE

    public function teacherEvaluationCreate(Request $request)
    {
        $data = $this->validate($request,[
            'choices' => 'required|array',
            'choices.*.category' => 'required',
            'choices.*.statement' => 'required',
            'choices.*.rate' => 'required'
        ]);

        $id = Auth::guard('web_student')->id();
        $student = Student::find($id);
        $fname = $student->fname;
        $lname = $student->lname;

        foreach($data['choices'] as $choices){
            TeacherRating::create([
                'category' => $choices['category'],
                'statement' => $choices['statement'],
                'rate' => $choices['rate'],
                'form_id' => $request['form_id'],
                'form_title' => $request['title'],
                'teacher_fname' => $request['teacher_fname'],
                'teacher_lname' => $request['teacher_lname'],
                'sub_desc' => $request['sub_desc'],
                'rated_by_fname' => $fname,
                'rated_by_lname' => $lname,
            ]);
        }


    }


    // LOGOUT

    public function logout()
    {
        auth()->logout();
        return redirect()->route('student.login');
    }

}
