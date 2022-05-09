<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Http\Requests\AskQuestionRequest;
use Illuminate\Support\Facades\Gate;
use Auth;


class QuestionController extends Controller
{

    public function __construct(){

        $this->middleware('auth',['except'=>['index','show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //\DB::enableQueryLog();
        $data['questions']=Question::with(['user'])->latest()->paginate(5);
        return view('questions.index',$data);
        //dd(\DB::getQueryLog());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $question = new Question();
        return view('questions.create',compact('question'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AskQuestionRequest $request)
    {
        $request->user()->questions()->create($request->all());
        return redirect('/questions')->with('success','succesfully inssert');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
              $question->increment('views');
              return view('questions.show',compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {

        if(\Gate::allows('update-question',$question)){
       // $data['question'] = Question::find($id);

        //dd($question);
         return view('questions.edit',compact('question'));
        }
        abort(403,'Access denied');
       

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)

    {
        //dd();

          if(\Gate::denies('delete-question',$question)){
       // $data['question'] = Question::find($id);

        //dd($question);
             abort(403,'Access denied');
       
        }
       $question->delete();

       //Question::where('id',$id)->delete();

        return redirect('/questions')->with('success','delete succesfully');
    }
}
