<?php
/**
 * Created by PhpStorm.
 * User: 宏达
 * Date: 2017/11/12
 * Time: 19:20
 */
class shopmanage{
    public $db;
    function __construct(){
        $obj=new db();
        $this->db=$obj->mysql;
    }
    function index(){
        $title='商店管理';
        include 'App/views/shopmanage.html';
    }
    function insert(){
        /*$sname=$_POST['sname'];
        $type=$_POST['type'];
        $hot=$_POST['hot'];
        $price=$_POST['price'];
        $thumb=$_POST['thumb'];
        $description=$_POST['description'];
        $capticy=$_POST['capticy'];*/
        $data=$_POST;
        $keys=array_keys($data);
        $str='(';
        for($i=0;$i<count($keys);$i++){
            $str.=$keys[$i].',';
        }
        $str=substr($str,0,-1);
        $str.=') values (';
        foreach($data as $v){
            $str.="'{$v}',";
        }
        $str=substr($str,0,-1);
        $str.=')';
        $sql="insert into shop $str";
        $mysql=new mysqli('localhost','root','','ktv',3306);
        $mysql->query('set names utf8');
        $mysql->query($sql);
        /*$data=$mysql->query("insert into shop (sname,description,price,thumb,hot,capticy,type) VALUES ('{$sname}','{$description}','{$price}','{$thumb}','{$hot}','{$capticy}','{$type}')");*/
        if($mysql->affected_rows){
            echo 'ok';
            exit();
        }else {
            echo 'error';
        }
    }
    function show(){
        $mysql=new mysqli('localhost','root','','ktv',3306);
        $mysql->query('set names utf8');
        $data=$mysql->query("select * from shop")->fetch_all(MYSQLI_ASSOC);
        echo json_encode($data);
    }
    function delete(){
        $ids=$_GET['id'];
        $mysql=new mysqli('localhost','root','','ktv',3306);
        $mysql->query('set names utf8');
        $data=$mysql->query("delete from shop where sid=$ids");
        if($mysql->affected_rows){
            echo 'ok';
            exit;
        }
        echo 'error';
    }
    function update(){
        $value=$_GET['value'];
        $type=$_GET['type'];
        $id=$_GET['id'];
        /*$mysql=new mysqli('localhost','root','','ktv',3306);
        $mysql->query('set names utf8');*/
        $data=$this->db->query("update shop set $type='{$value}' where sid=$id")->fetch_all(MYSQLI_ASSOC);
        if($this->db->affected_rows){
            echo 'ok';
            exit;
        }
        echo 'error';
    }
    function upload(){
        $_FILES['file'];
        if(is_uploaded_file($_FILES['file']['tmp_name'])){
            if(!file_exists('Public/upload')){
                mkdir('Public/upload');
            }
            $data=date('y-m-d');
            if(!file_exists('Public/upload/'.$data)){
                mkdir('Public/upload/'.$data);
            }
            $path='Public/upload/'.$data.'/'.$_FILES['file']['name'];
            if(move_uploaded_file($_FILES['file']['tmp_name'],$path)){
                echo '/php/ktv/'.$path;
            }
        }
    }
}