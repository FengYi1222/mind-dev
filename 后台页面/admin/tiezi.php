<?php

require_once '../functions.php';

xiu_get_current_user();

// 接收筛选参数
// ==================================

    $where = '1 = 1';
    $search = '';

    // 分类筛选

    if (isset($_GET['status']) && $_GET['status'] !== 'all') {
      $where .= " and tiezi.status = '{$_GET['status']}'";
      $search .= '&status=' . $_GET['status'];
    }

    // $where => "1 = 1 and tiezi.category_id = 1 and tiezi.status = 'published'"
    // $search => "&category=1&status=published"

    // 处理分页参数
    // =========================================

    $size = 5;
    $page = empty($_GET['page']) ? 1 : (int)$_GET['page'];
    // 必须 >= 1 && <= 总页数

    // $page = $page < 1 ? 1 : $page;
    if ($page < 1) {
      // 跳转到第一页
      header('Location: /后台页面/admin/tiezi.php?page=1' . $search);
    }

    // 只要是处理分页功能一定会用到最大的页码数
    $total_count = (int)xiu_fetch_one("select count(1) as count from tiezi
    inner join users on tiezi.user_id = users.id
    where {$where};")['count'];
    $total_pages = (int)ceil($total_count / $size);

    // $page = $page > $total_pages ? $total_pages : $page;
    if ($page > $total_pages) {
      // 跳转到第最后页
      header('Location: /后台页面/admin/tiezi.php?page=' . $total_pages . $search);
    }

    // 获取全部数据
    // ===================================

    // 计算出越过多少条
    $offset = ($page - 1) * $size;

    $posts = xiu_fetch_all("select
      tiezi.id,
      tiezi.title,
      tiezi.autor,
      tiezi.created,
      tiezi.status
    from tiezi
    inner join users on tiezi.user_id = users.id
    where {$where}
    order by tiezi.created desc
    limit {$offset}, {$size};");

    // 查询全部的分类数据
    // $categories = xiu_fetch_all('select * from categories;');

    // 处理分页页码
    // ===============================

    $visiables = 5;

    // 计算最大和最小展示的页码
    $begin = $page - ($visiables - 1) / 2;
    $end = $begin + $visiables - 1;

    // 重点考虑合理性的问题
    // begin > 0  end <= total_pages
    $begin = $begin < 1 ? 1 : $begin; // 确保了 begin 不会小于 1
    $end = $begin + $visiables - 1; // 因为 50 行可能导致 begin 变化，这里同步两者关系
    $end = $end > $total_pages ? $total_pages : $end; // 确保了 end 不会大于 total_pages
    $begin = $end - $visiables + 1; // 因为 52 可能改变了 end，也就有可能打破 begin 和 end 的关系
    $begin = $begin < 1 ? 1 : $begin; // 确保不能小于 1

    // 处理数据格式转换
    // ===========================================

    /**
     * 转换状态显示
     * @param  string $status 英文状态
     * @return string         中文状态
     */
    function convert_status ($status) {
      $dict = array(
        'published' => '发布',
        'drafted' => '待审核',
      );
      return isset($dict[$status]) ? $dict[$status] : '未知';
    }

    /**
     * 转换时间格式
     * @param  [type] $created [description]
     * @return [type]          [description]
     */
    function convert_date ($created) {
      // => '2017-07-01 08:08:00'
      // 如果配置文件没有配置时区
      // date_default_timezone_set('PRC');
      $timestamp = strtotime($created);
      return date('Y年m月d日<b\r>H:i:s', $timestamp);
    }


?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
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
        <h1>所有帖子</h1>
        <!-- <a href="post-add.html" class="btn btn-primary btn-xs">写文章</a> -->
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <form class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <select name="status" class="form-control input-sm">
            <option value="all">所有状态</option>
            <option value="drafted"<?php echo isset($_GET['status']) && $_GET['status'] == 'drafted' ? ' selected' : '' ?>>待审核</option>
            <option value="published"<?php echo isset($_GET['status']) && $_GET['status'] == 'published' ? ' selected' : '' ?>>发布</option>
          </select>
          <button class="btn btn-default btn-sm">筛选</button>
        </form>
        <ul class="pagination pagination-sm pull-right">
          <li><a href="#">上一页</a></li>
          <?php for ($i = $begin; $i <= $end; $i++): ?>
          <li<?php echo $i === $page ? ' class="active"' : '' ?>><a href="?page=<?php echo $i . $search; ?>"><?php echo $i; ?></a></li>
          <?php endfor ?>
          <li><a href="#">下一页</a></li>
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($posts as $item): ?>
          <tr id="shuaxin" data-id='<?php echo $item["id"] ?>'>
            <td class="text-center"><input type="checkbox"></td>
            <td><?php echo $item['title']; ?></td>
            <!-- <td><?php // echo get_user($item['user_id']); ?></td>
            <td><?php // echo get_category($item['category_id']); ?></td> -->
            <td><?php echo $item['autor']; ?></td>
            <td class="text-center"><?php echo convert_date($item['created']); ?></td>
            <!-- 一旦当输出的判断或者转换逻辑过于复杂，不建议直接写在混编位置 -->
            <td class="text-center zhuangtai"><?php echo convert_status($item['status']); ?></td>
            <td class="text-center anniu">
              <?php if ($item['status'] == 'published'): ?> 
              <a href="javascript:;" class="btn btn-warning btn-xs"><span>待定</span></a>
              <?php else: ?>
              <a href="javascript:;" class="btn btn-info btn-xs"><span>通过</span></a>
              <?php endif; ?>
              <a href="/后台页面/admin/tiezi-delete.php?id=<?php echo $item['id']; ?>" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>

  <?php $current_page = 'tiezi'; ?>
  <?php include 'inc/sidebar.php'; ?>

  <script src="/后台页面/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/后台页面/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
  <script>



    // 更改状态
       $('tbody').on('click','.btn-warning',function () {
       // 删除单条数据
       // 1.拿到数据
      var $tr = $(this).parent().parent()
      var id = $tr.data('id')
       // 2. 发送AJAX请求
      $.get('/后台页面/admin/api/tiezi-update.php', { id: id }, function(res){
        if(!res) return
        $tr.find("td.zhuangtai").html(res.val1)        
        $tr.find("td.anniu a:first-child").html(res.val2).addClass("btn-info").removeClass("btn-warning")   
       })
    })

    $('tbody').on('click','.btn-info',function () {
       // 删除单条数据
       // 1.拿到数据
      var $tr = $(this).parent().parent()
      var id = $tr.data('id')
       // 2. 发送AJAX请求
      $.get('/后台页面/admin/api/tiezi-update.php', { id: id }, function(res){
        if(!res) return
        $tr.find("td.zhuangtai").html(res.val1)   
        $tr.find("td.anniu a:first-child").html(res.val2).addClass("btn-warning") .removeClass("btn-info")       
       })
    })
  </script>
</body>
</html>
