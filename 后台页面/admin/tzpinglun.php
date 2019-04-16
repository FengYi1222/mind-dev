
<?php

require_once '../functions.php';

xiu_get_current_user();

?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>tzpinlgun &laquo; Admin</title>
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
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" style="display: none">
          <button class="btn btn-info btn-sm">批量批准</button>
          <button class="btn btn-warning btn-sm">批量拒绝</button>
          <button class="btn btn-danger btn-sm">批量删除</button>
        </div>
        <ul class="pagination pagination-sm pull-right">
         
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>回复对象</th>
            <th>评论内容</th>
            <th>评论帖子</th>
            <th>评论时间</th>
            <th class="text-center" width="140">操作</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>

  <?php $current_page = 'tzpinglun'; ?>
  <?php include 'inc/sidebar.php'; ?>

<div id="loading" style="display: none;">
    <div class="flip-txt-loading">
      <span>L</span><span>o</span><span>a</span>
      <span>d</span><span>i</span><span>n</span>
      <span>g</span>
    </div>
  </div>

  <script id="tzpinglun_tmpl" type="text/x-jsrender">
      {{for tzpinglun}}
      {{!--<tr><td>{{:#index}}</td><td>{{:autor}}</td></tr>--}}
      <tr {{if status == 'held'}} class="warning" {{else status =='rejected'}} class="danger"  {{/if}}  data-id="{{:id}}" >
            <td class="text-center"><input type="checkbox"></td>
            <td>{{:user_id}}</td>
            <td>{{:content}}</td>
            <td>{{:tiezi_id}}</td>
            <td>{{:created}}</td>
            <td class="text-center">
            {{if status == 'held'}}
               <a href="post-add.html" class="btn btn-info btn-xs">批准</a>
              <a href="post-add.html" class="btn btn-warning btn-xs">拒绝</a>
              {{/if}}
              <a href="/后台页面/admin/tzpinglun-delete.php?id={{:id}}" class="btn btn-danger btn-xs btn-delete">删除</a>
            </td>
          </tr>

      {{/for}}
  </script>
  <script src="/后台页面/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/后台页面/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="/后台页面/static/assets/vendors/jsrender/jsrender.js"></script>
  <script src="/后台页面/static/assets/vendors/twbs-pagination/jquery.twbsPagination.js"></script>
  <script>
    // nprogress
    $(document)
      .ajaxStart(function () {
        NProgress.start()
        $('#loading').fadeIn()
        // $('#loading').css('display','flex')

      })
      .ajaxStop(function () {
         NProgress.done()
         $('#loading').fadeOut()
        // $('#loading').css('display','none')
       })


    var currentPage = 1

    // 发送 AJAX 请求获取列表数据
    function loadPageData (page) {
      $.get('/后台页面/admin/api/tzpinglun.php',{ page: page },function(res) {
                  console.log (res)
        if(page > res.total_pages) {
          loadPageData(res.total_pages )
          return false
        }
        // 第一次回调时没有初始化分页组件
        // 第二次调用这个组件不会重新渲染分页组件
        $('.pagination').twbsPagination('destroy')
        $('.pagination').twbsPagination({
          first: '开始',
          last: '末尾',
          prev: '&lt;',
          next: '&gt;',
          startPage: page,
          totalPages: res.total_pages,
          visiablePages: 5,
          initiateStartPageClick: false,
          onPageClick: function (e, page) {
            loadPageData(page)
          }
        })
        // 渲染数据
        var html = $('#tzpinglun_tmpl').render({ tzpinglun: res.tzpinglun })
        $('tbody').fadeOut(function(){
          console.log("enen")
          $(this).fadeIn().html(html)
          currentPage = page
          })
        })
      }

    loadPageData(1)
    
  </script>
  <script>NProgress.done()</script>
</body>
</html>
