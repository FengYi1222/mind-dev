<?php

require_once '../functions.php';

function add() {
  
  var_dump($_FILES['avatar']);

  if (empty($_POST['email'])) {
    $GLOBALS['message'] = '请填写邮箱  你看我在干啥';
    return;
  }
  if (empty($_POST['password'])) {
    $GLOBALS['message'] = '请填写密码';
    return;
  }
  if (empty($_POST['password1'])) {
    $GLOBALS['message'] = '请填写确认密码';
    return;
  }
  if ($_POST['password'] !== $_POST['password1'] ) {
    $GLOBALS['message'] = '密码与确认密码不一致';
    return;
  }
  if (empty($_POST['nickname'])) {
    $GLOBALS['message'] = '请输入昵称';
    return;
  }
  if (empty($_POST['jianjie'])) {
    $GLOBALS['message'] = '请输入简介';
    return;
  }


  $email = $_POST['email'];
  $password = $_POST['password'];
  $nickname = $_POST['nickname'];
  $jianjie = $_POST['jianjie'];


      $urla = $_FILES['avatar'];
      var_dump($urla['error']);
      if ($urla['error'] !== 0){
        $GLOBALS['message'] = 'nicuola';
        echo $urla['error'];
        return;
      }
      // 校验文件类型大小
      $ext = pathinfo($urla['name'], PATHINFO_EXTENSION);
      // 移动文件到网站范围之内
      $target = '../static/uploads/img-' . uniqid() . '.' . $ext;
      if(!move_uploaded_file($urla['tmp_name'], $target)) {
      $GLOBALS['message'] = '上传成功';
      }


  // 当客户端提交过来的完整的表单信息就应该开始对其进行数据校验
  $conn = mysqli_connect(XIU_DB_HOST, XIU_DB_USER, XIU_DB_PASS, XIU_DB_NAME);
  if (!$conn) {
    exit('<h1>连接数据库失败</h1>');
  }

  $query = xiu_execute("insert into users (email,password,nickname,jianjie,avatar,power) values ('{$email}','{$password}','{$nickname}','{$jianjie}','{$target}','no');");

      header('Location: /前台页面/admin/登录页面.php');
}

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      add(); 

  }


?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
  <link rel="stylesheet" href="/前台页面/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/前台页面/static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="/前台页面/static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="/前台页面/static/assets/css/admin.css">
  <script src="/前台页面/static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php if (isset($message)): ?>
    <?php echo $message;?>
    <?php endif;?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>用户注册</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <form class="form-horizontal"  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label class="col-sm-3 control-label">头像</label>
          <div class="col-sm-6">
            <label class="form-image">
              <input id="avatar" type="file" name="avatar">
              <img src="">
              <input type="hidden" name="avatar">
              <i class="mask fa fa-upload"></i>
            </label>
          </div>
        </div>
        <div class="form-group">
          <label for="email" class="col-sm-3 control-label">邮箱</label>
          <div class="col-sm-6">
            <input id="email" class="form-control" name="email" type="type" value="" placeholder="邮箱">
          </div>
        </div>
        <div class="form-group">
          <label for="password" class="col-sm-3 control-label">密码设置</label>
          <div class="col-sm-6">
            <input type="password" id="password" class="form-control" name="password" type="type" value="" placeholder="密码" >
            <!-- <p class="help-block">登录邮箱不允许修改</p> -->
          </div>
        </div>

        <div class="form-group">
          <label for="password1" class="col-sm-3 control-label">确认密码</label>
          <div class="col-sm-6">
            <input type="password" id="password1" class="form-control" name="password1" type="type" value="" placeholder="确认密码" >
            <!-- <p class="help-block">登录邮箱不允许修改</p> -->
          </div>
        </div>

        <div class="form-group">
          <label for="nickname" class="col-sm-3 control-label">昵称</label>
          <div class="col-sm-6">
            <input id="nickname" class="form-control" name="nickname" type="type" value="" placeholder="">
            <p class="help-block">限制在 2-16 个字符</p>
          </div>
        </div>
        <div class="form-group">
          <label for="jianjie" class="col-sm-3 control-label">简介</label>
          <div class="col-sm-6">
            <textarea id="jianjie" name="jianjie"class="form-control" placeholder="" cols="30" rows="6"></textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-6">
            <button id="fasong" type="submit" class="btn btn-primary">注册</button>
            <!-- <a class="btn btn-link" href="password-reset.html">修改密码</a> -->
          </div>
        </div>
      </form>
</div>
  </div>


  <script src="/后台页面/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/后台页面/static/assets/vendors/bootstrap/js/bootstrap.js"></script>


  <script>
    
    $('#avatar').on('change', function(){
      // 当文件选择状态发生变化会执行这个事件处理函数
      // 判断是否选中了文件

      var $this = $(this)

      var files = $this.prop('files')
      if(!files.length) return

      var file = files[0]

      var data = new FormData()
      data.append('avatar', file)

      var xhr = new XMLHttpRequest()
      xhr.open('POST', '/后台页面/admin/api/upload.php')
      xhr.send(data)

      xhr.onload = function () {
        // console.log(this.responseText)
        console.log('hahahha')
        console.log(this.responseText)
        $this.siblings('img').attr('src', this.responseText)
        $this.siblings('input').val(this.responseText)
      }


    })


      // $('#fasong').on('click',function(){
      //     $.post("/后台页面/admin/inc/sidebar.php",{ nickname: "<?//php echo $current_edit_users['nickname']; ?>"}, function(res){
      //           return;
      //     })
      // })

  </script>


  <script>NProgress.done()</script>
</body>
</html>
