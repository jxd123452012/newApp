<?php
class DbUntil
{
    private $dsn;
    private $name;
    private $password;
    private $opts = array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION);
    private $dbn;
    /**
	*$dbname为数据库名字传入字符串
	*/
    function __construct(){
        $this->dsn = "mysql:host=localhost;dbname=xiangmu";
        $this->name = "root";
        $this->password = "";
    }
    
    private function createPdo(){
        $this->dbn = new PDO($this->dsn, $this->name, $this->password, $this->opts);
    }
    
    private function clear($dbn,$res){
        $dbn = null;
        $res=null;
    }
    /**
     * 通用的增删改方法
     * sql代表传进来的sql语句
     */
    public function addDelUpd($sql,array $pratm,&$con){
        $res = 0;
        try{
            if($this->dbn == null){
                $this->createPdo();
            }
            $pre = $this->dbn->prepare($sql);
            $res = $pre->execute($pratm);
            $con = $pre->rowCount();
            $this->clear($this->dbn, $pre);
        }catch(PDOException $e){
            echo "操作失败".$e->getMessage();
        }
        return $res;
    }
    public function search($sql,array $pratm=array(),&$con,$type=null){
        $arr=array();
        try{
            if($this->dbn == null){
                $this->createPdo();
            }
            $pre = $this->dbn->prepare($sql);
            $res = $pre->execute($pratm);
            $con = $pre->rowCount();
            if(is_null($type)){
                foreach ($pre as $arr1){
//                     $arr[] = $arr1;
                    array_push($arr, $arr1);
                }
            }else {
                while(!!$obj = $pre->fetchObject($type)){
                    array_push($arr, $obj);
                }
            }
        }catch(PDOException $e){
            
        }
        return $arr;
    }
    /**
     * 通用的分页方法
     * $sql代表传入的sql语句
     * $cur_page代表从那一页开始
     * $rows代表查多少条
     * @author kqs
     * 
     */
    public function TongFen($sql,$cur_page,$rows){
        if($this->dbn==null){
            $this->createPdo();
        }
        try{
            $pages = $this->countPages($sql,$rows);
            if(0<$cur_page&$cur_page<=$pages){
                $sql=$sql." limit ".($cur_page-1)*$rows.",".$rows;
                $arr = $this->search($sql,array(),$con);
            }else {
                die("请输入正确的页码，或者正确的行数");
            }
        }catch(PDOException $e){
            die("操作失败".$e->getMessage());
        }
        return $arr;
    }
    /**
     * 计算总条数
     * $sql代表计算的sql语句
     * 返回$con;
     */
    public function countRow($sql){
        if($this->dbn==null){
            $this->createPdo();
        }
        try{
            $this->search($sql,array(),$con);
        }catch(PDOException $e){
            die("计算总条数失败".$e->getMessage());
        }
        return $con;
    }
    /**
     * 计算总页数
     * $sql代表计算的sql语句
     * $pages代表计算出来的总页数
     * 返回$pages;
     */
    public function countPages($sql,$size){
        $pages=0;
        $countRow = $this->countRow($sql);
        if($countRow%$size==0){
            $pages = $countRow/$size;
        }else {
            $pages = intval($countRow/$size)+1;
        }
        return $pages;  
    }
        
}
?>