<?php
header("Content-Type:text/html;charset=utf-8");
date_default_timezone_set('Asia/Chongqing');
require_once "DbUntil.class.php";
class User 
{
    var $id;
    var $username;
    var $password; //保存失败信息
    var $error;
    //保存成功信息
    var $success;
    //跳转的页面
    var $url;
    var $db;
    public function __construct(){
        $this->db = new DbUntil();
    }
    

    /**
     * 注册方法，传两个参数
     * username代表用户名
     * password代表密码
     * 也可以使用不传的方式
     */
    public function register(){
        if(isset($_POST["username"])&isset($_POST["password"])){
            $username = $_POST["username"];
            $password = $_POST["password"];
            $name=$_POST["relname"];
            $dizhi=$_POST["dizhi"];
            $phone=$_POST["phone"];
            $email=$_POST["email"];
            $kahao=$_POST["kahao"];
            $time=date("Y-m-d H:i:s");
            $sql = "select * from `user` where username=?";
            $this->db->search($sql,array($username),$con);
            if($con>0){
                $this->error = "用户名已存在";
            }else{
            
                $sql1 = "insert into `user`(`username`,`password`,`name`,`dizhi`,`phone`,`email`,`kahao`,`time`) values(?,?,?,?,?,?,?,?)";
                $res = $this->db->addDelUpd($sql1,array($username,$password,$name,$dizhi,$phone,$email,$kahao,$time), $con);
                if($res){
                    $this->success = "注册成功";
                    $sql2="select id from user where username=?";
                    $a=$this->db->search($sql2,array($username),$con);
                    $id=$a[0]["id"];
                    $sql3="insert into vipcard(u_id,jifen,money) values(?,?,?)";
                    $this->db->addDelUpd($sql3,array($id,0,0),$con1);
                    $sql4="insert into level(d_id,dengji) value(?,?)";
                    $this->db->addDelUpd($sql4,array($id,"青铜"),$con2);
                    header("Refresh:2;denglu.php");
                }
            }
        }
    }
    
    /**
     * 登陆方法
     */
public function login(){
        if(isset($_POST["username"])&isset($_POST["password"])){
            $username = $_POST["username"];
            $password = $_POST["password"];
            
            $sql = "select * from `user` where `username`=? and `password`=?";
            $arr = $this->db->search($sql,array($username,$password),$con);
            if($con>0){
                if($username==$arr[0]["username"]&&$username=="admin"&&$password==$arr[0]["password"]){
                    
                    session_start();
                    $ycode = $_SESSION["code"];
                    $code = $_POST["code"];
                    if(strtolower($ycode)== $code&&strtolower($ycode)!=""){
                        echo "管理员跳转，请稍等...";
                       header("Refresh:1;houtaiguanli.php");
                    }else if(strtolower($ycode)!= $code){
                        echo "验证码输入错误或者为空";
                        header("Refresh:1;denglu.php");
                    }   
                    
                    
                       
                }
                else
                if ($username==$arr[0]["username"]&&$password==$arr[0]["password"]){
                    
                    session_start();
                    $_SESSION["one"]=$username;
                    
                    
                    $ycode = $_SESSION["code"];
                    $code = $_POST["code"];
                    if(strtolower($ycode)== $code&&strtolower($ycode)!=""){
                        echo "登陆成功";
                        header("Refresh:1;zhuye/zhuye.php");
                    }else if(strtolower($ycode)!= $code){
                        echo "验证码输入错误或者为空";
                        header("Refresh:1;denglu.php");
                    }
                    
                    
                   
                    
                }else {
                    $this->error="用户名或者密码错误";
                    header("Refresh:1;denglu.php");
                }
            }else {
                $this->error="用户名或者密码错误";
                header("Refresh:1;denglu.php");
            }
        }
    }
    
    //信息查询
    public function shuju(){
         session_start();
         $session = $_SESSION["one"];
         $sql="select * from user where username=?";
         $arr=$this->db->search($sql,array($session), $con);
         echo json_encode($arr);
     }
    public function session(){
            session_start();
            if(isset($_SESSION["one"])){
                echo $_SESSION["one"];
            }
       
    }
            
            //修改
    public function xiugai(){
        if(isset($_POST["username"])){
            $username=$_POST["username"];
            $password = $_POST["password"];
            $name=$_POST["name"];
            $dizhi=$_POST["dizhi"];
            $phone=$_POST["phone"];
            $email=$_POST["email"];
            $kahao=$_POST["kahao"];
            
            
            session_start();
            $username1 = $_SESSION["one"];
            $id=$this->db->search("select id from user where username=?", array($username1),$con1);
            $id=$id[0]["id"];
            $arr=$this->db->search("select * from `user` where id=?",array($id), $con2);
            if($arr[0]["username"]!=$username|$arr[0]["password"]!=$password|$arr[0]["name"]!=$name|
                $arr[0]["dizhi"]!=$dizhi|$arr[0]["phone"]!=$phone|
                $arr[0]["email"]!=$email|$arr[0]["kahao"]!=$kahao){
            
                    $sql = "select * from `user` where username=?";
                    $this->db->search($sql,array($username),$con);
                    
                        $sql1 = "update `user` set `username`=?,`password`=?,`name`=?,`dizhi`=?,`phone`=?,`email`=?,`kahao`=? where id=$id";
                        $res = $this->db->addDelUpd($sql1,array($username,$password,$name,$dizhi,$phone,$email,$kahao), $con);
                        if($res){
                            $this->success = "修改成功";
                            $_SESSION["one"]=$username;
                            header("Refresh:1;massage.html");
                        }else {
                            $this->error;
                        }
                   
           }else {
               echo "没有做任何修改";
               header("Refresh:1;massage.html");
           }
        }
    }
            /*充值*/
            public function chongzhi(){
                session_start();
                $username = $_SESSION["one"];
                $sql5="select id from user where username=?";
                $arr1=$this->db->search($sql5,array($username), $con1);
                $id=$arr1[0]["id"];
                $money=$_GET["money"];
            
                $sql7="select money,jifen from vipcard where U_id=?";
                
                $arr2=$this->db->search($sql7,array($id), $con);
                $qian=$arr2[0]["money"];
                $jifen=$arr2[0]["jifen"];
                $arr1=$this->db->search($sql7,array($username), $con1);
                $sql6="update vipcard set money=?,jifen=? where U_id=?";
                $this->db->addDelUpd($sql6,array($money+$qian,$money+$jifen,$id), $con);
                if($con>0){
                    echo "充值成功";
                    header("Refresh:1;jifen.html");
                }
            }
            
    
    /*查询积分方法*/
public function chajifen(){
        
        session_start();
        $username = $_SESSION["one"];
        
        
        $sql5="select id from user where username=?";
        $arr1=$this->db->search($sql5,array($username), $con1);
        $id=$arr1[0]["id"];
        
        
        $sql1="select jifen from vipcard where U_id=?";
        $arr2=$this->db->search($sql1,array($id), $con2);
        $bjfen=$arr2[0]["jifen"];
        
        
        $sql="select username,jifen from user join vipcard on user.id=vipcard.U_id order by jifen desc limit 0,10";
        $arr=$this->db->search($sql,array($id), $con);
        array_push($arr, array($username,$bjfen));
        echo json_encode($arr);
    }
            
    
    
    
    
    
    
    
    
    
    
    
    
    public function __call($fun,$args){
        echo "不能调用不存在的方法${fun},"."参数是:";
        print_r($args);
    }
    
    
    
    
}

?>