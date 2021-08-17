$(window).scroll(function(){
    wScroll = $(this).scrollTop();
    if(wScroll > 220){
        $('.hidnavbar').addClass('show');
        $('.about').addClass('show');
  	}else{
        $('.hidnavbar').removeClass('show');
  	}if(wScroll > 260){
        $('.hid260').addClass('show');
    }if (wScroll > 700) {
        $('.preview').addClass('show');
    }
})

function error_msg(page){
    var msg = sessionStorage.getItem("msg");
    var msg_type = sessionStorage.getItem("msg_type");
    if(page === 1){
        if (msg !== "") {
            $('.navbar').addClass('navmsg');
            $('.msg').addClass('short');
            if (msg_type == "error") {
                $('.msg').addClass('show');
                $('.msg').addClass('error');
            } else if (msg_type == "warning") {
                $('.msg').addClass('show');
                $('.msg').addClass('warning');
            } else if (msg_type == "success") {
                $('.msg').addClass('show');
                $('.msg').addClass('success');
            } else if (msg_type == "info") {
                $('.msg').addClass('show');
                $('.msg').addClass('info');
            };
            $(window).scroll(function () {
                wScroll = $(this).scrollTop();
                if (wScroll > 220) {
                    $('.navbar').removeClass('navmsg');
                    $('.msg.show').removeClass('short');
                }else{
                    $('.msg.show').addClass('short');
                };
            })
            printLetterByLetter("msg", msg, 100);
            setTimeout(function () {
                $('.msg').removeClass('show');
                $('.msg').removeClass('short');
                if (msg_type == "error") {
                    $('.msg').removeClass('error');
                } else if (msg_type == "warning") {
                    $('.msg').removeClass('warning');
                } else if (msg_type == "success") {
                    $('.msg').removeClass('success');
                } else if (msg_type == "info") {
                    $('.msg').removeClass('info');
                }
                $('.navbar').removeClass('navmsg');
                sessionStorage.setItem("msg", "");
                sessionStorage.setItem("msg_type", "");
                var errormsg = sessionStorage.getItem("msg");
            }, 7000);
        };
    }else if(page === 2){
        if (msg !== "") {
            if (msg_type == "error") {
                $('.msg').addClass('show');
                $('.msg').addClass('error');
            } else if (msg_type == "warning") {
                $('.msg').addClass('show');
                $('.msg').addClass('warning');
            } else if (msg_type == "success") {
                $('.msg').addClass('show');
                $('.msg').addClass('success');
            } else if (msg_type == "info") {
                $('.msg').addClass('show');
                $('.msg').addClass('info');
            };
            printLetterByLetter("msg", msg, 100);
            setTimeout(function () {
                $('.msg').removeClass('show');
                if (msg_type == "error") {
                    $('.msg').removeClass('error');
                } else if (msg_type == "warning") {
                    $('.msg').removeClass('warning');
                } else if (msg_type == "success") {
                    $('.msg').removeClass('success');
                } else if (msg_type == "info") {
                    $('.msg').removeClass('info');
                }
                sessionStorage.setItem("msg", "");
                sessionStorage.setItem("msg_type", "");
                var errormsg = sessionStorage.getItem("msg");
            }, 7000);
        };
    };
}

function getcurrentpage(){
    sessionStorage.setItem("last_url", window.location.href);
}

// review this
function mobileview(){
    if ($(window).width() < 600) {
        
    }
}