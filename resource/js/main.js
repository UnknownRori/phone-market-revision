$(window).scroll(function(){
    wScroll = $(this).scrollTop();
    if(wScroll > 220){
        $('.hidnavbar').addClass('show');
        $('.about').addClass('show');
  	}else{
        $('.hidnavbar').removeClass('show');
  	}
    if(wScroll > 700){
        $('.preview').addClass('show');
    }
})
