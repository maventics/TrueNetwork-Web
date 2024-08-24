<?php

namespace App\Http\Controllers;

use App\Mail\emails\DisableUser;
use App\Models\Investment;
use App\Models\TransactionTable;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Withdrawrequest;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Models\depositrequest;
use Flasher\Toastr\Laravel\Facade\Toastr;
use Symfony\Component\Console\Input\Input;
use get;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\ManageMemberController;
use datatables;
class usercontroller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function user_available_amount()
    // {
    //     $userId = Auth::id(); // Fetch the authenticated user's ID
    //     try {

    //         $data = TransactionTable::where('user_id', $userId)->where('status',1)->sum('avaiable_amount');

    //         $data = TransactionTable::where('user_id', $userId)->where('type','Deposit')->sum('avaiable_amount');

    //          $this->res = [
    //             'User_Avaiable_Amount' => $data,
    //         ];
    //     } catch (Exception $ex) {
    //         $this->res = $ex->getMessage();
    //     } finally {
    //         return $this->res;
    //     }
    // }

    public function user_available_amount()
    {
    }
    public function updatestatus($id)
    {
        $user = User::find($id);
        if ($user) {
            if ($user->status) {
                $user->status = 0;
                $user->save();
                Mail::to($user->email)->send(new DisableUser($user));
            } else {
                $user->status = 1;
                $user->save();
            }
        }
        return back();
    }


    // public function index()
    // {
    //     $users = User::all();
    //     $withdrawrequests = Withdrawrequest::all();
    //     $depositRequests = depositrequest::all();
    //     return view('usermanagement.index', compact('users', 'withdrawrequests', 'depositRequests'));
    // }

    // public function getUserData()
    // {
    //     // Fetch the user data with selected fields
    //     $users = User::select('id', 'name', 'email', 'phone', 'referral_link', 'status');
        
    //     // Return the datatables response
    //     return datatables()
    //         ->eloquent($users)
    //         ->addColumn('actions', function ($user) {
    //             // Pass the user to the action_modal view
    //             return view('users.action_modal', compact('user'));
    //         })
    //         ->addColumn('status', function ($user) {
    //             // Return the status badge based on user status
    //             if ($user->status === "Active") {
    //                 return '<span class="badge bg-success">Active</span>';
    //             } else {
    //                 return '<span class="badge bg-danger">In-Active</span>';
    //             }
    //         })
    //         ->rawColumns(['actions', 'status'])
    //         ->make(true);
    // }
    
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::select('id','name','email','phone','referral_link','status')->get();
    
            return \Yajra\DataTables\Facades\DataTables::of($data)
                ->addColumn('status', function($row) {
                    $statusText = ($row->status == 1) ? 'UnBlock' : 'Block';
                    $btnClass = ($row->status == 1) ? 'success' : 'danger';
                    return '<a href="/admin/update-status/'.$row->id.'" class="btn btn-sm btn-'.$btnClass.'">'.$statusText.'</a>';
                })
                ->addColumn('action', function($row){
                    $editUrl = "/admin/user/edit/$row->id";
                    $viewUrl = "/admin/user/view/$row->id";
                    $editButton = "<a href='".$editUrl."' class='btn btn-primary btn-sm'><i class='fa fa-edit'></i></a>";
                    $viewButton = "<a href='".$viewUrl."' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i></a>";
                    return $editButton . "  " . $viewButton;
                })
                ->addColumn('image', function($row) {
                    $imageUrl = asset($row->image); 
                    return '<img src="'.$imageUrl.'" alt="User Image" class="img-thumbnail" width="50">';
                })
                ->rawColumns(['status', 'action','image'])
                ->make(true);
        }
    
        $withdrawrequests = Withdrawrequest::all();
        $depositRequests = depositrequest::all();
    
        return view('usermanagement.index', compact('withdrawrequests', 'depositRequests'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|unique:users,email',
                'phone' => 'required|unique:users,phone',
                'password' => 'required',
                //'image' => 'required', // Adjust file types and size as per your requirements
            ]);


            // Hash password
            $hashedPassword = Hash::make($request->input('password'));

            // for testing purpose
            //  $referral_id = "n35y9DDo";
            $user = User::create([
                'email' => $request->email,
                'phone' => $request->phone,
                'name' => $request->name,
                'password' => $hashedPassword,
                'referral_link' => uniqid(),
            ]);

            // Store image
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = 'upload_image' . $imageName;
                $path = public_path('upload_image/');
                $image->move($path, $imageName);
                User::where('id', $user->id)->update(['image' => $imagePath]);
            }
            Toastr::success('User created successfull!');
            return redirect('/admin/user/index');
        } catch (Exception $ex) {
            Toastr::error($ex->getMessage());
            return back()->with('error', $ex->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::where('id', $id)->get()->first(); 
        $withdrawrequests = Withdrawrequest::all();
        $depositRequests = depositrequest::all();
        return view('usermanagement.edit', compact('user','withdrawrequests','depositRequests'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // return $request;
        try {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required',
                'phone' => 'required',
                'password' => 'required',
                'image' => 'required', // Adjust file types and size as per your requirements
            ]);

            // Find the user by ID
            $user = User::findOrFail($id);

            // Update image if provided
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = '/upload_image/' . $imageName;

                $path = public_path('/upload_image');
                $image->move($path, $imageName);
                // Delete old image if exists
                if ($user->image) {
                    unlink(public_path('upload_image/' . $user->image));
                }
                $user->image = $imagePath;
            }

            // Hash password
            $hashedPassword = Hash::make($request->input('password'));

            // Update user details
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->password = $hashedPassword;

            $user->save();

            return back()->with('success', 'User updated Successfully..');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }


    public function destroy(string $id)
    {
        try {
            User::where('id', $id)->delete();
            return back()->with('success', 'User Deleted Successfully..');
        } catch (Exception $ex) {
            return back()->withErrors(['errors' => $ex->getMessage()]);
        }
    }
    public function view($id)
    {
        $userId = Auth::id(); // Fetch the authenticated user's ID
        $sumdepositrequest = depositrequest::where('user_id', $id)->where('status',1)->sum('depositamount');

        // Fetch the user record based on the provided ID
        $user = User::findOrFail($id);
        $withdrawrequests = Withdrawrequest::all();
        $depositRequests = depositrequest::all();
        $controller = new ManageMemberController();
        $commissions = $controller->getCommissionsOfAUser($user->id);
        // Pass the user record and paginated data to the view
        return view('usermanagement.details', compact('user', 'sumdepositrequest', 'withdrawrequests', 'depositRequests','commissions'));
    }

    public function depositRequest(Request $request)
    {
        if ($request->ajax()) {
            $data = depositrequest::select('id','user_id','bank_id','accountholder','accountnumber','depositamount','status')->get();
    
            return \Yajra\DataTables\Facades\DataTables::of($data)
            ->addColumn('action', function($row) {
                if ($row->status == 0) {
                    return '
                    <div class="row">
                        <form action="/update-deposit-status/' . $row->id . '" method="post">
                            ' . csrf_field() . '
                            <input type="hidden" name="status" value="1">
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-check-circle"></i>
                            </button>
                        </form>
                        <form action="/update-status-rejected/' . $row->id . '" method="POST">
                            ' . csrf_field() . '
                            <input type="hidden" name="status" value="2">
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </form>
                    </div>';
                } elseif ($row->status == 1) {
                    return "<span class='badge bg-primary'>Approved</span>";
                } else {
                    return "<span class='badge bg-danger'>Rejected</span>";
                }
            })
            ->addColumn('bank', function ($row){
                return $row->bank->bank;
            })
            ->addColumn('user', function ($row){
                return $row->user->name;
            })
              
                ->rawColumns(['action','bank','user'])
                ->make(true);
        }
    
        $withdrawrequests = Withdrawrequest::all();
        $depositRequests = depositrequest::all();
    
        return view('usermanagement.details', compact('withdrawrequests', 'depositRequests'));
    }
    
    public function TransactionHistory(Request $request)
    {
        if ($request->ajax()) {
            $data = TransactionTable::select('id','user_id','type','avaiable_amount','status','deposit_id','withdraw_id','investment_id')->get();
    
            return \Yajra\DataTables\Facades\DataTables::of($data)
            ->addColumn('action', function ($row) {
                if ($row->status == 1) {
                    return "<span class='badge bg-primary'>Approved</span>";
                } else {
                    return "<span class='badge bg-danger'>Rejected</span>";
                }
            })
            ->addColumn('user', function ($row){
                return $row->user->name;
            })
                ->rawColumns(['action','bank','user'])
                ->make(true);
        }
    
        $withdrawrequests = Withdrawrequest::all();
        $depositRequests = depositrequest::all();
    
        return view('usermanagement.details', compact('withdrawrequests', 'depositRequests'));
    }


    public function Trade(Request $request)
    {
        if ($request->ajax()) {
            $data = Investment::select('id','user_id','scheme_ref_id','amount','end_date_timestamp','created_at')->get();
    
            return \Yajra\DataTables\Facades\DataTables::of($data)
            ->addColumn('user', function ($row){
                return $row->user->name;
            })
            ->addColumn('scheme', function ($row){
                return $row->scheme->title;
            })
            ->addColumn('action', function ($row) {
                return \Carbon\Carbon::parse($row->end_date_timestamp)->format('Y-m-d h:i:s A');
            })
        
                ->rawColumns(['action','scheme','user'])
                ->make(true);
        }
    
        $withdrawrequests = Withdrawrequest::all();
        $depositRequests = depositrequest::all();
    
        return view('usermanagement.details', compact('withdrawrequests', 'depositRequests'));
    }

   
    public function withdrawRequest(Request $request)
    {
        if ($request->ajax()) {
            $data = Withdrawrequest::select('id','user_id','bank_id','accountholder','accountnumber','withdrawamount','status')->get();
    
            return \Yajra\DataTables\Facades\DataTables::of($data)
            ->addColumn('action', function ($row) {
                if ($row->status == 0) {
                    return '
                    <div class="row">
                         <form action="/update-withdraw-status/' . $row->id . '" method="post">
                            ' . csrf_field() . '
                            <input type="hidden" name="status" value="1">
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fas fa-check-circle"></i>
                            </button>
                        </form>
                         <form action="/update-status-rejected-withdraw/' . $row->id . '" method="post">
                            ' . csrf_field() . '
                            <input type="hidden" name="status" value="2">
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </form>
                    </div>';
                } elseif ($row->status == 1) {
                    return "<span class='badge bg-primary'>Approved</span>";
                } else {
                    return "<span class='badge bg-danger'>Rejected</span>";
                }
            })
            ->addColumn('bank', function ($row){
                return $row->bank->bank;
            })
            ->addColumn('user', function ($row){
                return $row->user->name;
            })
              
                ->rawColumns(['action','bank','user'])
                ->make(true);
        }
    
        $withdrawrequests = Withdrawrequest::all();
        $depositRequests = depositrequest::all();
    
        return view('usermanagement.details', compact('withdrawrequests', 'depositRequests'));
    }
}