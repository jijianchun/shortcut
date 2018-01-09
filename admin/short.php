<?php
  header('Access-Control-Allow-Origin:*');

  require('db_config.php');
  $con=mysql_connect($mysql_server_name,$mysql_username,$mysql_password) or die("error connecting") ; //连接数据库
  mysql_query("set names 'utf8'"); //数据库输出编码 
  mysql_select_db($mysql_database); //打开数据库

  // 添加快捷键
  if($_POST['m'] == 'add'){
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $sql = "insert into content (category_id,name,description) VALUES ('$category_id','$name','$description')";
    if(!mysql_query($sql,$con)){
      echo json_encode(array('status'=>'false','msg'=>mysql_error()));
      exit;
    }
    echo json_encode(array('status'=>true));
  }

  // 查询快捷键列表
  if($_POST['m'] == 'query'){
    $category_id = $_POST['category_id'];
    $sql = "select * from content where category_id='$category_id'";
    $result = mysql_query($sql,$con);
    $arr = array();
    while($row = mysql_fetch_assoc($result)){
      $arr[] = $row;
    }
    echo json_encode(array('status'=>true,'data'=>$arr));
  }

  // 查询快捷键分类列表
  if($_GET['m'] == 'cate_query'){
    $sql = "select * from category";
    $result = mysql_query($sql,$con);
    $arr = array();
    while($row = mysql_fetch_assoc($result)){
      $arr[] = $row;
    }
    echo json_encode(array('status'=>true,'data'=>$arr));
  }

  mysql_close($con);
?>
