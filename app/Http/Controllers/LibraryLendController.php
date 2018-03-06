<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\LendRecord;
use App\Services\BindingService;
use App\Services\LendRecordService;

class LibraryLendController extends Controller
{

    public function index(){
        return view('library_lend.index',BindingService::binding());
    }

    public function lend(){
        return view('lend.index',BindingService::binding());
    }

    public function lendProcess(){
        $input = Request()->all();
        $rules = [
            'unit'=>[
                'required',
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
        $record = LendRecord::where('id',$id)->update([
            'response' => $input['response'],
            'verification' => $input['solution']
        ]);;
        return redirect('lend/verification');
    }
}
