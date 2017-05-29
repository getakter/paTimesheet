<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Permission;
use App\User;
use Datatables;
use Crypt;
use Auth;
use Response;
use DB;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('permissions.permission_list');
    }


    public function get_all_permissions(){
        $query_get_all_permission="
        SELECT 
        id,
        name,
        display_name,
        description
        FROM permissions
        ";
        $permissions=DB::select($query_get_all_permission);
        $permissions_collection= collect($permissions);
    // dd($reservation_collection);
        return Datatables::of($permissions_collection)
        ->addColumn('action', function ($permissions_collection) {
            return 

            ' <a href="'. url('/permissions') . '/' . 
            Crypt::encrypt($permissions_collection->id) . 
            '/edit' .'"' . 
            'class="btn btn-primary btn-danger"><i class="glyphicon   glyphicon-list"></i> Edit</a>';
        })
        ->editColumn('id', '{{$id}}')
        ->setRowId('id')
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permissions.permission_create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permission = new Permission;

        $permission->name = $request->permission_name;
        $permission->display_name = $request->display_name;
        $permission->description = $request->description;

        $permission->save();

        return redirect()->action('PermissionController@index');

        // dd('done');

    }


    public function roles_list(){

        return view('permissions.permission_role_list');

    }

    public function user_role_permissions_details(){

        $user_role = DB::table('users')
        ->leftJoin('role_user','users.id','=','role_user.user_id')
        ->leftJoin('roles','role_user.role_id','=','roles.id')
        ->select('users.name','users.id','roles.name AS role')->get();

        $user_role_collection= collect($user_role);
    // dd($reservation_collection);
        return Datatables::of($user_role_collection)
        ->addColumn('action', function ($user_role_collection) {
            return 

            ' <a href="'. url('/permissions') . '/' . 
            Crypt::encrypt($user_role_collection->id) . 
            '' .'"' . 
            'class="btn btn-primary btn-danger"><i class="glyphicon   glyphicon-list"></i> Edit</a>';
        })
        ->editColumn('id', '{{$id}}')
        ->setRowId('id')
        ->make(true);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $user_id=Crypt::decrypt($id);

        //checking if the role exists or not
        $role_id = DB::table('role_user')
        ->select('role_id')
        ->where('user_id',$user_id)->get();

        if(sizeof($role_id)>=1){
            //redirect to premission setting page
            
            $user = User::findOrFail($user_id);

            return view('permissions.set_user_permission')->with('user',$user);

        }else{
            //role doesn't exist so set the role first
            $request->session()->flash('alert-warning', 'Please set the role first');
            return redirect()->back(); 
        }


    }

    public function get_permissions_for_roles(Request $request){

        $search_term = $request->input('term');

        $query_permissions= "
        SELECT id, name AS text
        FROM permissions
        WHERE name LIKE '%{$search_term}%'";

        $permissions = DB::select($query_permissions);

        // dd($permissions);

        return response()->json($permissions);

    }

    public function permission_details(Request $request){

        $permission_id = $request->name;

        $permission_details = DB::table('permissions')->select('description')
        ->where('id',$permission_id)->first();

        // dd($project_code);
        
        return response()->json($permission_details);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
