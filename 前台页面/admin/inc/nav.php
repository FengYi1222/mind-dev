	<?php
		$current_page = isset($current_page) ? $current_page : '';
	?>
		<div class="wel-nav">
			<div class="zhongjian">
			<span class="mt5 fl mr20 logo">心理栈</span>
			<ul class="fl mt5 navbar">
				<li><a <?php echo $current_page === 'one' ? ' class="active"' : '' ?> href="/前台页面/admin/a-admin.php">首页</a></li>
				<span>|</span>
				<li><a <?php echo $current_page === 'two' ? ' class="active"' : '' ?> href="/前台页面/admin/b-文章列表页面-1.php">男女情感</a></li>
				<span>|</span>
				<li><a <?php echo $current_page === 'tree' ? ' class="active"' : '' ?> href="/前台页面/admin/b-文章列表页面-2.php">人际交往</a></li>
				<span>|</span>
				<li><a <?php echo $current_page === 'four' ? ' class="active"' : '' ?> href="/前台页面/admin/b-文章列表页面-3.php">自我提升</a></li>
				<span>|</span>
				<li><a <?php echo $current_page === 'five' ? ' class="active"' : '' ?> href="/前台页面/admin/b-文章列表页面-4.php">生活幸福</a></li>
				<span>|</span>
				<li><a <?php echo $current_page === 'six' ? ' class="active"' : '' ?> href="/前台页面/admin/e-帖子列表页面.php">心理互诉</a></li> 
				<span>|</span>
				<li><a <?php echo $current_page === 'seven' ? ' class="active"' : '' ?> href="/前台页面/admin/h-音乐栏目.php">音乐栏目</a></li>
			</ul>
			<input type="text" class="fl ml30 search-input" placeholder="搜索">
			<div class="search">
				
			</div>	
			<div class="avatar-container">
				<img src="" alt="">
				<div class="show-list ">
					<ul >
						<il class="list-item"><a href="javascript:;">管理中心</a></il>
						<il class="list-item"><a href="javascript:;">个人主页</a></il>
						<il class="list-item"><a href="javascript:;">消息提示</a></il>
						<il class="list-item"><a href="javascript:;">切换账号</a></il>
						<il class="list-item"><a href="javascript:;">退出</a></il>
					</ul>
				</div>
			</div>
		</div> 
		</div>
