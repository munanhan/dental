<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Patient;
use Illuminate\Support\Facades\DB;

class PatientRecyclingBinController extends Controller
{
    //
    // protected $input = '';//参数
    public function __construct(Request $request){
    	// $input = $request->input();
    	// $pager = [];//分页参数
    	// $unset_field = ['current_page','page_size','_d'];//删除字段
    	// $unset_parms = function() use ($input,$unset_field,$pager){
    	// 	foreach ($input as $k => $v) {
    	// 		if (in_array($k,$unset_field)) {
    	// 			$pager[$k] = $v;
    	// 			unset($input[$k]);
    	// 		}
    	// 	}
    	// 	return ['parms' => $input,'pager' => $pager];
    	// };
    	// $this->input = $unset_parms();
    	// $this->input = getParms($request->input());
    }

    public function index(Request $request){
    	//获取患者回收站数据
    	$input = $request->input();
    	$input['status'] = 0;
    	$input = getParms($input);//参数获取
    	$parms = $input['parms'];
    	$pager = $input['pager'];

    	//顺序，获取case->select->case->join(后面补充)->where->limit;
    	$patient_group = config('config.patient_group');//类型转换,设置case
    	$caseGroup = ['data' => $patient_group,'table' => 'patients','field' => 'group'];
    	$case = caseThen($caseGroup);//case

    	$select = [ 
    				'field' => ['id','name','sex','age','phone','content','source',$case],
    				'table' => 'patients',
    			  ];//设置字段

    	$limit = [  
    				'current_page' => $pager['current_page'],//设置分页
    				'page_size' => $pager['page_size']
    			 ];

    	$sql = MySelect($select).MyWhere($parms).MyLimit($limit);

    	$total = Patient::where('status',0)->count();

    	$res = getData($sql,$parms,1);//处理
    	$res['data']['total'] = $total;
    	return message($res['msg'],$res['data'],$res['code']);

    }

    public function reduction($id){
    	//还原被删除的患者
    	$id = empty($id)?0:$id;
    	if ($id == 0) {
    		return message('缺少id',[],404);
    	}
    	$res = Patient::where('id',$id)->update(['status' => 1 ]);
    	if ($res) {
    		return message('成功',[],200);
    	}
    	else{
    		return message('失败',[],500);
    	}

    }

    public function delete($id){
    	$id = empty($id)?0:$id;
    	if ($id == 0) {
    		return message('缺少id',[],404);
    	}
    	$res = Patient::where('id',$id)->delete();
    	if ($res) {
    		return message('成功',[],200);
    	}
    	else{
    		return message('失败',[],500);
    	}
    }

    public function deleteAll(Request $request){
    	//批量删除
    	$id = empty($request->input('id'))?0:$request->input('id');
    	if ($id == 0) {
    		return message('缺少id',[],404);
    	}
    	$res = Patient::whereIn('id', $id)->delete();
    	if ($res) {
    		return message('成功',[],200);
    	}
    	else{
    		return message('失败',[],500);
    	}
    }

    

}