<?php

namespace App\Http\Controllers\Admin;
use App\Enums\Status;
use App\Models\Employee;
use App\Enums\UserStatus;
use App\Http\Controllers\BackendController;
use App\Http\Requests\AdminUserRequest;
use App\User;
use App\Slot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use App\TransferSms;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables;
use DB;

class AdminUserController extends BackendController
{
    public function __construct()
    {
        $this->data['sitetitle'] = 'Administrator';

        $this->middleware(['permission:adminusers'])->only('index');
        $this->middleware(['permission:adminusers_create'])->only('create', 'store');
        $this->middleware(['permission:adminusers_edit'])->only('edit', 'update');
        $this->middleware(['permission:adminusers_delete'])->only('destroy');
        $this->middleware(['permission:adminusers_show'])->only('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.adminuser.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.adminuser.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminUserRequest $request)
    {
        $user             = new User;
        $user->first_name = $request->first_name;
        $user->last_name  = $request->last_name;
        $user->email      = $request->email;
        $user->username   = $request->username ?? $this->username($request->email);
        $user->password   = Hash::make(request('password'));
        $user->phone      = $request->phone;
        $user->address    = $request->address;
        $user->status     = 5;
        $user->save();

        if (request()->file('image')) {
            $user->addMedia(request()->file('image'))->toMediaCollection('user');
        }

        $role = Role::find(3);
        $user->assignRole($role->name);

        return redirect(route('admin.adminusers.index'))->withSuccess('The Data Inserted Successfully');
   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->data['user'] = User::findOrFail($id);

        return view('admin.adminuser.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->data['user'] = $user;
        return view('admin.adminuser.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminUserRequest $request, $id)
    {
        $user = User::findOrFail($id);

            $user->first_name = $request->first_name;
            $user->last_name  = $request->last_name;
            $user->email      = $request->email;
            $user->username   = $request->username ?? $this->username($request->email);

            if ($request->password) {
                $user->password = Hash::make(request('password'));
            }

            $user->phone   = $request->phone;
            $user->address = $request->address;
            if ($user->id != 1) {
                $user->status = 5;
            } else {
                $user->status = UserStatus::ACTIVE;
            }
            $user->save();

            if (request()->file('image')) {
                $user->media()->delete();
                $user->addMedia(request()->file('image'))->toMediaCollection('user');
            }

            return redirect(route('admin.adminusers.index'))->withSuccess('The Data Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (($user->id != 1) && (auth()->id() == 1)) {
            $user->delete();
            return redirect(route('admin.adminusers.index'))->withSuccess('The Data Deleted Successfully');
        }
    }

    public function getAdminUsers()
    {
        $role           = Role::find(1);
        $roleTow        = Role::find(3);
        $users     = User::role([$role->name,$roleTow->name])->latest()->get();
        $userArray = [];

        $i = 1;
        if (!blank($users)) {
            foreach ($users as $user) {
                $userArray[$i]          = $user;
                $userArray[$i]['setID'] = $i;
                $i++;
            }
        }
        return Datatables::of($userArray)
            ->addColumn('action', function ($user) {
                $retAction = '';
                if (($user->id == auth()->id()) && (auth()->id() == 1)) {
                    if (auth()->user()->can('adminusers_show')) {
                        $retAction .= '<a href="' . route('admin.adminusers.show', $user) . '" class="btn btn-sm btn-icon float-left btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
                    }

                    if (auth()->user()->can('adminusers_edit')) {
                        $retAction .= '<a href="' . route('admin.adminusers.edit', $user) . '" class="btn btn-sm btn-icon float-left btn-primary ml-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></a>';
                    }
                } else if (auth()->id() == 1) {
                    if (auth()->user()->can('adminusers_show')) {
                        $retAction .= '<a href="' . route('admin.adminusers.show', $user) . '" class="btn btn-sm btn-icon float-left btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
                    }

                    if (auth()->user()->can('adminusers_edit')) {
                        $retAction .= '<a href="' . route('admin.adminusers.edit', $user) . '" class="btn btn-sm btn-icon float-left btn-primary ml-2" data-toggle="tooltip" data-placement="top" title="Edit"><i class="far fa-edit"></i></a>';
                    }

                    if (auth()->user()->can('adminusers_delete')) {
                        $retAction .= '<form class="float-left pl-2" action="' . route('admin.adminusers.destroy', $user) . '" method="POST">' . method_field('DELETE') . csrf_field() . '<button class="btn btn-sm btn-icon btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash"></i></button></form>';
                    }
                } else {
                    if ($user->id == 1) {
                        if (auth()->user()->can('adminusers_show')) {
                            $retAction .= '<a href="' . route('admin.adminusers.show', $user) . '" class="btn btn-sm btn-icon float-left btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
                        }
                    } else {
                        if (auth()->user()->can('adminusers_show')) {
                            $retAction .= '<a href="' . route('admin.adminusers.show', $user) . '" class="btn btn-sm btn-icon float-left btn-info" data-toggle="tooltip" data-placement="top" title="View"><i class="far fa-eye"></i></a>';
                        }

                        if (auth()->user()->can('adminusers_edit')) {
                            $retAction .= '<a href="' . route('admin.adminusers.edit', $user) . '" class="btn btn-sm btn-icon float-left btn-primary ml-2"><i class="far fa-edit"></i></a>';
                        }
                    }
                }

                return $retAction;
            })
            ->addColumn('image', function ($user) {
                return '<figure class="avatar mr-2"><img src="' . $user->images . '" alt=""></figure>';
            })
            ->addColumn('name', function ($user) {
                return $user->name;
            })
            ->editColumn('id', function ($user) {
                return $user->setID;
            })
            ->escapeColumns([])
            ->make(true);
    }

    private function username($email)
    {
        $emails = explode('@', $email);
        return $emails[0] . mt_rand();
    }


public function view_room_Slots(){
    $data = Slot::all();
    return view('Room_Time_Slot.Time_Slots',['data'=>$data]);
}

public function new_Slots(){

    $this->data['employees'] = Employee::where('status', Status::ACTIVE)->get();

    return view('Room_Time_Slot.create_slot', $this->data);

}

public function create_slots(Request $request){

    $Slo = new Slot();
    $Slo->room_name = $request->get('room_name');
    $Slo->day = $request->get('day');
    $Slo->status=$request->get('status');
    $Slo->number_visitors=$request->get('number_visitors');
    $Slo->room_support_number=$request->get('room_support_number');
    $Slo->check_in_time=$request->get('check_in_time');
    $Slo->check_out_time=$request->get('check_out_time');
    $Slo->note=$request->get('note');
    $Slo->save();

   return redirect()->back()->with('message','Slot is created successfully');

}

public function checkRoomAvailability(){


    $igihe=Slot::all();
   $room=Employee::all();

   //dd( $room);
     return view('admin.visitor.RoomAvailability',['Slots'=>$igihe,'employees'=>$room]);

}
public function showIndex(){
    return view('admin.visitor.index');
}

public function checkTimeSlots(Request $request){

    $itariki = $request->get('check_in_date');
    $day = Carbon::createFromFormat('Y-m-d', $itariki)->format('l');
  
// dd($request->get('check_in_date').$day);

$sl=explode('-',$request->get('check_time_slot'));

$slot_exists =DB::table('slots')
   ->where('day', '=',$day)
    ->where('check_in_time', '=', $sl[0])
    ->where('check_out_time','=',trim($sl[1]))
    ->first();

    if (is_null($slot_exists)) {
        return redirect()->back()->with('message','Sorry, There is no available Visiting time slot for the selected date! ');
    } else {
       if($slot_exists->number_visitors =='0'){
        return redirect()->back()->with('message','Sorry,There is no available Visitors on this slot of '.$request->get('check_time_slot').' Date of '.$request->get('check_in_date'). ' Please choose another time slot');
      }else{
          
        Slot::where('id', $slot_exists->id)
         ->first()
         ->update(['number_visitors' => $slot_exists->number_visitors-1]);

         
        $datax = Employee::where('status', Status::ACTIVE)->get();

  

         return view('admin.visitor.create',[
             'go_in_date'=>$request->get('check_in_date'),
         'go_in_time'=>$request->get('check_time_slot'),
         'employees'=>$datax,
        'room_name'=>$request->get('employee_id')]);

      }


    }

}



public function registerV(Request $request)
{
// dd($request->get('first_name'));

 $user      = new User;
    $user->first_name = $request->first_name;
    $user->last_name  = $request->last_name;
    $user->email      = $request->email;
    $user->username   = $request->username ?? $this->username($request->email);
    $user->password   = Hash::make(request('password'));
    $user->phone      = $request->phone;
    $user->address    = $request->about;
    // $user->status     = 5;
    $user->save();

    $sms=new TransferSms();
    $message='Hello '.$request->input('first_name').' '
    .$request->input('last_name').' Your Visitor account on Hospital Patient tracker system has been created successfully,  Thank you for using HPVT, powered by Zacharie Auca ';
    
    $sms->sendSMS($request->input('phone'),$message);

    if (request()->file('image')) {
        $user->addMedia(request()->file('image'))->toMediaCollection('user');
    }

    $role = Role::find(3);
    $user->assignRole($role->name);

    return redirect('/login');



}



}
