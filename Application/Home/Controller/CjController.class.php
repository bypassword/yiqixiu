<?php
namespace Home\Controller;
use Think\Controller;
header("Content-Type: text/html;charset=utf-8");
ini_set("max_execution_time",0);

class CjController extends Controller {
    public function index() {
		if(!isset($_SESSION['adminUser'])){
			exit();
		}
        $cs = $_GET['cs'];
        $user = M("scene");
		//die(var_dump($cs)); 
        $where['eqcode'] = $cs;
        $code = $user->where($where)->select();
		
	 	
        $img = './Uploads/syspic/scene/';
        $img2 = './Uploads/';
        $mp3 = './Uploads/syspic/mp3/';
        
	 	
		//0922开始
		
				$url22 = 'http://eqxiu.com/s/'.$_GET['cs'];

$data22  = $this->GetCurl($url22);


$idstart = strpos($data22,'{id:');
$idend = strpos($data22,',code:');
$id = substr($data22,$idstart+4,$idend-$idstart-4);


$namestart = strpos($data22,'name: "');
$nameend = strpos($data22,'", description');
$name = substr($data22,$namestart+7,$nameend-$namestart-7);


$codestart = strpos($data22,'code:"');
$codeend = strpos($data22,'",name');
$codee = substr($data22,$codestart+6,$codeend-$codestart-6);

if(strstr($data22,"bgAudio:{")){
//$musicstart = strpos($data22,'"url" : "');
$musicend = strpos($data22,'mp3",');
$sub = substr($data22,0,$musicend+3);
$musicstart = strripos($sub,'"');
//echo $musicstart.'|'.$musicend;
$music = substr($sub,$musicstart+1,$musicend-$musicstart+6);	
$music = str_replace("\\",'',$music);
//echo $music;
}


$coverstart = strpos($data22,'cover:"');
$coverend = strpos($data22,',bgAudio');
$cover = substr($data22,$coverstart+7,$coverend-$coverstart-8);


$propertystart = strpos($data22,"property:'");
$propertyend = strpos($data22,"',createTime");
$property = substr($data22,$propertystart+10,$propertyend-$propertystart-10);


		$arr22=array();
		$arr22['id'] = $id;
		$arr22['name'] = $name;
		$arr22['code'] = $codee;
		$arr22['bgAudio']['url'] = $music;
		$arr22['cover'] = $cover;
		$arr22['property'] = $property;
		
		$url = 'http://s1.eqxiu.com/eqs/page/' . $arr22['id'].'?ad=1&time=1449479812051'; 
		//die($url);
        $da = $this->GetCurl($url);
		$resp = json_decode($da, true);

        if (empty($code) and $arr22[name] !== '该场景已关闭') {

			   preg_match_all("/((group\d\/\w+\/\w+\/\w+\/\w+(-\\w+)*+.(gif|jpg|jpeg|png|bmp|svg|jpe)))/isu", $da, $array); 
			
            $src2 = 'syspic/scene/';
			if(C('ISLOG'))
			 \Think\Log::write('要下载企秀的图片'.var_export($array,true)."\n\n -----------\n"); 
			
			 
				$src3 = preg_replace("/(group\d\/\w+\/\w+\/\w+\/)/", $src2, $da);
			 
		 	//die($src3);
            $resp2 = json_decode($src3, true);

 			if(C('ISLOG'))
			 \Think\Log::write('$resp2 = syspic/scene/后'.var_export($resp2,true)."\n\n -----------\n"); 
			
			
            foreach ($array[0] as $key => $var) {
                $urls[$key] = pathinfo($array[0][$key]);
                $this->save_pic('http://res.eqxiu.com/' . $var, $img);
            }
            $data['scenename_varchar'] = $arr22['name'];
			//$data['property'] = $arr22['property'];
            $data['scenecode_varchar'] = 'S' . (date('y', time()) - 9) . date('m', time()) . randorderno(6, -1);
            $data['eqid_int'] = $arr22['id'];
            $data['eqcode'] = $arr22['code'];
            $data['createtime_time'] = date('Y-m-d H:i:s', time());
            $data['showstatus_int'] = 1;
            $data['movietype_int'] = 0;
			$data['userid_int'] =0;

			if (!empty($arr22['bgAudio']['url'])) {
				if (preg_match('|^http://|', $arr22['bgAudio']['url'])) {
					$mp = $arr22['bgAudio']['url'];
				} elseif (isset($arr22['bgAudio']['url'])) {
					$mp = 'http://res.eqxiu.com/' . $arr22['bgAudio']['url'];
				}
				$data['musicurl_varchar'] = 'syspic/mp3/' . $this->save_pic($mp, $mp3);
			 } else {
			}
			
            $pic1 = 'http://res.eqxiu.com/' . $arr22['cover'];
            $data['thumbnail_varchar'] = 'syspic/scene/' . $this->save_pic($pic1, $img);
            
			$data['is_tpl'] = 1;
            $data['desc_varchar'] = $arr22['description'];
            $data['biztype_int'] = $arr22['biztype']? intval($arr22['biztype']):0;
            $data['musictype_int'] = 3;
            //$data['musictype_int'] = (empty($resp['obj']['bgAudio']['type'])) ? 'null' : $data['musictype_int'];
			
			//2015-5-25
			$data['scenetype_int']= $_GET['scenetypeB'] ? intval($_GET['scenetypeB']) :'101';
			$data['tagid_int']= $_GET['scenetypeS'] ? intval($_GET['scenetypeS']) :'20';			
			
			//\Think\Log::write('$_GET ：'. D('')->getLastSql()."\n".var_export($_GET,true)."\n\n -----------\n");
			if(C('ISLOG'))\Think\Log::write('78$data'.var_export($data,true)); 
			
            if ($lastInsId = $user->add($data)) {
			if(C('ISLOG')) \Think\Log::write('scene 表'. D('')->getLastSql()."\n".var_export($data,true)."\n\n -----------\n");
				//2015-5-25
				if($data['musicurl_varchar']&& $_GET['isMusicToSys']){
					$fileData=array(
						'userid_int'=>0,
						'filetype_int'=>2,
						'filesrc_varchar'=>$data['musicurl_varchar'],
						'create_time'=>date('y-m-d H:i:s',time()),
						'biztype_int'=>1,
						'filename_varchar'=>'模板采集ID为'.$lastInsId.'的音乐',
						'ext_varchar'=>'MP3'
						
						);
					M('upfilesys')->add($fileData);	
						
					//\Think\Log::write('upfilesys 表'. D('')->getLastSql()."\n".var_export($fileData,true));
					
				}
				
                echo json_encode(array(
                    "msg" => "成功采集",
                    "url" => 'http://' . $_SERVER['HTTP_HOST'] . '/v-' . $data['scenecode_varchar']
                ));
            } else {
			die(var_dump("数据写入错误"));
                echo json_encode(array(
                    "msg" => "数据写入错误"
                ));
            }
            $dd = M("scenepage");
            $de['sceneid_bigint'] = $lastInsId;
            $de['scenecode_varchar'] = $arr22['code'];
            $de['createtime_time'] = date('Y-m-d H:i:s', time());
            $de['content_text'] = '';
            $de['pagename_varchar'] = 'admin';
			$de['userid_int'] =0;   
            $de['properties_text'] = 'null';
			//die('000');
            foreach ($resp2['list'] as $k => $var) {
                $de['content_text'] = json_encode($var['elements']);
                $de['pagecurrentnum_int'] = $k + 1;
                $dd->add($de);
            }
        } elseif (isset($_GET['cpic'])) {
            $dd = M("scenepage");
            $where['sceneid_bigint'] = $_GET['id'];
            $data = $dd->where($where)->field('content_text')->select();
        } else {
            if (!empty($code[0][scenecode_varchar])) {
                echo json_encode(array(
                    "msg" => "已经存在",
                    "url" => 'http://' . $_SERVER['HTTP_HOST'] . '/v-' . $code[0][scenecode_varchar]
                ));
            } else {
                echo json_encode(array(
                    "msg" => "参数不对"
                ));
            }
        }
    }
    public function searchMultiArray(array $array, $search, $mode = 'key') {
        $res = array();
        foreach (new RecursiveIteratorIterator(new RecursiveArrayIterator($array)) as $key => $value) {
            if ($search === $ {
                $ {
                    "mode"
                }
            }) {
                if ($mode == 'key') {
                    $res[] = $value;
                } else {
                    $res[] = $key;
                }
            }
        }
        return $res;
    }
    public function my_file_exists($file) {
        if (preg_match('/^http:\/\//', $file)) {
            if (ini_get('allow_url_fopen')) {
                if (@fopen($file, 'r')) return true;
            } else {
                $parseurl = parse_url($file);
                $host = $parseurl['host'];
                $path = $parseurl['path'];
                $fp = fsockopen($host, 80, $errno, $errstr, 10);
                if (!$fp) return false;
                fputs($fp, "GET {$path} HTTP/1.1 \r\nhost:{$host}\r\n\r\n");
                if (preg_match('/HTTP\/1.1 200/', fgets($fp, 1024))) return true;
            }
            return false;
        }
        return file_exists($file);
    }
	
