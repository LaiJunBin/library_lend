<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\LendRecord;


class LibraryLendController extends Controller
{
    public function index(){
        $binding = [];
        if(session()->has('user_name')){
            $binding = [
                'breadcrumb' => ['首頁'],
                'navMenu' => [
                    ['url'=>'lend/','title'=>'借用申請'],
                    ['url'=>'lend/records','title'=>'申請紀錄'],
                    ['url'=>'user/update-password','title'=>'修改密碼'],
                    'divider',
                    ['url'=>'user/sign-out','title'=>'登出'],
                ],
                'user_name' => '使用者：'.session('user_name')
            ];
        }else{
            $binding = [
                'breadcrumb' => ['首頁'],
                'navMenu' => [
                    ['url'=>'user/sign-in','title'=>'登入'],
                    ['url'=>'user/sign-up','title'=>'註冊']
                ]
            ];
        }
        return view('library_lend.index',$binding);
    }

    public function lend(){
        $binding = [
            'breadcrumb' =>[
                ['url'=>'/','title'=>'首頁'],
                '借用申請'
            ],
            'navMenu' => [
                ['url'=>'lend/','title'=>'借用申請'],
                ['url'=>'lend/records','title'=>'申請紀錄'],
                ['url'=>'user/update-password','title'=>'修改密碼'],
                'divider',
                ['url'=>'user/sign-out','title'=>'登出'],
            ],
            'user_name' => '使用者：'.session('user_name')
        ];
        return view('lend.index',$binding);
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
        $records = LendRecord::where(['teacher'=>session('user_name')])->get()->toarray();
        $record = [];
        foreach($records as $index => $values){
            foreach($values as $key => $value){
                switch($key){
                    case 'lendTime':
                            $timeArray = explode(',',$value);
                            $tempArray = [];
                            foreach($timeArray as $time){
                                if($time == 'noon'){
                                    array_push($tempArray,'午休時間');
                                }else{
                                    array_push($tempArray,'第'.$time.'節');
                                }
                            }
                            $record[$index]['lendTime'] = implode(',',$tempArray);
                        break;
                    case 'verification':
                        switch($value){
                            case 'T':
                                $record[$index]['color'] = 'success';
                                $record[$index]['verification']='可使用';
                                break;
                            case 'F':
                                $record[$index]['color'] = 'warning';
                                $record[$index]['verification']='待審核';
                                break;
                            default:
                                $record[$index]['color'] = 'danger';
                                $record[$index]['verification']='不可使用';
                                break;
                        }
                        break;
                    default:
                        $record[$index][$key] = $value;
                }
            }
        }
        $binding = [
            'breadcrumb' =>[
                ['url'=>'/','title'=>'首頁'],
                '申請紀錄'
            ],
            'navMenu' => [
                ['url'=>'lend/','title'=>'借用申請'],
                ['url'=>'lend/records','title'=>'申請紀錄'],
                ['url'=>'user/update-password','title'=>'修改密碼'],
                'divider',
                ['url'=>'user/sign-out','title'=>'登出'],
            ],
            'user_name' => '使用者：'.session('user_name'),
            'records' => $record
        ];
        return view('lend.record',$binding);
    }

    public function recordsDelete($id){
        $records = LendRecord::where('id',$id)->first();
        $records->delete();
        return redirect('/lend/records');
    }
}
