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
function error_msg(page) {
    var msg = sessionStorage.getItem("msg");
    var msg_type = sessionStorage.getItem("msg_type");
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
            msg = sessionStorage.getItem("msg");
            msg_type = sessionStorage.getItem("msg_type");
            document.getElementById('msg').innerHTML = '';
        }, 7000);
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