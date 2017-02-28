<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Cart;
use App\Order;
use DB;
use Mail;
use Symfony\Component\HttpFoundation\Session\Session;
use App\User;
use App\Info;
use App\Collect;
class CenterController extends Controller{

/**
 * 个人中心
 * @return [type] [description]
 */
    public function center(Request $request){
    	//$request->session()->put('key', '黄文靖');
    	//$value = $request->session()->pull('key', 'default');
        $session = new Session();
        $nickname = $session->get('id');
        $arr = DB::table('study_user')->where('user_id',$nickname)->first();
        return view('center.center',['arr'=>$arr]);
    }
    /**
    *
    * 资料
     */
    public function myinfo(Request $request)
    {
        $session = new Session;
        $nickname =  $session->get('nickname');
          if(empty($nickname))
          {
             return redirect('login');
             die;
          }else
          {
              $id =  $session->get('id');
            $User = new User();
            $Info = $User->infomation($id);
          }
        return view('myinfo.myinfo',['info'=>$Info]);
    }
/**
 * 修改个人资料
 */
   public function updateInfo(Request $request)
   {
     $session = new Session;
     $nickname =  $session->get('nickname');
          if(empty($nickname))
          {
             return redirect('login');
             die();
          }else{
              $user = new User();
             $request = $request->all();
             $img = $request['file'];
            $nickName = $request['nickname'];
            $desc = $request['desc'];
            preg_match("/^.*,(.*)$/is",$img,$res);
            $name = time().rand(100,900);
            if(!empty($img)){
                file_put_contents("./style/images/$name.jpg",base64_decode($res[1]));
                $filename = "./style/images/$name.jpg";
                $reg = $user->Update_info($nickname,$nickName,$desc,$filename);
            }else{
                $reg = $user->Updateinfo($nickname,$nickName,$desc);
            }
              if($reg == 1)
            {
                $session->set('nickname',$nickName);
                return 0;
            }else
            {
              return 500;
            }
        }
   }
   /**
    * 我的购物车
    */
   public function cart_info(Request $request)
   {
      $session = new Session;
      $nickname = $session->get('nickname');
      if(empty($nickname))
       {
         return redirect('login');
       }else
       {
         $Cart = new Cart();
         $arr = $Cart->user_cart($nickname);
         $price=0;
         foreach ($arr as $key => $value)
         {
            $price+=$value['cur_price'];
         }
         return view('center.cart',['arr'=>$arr,'price'=>$price]);
      }
   }
 
    /**
     * 删除购物车单条数据
     */
    public function delCart(Request $request)
    {
       $request = $request->all();
       $cart_id = $request['id'];
       $cart = new Cart();
       $res = $cart->del_cart($cart_id);
       if($res)
       {
          return 1;
       }
    }
   /**
    * 个人订单列表
    * 高并发的应用场景，处理
    */
   public function order_list()
   {
   
    $session = new Session;
      $nickname = $session->get('nickname');
      if(empty($nickname)) {
          return redirect('login');
      } else
      {
        $order = new Order();
        $orders = $order->orderList($nickname);
        return view('center.orderList',['orders'=>$orders]);
       }
   }
   /**
    * 用户意见反馈界面
    */
   public function user_Feed()
   {
      $session = new Session;
      $nickname = $session->get('nickname');
      if(!isset($nickname))
      {
         return redirect('login');
      }else
      {
        return view('center.feed');
       }
   }
   /**
    * 用户反馈提交
    */
   public function subFeed(Request $request)
   {
       
        $session = new Session;
      
        $nickname = $session->get('nickname');
        $request = $request->all();
        $email = $request['email'];
        $feedBack = $request['feedBack'];
        $Info = new Info();
        $reg = $Info->user_info_feedback($email,$feedBack,$nickname);
        if($reg)
        {
          return 1;
        }
   }
    /**
     * 添加个人收藏
     */
    public function my_collection(Request $request)
    {
       $request = $request->all();
       $cur_id = $request['cur_id'];
       $session = new Session;
       $nickname = $session->get('nickname');
       if(!isset($nickname))
       {
          echo "<script>alert('请先登录');location.href='login';</script>";
       }
       $userInfo = DB::table('study_user')->where('nickname', '=',$nickname)->first();
       $ruls =DB::table('study_collect')->where('user_id',$userInfo['user_id'])->where('cur_id',$cur_id)->first();
        if($ruls)
        {
           return view('market.list');
         }else
         {
           $collect = new Collect();
           $reg = $collect->addCol($cur_id,$nickname);
           return redirect('personal');
         }
    }
    /**
     * 查看个人收藏
     */
    public function personal_collection()
    {
         $session = new Session;
         $nickname =$session->get('nickname');
      if(empty($nickname))
       {
         return redirect('login');
       }else
       {
           $collect = new Collect();
           $cur = $collect->getCol($nickname);
           $arr = array();
           foreach ($cur as $key => $value)
           {
               $arr[]=$value['cur_id'];
           }
            $curs = DB::table('study_cur')->whereIn('cur_id', $arr)->get();
            return view('center.collection',['curs'=>$curs]);
        }
    }

    public function del_collection(Request $request)
    {
          $request = $request->all();
          $cur_id = $request['id'];
          $session = new Session;
          $nickname = $session->get('nickname');
          $collect = new Collect();
          $res = $collect->delCol($cur_id,$nickname);
          if(!$res)
          {
            return 1;
          }
    }

}


