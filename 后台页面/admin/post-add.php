<?php

require_once '../functions.php';
$current_user = xiu_get_current_user();

 $GLOBALS['userid'] =  $current_user['id'];
 $GLOBALS['username'] =  $current_user['nickname'];

function add () {
  //1. 接受并校验
  //2. 持久化
  //3. 响应
  if (empty($_POST['title'])) {
    $GLOBALS['message'] = '请输入文章标题  你看我在干啥';
    return;
  }
  // if (empty($_POST['autor'])) {
  //   $GLOBALS['message'] = '请输入作者名';
  //   return;
  // }
  if (empty($_POST['content'])) {
    $GLOBALS['message'] = '请填写文章内容';
    return;
  }
  // if (empty($_POST['created'])) {
  //   $GLOBALS['message'] = '请选择发布时间';
  //   return;
  // }
  if ($_POST['category'] === 1) {
    $GLOBALS['message'] = '请选择分类';
    return;
  }
  if (empty($_POST['status'])) {
    $GLOBALS['message'] = '请选择状态';
    return;
  }

  $title = $_POST['title'];
  $autor = $GLOBALS['username']; 
  $content = $_POST['content'];
  $created = date('Y-m-d h:i:s', time());
  $category = $_POST['category'];
  $status = $_POST['status'];
  $userid = $GLOBALS['userid'];

  // 当客户端提交过来的完整的表单信息就应该开始对其进行数据校验
  $conn = mysqli_connect(XIU_DB_HOST, XIU_DB_USER, XIU_DB_PASS, XIU_DB_NAME);
  if (!$conn) {
    $GLOBALS['message'] = '连接数据库失败';
    return;
  }


  $query = mysqli_query($conn, "insert into posts values (null, '{$title}', '{$autor}', '{$content}', '{$created}', {$category}, '{$status}', null, null, null, {$userid}, null);");

 if (!$query) {
    $GLOBALS['message'] = '查询过程失败';
    return;
  }

  $affected_rows = mysqli_affected_rows($conn);

  if ($affected_rows !== 1) {
    $GLOBALS['message'] = '添加数据失败';
    return;
  }
   header('Location: /后台页面/admin/posts.php');
}



  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "enene";
    add();
  }


?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Add new post &laquo; Admin</title>
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
        <h1>写文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="row" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="col-md-9">
          <div class="form-group">

            <label for="title">标题</label>
            <input id="title" class="form-control input-lg" name="title" type="text" placeholder="<?php echo isset($current_edit_category) ? $current_edit_category['title'] : '文章标题'; ?>">
          </div>
          <div class="form-group">
            <label for="content">标题</label>
            <!-- <textarea id="content" class="form-control input-lg" name="content" cols="30" rows="10" placeholder="内容"></textarea> -->
            <script id="content" name="content" type="text/plain"><?php echo isset($current_edit_category)? $current_edit_category['title'] : ''; ?></script>
          </div>
        </div>
        <div class="col-md-3">        

           <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control" name="category">
              <option value="5">未分类</option>
              <option value="1">男女情感</option>
              <option value="2">人际交往</option>
              <option value="3">自我提升</option>
              <option value="4">生活幸福</option>
            </select>
          </div>

          <div class="form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control" name="status">
              <option value="drafted">草稿</option>
              <option value="published">已发布</option>
              <option value="trashed">回收站</option>  
            </select>
          </div>
          <?php if (isset($message)): ?>
      <div class="alert alert-danger">
        <strong>错误！</strong> <?php echo $message; ?>
      </div>
      <?php endif ?>
          <div class="form-group">
            <button class="btn btn-primary" type="submit">保存</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php $current_page = 'post-add'; ?>
  <?php include 'inc/sidebar.php'; ?>

  <script src="/后台页面/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/后台页面/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="/后台页面/static/assets/vendors/ueditor/ueditor.config.js"></script>
  <script src="/后台页面/static/assets/vendors/ueditor/ueditor.all.js"></script>
  <script>
    UE.getEditor('content', {
      initialFrameHeight: 1320,
      autoHeight: false
    })
  </script>
  <script>NProgress.done()</script>
</body>
</html>
