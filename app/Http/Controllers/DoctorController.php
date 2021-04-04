<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Appointment;
use App\Models\Medical_History;
use App\Models\Patient;
use App\Models\User;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function PHPSTORM_META\map;

class DoctorController extends Controller
{
    use AuthenticatesUsers;


    protected function authenticated(Request $request, $user)
    {
        return redirect()->route('doctor.home');
    }
        /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function logout(Request $request)
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
        return redirect()->route('doctor.login');
    }
    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('doctor');
    }

    protected function showPatients()
    {
        $patients = Patient::where('doctor_id','=',Auth::guard('doctor')->id())->get();
        //dd($doctors);
        return view('doctor.showPatients', [
            'patients' => $patients
        ]);
    }

    protected function addPatient(Request $request)
    {
        $request->validate([
            'name'=>'required|max:255',
            'email'=>'required|email',
            'age'=>'required|numeric',
            'contact_no'=>'required|numeric',
            'address' => 'required',
            'medical_history' => 'required',
         ]);
        //dd($request);
        $patient = new Patient();
        $patient->doctor_id = $request->doctor_id;
        $patient->doctor_name = $request->doctor_name;
        $patient->name = $request->name;
        $patient->age = $request->age;
        $patient->gender = $request->gender;
        $patient->contact_no = $request->contact_no;
        $patient->email = $request->email;
        $patient->address = $request->address;
        $patient->medical_history = $request->medical_history;
        $patient->save();
        return redirect()->route('doctor.showPatients');
    }

    protected function updatePatientForm($id)
    {
        $patient = Patient::find($id);
        return view('doctor.updatePatientForm', [
            'patient' => $patient,
        ]);
    }

    protected function updatePatient(Request $request)
    {
        $request->validate([
            'name'=>'required|max:255',
            'email'=>'required|email',
            'age'=>'required|numeric',
            'contact_no'=>'required|numeric',
            'address' => 'required',
            'medical_history' => 'required',
         ]);
        $data = Patient::find($request->id);
        $data->name = $request->name;
        $data->age = $request->age;
        $data->contact_no = $request->contact_no;
        $data->email = $request->email;
        $data->address = $request->address;
        $data->medical_history = $request->medical_history;
        $data->save();
        return redirect()->route('doctor.showPatients');
    }

    protected function deletePatient(Request $request)
    {
        if($request->ajax())
        {
            $data = Patient::find($request->id);
            $data->delete();
            return response()->json($data);
        }
        else
        {
            $data = Patient::find($request->id);
            return $data;
        }
    }

    protected function viewPatient($id)
    {
        $data = Patient::find($id);
        $mHistory = Medical_History::where("patient_id" , '=', $id)->get();

        return view('doctor.viewPatient', [
            'patient' => $data,
            'medical_history' => $mHistory
        ]);
    }

    protected function addMedicalHistoryAJAX(Request $request)
    {
        // return $request->patient_id;
        $mHistory = new Medical_History();
        $mHistory->patient_id = $request->patient_id;
        $mHistory->blood_pressure = $request->blood_pressure;
        $mHistory->blood_sugar = $request->blood_sugar;
        $mHistory->weight = $request->weight;
        $mHistory->temperature = $request->temperature;
        $mHistory->medical_prescription = $request->medical_prescription;
        $mHistory->save();
        return response()->json($mHistory);
    }

    protected function appointmentHistory()
    {
        $appointments = Appointment::where('doctor_id','=',Auth::guard('doctor')->id())->orderBy('appointment_date', 'desc')->get();
        // $docNames = [];
        // foreach($appointments as $appointment)
        // {
        //     array_push($docNames,Doctor::find($appointment->doctor_id));
        // }
        return view('doctor.appointmentHistory', [
            'appointments' => $appointments,
        ]);
    }

    protected function cancelAppointment(Request $request)
    {
        $appointment = Appointment::find($request->id);
        $appointment->doctor_status = false;
        $appointment->save();
        return response()->json("success");
    }

    protected function searchPage()
    {
        return view('doctor.search');
    }


    protected function search(Request $request)
    {
        if(filter_var($request->input('query'), FILTER_VALIDATE_INT))
        {
            $data = Patient::where('contact_no','=',$request->input('query'))->get();
            return view('doctor.search', [
                'patients' => $data
            ]);
        }
        $data = Patient::where('name','like','%'.$request->input('query').'%')->get();
        return view('doctor.search', [
            'patients' => $data
        ]);
    }

    protected function updatePassword(Request $request)
    {
        $user = Auth::guard('doctor')->user();
        if ($request->password != $request->password_confirmation)
        {
            $request->session()->flash('mismatch','New password and confirmed password do not match!');
            return redirect()->route('doctor.updatePasswordForm');
        }
        if($user)
        {
            if(Hash::check($request->current_password, $user->password))
            {
                $user->password = Hash::make($request->password);
                $user->save();

                $request->session()->flash('success','Your password has been updated!');
                return redirect()->route('doctor.home');
            }
            else
            {
                $request->session()->flash('current_password','The current password in incorrect!');
                return redirect()->back();
            }
        }


    }
}

