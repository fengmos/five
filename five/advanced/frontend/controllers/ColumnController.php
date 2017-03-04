<?php

namespace frontend\controllers;
use frontend\models\Cur;
use Yii;
use frontend\models\Type;
use frontend\models\Details;
use yii\web\Uploads;
use yii\db\Query;
use frontend\models\Chapter;
use yii\data\Pagination;
class ColumnController extends \yii\web\Controller
{
    #404时调用
    public $enableCsrfValidation = false;
    #禁用Yii框架的样式
    public $layout = false;


    public function actionColumn()
    {
        return $this->render('column');
    }

    /**添家资源页面
     * @return string
     */
    public function actionAddcur(){
        //分类查询
        $type=new Type();
        $info=$type::find()->asArray()->all();
        $data=$this->recursion($info);
        //老师
        $query = new Query();
        $res = $query->select('teacher_id,teacher_name')->from('study_teacher')->all();
        return $this->render('addcur',['type'=>$data,'teacher'=>$res]);
    }

    /**递归处理
     * @param $data
     * @param int $path
     * @param int $flag
     * @return array
     */
    public function recursion($data,$path=0,$flag=1){
        static $arr=array();
        foreach($data as $key=>$val){
            if($val['parent_id']==$path){
                $val['flag']=$flag;
                $arr[]=$val;
                $this->recursion($data,$val['type_id'],$flag+1);
            }
        }
        return $arr;
    }
    #入库
    public function actionAddresources()
    {
        //$session=Yii::$app->session;
        $post=Yii::$app->request->post();
        $upload=new Uploads();
        $res=$upload->up($_FILES['img']);
        $res=Yii::$app->db->createCommand()->insert('study_cur',[
            'cur_name' =>$post['ke'],
            'typeid' =>$post['type'],
            'cur_addtime' =>date('Y-m-d h:i:s'),
            'cur_img' =>$res,
            'teacher_id' =>$post['teacher_id'],
            'cur_is_heat' =>$post['is_heat'],
            'cur_is_new'=>$post['is_new'],
            'cur_describe' =>$post['cur_describe'],
            'cur_price' =>$post['price'],
            'typeid' => $post['type'],
        ])->execute();
        if($res){
            $id=Yii::$app->db->getLastInsertID();
            foreach ($post['chapter'] as $k=>$v){
                $re=Yii::$app->db->createCommand()->insert('study_details',['cur_id'=>$id,'chapter'=>$v,'teacher'=>$post['teacher_id']])->execute();
            }
            if($re){
                $ob=new Details();
                $info=$ob::find()->where(['teacher' =>$post['teacher_id']])->asArray()->all();
                return $this->render('addresources',['ziyuan'=>$info]);
            }
        }else{
            echo "<script>alert('添加失败');location.href='?rcolumn/addcur'</script>";
        }
    }

    /**
     * 添加资源
     */
    public function actionAdd(){
        $post=Yii::$app->request->post();
        $name = $post['video_name'];
        $cur_id=$post['type'];
        $str=trim($post['file_path'][0],',');
        $file_path=explode(',',$str);
//        $name=trim($post['username'][0],',');
//        $file_name=explode(',',$name);
        foreach ($file_path as $k=>$v){
            $re=Yii::$app->db->createCommand()->insert('study_chapter',['det_id'=>$cur_id,'url'=>"./".$v,'file_name'=>$name[$k]])->execute();
        }
        if($re){
            $this->redirect('?r=column/lo');
        }else{
            $this->redirect('?r=column/lo');
        }
    }
   public function actionLo(){
       $session=Yii::$app->session;
       $ob=new Details();
       $info=$ob::find()->where(['teacher' =>$session['admin_id']])->asArray()->all();
       $sum=count($info);
       if($sum<=0){
           echo "<script>alert('您还没有添加章节,请先添加');location.href='?r=column/addcur'</script>";
       }else{
           return $this->render('addresources',['ziyuan'=>$info]);
       }
   }
    /**
     * 删除
     */
    public function actionDel()
    {
        $id = Yii::$app->request->post('id');

    }

