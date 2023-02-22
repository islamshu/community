<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.books.index')->with('books',Book::orderby('id','desc')->get());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.books.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title'=>'required',
                'price'=>'required',
                'description'=>'required',
                'demo_file'=>'required',
                'full_file'=>'required',

            ]
        );
        $book = new Book();
        $book->title = $request->title;
        $book->price = $request->price;
        $book->description = $request->description;
        $book->image = $request->image->store('books.images');
        $book->demo_file = $request->demo_file->store('books.demo_files');
        $book->full_file = $request->full_file->store('books.full_files');
        $book->save();
        return redirect()->route('books.index')->with(['success'=>'تم اضافة الكتاب بنجاح']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        return view('dashboard.books.edit')->with('book',$book);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $request->validate(
            [
                'title'=>'required',
                'price'=>'required',
                'description'=>'required'
            ]
        );
        $book->title = $request->title;
        $book->price = $request->price;
        $book->description = $request->description;
        if($request->image){
            $book->image = $request->image->store('books.images');
        }
        if($request->demo_file){
            $book->demo_file = $request->demo_file->store('books.demo_files');
        }
        if($request->full_file){
            $book->full_file = $request->full_file->store('books.full_files');
        }
        
        $book->save();
        return redirect()->route('books.index')->with(['success'=>'تم تعديل الكتاب بنجاح']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with(['success'=>'تم حذف الكتاب بنجاح']);

    }
}
