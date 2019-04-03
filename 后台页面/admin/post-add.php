<?php

require_once '../functions.php';
$current_user = xiu_get_current_user();

 $GLOBALS['userid'] =  $current_user['id'];
 $GLOBALS['username'] =  $current_user['nickname'];
 $GLOBALS['created'] = date('Y-m-d h:i:s', time());

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
  $created = $GLOBALS['created'];
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

function edit () {
    global $current_edit_category;

    // // 只有当时编辑并点保存
    // if (empty($_POST['name']) || empty($_POST['slug'])) {
    //   $GLOBALS['message'] = '请完整填写表单！';
    //   $GLOBALS['success'] = false;
    //   return;
    // }

    // 接收并保存
    $id = $current_edit_category['id'];
    $title = empty($_POST['title']) ? $current_edit_category['title'] : $_POST['title'];
    // 同步数据
    $current_edit_category['title'] = $title;


    $autor = empty($_POST['autor']) ? $current_edit_category['autor'] : $GLOBALS['username'];
    $current_edit_category['autor'] = $autor;


    $content = empty($_POST['content']) ? $current_edit_category['content'] : $_POST['content'];
    $current_edit_category['content'] = $content;


    $created = $GLOBALS['created'];
    $current_edit_category['created'] = $created;

    $category = empty($_POST['category']) ? $current_edit_category['category_id'] : $_POST['category'];
    $current_edit_category['category_id'] = $category;

    $status = empty($_POST['status']) ? $current_edit_category['status'] : $_POST['status'];

    // insert into categories values (null, 'slug', 'name');
    $rows = xiu_execute("update posts set title = '{$title}', autor = '{$autor}', content = '{$content}', created = '{$created}', category_id = {$category}, status = '{$status}' where id = {$id}");

    $GLOBALS['success'] = $rows > 0;
    $GLOBALS['message'] = $rows <= 0 ? '更新失败！' : '更新成功！';

    header('Location: /后台页面/admin/posts.php');
}


// 判断是否为需要编辑的数据
// ====================================
// 判断是编辑主线还是添加主线

if (empty($_GET['id'])) {
  // 添加
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    add();
  }
} else {
  // 编辑
  // 客户端通过 URL 传递了一个 ID
  // => 客户端是要来拿一个修改数据的表单
  // => 需要拿到用户想要修改的数据
  $current_edit_category = xiu_fetch_one('select * from posts where id = ' . $_GET['id']);
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo $current_edit_category['id'];
    edit();
  }
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
      <?php if (empty($current_edit_category)): ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <?php else: ?>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $current_edit_category['id']; ?>" method="post">
      <?php endif ?>
      
        <div class="col-md-9">
          <div class="form-group">

            <label for="title">标题</label>
            <input id="title" class="form-control input-lg" name="title" type="text" placeholder="<?php echo isset($current_edit_category) ? $current_edit_category['title'] : '文章标题'; ?>">
          </div>
          <div class="form-group">
            <label for="content">标题</label>
            <!-- <textarea id="content" class="form-control input-lg" name="content" cols="30" rows="10" placeholder="内容"></textarea> -->
            <script id="content" name="content" type="text/plain"><?php echo isset($current_edit_category)? $current_edit_category['content'] : ''; ?></script>
          </div>
        </div>
        <div class="col-md-3">        

           <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control" name="category">
              <option value="5"
               <?php if ($current_edit_category['category_id'] == '5') {
                echo 'selected="selected"';
              }; ?>>未分类</option>
              <option value="1"
              <?php if ($current_edit_category['category_id'] == 1) {
                echo 'selected="selected"';
              }; ?>>男女情感</option>
              <option value="2"
              <?php if ($current_edit_category['category_id'] == 2) {
                echo 'selected="selected"';
              }; ?>>人际交往</option>
              <option value="3"
              <?php if ($current_edit_category['category_id'] == 3) {
                echo 'selected="selected"';
              }; ?>>自我提升</option>
              <option value="4"
              <?php if ($current_edit_category['category_id'] == 4) {
                echo 'selected="selected"';
              }; ?>>生活幸福</option>
            </select>
          </div>

          <div class="form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control" name="status">
              <option value="drafted"
              <?php if ($current_edit_category['status'] == 'drafted') {
                echo 'selected="selected"';
              }; ?>>草稿</option>
              <option value="published"
              <?php if ($current_edit_category['status'] == 'published') {
                echo 'selected="selected"';
              }; ?>>已发布</option>
              <option value="trashed"
              <?php if ($current_edit_category['status'] == 'trashed') {
                echo 'selected="selected"';
              }; ?>>回收站</option>  
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
