<?php

namespace App\Http\Controllers;

use App\Models\Faqs;
use Illuminate\Http\Request;

class FaqsController extends Controller
{
    public function index()
    {
        return view('dashboard.faqs.index')->with('faqs',Faqs::orderBy('sort','asc')->get());

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $page = new Faqs();
        $page->answer = $request->answer;
        $page->question = $request->qus;
        $page->sort =  Faqs::count() +1;
        $page->save();

        return redirect()->back()->with(['succss'=>'تم الاضافة بنجاح']);
    }
    public function update_sort_faqs(Request $request)
    {
        if($request->has('ids')){
            $arr = explode(',',$request->input('ids'));
            foreach($arr as $sortOrder => $id){
                $menu = Faqs::find($id); 
                $menu->sort = $sortOrder;
                $menu->update(['sort'=>$sortOrder]);
            }
            return ['success'=>true,'message'=>'Updated'];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faqs  $faqs
     * @return \Illuminate\Http\Response
     */
    public function show(Faqs $faqs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faqs  $faqs
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('dashboard.faqs.edit')->with('faq',Faqs::find($id));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faqs  $faqs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $faqs=Faqs::find($id);
        $faqs->answer = $request->answer;
        $faqs->question = $request->question;
        $faqs->save();

        return redirect()->back()->with(['succss'=>'تم التعديل بنجاح']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faqs  $faqs
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $about= Faqs::find($id);
       $about->delete();

       return redirect()->back()->with(['success'=>'تم الحذف بنجاح']);

    }
}
