<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use DB;
use App\User;
use App\Cur;
use App\Cart;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Session\Session;
class MarketController extends Controller{

/**
 * 全部课程分类
 * @return [type] [description]
 */
    public function market(){
        $id=Input::get('sh','');
        $types = DB::table('study_type')->where('type_is_show',1)->where('parent_id','=',0)->get();
        //print_r($types);die;
        foreach($types as $key=>$val){
            $types[$key]['pp']=DB::table('study_type')->where('type_is_show',1)->where('parent_id','=',$val['type_id'])->get();
            foreach($types[$key]['pp'] as $k=>$v){
                $types[$key]['pp'][$k]['pp']=DB::table('study_type')->where('type_is_show',1)->where('parent_id','=',$v['type_id'])->get();
                //print_r($v['type_id']);
            }
            //print_r($types[$key]['pp']);
        }
//        print_r($types);
//        print_r($info);
//        die;
        $cur = new Cur();
        if($id==1){
            $data=$cur->searchCurNew("study_cur.cur_is_new");
        }else if($id==2){
            $data=$cur->searchCurNew("study_cur.cur_is_heat");
        }else{
            $data=$cur->searchCurAlls();
        }
        return view('market.market',['types'=>$types,'data'=>$data]);
    }

    public function curr(){
        $id=Input::get('id','');
        //echo $id;
        $cur = new Cur();
        if($id==""){
            $data=$cur->searchCurAll();
        }else{
            $data=$cur->searchCurType($id);
        }
//        print_r($data);
        return view('market.list',['data'=>$data]);
    }
    //点击查看
    public function laidian(Request $request){
        $nums=$request->get('nums','');
        $cur = new Cur();
        $num=$nums-5;
        $data=$cur->searchCurNum($num,$nums);
        return json_encode($data);
    }
//    //////详情页
//    public function cont(){
//        $id=Input::get('cur_id');
//        $cur = new Cur();
//        $curone=$cur->searchCurone($id);
//        $kejie=$cur->curOne($id);
//        //print_r($kejie);die;
//        return view('market.article',['curone'=>$curone,'kejie'=>$kejie]);
//    }
    //////详情页
    public function cont(){
        $id=Input::get('cur_id');
        $cur = new Cur();
        $curone=$cur->searchCurone($id);
        $kejie=$cur->curOne($id);
        $session = new Session();
        $name = $session->get('nickname');
        if($name!=""){
            $user = DB::table('study_user')->where('nickname', '=',$name)->first();
            $user_id = $user['user_id'];
            $res=DB::table('study_order')->where('cur_id',$id)->where('user_id',$user_id)->where('status',1)->first();
            if($res){
                $curone['cur_price']=0;
                return view('market.article',['curone'=>$curone,'kejie'=>$kejie]);
            }else{
                return view('market.article',['curone'=>$curone,'kejie'=>$kejie]);
            }
        }
        return view('market.article',['curone'=>$curone,'kejie'=>$kejie]);
    }

    //播放
    public function bfang(){
        $id=Input::get('fid');
        $cur_id=Input::get('cur_id');
        $cur = new Cur();
        $kejie=$cur->curOne($cur_id);
        $curone=$cur->searchCurone($cur_id);
        $onetv=DB::table('study_chapter')->where('id',$id)->first();
//        print_r($curone);die;
        return view('market.video',['curone'=>$curone,'onetv'=>$onetv,'kejie'=>$kejie]);
    }
    ///加入购物车
     public function shopcart(){
             $id=Input::get("id");
             $cart = new Cart();
             $session = new Session;
             $nickname = $session->get('nickname');
             $time = date("Y-m-d H:i:s",time()+8*60*60);
             $reg = $cart->insert_cart($nickname,$id,$time);
             if($reg)
             {
                 $info=[
                   'status'=>0,
                   'msg'=>"加入成功",
                 ];
                 return $info;
             }else
             {
                echo 0;
             }
     }
    /**
     * 查询用户是否已经将视频添加到购物车
     */
     public function getCart()
     {
         $id = Input::get("id");
         $cart = new Cart();
         $session = new Session;
         $nickname = $session->get('nickname');
         $reg = $cart->get_cart($id,$nickname);
         if($reg)
         {
            return 1;
         }else
         {
            return 0;
         }
     }

