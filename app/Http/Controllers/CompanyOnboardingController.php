<?php

namespace App\Http\Controllers;

use App\Company;
use App\Department;
use App\Grade;
use App\Holiday;
use App\Job;
use App\Leave;
use App\LeavePeriod;
use App\LeavePolicy;
use App\Notifications\NewUserCreatedNotify;
use App\PayrollPolicy;
use App\RegistrationProgress;
use App\SalaryComponent;
use App\User;
use App\Workflow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyOnboardingController extends Controller
{
    public function index(Request $request)
    {
        $rp=RegistrationProgress::where('company_id',companyId())->first();
        if (!$rp){
            $rp=RegistrationProgress::create(['has_users'=>0,'has_grades'=>0,'has_leave_policy'=>0,'has_payroll_policy'=>0,'has_departments'=>0,'has_job_roles'=>0,'company_id'=>companyId(),'completed'=>0]);
        }
        if($rp->has_grades==0){
            return $this->first_step($rp);
        }elseif ($rp->has_branches==0){
            return $this->second_step($rp);
        }elseif ($rp->has_departments==0){
            return $this->third_step($rp);
        }elseif ($rp->has_job_roles==0){
            return $this->fourth_step($rp);
        }elseif ($rp->has_users==0){
            return $this->fifth_step($rp);
        }elseif ($rp->has_leave_policy==0){
            return $this->sixth_step($rp);
        }elseif ($rp->has_payroll_policy==0){
            return $this->seventh_step($rp);
        }else{
            return redirect(url('home'));
        }
   }

    public function first_step($rp)
    {

        return view('registration_process.first_step',compact('rp'));
   }
    public function second_step($rp)
    {
        return view('registration_process.second_step',compact('rp'));
    }
    public function third_step($rp)
    {
        return view('registration_process.third_step',compact('rp'));
    }
    public function fourth_step($rp)
    {
        return view('registration_process.fourth_step',compact('rp'));
    }
    public function fifth_step($rp)
    {
        return view('registration_process.fifth_step',compact('rp'));
    }
    public function sixth_step($rp)
    {
        $company_id=companyId();
        $lp=LeavePolicy::where('company_id',$company_id)->first();
        $workflows=Workflow::all();
        if (!$lp) {
            $lp=LeavePolicy::create(['includes_weekend'=>0,'includes_holiday'=>0,'user_id'=>Auth::user()->id,'company_id'=>$company_id,'workflow_id'=>0]);
        }
        $holidays=Holiday::where('company_id',$company_id)->get();
        $leaveperiods=LeavePeriod::all();
        $leaves=Leave::all();
        $grades=Grade::doesntHave('leaveperiod')->get();
        return view('registration_process.sixth_step',compact('holidays','leaveperiods','grades','leaves','workflows','lp'));
    }
    public function seventh_step($rp)
    {
        return view('registration_process.seventh_step',compact('rp'));
    }

    public function register(Request $request)
    {

//        request()->request->add(['email'=>'rex@fgh.com','company_email'=>'info@fgh.com','emp_num'=>'rx1234','first_name'=>'Rex','grade'=>'123rx']);

        $company=Company::create(['name'=>$request['company_name'],'email'=>$request['company_email'],'address'=>$request['company_address']]);
        $grade=Grade::create(['level'=>$request['grade'],'company_id'=>$company->id]);
        $department=Department::create(['name'=>$request['department'],'company_id'=>$company->id]);
        $job_role=Job::create(['title'=>$request['job_role'],'department_id'=>$department->id,'qualification_id'=>23]);


        $user = User::create([
            'name' => $request['first_name'].' '.$request['last_name'],
            'email' => $request['email'],
            'emp_num'=>$request['emp_num'],
            'sex'=>$request['gender'],
            'hire_date'=>date('Y-m-d',strtotime($request['hiredate'])),
            'company_id'=>$company->id,
            'job_id'=> $job_role->id,
            'department_id'=> $department->id,
            'grade_id'=>$grade->id,
            'role_id'=>1,
            'payroll_type'=>'office'
        ]);
        $user->notify( new NewUserCreatedNotify($user));
        Auth::loginUsingId($user->id);
        return redirect('home');
//        return $user;
    }

    public function save_payroll_policy(Request $request)
    {
        $company_id=companyId();
        $pp = PayrollPolicy::where('company_id', $company_id)->first();
        $workflow=Workflow::first();

        if ($pp) {
            $pp->update(['basic_pay_percentage' => $request->basic_pay, 'payroll_runs' => 0, 'user_id' => Auth::user()->id, 'workflow_id' => $workflow->id, 'show_all_gross' => 1,'uses_approval' => 0]);
        } else {
            PayrollPolicy::create(['basic_pay_percentage' => $request->basic_pay, 'payroll_runs' => 0, 'user_id' => Auth::user()->id, 'workflow_id' => $workflow->id, 'company_id' => $company_id, 'show_all_gross' => 1,'uses_approval' => 0]);
        }

        $sc1 = SalaryComponent::create( ['name' =>"Transport",  'type' =>1, 'comment' => '', 'constant' => 'transport', 'formula' => 'gross_salary*'.($request->transport/100), 'company_id' => $company_id, 'taxable' => 1,'status'=>1]);
        $sc2 = SalaryComponent::create( ['name' =>"Housing",  'type' =>1, 'comment' =>'' , 'constant' => 'housing', 'formula' => 'gross_salary*'.($request->housing/100), 'company_id' => $company_id, 'taxable' => 1,'status'=>1]);
        $sc3 = SalaryComponent::create( ['name' =>"Pension Fund",  'type' =>0, 'comment' => '', 'constant' => 'pension_fund', 'formula' => '(basic_pay + housing_allowance + transport_allowance) * (0.08)', 'company_id' => $company_id, 'taxable' => 0,'status'=>1]);


            $rp=RegistrationProgress::where('company_id',companyId())->first();
            $rp->update(['has_payroll_policy'=>1,'completed'=>1]);

            $request->session()->flash('success', 'Leave Policy was saved successfully!');
            return redirect('home');
        }



}