    /**
     * 资源展示列表
     */
    public function actionShow()
    {
        $name = \Yii::$app->request->post('username');
        $page = \Yii::$app->request->post('pages');
        $type_id = \Yii::$app->request->post('type_id');
        $where = '1';
        if(!empty($name) && empty($type_id)){
            $where = "cur_name like '%$name%'";
        }
        if(!empty($type_id) && empty($name)){
            $where = "typeid = $type_id";
        }
        if(!empty($type_id) && !empty($name)){
            $where= "cur_name like '%$name%' and typeid=$type_id";
        }
        $pages = isset($page) ? $page : 1 ;
        //计算总条数
        $que=new Query();
        $data=$que->from('study_cur')->all();
        $count=count($data);
        //设置每一页显示的条数
        $pageSize = 3;
        //计算总页数
        $pageSum = ceil($count/$pageSize);
        //计算偏移量
        $offset = ($pages-1)*$pageSize;
        //计算上一页 下一页
        $last = $pages<=1 ? 1 : $pages-1 ;
        $next = $pages>=$pageSum ? $pageSum : $pages+1 ;
        //拼接A链接
        $str = '';
        $str .= "<a href='javascript:void(0);' onclick='page(1)'>首页</a>";
        $str .= "<a href='javascript:void(0);' onclick='page($last)'>上一页</a>";
        $str .= "<a href='javascript:void(0);' onclick='page($next)'>下一页</a>";
        $str .= "<a href='javascript:void(0);' onclick='page($pageSize)'>尾页</a>";
        $query = new Query();
        $arr = $query->select('*')->from('study_cur')->join('inner join','study_type','study_cur.typeid = study_type.type_id')->where($where)->offset($offset)->limit($pageSize)->all();
        $ob = new Query();
        foreach ($arr as $k=>$v){
            $arr[$k]['jie'] = $ob->select('id,chapter')->from('study_details')->where(['cur_id'=>$v['cur_id']])->all();
        }

        $type=new Type();
        $info=$type::find()->asArray()->all();
        $data=$this->recursion($info);
        return $this->render('show',[
            'model' => $arr,
            'str' =>$str,
            'type' =>$data,
            'username' =>$name,
            'type_id' =>$type_id
        ]);
    }
    /**
     * 视频
     */
    public function actionVideo()
    {
        $id = Yii::$app->request->post('video_id');
        if(!is_numeric($id)){
            return 1;
        }
        $obj = new Chapter();
        $arr = $obj::find()->where(['id'=>$id])->asArray()->one();
        die(json_encode($arr));
    }
    /**
     * 看电视
     */
    public function actionShowvideo()
    {
        $data = Yii::$app->request->get('video');
        $arr = json_decode($data,true);
        return $this->render('showvideo',['arr'=>$arr]);
    }
    /**
     * 下拉菜单改变
     */
    public function actionChange()
    {
        $id = Yii::$app->request->post('id');
        $obj = new Chapter();
        $arr = $obj::find()->where(['det_id' =>$id])->asArray()->all();
        $sum = count($arr);
        if($sum == 0){
            return 0;
        }else{
            die(json_encode($arr));
        }
    }
    public function actionUploadimg()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            exit; // finish preflight CORS requests here
        }


        if ( !empty($_REQUEST[ 'debug' ]) ) {
            $random = rand(0, intval($_REQUEST[ 'debug' ]) );
            if ( $random === 0 ) {
                header("HTTP/1.0 500 Internal Server Error");
                exit;
            }
        }

// header("HTTP/1.0 500 Internal Server Error");
// exit;


// 5 minutes execution time
        @set_time_limit(5 * 60);

// Uncomment this one to fake upload time
        usleep(5000);

// Settings
// $targetDir = ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";
        $targetDir = 'upload_tmp';
        $uploadDir = 'uploads';

        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 5 * 3600; // Temp file age in seconds


// Create target dir
        if (!file_exists($targetDir)) {
            @mkdir($targetDir);
        }

// Create target dir
        if (!file_exists($uploadDir)) {
            @mkdir($uploadDir);
        }

// Get a file name
        if (isset($_REQUEST["name"])) {
            $fileName = $_REQUEST["name"];
        } elseif (!empty($_FILES)) {
            $fileName = $_FILES["file"]["name"];
        } else {
            $fileName = uniqid("file_");
        }

        $md5File = @file('md5list.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $md5File = $md5File ? $md5File : array();

        if (isset($_REQUEST["md5"]) && array_search($_REQUEST["md5"], $md5File ) !== FALSE ) {
            die('{"jsonrpc" : "2.0", "result" : null, "id" : "id", "exist": 1}');
        }
       // $fileName = iconv("GB2312", "UTF-8",$fileName);
        $name = explode('.',$fileName);
        $names = $name[1];
        $filePath = $targetDir . DIRECTORY_SEPARATOR .$fileName;
        $uploadPath = $uploadDir . DIRECTORY_SEPARATOR .time().".".$names;

// Chunking might be enabled
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;


// Remove old temp files
        if ($cleanupTargetDir) {
            if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
            }

            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

                // If temp file is current file proceed to the next
                if ($tmpfilePath == "{$filePath}_{$chunk}.part" || $tmpfilePath == "{$filePath}_{$chunk}.parttmp") {
                    continue;
                }

                // Remove temp file if it is older than the max age and is not the current file
                if (preg_match('/\.(part|parttmp)$/', $file) && (@filemtime($tmpfilePath) < time() - $maxFileAge)) {
                    @unlink($tmpfilePath);
                }
            }
            closedir($dir);
        }


// Open temp file
        if (!$out = @fopen("{$filePath}_{$chunk}.parttmp", "wb")) {
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }

        if (!empty($_FILES)) {
            if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
            }

            // Read binary input stream and append it to temp file
            if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        } else {
            if (!$in = @fopen("php://input", "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        }

        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }

        @fclose($out);
        @fclose($in);

        rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");

        $index = 0;
        $done = true;
        for( $index = 0; $index < $chunks; $index++ ) {
            if ( !file_exists("{$filePath}_{$index}.part") ) {
                $done = false;
                break;
            }
        }
        if ( $done ) {
            if (!$out = @fopen($uploadPath, "wb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
            }

            if ( flock($out, LOCK_EX) ) {
                for( $index = 0; $index < $chunks; $index++ ) {
                    if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) {
                        break;
                    }

                    while ($buff = fread($in, 4096)) {
                        fwrite($out, $buff);
                    }

                    @fclose($in);
                    @unlink("{$filePath}_{$index}.part");
                }

                flock($out, LOCK_UN);
            }
            @fclose($out);
        }
        $result = array(
            'jsonrpc' => '2.0',
            'result' => 'null',
            'id' => 'id',
            'imgpath' => str_replace('\\','/',$uploadPath),
            'name' =>$fileName
        );
// Return Success JSON-RPC response
        die( json_encode($result));
    }

}

