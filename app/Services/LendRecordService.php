<?php

namespace App\Services;
use App\LendRecord;

class LendRecordService
{
    static function getRecord($pattern){
        if($pattern != null)
            $records = LendRecord::where($pattern)->orderBy('created_at','desc')->get()->toarray();
        else
            $records = LendRecord::get()->toarray();
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
        return $record;
    }
}