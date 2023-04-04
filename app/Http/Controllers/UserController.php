<?php

namespace App\Http\Controllers;

use App\Models\GeneralInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('type', 'user')->orderby('id', 'desc')->get();
        return view('dashboard.users.index')->with('users', $users)->with('title', 'جميع المستخدمين');
    }
    public function paid_user()
    {
        $users = User::where('type', 'user')->where('is_paid', 1)->orderby('id', 'desc')->get();
        return view('dashboard.users.index')->with('users', $users)->with('title', 'جميع المستخدمين الدافعين');
    }
    public function un_paid_user()
    {
        $users = User::where('type', 'user')->where('is_paid', 0)->orderby('id', 'desc')->get();
        return view('dashboard.users.index')->with('users', $users)->with('title', 'جميع المستخدمين الغير دافعين');
    }
    public function create()
    {
        return view('dashboard.users.create');
    }
    public function show($id)
    {
        return view('dashboard.users.show')->with('user', User::find($id));
    }
    public function edit($id)
    {
        return view('dashboard.users.edit')->with('user', User::find($id));
    }
    public function user_update_status(Request $request)
    {
        $user = User::find($request->user_id);
        $user->check_register = $request->check_register;
        $user->save();
    }
    public function add_general(Request $request)
    {
        if ($request->hasFile('general_file')) {
            foreach ($request->file('general_file') as $name => $value) {
                if ($value == null) {
                    continue;
                }
                GeneralInfo::setValue($name, $value->store('general'));
            }
        }
        if ($request->hasFile('general')) {

            foreach ($request->input('general') as $name => $value) {
                if ($value == null) {
                    continue;
                }
                GeneralInfo::setValue($name, $value);
            }
        }

        return redirect()->back()->with(['success' => 'تم تعديل البيانات بنجاح']);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'phone' => 'required|unique:users,phone',
            'have_website' => 'required',
            'site_url' => $request->have_website == 1 ? 'required' : '',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password =  Hash::make($request->password);
        $user->phone = $request->phone;
        $user->domains = $request->domains;
        $user->have_website = $request->have_website;
        $user->site_url = $request->site_url;
        $user->type = 'user';
        $user->image = $request->image->store('users');
        $user->video = 'user_video/defult.mp4';
        $user->packege_id = $request->packege_id;
        $user->is_paid = 1;
        $user->save();
        return redirect()->route('users.index')->with(['success' => 'تم اضافة العضو']);
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $user->id,
            // 'password' => 'required',
            'phone' => 'required|unique:users,phone,' . $user->id,
            'have_website' => 'required',
            'site_url' => $request->have_website == 1 ? 'required' : '',
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password != null) {
            $user->password =  Hash::make($request->password);
        }
        $user->phone = $request->phone;
        $user->have_website = $request->have_website;
        $user->site_url = $request->site_url;
        $user->is_paid = $request->is_paid;
        $user->domains = $request->domains;

        $user->type = 'user';
        if ($request->image != null) {
            $user->image = $request->image->store('users');
        }
        $user->packege_id = $request->packege_id;
        $user->save();
        return redirect()->back()->with(['success' => 'تم تعديل العضو']);
    }
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('users.index')->with(['success' => 'تم حذف العضو']);
    }
}
