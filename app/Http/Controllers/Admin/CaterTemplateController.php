<?php
/**
 * Created by PhpStorm.
 * User: 12183
 * Date: 2018/9/4
 * Time: 15:27
 */
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;

class CaterTemplateController extends Controller
{
    //微餐饮-模板首页
    public function index(Request $request)
    {
        return view("admin.cater.template.index");
    }

    public function data(Request $request)
    {

        $admins = Auth::guard()->user();
        $admin_id = $admins->id;

        $res = DB::table("cater_template")->where(['admin_id' => $admin_id, 'isvalid' => true])->orderBy('id','desc')
            ->paginate($request->get('limit',30))->toArray();

        $data = [
            'code' => 0,
            'msg'   => '正在请求中...',
            'count' => $res['total'],
            'data'  => $res['data']
        ];
        return response()->json($data);
    }
    /**
     * 微餐饮-新增编辑模板
     * @return view
     */
    public function addTemplate(Request $request)
    {
        $template_id = (int)$request->input("template_id", 0);

        $temp_info = "";

        if ($template_id) {
            $temp_info = DB::table("cater_template")->whereId($template_id)->first();
        }

        return view("admin.cater.template.add_template", ['temp_info' => $temp_info]);
    }

    /**
     * 微餐饮-保存模板
     * @return view
     */
    public function saveTemplate(Request $request)
    {
        $temp_id = (int)$request->input("temp_id", 0);
        $template_id = $request->input("template_id", '');
        $type = (int)$request->input("type", 0);
        $is_on = (int)$request->input("is_on", 0);

        $data = array(
            'template_id' => $template_id,
            'type' => $type,
            'is_on' => $is_on
        );
        if ($temp_id > 0) { //修改
            $result = DB::table("cater_template")->whereId($temp_id)->update($data);
        } else {
            $data['admin_id'] = Auth::guard()->user()->id;
            $data['isvalid'] = true;

            $result = DB::table("cater_template")->insert($data);
        }

        return redirect(route('cater.template.index'))->with(['status'=>'成功']);
    }

    /**
     *  微餐饮-删除模板
     * @return view
     */
    public function delTemplate(Request $request)
    {
        $temp_id = (int)$request->input("temp_id", 0);
        if (empty($temp_id)){
            return response()->json(['code'=>1,'msg'=>'请选择删除项']);
        }
        $template = DB::table("cater_template")->find($temp_id);
        if (!$template){
            return response()->json(['code'=>1,'msg'=>'数据不存在']);
        }

        $result = DB::table("cater_template")->whereId($temp_id)->update(['isvalid' => false]);

        if ($result) {
            return response()->json(['code'=>0,'msg'=>'删除成功']);
        }

        return response()->json(['code'=>1,'msg'=>'删除失败']);
    }
}
