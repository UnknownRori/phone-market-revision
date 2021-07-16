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

function printLetterByLetter(destination, message, speed) {
    var i = 0;
    var interval = setInterval(function () {
        document.getElementById(destination).innerHTML += message.charAt(i);
        i++;
        if (i > message.length) {
            clearInterval(interval);
        }
    }, speed);
}