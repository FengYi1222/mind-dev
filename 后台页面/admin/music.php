<?php

require_once '../functions.php';

xiu_get_current_user();

function add_music () {

  var_dump($_FILES['url']);
  if (empty($_POST['name']) || empty($_POST['autor']) || empty($_FILES['url']) || empty($_POST['categories'])) {
    $GLOBALS['message'] = '请完整填写表单！';
    $GLOBALS['success'] = '退出';
    return;
  }
  // 接收并保存
  $name = $_POST['name'];
  $autor = $_POST['autor'];
  $categories = $_POST['categories'];
  // $idTime = time();
  $id = (int)time();
  // 文件的保存
  $urla = $_FILES['url'];
  var_dump($urla['error']);
  if ($urla['error'] !== 0){
    $GLOBALS['message'] = 'nicuola';
    return;
  }
  // 校验文件类型大小
  $ext = pathinfo($urla['name'], PATHINFO_EXTENSION);
  // 移动文件到网站范围之内
  $target = '../../static/uploads/img-' . uniqid() . '.' . $ext;
  if(!move_uploaded_file($urla['tmp_name'], $target)) {
  $GLOBALS['message'] = '上传成功';
  }

  // insert into music values (null, 'autor', 'name');
  $rows = xiu_execute("insert into music values ('{$id}', '{$name}', '{$autor}', '{$categories}', '{$target}');");

  $GLOBALS['success'] = $rows > 0;
  $GLOBALS['message'] = $rows <= 0 ? '添加失败！' : '添加成功！';
  header('Location: /后台页面/admin/zhongzhuan.php');
}

function edit_music () {
  global $current_edit_music;

  // // 只有当时编辑并点保存
  // if (empty($_POST['name']) || empty($_POST['autor'])) {
  //   $GLOBALS['message'] = '请完整填写表单！';
  //   $GLOBALS['success'] = false;
  //   return;
  // }

  // 接收并保存
  $id = $current_edit_music['id'];

  $name = empty($_POST['name']) ? $current_edit_music['name'] : $_POST['name'];
  // 同步数据
  $current_edit_music['name'] = $name;
  $autor = empty($_POST['autor']) ? $current_edit_music['autor'] : $_POST['autor'];
  $current_edit_music['autor'] = $autor;

   $categories = empty($_POST['categories']) ? $current_edit_music['categories'] : $_POST['categories'];
  $current_edit_music['categories'] = $categories;

  // insert into music values (null, 'autor', 'name');
  $rows = xiu_execute("update music set autor = '{$autor}', categories = '{$categories}', name = '{$name}' where id = {$id}");

  $GLOBALS['success'] = $rows > 0;
  $GLOBALS['message'] = $rows <= 0 ? '更新失败！' : '更新成功！';
}

// 判断是否为需要编辑的数据
// ====================================
// 判断是编辑主线还是添加主线

if (empty($_GET['id'])) {
  // 添加
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    add_music();
  }
} else {
  // 编辑
  // 客户端通过 URL 传递了一个 ID
  // => 客户端是要来拿一个修改数据的表单
  // => 需要拿到用户想要修改的数据
  $current_edit_music = xiu_fetch_one('select * from music where id = ' . $_GET['id']);
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    edit_music();
  }
}



// 查询全部的分类数据
$music = xiu_fetch_all('select * from music;');


?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>music &laquo; Admin</title>
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
        <h1>音乐列表</h1>
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
          <?php if (isset($current_edit_music)): ?>
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $current_edit_music['id']; ?>" method="post" enctype="multipart/form-data">
            <h2>编辑《<?php echo $current_edit_music['name']; ?>》</h2>
            <div class="form-group">
              <label for="url">音乐</label>
              <!-- show when url chose -->
              <img class="help-block thumbnail" style="display: none">
              <input id="url" class="form-control" name="url" type="file">
            </div>
            <div class="form-group">
              <label for="name">音乐名</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="音乐名称" value="<?php echo $current_edit_music['name']; ?>">
            </div>
            <div class="form-group">
              <label for="autor">歌手</label>
              <input id="autor" class="form-control" name="autor" type="text" placeholder="歌手" value="<?php echo $current_edit_music['autor']; ?>">
            </div>
            <div class="form-group">
               <label for="categories">所属分类</label>
              <select id="categories" class="form-control" name="categories">
                <option value="3"<?php if (isset($current_edit_music['categories']) && $current_edit_music['categories'] == 3) {
                echo ' selected="selected"';
              }; ?>>未分类</option>
                <option value="1"<?php if (isset($current_edit_music['categories']) && $current_edit_music['categories'] == 1) {
                echo ' selected="selected"';
              }; ?>>静谧</option>
                <option value="2"<?php if (isset($current_edit_music['categories']) && $current_edit_music['categories'] == 2) {
                echo ' selected="selected"';
              }; ?>>热血</option>
              </select>
            </div>
            <div class="form-group">
              <button class="btn btn-primary" type="submit">保存</button>
            </div>
          </form>
          <?php else: ?>


          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"  enctype="multipart/form-data">
            <h2>添加新音乐</h2>
            <div class="form-group">
              <label for="url">音乐</label>
              <!-- show when url chose -->
              <img class="help-block thumbnail" style="display: none">
              <input id="url" class="form-control" name="url" type="file">
            </div>
            <div class="form-group">
              <label for="name">音乐名</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="音乐名称">
            </div>
            <div class="form-group">
              <label for="autor">歌手</label>
              <input id="autor" class="form-control" name="autor" type="text" placeholder="歌手">
            </div>
            <div class="form-group">
               <label for="categories">所属分类</label>
              <select id="categories" class="form-control" name="categories">
                <option value="3">未分类</option>
                <option value="1">静谧</option>
                <option value="2">热血</option>
              </select>
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
            <a id="btn_delete" class="btn btn-danger btn-sm" href="/后台页面/admin/music-delete.php" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>音乐名</th>
                <th>歌手</th>
                <th>分类</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($music as $item): ?>
              <tr>
                <td class="text-center"><input type="checkbox" data-id="<?php echo $item['id']; ?>"></td>
                <td><?php echo $item['name']; ?></td>
                <td><?php echo $item['autor']; ?></td>
                <td><?php if($item['categories'] == 1) {echo '静谧';} elseif ($item['categories'] == 2) {echo '热血';} else {echo '未知';}  ?></td>
                <td class="text-center">
                  <a href="/后台页面/admin/music.php?id=<?php echo $item['id']; ?>" class="btn btn-info btn-xs">编辑</a>
                  <a href="/后台页面/admin/music-delete.php?id=<?php echo $item['id']; ?>" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php $current_page = 'music'; ?>
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
