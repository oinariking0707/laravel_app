<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;  // 追記
use Auth;

class TodoController extends Controller
{
     // ここから追記
     private $todo;

     public function __construct(Todo $instanceClass)
     {
        $this->middleware('auth'); 
         $this->todo = $instanceClass;
     }
     // ここまで追記
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = $this->todo->all();  
       // dd(compact('todos'));
        $todos = $this->todo->getByUserId(Auth::id());
        return view('todo.index', compact('todos'));
        //dd(compact('todos'));
        // return view('todo.index', ['todos' => $this->todo->all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('todo.create');   

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::id();
        $this->todo->fill($input)->save();
        return redirect()->to('todo');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $todo = $this->todo->find($id);  // 追記
        return view('todo.edit', compact('todo'));  // 追記
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
        $input = $request->all();
        $this->todo->find($id)->fill($input)->save();

        // $this->todo->title = '123456';
        // $this->todo->save();

        return redirect()->to('todo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->todo->find($id)->delete();
        return redirect()->to('todo');
    }
}
