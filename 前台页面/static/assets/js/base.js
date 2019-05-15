
	$(document).ready(function(){
		$('.avatar-container').mouseenter(function(){
            $('.show-list').show();
        })
        $('.avatar-container .show-list').mouseenter(function(){
            $('.show-list').show();
        })
        $('.avatar-container').mouseleave(function(){
            $('.show-list').hide();
        })
        $('.navbar li a').click(function(){
            // console.log("enen")

            $('.navbar li a').removeClass('active');
            $(this).addClass('active');
        })



    })

    // 主页面
    $(document).ready(function(){
        $('.rewen-tupian').hide();            
        $('.qinggan').show();
        console.log('enen');        
        $('.rewen-nav .qinggan-btn').click(function(){
            $('.rewen-nav div').removeClass('active');
            $(this).addClass('active');
            $('.rewen-tupian').hide();            
            $('.qinggan').show();
        })
        $('.rewen-nav .renji-btn').click(function(){
            $('.rewen-nav div').removeClass('active');
            $(this).addClass('active');
            $('.rewen-tupian').hide(); 
            $('.renji').show();
        })
        $('.rewen-nav .tisheng-btn').click(function(){
            $('.rewen-nav div').removeClass('active');
            $(this).addClass('active');
            $('.rewen-tupian').hide(); 
            $('.tisheng').show();
        })
        $('.rewen-nav .shenghuo-btn').click(function(){
            $('.rewen-nav div').removeClass('active');
            $(this).addClass('active');
            $('.rewen-tupian').hide(); 
            $('.shenghuo').show();
        })
    })