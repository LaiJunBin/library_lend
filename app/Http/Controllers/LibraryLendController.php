<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\LendRecord;
use App\Services\BindingService;
use App\Services\LendRecordService;
Use App\Jobs\SendSignUpMailJob;

class LibraryLendController extends Controller
{

    public function index($y=null,$m=null){
        $Y = $y ?? date('Y');
        $M = $m ?? date('m');
        $D = 1;
        $binding = BindingService::binding();
        $week=Array("日","一","二","三","四","五","六");
        $binding['currentMourh'] = $Y.'年'.$M.'月';
        $binding['prevMouth'] = date("Y/m", mktime(0, 0, 0, $M-1, $D, $Y));
        $binding['nextMouth'] = date("Y/m", mktime(0, 0, 0, $M+1, $D, $Y));
        do{
            $binding['week_day'][$D] = $week[date("w", mktime(0,0,0,$M,$D,$Y))];
            $binding['day'][$D]=LendRecordService::getRecord(['date'=>$Y.'-'.$M.'-'.$D]);
            list($Y,$M,$D) = explode('/',date("Y/m/d", mktime(0, 0, 0, $M, $D+1, $Y)));
            $D = (int)$D;
        }while($D != 1);
        $binding['week'] = $week;
        $binding['max_day'] = (int)date("d", mktime(0, 0, 0, $M, $D-1, $Y));
        $binding['current_day'] = 1;
        // dd($binding);
        return view('library_lend.index',$binding);
    }

    public function lend(){
        return view('lend.index',BindingService::binding());
    }

    public function lendProcess(){
        $input = Request()->all();
        $rules = [
            'unit'=>[
                'max:10',
            ],
            'date'=>[
                'required',
                'date',
                'after:'.date("Y/m/d", mktime(0, 0, 0, date('m'), date('d')-1, date('Y'))),
            ],
            'purpose'=>[
                'required',
                'max:191',
            ]
        ];
        $validator = Validator::make($input,$rules);
        if($validator->fails()){
            return redirect('/lend')->withErrors($validator)->withInput();
        }
        $input['teacher'] = session('user_name');
        $input['unit'] = $input['unit'] ?? ' ';
        $type = $input['time'];
        switch($type){
            case 'am':
                $input['lendTime'] = '1,2,3,4';
                break;
            case 'pm':
                $input['lendTime'] = '5,6,7';
                break;
            case 'custom':
                $input['lendTime'] = implode(',',$input['customTime']);
                break;
        }
        $input['email'] = session('user_email');
        LendRecord::create($input);
        return redirect('/')->with('lendSuccess','T');
    }

    public function records(){
        $record = LendRecordService::getRecord(['teacher' => session('user_name')]);
        $binding = BindingService::binding();
        $binding['records'] = $record;
        return view('lend.record',$binding);
    }

    public function recordsDelete($id){
        $records = LendRecord::where('id',$id)->first();
        $records->delete();
        return redirect('/lend/records');
    }

    public function verification(){
        $record = LendRecordService::getRecord(['verification' => 'F']);
        $binding = BindingService::binding();
        $binding['records'] = $record;
        return view('lend.verification',$binding);
    }

    public function verificationProcess($id){
        $input = Request()->all();
        LendRecord::where('id',$id)->update([
            'response' => $input['response']??' ',
            'verification' => $input['solution']
        ]);
        $lendRecord = LendRecord::where('id',$id)->first();
        $mail_binding = [
            'email' => $lendRecord->email,
            'title' => '圖書館借用申請成功',
            'template' => 'email.lendVerificationEmail',
            'date' => $lendRecord->date
        ];
        SendSignUpMailJob::dispatch($mail_binding);

        return redirect('lend/verification');
    }
}