     public function order()
     {
         $url = Input::get('url');
         return view('market.order',['url'=>$url]);
     }
     /**
      * 支付
      *
      */
     public function pay()
     {
         $img = Input::get('img');
         $courseName = Input::get('courseName');
         //处理
         $curPrice = Input::get('curPrice');
         $curId = Input::get('curId');
         $token = Input::get('_token');
         $imgs =  rtrim($img,',');
         $imgg = explode(',',$imgs);

         $name = rtrim($courseName,',');
         $cname = explode(',',$name);

         $pric = rtrim($curPrice,',');
         $price = explode(',',$pric);

         $id = rtrim($curId,',');
         $curid = explode(',',$id);

         $time = time()+8*8*60;
         $session = new Session();
         $name = $session->get('nickname');
         $user = DB::table('study_user')->where('nickname', '=',$name)->first();
         $id = $user['user_id'];//用户id
         //唯一订单号
         $weiyi = "duoxue".time().rand(100,900);
         foreach ($curid as $k=>$v){
             $user=array(
                 'cur_img'=>$imgg[$k],
                 'order_name'=>$cname[$k],
                 'add_time'=>date("Y-m-d H:i:s",$time),
                 'user_id'=>$id,
                 'cur_id'=>$v,
                 'weiyi'=>$weiyi,
                 'price'=>$price[$k]
             );
             $re = DB::table('study_order')->insert($user);
         }

         if($re){
             //商品名
             $goods_name = $courseName;
             $curPrice = 0.01;
             $url = $this->order_pay($goods_name,$weiyi,$curPrice);
//             trim(' ',$url);
             return $url;
         }else{
             return 1;
         }


     }
     public function result()
     {
         $re = Input::get();
         $dingdan = $re['out_trade_no'];
         $status = $re['is_success'];
         if($status == 'T'){
             $session = new Session();
             $name = $session->get('nickname');
             $user = DB::table('study_user')->where('nickname', '=',$name)->first();
             $id = $user['user_id']; //用户ID
             //查询出订单对应的id
             $order = DB::table('study_order')->where('weiyi', '=',$dingdan)->get();
             foreach ($order as $k=>$v){
                 $r = DB::table('study_cart')->where('cart_id', '=',$v['cur_id'])->delete();
             }
             //$res = DB::table('study_cart')->where('user_id',$id)->where('')
             $res = DB::table('study_order')
                 ->where('user_id',$id)
                 ->where('weiyi',$dingdan)
                 ->update(
                     array('status' => 1)
                 );
             if($res){
                 return redirect("myorder");
             }else{
                 return redirect('mycart');
             }
         }

     }

    function  order_pay($goods_name,$weiyi,$price)
    {
        header("Content-type:text/html;charset=utf-8");
        //合作身份者id，以2088开头的16位纯数字
        $alipay_config['partner']		= '2088121321528708';
        //收款支付宝账号
        $alipay_config['seller_email']	= 'itbing@sina.cn';
        //安全检验码，以数字和字母组成的32位字符
        $alipay_config['key'] = '1cvr0ix35iyy7qbkgs3gwymeiqlgromm';
        //签名方式 不需修改
        $alipay_config['sign_type']    = strtoupper('MD5');
        //字符编码格式 目前支持 gbk 或 utf-8
        //$alipay_config['input_charset']= strtolower('utf-8');
        //ca证书路径地址，用于curl中ssl校验
        //请保证cacert.pem文件在当前文件夹目录中
        //$alipay_config['cacert']    = getcwd().'\\cacert.pem';
        //访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        $alipay_config['transport']    = 'http';
        $parameter = array(
            "service" => "create_direct_pay_by_user",	    		//请求方式
            "partner" => $alipay_config['partner'], 				// 合作身份者id
            "seller_email" => $alipay_config['seller_email'],       // 收款支付宝账号
            "payment_type"	=> '1', // 支付类型
            "notify_url"	=> "http://home.duzejun.cn/result", 			// 服务器异步通知页面路径
            "return_url"	=> "http://home.duzejun.cn/result", 		// 页面跳转同步通知页面路径
            "out_trade_no"	=> $weiyi, 								// 商户网站订单系统中唯一订单号
            "subject"	=> $goods_name, 								// 订单名称
            "total_fee"	=> $price, 									// 付款金额
            "body"	=> "1501phpa", 									// 订单描述 可选
            "show_url"	=> "", 										// 商品展示地址 可选
            "anti_phishing_key"	=> "", 								// 防钓鱼时间戳  若要使用请调用类文件submit中的query_timestamp函数
            "exter_invoke_ip"	=> "", 								// 客户端的IP地址
            "_input_charset"	=> 'utf-8', 						// 字符编码格式
        );

        // 去除值为空的参数
        foreach ($parameter as $k => $v) {
            if (empty($v)) {
                unset($parameter[$k]);
            }
        }
        // 参数排序
        ksort($parameter);
        reset($parameter);

        // 拼接获得sign
        $str = "";
        foreach ($parameter as $k => $v) {
            if (empty($str)) {
                $str .= $k . "=" . $v;
            } else {
                $str .= "&" . $k . "=" . $v;
            }
        }
        $parameter['sign'] = md5($str . $alipay_config['key']);	// 签名
        $parameter['sign_type'] = $alipay_config['sign_type'];
        $html = "https://mapi.alipay.com/gateway.do?".$str.'&sign='.$parameter['sign'].'&sign_type='.$parameter['sign_type'];
        return  $html;
    }
}

    ?>



 


