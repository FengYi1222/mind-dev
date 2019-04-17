<?php

require_once '../functions.php';


$current_user = xiu_get_current_user();

 $GLOBALS['userid'] =  $current_user['id'];

 $current_edit_users = xiu_fetch_one('select * from users where id = ' . $GLOBALS['userid']);

function edit_users () {
  global $current_edit_users;

  // 接收并保存
  $id = $current_edit_users['id'];

  $avatar = $_POST["avatar"];
  $nick = $_POST['nickname'];
  // var_dump($urla);
  // var_dump($nick);


  $nickname = empty($_POST['nickname']) ? $current_edit_users['nickname'] : $_POST['nickname'];
  // 同步数据
  $current_edit_users['nickname'] = $nickname;
  $content = empty($_POST['content']) ? $current_edit_users['content'] : $_POST['content'];
  $current_edit_users['content'] = $content;

  $password = empty($_POST['password']) ? $current_edit_users['password'] : $_POST['password'];
  $current_edit_users['password'] = $password;

  $avatar = empty($_POST['avatar']) ? $current_edit_users['avatar'] : $_POST['avatar'];
  $current_edit_users['avatar'] = $avatar;

  if($_POST['password'] !== $_POST['password1']) {
    $GLOBALS['message'] = '密码出错';
    return;
  }


  $rows = xiu_execute("update users set content = '{$content}', nickname = '{$nickname}', password='{$password}', avatar = '{$avatar}' where id = {$id}");

  $GLOBALS['success'] = $rows > 0;
  $GLOBALS['message'] = $rows <= 0 ? '更新失败！' : '更新成功！';
}

  // echo $current_edit_users['email']; 
  // echo $current_edit_users['avatar']; 

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    edit_users(); 
  }


// 查询全部的分类数据
$users = xiu_fetch_all('select * from users;');




?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
  <link rel="stylesheet" href="/后台页面/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/后台页面/static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="/后台页面/static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="/后台页面/static/assets/css/admin.css">
  <script src="/后台页面/static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include 'inc/navbar.php'; ?>

    <div class="container-fluid">
      <div class="page-title">
        <h1>我的个人资料</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <?php if (isset($message)): ?>
      <?php if (isset($success)): ?>
      <div class="alert alert-success">
        <strong>成功！</strong> <?php echo $success; ?>
      </div>
      <?php else: ?>
      <div class="alert alert-danger">
        <strong>错误！</strong> <?php echo $message; ?>
      </div>
      <?php endif ?>
      <?php endif ?>
      <?php if (isset($current_edit_users)): ?>
      <form class="form-horizontal"  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label class="col-sm-3 control-label">头像</label>
          <div class="col-sm-6">
            <label class="form-image">
              <input id="avatar" type="file">
              <img src="<?php echo $current_edit_users['avatar']; ?>">
              <input type="hidden" name="avatar">
              <i class="mask fa fa-upload"></i>
            </label>
          </div>
        </div>
        <div class="form-group">
          <label for="email" class="col-sm-3 control-label">邮箱</label>
          <div class="col-sm-6">
            <input id="email" class="form-control" name="email" type="type" value="<?php echo $current_edit_users['email']; ?>" placeholder="邮箱" readonly>
            <p class="help-block">登录邮箱不允许修改</p>
          </div>
        </div>
        <div class="form-group">
          <label for="password" class="col-sm-3 control-label">原密码</label>
          <div class="col-sm-6">
            <input type="password" id="password" class="form-control" name="password" type="type" value="<?php echo $current_edit_users['password']; ?>" placeholder="邮箱" >
            <!-- <p class="help-block">登录邮箱不允许修改</p> -->
          </div>
        </div>

        <div class="form-group">
          <label for="password1" class="col-sm-3 control-label">确认密码</label>
          <div class="col-sm-6">
            <input type="password" id="password1" class="form-control" name="password1" type="type" value="<?php echo $current_edit_users['password']; ?>" placeholder="邮箱" >
            <!-- <p class="help-block">登录邮箱不允许修改</p> -->
          </div>
        </div>

        <div class="form-group">
          <label for="nickname" class="col-sm-3 control-label">昵称</label>
          <div class="col-sm-6">
            <input id="nickname" class="form-control" name="nickname" type="type" value="<?php echo $current_edit_users['nickname']; ?>" placeholder="<?php echo $current_edit_users['nickname']; ?>">
            <p class="help-block">限制在 2-16 个字符</p>
          </div>
        </div>
        <div class="form-group">
          <label for="content" class="col-sm-3 control-label">简介</label>
          <div class="col-sm-6">
            <textarea id="content" name="content"class="form-control" placeholder="<?php echo $current_edit_users['content']; ?>" cols="30" rows="6"></textarea>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-6">
            <button id="fasong" type="submit" class="btn btn-primary">更新</button>
            <!-- <a class="btn btn-link" href="password-reset.html">修改密码</a> -->
          </div>
        </div>
      </form>
    <?php endif; ?>
    </div>
  </div>

  <?php $current_page = 'profile'; ?>
  <?php include 'inc/sidebar.php'; ?>

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
