<?php
  header('Access-Control-Allow-Origin:*');
  // header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS');
  // 响应头设置    
  header('Access-Control-Allow-Headers:x-requested-with,content-type'); 
  if (strtolower($_SERVER['REQUEST_METHOD']) == 'options') {
    exit;
  }

  require('db_config.php');
  $con=mysql_connect($mysql_server_name,$mysql_username,$mysql_password) or die("error connecting") ; //连接数据库
  mysql_query("set names 'utf8'"); //数据库输出编码 
  mysql_select_db($mysql_database); //打开数据库

  // 添加快捷键
  if($_REQUEST['m'] == 'add'){
    $category_id = $_REQUEST['category_id'];
    $name = $_REQUEST['name'];
    $description = $_REQUEST['description'];
    $time = time();
    $sql = "insert into content (category_id,name,description,time) VALUES ('$category_id','$name','$description','$time')";
    if(!mysql_query($sql,$con)){
      echo json_encode(array('status'=>false,'msg'=>mysql_error()));
      exit;
    }
    echo json_encode(array('status'=>true));
  }

  // 修改快捷键
  if($_REQUEST['m'] == 'modify'){
    $category_id = $_REQUEST['category_id'];
    $name = $_REQUEST['name'];
    $description = $_REQUEST['description'];
    $sql = "update content set name='$name',description='$description' where category_id='$category_id'";
    if(!mysql_query($sql,$con)){
      echo json_encode(array('status'=>false,'msg'=>mysql_error()));
      exit;
    }
    echo json_encode(array('status'=>true));
  }

  // 删除快捷键
  if($_REQUEST['m'] == 'del'){
    $id = $_REQUEST['id'];
    $sql = "delete from content where id='$id'";
    if(!mysql_query($sql,$con)){
      echo json_encode(array('status'=>false,'msg'=>mysql_error()));
      exit;
    }
    echo json_encode(array('status'=>true));
  }

  // 查询快捷键列表
  if($_REQUEST['m'] == 'query'){
    $category_id = $_REQUEST['category_id'];
    $pageSize = $_REQUEST['pageSize'];
    $pageNo = $_REQUEST['pageNo'];
    $start = $pageNo*$pageSize;
    $sql = "select * from content where category_id='$category_id' limit $start,$pageSize";
    $result = mysql_query($sql,$con);
    $arr = array();
    while($row = mysql_fetch_assoc($result)){
      $arr[] = $row;
    }
    $sql = "select count(*) as total from content where category_id='$category_id'";
    $total = mysql_query($sql,$con);
    $total = intval(mysql_fetch_row($total)[0]);
    echo json_encode(array('status'=>true,'data'=>$arr,'total'=>$total));
  }

  // 查询分类列表
  if($_GET['m'] == 'cate_query'){
    $pageSize = $_REQUEST['pageSize'];
    $pageNo = $_REQUEST['pageNo'];
    $start = $pageNo * $pageSize;
    if ($pageSize) {
      $sql = "select * from category limit $start,$pageSize";
    } else {
      $sql = "select * from category";
    }
    
    $result = mysql_query($sql,$con);
    $arr = array();
    while($row = mysql_fetch_assoc($result)){
      $arr[] = $row;
    }
    $sql = "select count(*) as total from category";
    $total = mysql_query($sql,$con);
    $total = intval(mysql_fetch_row($total)[0]);
    echo json_encode(array('status'=>true,'data'=>$arr,'total'=>$total));
  }

  // 添加分类
  if($_REQUEST['m'] == 'cate_add'){
    $name = $_REQUEST['name'];
    $time = time();
    $sql = "insert into category (name,time) VALUES ('$name','$time')";
    if(!mysql_query($sql,$con)){
      echo json_encode(array('status'=>false,'msg'=>mysql_error()));
      exit;
    }
    echo json_encode(array('status'=>true));
  }

  // 修改分类
  if($_REQUEST['m'] == 'cate_modify'){
    $id = $_REQUEST['id'];
    $name = $_REQUEST['name'];
    $sql = "update category set name='$name' where id='$id'";
    if(!mysql_query($sql,$con)){
      echo json_encode(array('status'=>false,'msg'=>mysql_error()));
      exit;
    }
    echo json_encode(array('status'=>true));
  }

  // 删除分类
  if($_REQUEST['m'] == 'cate_del'){
    $id = $_REQUEST['id'];
    $sql = "select count(*) as total from content where category_id='$id'";
    $total = mysql_query($sql,$con);
    $total = intval(mysql_fetch_row($total)[0]);
    if($total > 0) {
      echo json_encode(array('status'=>false,'msg'=>'该分类下有关联快捷键，请先删除分类下所有快捷键再尝试'));
      exit;
    }
    $sql = "delete from category where id='$id'";
    if(!mysql_query($sql,$con)){
      echo json_encode(array('status'=>false,'msg'=>mysql_error()));
      exit;
    }
    echo json_encode(array('status'=>true));
  }

  mysql_close($con);
?>
