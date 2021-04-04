<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Medical_History;
use App\Models\Patient;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    protected function bookAppointmentForm()
    {
        $specializations = Specialization::get();
        $doctors = Doctor::get();
        return view('bookAppointment', [
            'specializations' => $specializations,
            'doctors' => $doctors
        ]);
    }

    protected function getDoctors($id)
    {
        $doctors = Doctor::where('specialization', '=', $id)->get();
        return response()->json($doctors);
    }

    protected function getFees($id)
    {
        $doctors = Doctor::find($id);
        return response()->json($doctors->fees);
    }

    protected function bookAppointment(Request $request)
    {
        $request->validate([
            'specialization'=>'required',
            'fees'=>'required',
            'appointment_date'=>'required|date',
            'appointment_time'=>'required|time',
         ]);
        $appointment = new Appointment();
        $appointment->specialization = $request->specialization;
        $appointment->doctor_id = $request->doctor;
        $appointment->user_id = $request->user()->id;
        $appointment->fees = $request->fees;
        $appointment->appointment_date = $request->date;
        $appointment->appointment_time = $request->time;
        $appointment->user_status = true;
        $appointment->doctor_status = true;
        $appointment->save();
        return redirect()->route('appointmentHistory');
    }

    protected function appointmentHistory()
    {
        $appointments = Appointment::where('user_id','=',Auth::user()->id)->orderBy('appointment_date', 'desc')->get();
        // $docNames = [];
        // foreach($appointments as $appointment)
        // {
        //     array_push($docNames,Doctor::find($appointment->doctor_id));
        // }
        return view('appointmentHistory', [
            'appointments' => $appointments,
        ]);
    }

    protected function cancelAppointment(Request $request)
    {
        $appointment = Appointment::find($request->id);
        $appointment->user_status = false;
        $appointment->save();
        return response()->json("success");
    }

    protected function medicalHistory()
    {
        $patient = Patient::where('name','=',Auth::user()->name)->first();
        if($patient != null){
            $medicalHistory = Medical_History::where('patient_id', '=', $patient->id)->get();
        }
        //dd($medicalHistory);
        if(isset($medicalHistory))
        {
            // $medicalHistoryAll = $medicalHistory->get();
            return view('medicalHistory', [
                'patient' => $patient,
                'medical_history' => $medicalHistory
            ]);
        }
        return view('medicalHistory', [
            'patient' => $patient,
        ]);

    }

    protected function updatePassword(Request $request)
    {
        $user = Auth::guard('web')->user();
        if ($request->password != $request->password_confirmation)
        {
            $request->session()->flash('mismatch','New password and confirmed password do not match!');
            return redirect()->route('home.updatePasswordForm');
        }
        if($user)
        {
            if(Hash::check($request->current_password, $user->password))
            {
                $user->password = Hash::make($request->password);
                $user->save();

                $request->session()->flash('success','Your password has been updated!');
                return redirect()->route('home');
            }
            else
            {
                $request->session()->flash('current_password','The current password in incorrect!');
                return redirect()->back();
            }
        }
    }


    protected function updateUser(Request $request)
    {
        $request->validate([
            'name'=>'required|max:255',
            'email'=>'required|email',
            'address'=>'required|max:255',
            'city'=>'required|max:255',
         ]);
        $data = User::find($request->id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->address = $request->address;
        $data->city = $request->city;
        $data->save();
        return redirect()->route('home');
    }
}
