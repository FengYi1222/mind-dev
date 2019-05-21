<?php 
require_once '../functions.php';

if(empty($_SESSION['current_login_user'])){
    $current_user = null;
}else {
    $current_user = $_SESSION['current_login_user'];
}


function add() {
  //1. 接受并校验
  //2. 持久化
  //3. 响应
    $GLOBALS['message'] = '';
  if (empty($_POST['title'])) {
    $GLOBALS['message'] = '请输入文章标题  你看我在干啥';
    return;
  }
  if (empty($_POST['content'])) {
    $GLOBALS['message'] = '请填写文章内容';
    return;
  }
  $title = $_POST['title'];
  $content = $_POST['content'];

  // 当客户端提交过来的完整的表单信息就应该开始对其进行数据校验
  $conn = mysqli_connect(XIU_DB_HOST, XIU_DB_USER, XIU_DB_PASS, XIU_DB_NAME);
  if (!$conn) {
    $GLOBALS['message'] = '连接数据库失败';
    return;
  }
  $rows = xiu_execute("insert into tiezi (title,autor,created,content,views,replies,likes,status,user_id) values ('{$title}','测试','12:12','{$content}',0,0,0,'published',1);");
 if (!$rows) {
    $GLOBALS['message'] = '查询过程失败';
    return;
  }
  $affected_rows = mysqli_affected_rows($conn);
  header('Location: /前台页面/admin/e-帖子列表页面.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    add();
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>心理问答-在线免费咨询</title>
    <link rel="stylesheet" href="../static/assets/css/base.css">
    <link rel="stylesheet" href="../static/assets/css/main.css">
    <script src="../static/assets/vendors/jquery/jquery.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="../static/assets/css/tiezifb.css">
</head>

<body>
    <?php $current_page = 'six'; ?>
    <?php include 'inc/nav.php'; ?>
    <div class="content clearfix mb30">
    	<div class="main">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="main-l">
            <?php if (isset($message)): ?>
            <div class="alert alert-danger">
                <strong>错误！</strong> <?php echo $message; ?>
            </div>
            <?php endif ?>
            <div class="tiwen">
                <div class="title">
                    <span class="biaoti">发布评论</span>
                    <span class="biaoqian">即时倾诉，倾听你的故事</span>
                </div>
                <div class="shuru">
                    <input type="text" name="title" placeholder="问题标题，5个字到25个字以内，必填">
                </div>
                <div class="juli">
                    <span>举例</span>
                    <ul>
                        <li>
                            大二学生，无法和室友相处，很容易受影响怎么办？</li>
                        <li>
                            情绪低落，很丧，怎么确认我是否患有抑郁症呢？3个月了</li>
                    </ul>
                </div>
                <textarea name="content" id="" cols="30" rows="10" placeholder="请输入问题的描述，会有很多人帮助你的~ ( 收到满意地回答，记得给回答者点赞哦~ )"></textarea>
                <div class="tijiaohezi">
                    <button class="tijiao">提交</button>
                </div>
            </div>
        </div>
    </form>
        <!-- 右边 -->
        <div class="fr">
            <div class="fr-top">
                <div class="fr-t-t">
                    <div class="fr-t-tl">
                        <p>0</p>
                        <p>提问数</p>
                    </div>
                    <div class="fr-t-tr">
                        <p>0</p>
                        <p>回答数</p>
                    </div>
                </div>
                <div class="fr-t-b">
                    <a href=""><div class="fr-t-bl">我要提问</div></a>
                    <a href=""><div class="fr-t-br">我的回答</div></a>
                </div>
            </div>
            <div class="fr-bottom"></div>
        </div>
    </div>
    </div>
    <div class="wel-footer">
        <script type="">
            $('.wel-footer').load('common/footer.html')
    </script>
    </div>

</body>

</html>