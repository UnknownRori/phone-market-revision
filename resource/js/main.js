function error_msg(page) {
    var msg = sessionStorage.getItem("msg");
    var msg_type = sessionStorage.getItem("msg_type");
    if (msg !== null && msg_type !== null) {
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
        document.getElementById("msg").innerHTML = msg;
        sessionStorage.setItem("msg", null);
        sessionStorage.setItem("msg_type", null);
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
            document.getElementById('msg').innerHTML = null;
        }, 7000);
    };
}

function getcurrentpage(){
    sessionStorage.setItem("last_url", window.location.href);
}