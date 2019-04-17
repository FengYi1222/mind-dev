<?php

require_once '../functions.php';

xiu_get_current_user();

function add_images () {

  if(isset($_FILES['url'])) {
      // var_dump($_FILES['url']);
  }
  if (empty($_POST['title']) || empty($_POST['src']) || empty($_FILES['url'])) {
    $GLOBALS['message'] = '请完整填写表单！';
    $GLOBALS['success'] = '退出';

    return;
  }
  // 接收并保存
  $title = $_POST['title'];
  $src = $_POST['src'];
  // $idTime = time();
  $id = (int)time();
  // 文件的保存
  $urla = $_FILES['url'];
  // var_dump($urla['error']);

  if ($urla['error'] !== 0){
    $GLOBALS['message'] = 'nicuola';

    return;
  }
  // 校验文件类型大小
  // echo $title;
   // $urla['error'];

  $ext = pathinfo($urla['name'], PATHINFO_EXTENSION);

  // 移动文件到网站范围之内
  $target = '../static/uploads/img-' . uniqid() . '.' . $ext;

  if(!move_uploaded_file($urla['tmp_name'], $target)) {
      var_dump($target);
  $GLOBALS['message'] = '上传成功';
  }
  // insert into images values (null, 'src', 'title');
  var_dump($id);
  var_dump($title);
  var_dump($src);
  $rows = xiu_execute("insert into images values ('{$id}', '{$title}', '${target}', '{$src}');");

  $GLOBALS['success'] = $rows > 0;
  $GLOBALS['message'] = $rows <= 0 ? '添加失败！' : '添加成功！';
  // header('Location: /后台页面/admin/zztupian.php');
}

function edit_images () {
  global $current_edit_images;

  // // 只有当时编辑并点保存
  // if (empty($_POST['title']) || empty($_POST['src'])) {
  //   $GLOBALS['message'] = '请完整填写表单！';
  //   $GLOBALS['success'] = false;
  //   return;
  // }

  // 接收并保存
  $id = $current_edit_images['id'];

  $title = empty($_POST['title']) ? $current_edit_images['title'] : $_POST['title'];
  // 同步数据
  $current_edit_images['title'] = $title;
  $src = empty($_POST['src']) ? $current_edit_images['src'] : $_POST['src'];
  $current_edit_images['src'] = $src;

  // insert into images values (null, 'src', 'title');
  $rows = xiu_execute("update images set src = '{$src}', title = '{$title}' where id = {$id}");

  $GLOBALS['success'] = $rows > 0;
  $GLOBALS['message'] = $rows <= 0 ? '更新失败！' : '更新成功！';
}

// 判断是否为需要编辑的数据
// ====================================
// 判断是编辑主线还是添加主线

if (empty($_GET['id'])) {
  // 添加
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    add_images();
  }
} else {
  // 编辑
  // 客户端通过 URL 传递了一个 ID
  // => 客户端是要来拿一个修改数据的表单
  // => 需要拿到用户想要修改的数据
  $current_edit_images = xiu_fetch_one('select * from images where id = ' . $_GET['id']);
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    edit_images();
  }
}



// 查询全部的分类数据
$images = xiu_fetch_all('select * from images;');




?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>images &laquo; Admin</title>
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
        <h1>图片列表</h1>
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
      <div class="row">
        <div class="col-md-4">
          <?php if (isset($current_edit_images)): ?>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $current_edit_images['id']; ?>" method="post" enctype="multipart/form-data">
            <h2>编辑《<?php echo $current_edit_images['title']; ?>》</h2>
            <div class="form-group">
              <label for="url">图片</label>
              <!-- show when url chose -->
              <img class="help-block thumbnail" style="display: none">
              <input id="url" class="form-control" name="url" type="file">
            </div>
            <div class="form-group">
              <label for="title">图片名</label>
              <input id="title" class="form-control" name="title" type="text" placeholder="图片名称" value="<?php echo $current_edit_images['title']; ?>">
            </div>
            <div class="form-group">
              <label for="src">链接地址</label>
              <input id="src" class="form-control" name="src" type="text" placeholder="链接地址" value="<?php echo $current_edit_images['src']; ?>">
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit">保存</button>
            </div>
          </form>
          <?php else: ?>


          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"  enctype="multipart/form-data">
            <h2>添加新图片</h2>
            <div class="form-group">
              <label for="url">图片</label>
              <!-- show when url chose -->
              <img class="help-block thumbnail" style="display: none">
              <input id="url" class="form-control" name="url" type="file">
            </div>
            <div class="form-group">
              <label for="title">图片名</label>
              <input id="title" class="form-control" name="title" type="text" placeholder="图片名称">
            </div>
            <div class="form-group">
              <label for="src">链接地址</label>
              <input id="src" class="form-control" name="src" type="text" placeholder="链接地址">
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit">添加</button>
            </div>
          </form>
          <?php endif ?>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a id="btn_delete" class="btn btn-danger btn-sm" href="/后台页面/admin/slides-delete.php" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>图片预览</th>
                <th>图片名</th>
                <th>链接的地址</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($images as $item): ?>
              <tr>
                <td class="text-center"><input type="checkbox" data-id="<?php echo $item['id']; ?>"></td>
                <td><img src="<?php echo $item['src']; ?>" alt=""></td>
                <td><?php echo $item['title']; ?></td>
                <td><?php echo $item['link']; ?></td>
                <td class="text-center">
                  <a href="/后台页面/admin/slides.php?id=<?php echo $item['id']; ?>" class="btn btn-info btn-xs">编辑</a>
                  <a href="/后台页面/admin/slides-delete.php?id=<?php echo $item['id']; ?>" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php $current_page = 'slides'; ?>
  <?php include 'inc/sidebar.php'; ?>

  <script src="/后台页面/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/后台页面/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>
    // 1. 不要重复使用无意义的选择操作，应该采用变量去本地化
    $(function ($) {
      // 在表格中的任意一个 checkbox 选中状态变化时
      var $tbodyCheckboxs = $('tbody input')
      var $btnDelete = $('#btn_delete')

      // 定义一个数组记录被选中的
      var allCheckeds = []
      $tbodyCheckboxs.on('change', function () {

        var id = $(this).data('id')

        // 根据有没有选中当前这个 checkbox 决定是添加还是移除
        if ($(this).prop('checked')) {
          // allCheckeds.indexOf(id) === -1 || allCheckeds.push(id)
          allCheckeds.includes(id) || allCheckeds.push(id)
        } else {
          allCheckeds.splice(allCheckeds.indexOf(id), 1)
        }

        // 根据剩下多少选中的 checkbox 决定是否显示删除
        allCheckeds.length ? $btnDelete.fadeIn() : $btnDelete.fadeOut()
        $btnDelete.prop('search', '?id=' + allCheckeds)
      })

      // 找一个合适的时机 做一件合适的事情
 
      $('thead input').on('change', function () {
        var checked = $(this).prop('checked')
        $tbodyCheckboxs.prop('checked', checked).trigger('change')
      })

     
    })
  </script>
  <script>NProgress.done()</script>
</body>
</html>
