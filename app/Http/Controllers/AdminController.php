<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Medical_History;
use App\Models\Patient;
use App\Models\Specialization;
use App\Models\User;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use SebastianBergmann\Environment\Console;

class AdminController extends Controller
{
    use AuthenticatesUsers;

    // public function login(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');
    //     if (Auth::guard('admin')->attempt($credentials, $request->remember)) {
    //         $user = Admin::where('email', $request->email)->first();
    //         Auth::guard('admin')->login($user);
    //         return redirect()->route('admin.home');
    //     }
    //     return redirect()->route('admin.login')->with('status', 'Failed To Process Login');
    // }
        /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        return redirect()->route('admin.home');
    }
        /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function logout(Request $request)
    {
        $this->guard()->logout();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
        ? new JsonResponse([], 204)
        : redirect('/');
    }
    protected function loggedOut(Request $request)
    {
        return redirect()->route('admin.login');
    }
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    public static function getStats()
    {
        $total_doctors = Doctor::get();
        $total_users = User::get();
        $total_patients = Patient::get();
        return [
            'total_doctors' => count($total_doctors),
            'total_users' => count($total_users),
            'total_patients' => count($total_patients)
        ];
    }

    protected function manageDoctors()
    {
        $doctors = Doctor::get();
        //dd($doctors);
        return view('admin.manageDoctors', [
            'doctors' => $doctors
        ]);
    }

    protected function editDoctor($id)
    {
        $specializations = Specialization::get();
        $doctor = Doctor::find($id);
        return view('admin.doctorEditForm', [
            'doctor' => $doctor,
            'specializations' => $specializations,
        ]);
    }

    protected function updateDoctor(Request $request)
    {
        $request->validate([
            'name'=>'required|max:255',
            'specialization'=>'required|max:255',
            'email'=>'required|email',
            'fees'=>'required|max:255',
            'contact_no'=>'required|numeric',
            'address'=>'required|max:255',
         ]);
        //return $request->id;
        $data = Doctor::find($request->id);
       // return $data;
        $data->name = $request->name;
        $data->specialization = $request->specialization;
        $data->email = $request->email;
        $data->fees = $request->fees;
        $data->contact_no = $request->contact_no;
        $data->address = $request->address;
        $data->save();
        return redirect()->route('manageDoctors');
    }

    protected function addDoctor(Request $request)
    {
        $request->validate([
            'name'=>'required|max:255',
            'specialization'=>'required|max:255',
            'email'=>'required|email',
            'fees'=>'required|max:255',
            'contact_no'=>'required|numeric',
            'address'=>'required|max:255',
            'password' => 'required|confirmed'
         ]);
        $newDoc = new Doctor();
        $newDoc->name = $request->name;
        $newDoc->specialization = $request->specialization;
        $newDoc->email = $request->email;
        $newDoc->fees = $request->fees;
        $newDoc->contact_no = $request->contact_no;
        $newDoc->address = $request->address;
        $newDoc->password = Hash::make($request->password);
        $newDoc->save();
        return redirect()->route('manageDoctors');
    }

    protected function deleteDoctor($id)
    {
        $data = Doctor::find($id);
        $data->delete();
        return redirect()->route('manageDoctors');
    }


    protected function manageSpecializations()
    {
        $specializations = Specialization::get();
        return view('admin.manageSpecializations', [
            'specializations' => $specializations
        ]);
    }

    public function getSpecialization($id)
    {
        $spec = Specialization::find($id);
        return response()->json($spec);
    }

    protected function addSpecializationAJAX(Request $request)
    {
        //dd("yooo");
        $newSpec = new Specialization();
        $newSpec->name = $request->Specialization;
        $newSpec->save();
        return response()->json($newSpec);
    }

    protected function updateSpecializationAJAX(Request $request)
    {
        $spec = Specialization::find($request->id);
        $spec->name = $request->name;
        $spec->save();
        return response()->json($spec);
    }

    protected function deleteSpecializationAJAX(Request $request)
    {
        if($request->ajax())
        {
            $data = Specialization::find($request->id);
            $data->delete();
            return response()->json($data);
        }
        else
        {
            $data = Specialization::find($request->id);
            return $data;
        }
    }

    protected function manageUsers()
    {
        $users = User::get();
        return view('admin.manageUsers', [
            'users' => $users
        ]);
    }

    protected function deleteUserAJAX(Request $request)
    {
        if($request->ajax())
        {
            $data = User::find($request->id);
            $data->delete();
            return response()->json($data);
        }
        else
        {
            $data = User::find($request->id);
            return $data;
        }
    }

    protected function managePatients()
    {
        $patients = Patient::get();
        return view('admin.managePatients', [
            'patients' => $patients
        ]);
    }

    protected function viewPatient($id)
    {
        $data = Patient::find($id);
        $mHistory = Medical_History::where("patient_id" , '=', $id)->get();

        return view('admin.viewPatient', [
            'patient' => $data,
            'medical_history' => $mHistory
        ]);
    }

    protected function searchPage()
    {
        return view('admin.search');
    }


    protected function search(Request $request)
    {
        if(filter_var($request->input('query'), FILTER_VALIDATE_INT))
        {
            $data = Patient::where('contact_no','=',$request->input('query'))->get();
            return view('admin.search', [
                'patients' => $data
            ]);
        }
        $data = Patient::where('name','like','%'.$request->input('query').'%')->get();
        return view('admin.search', [
            'patients' => $data
        ]);
    }

    protected function updateAdmin(Request $request)
    {
        $request->validate([
            'name'=>'required|max:255',
            'email'=>'required|email',
         ]);
        $admin = Admin::find($request->id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->save();
        return redirect()->route('admin.home');
    }

    protected function updatePassword(Request $request)
    {
        $user = Auth::guard('admin')->user();
        if ($request->password != $request->password_confirmation)
        {
            $request->session()->flash('mismatch','New password and confirmed password do not match!');
            return redirect()->route('updatePassForm');
        }
        if($user)
        {
            if(Hash::check($request->current_password, $user->password))
            {
                $user->password = Hash::make($request->password);
                $user->save();

                $request->session()->flash('success','Your password has been updated!');
                return redirect()->route('admin.home');
            }
            else
            {
                $request->session()->flash('current_password','The current password in incorrect!');
                return redirect()->back();
            }
        }
        // $request->validate([
        //     'password' => 'required|confirmed|min:4',
        //     'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
        //         if (!Hash::check($value, $user->password)) {
        //             return $fail(__('The current password is incorrect.'));
        //         }
        //     }],
        // ]);

    }

}