		public function save_pic($url, $savepath = '') {
			$filename = $this->get_filename($url);
			if(file_exists($savepath.$filename)){
				 
				return $filename;
			}
			$url = trim($url);
			$url = str_replace(" ", "%20", $url);
			$string = $this->read_filetext($url);
			if (empty($string)) {
				\Think\Log::write("-------------------------------\n".'读取不了文件,地址：'.$url."\n"); 
				// echo '读取不了文件';
				return $filename;
			}			
			$this->make_dir($savepath);
			$filepath = $savepath . $filename;
			$this->write_filetext($filepath, $string);
			return $filename;
		}
    public function save_picY($url, $savepath = '') {
        $url = trim($url);
        $url = str_replace(" ", "%20", $url);
        $string = $this->read_filetext($url);
        if (empty($string)) {
				echo '读取不了文件'.$url;
            exit;
        }
        $filename = $this->get_filename($url);
        $this->make_dir($savepath);
        $filepath = $savepath . $filename;
        $this->write_filetext($filepath, $string);
        return $filename;
    }
    public function get_filename($filepath) {
        $fr = explode("/", $filepath);
        $count = count($fr) - 1;
        return $fr[$count];
    }
    public function read_filetext($filepath) {
        $filepath = trim($filepath);
        $htmlfp = @fopen($filepath, "r");
        if (strstr($filepath, "://")) {
            while ($data = @fread($htmlfp, 500000)) {
                $string.= $data;
            }
        } else {
            $string = @fread($htmlfp, @filesize($filepath));
        }
        @fclose($htmlfp);
        return $string;
    }
    public function write_filetext($filepath, $string) {
        $fp = @fopen($filepath, "w");
        @fputs($fp, $string);
        @fclose($fp);
    }
    public function make_dir($path) {
        if (!file_exists($path)) {
            $mk = @mkdir($path, 0777, true);
            @chmod($path, 0777);
        }
        return true;
    }
    public function GetCurl($url) {
        $curl = curl_init();
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        $resp = curl_exec($curl);
        curl_close($curl);
        return $resp;
    }
} ?>
