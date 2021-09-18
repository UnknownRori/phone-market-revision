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

$(window).scroll(function () {
    wScroll = $(this).scrollTop();
    if (wScroll > 220) {
        $('.about').addClass('show');
    } else {
        $('.about').removeClass('show');
        $('.preview').removeClass('show');
    } if (wScroll > 260) {
        $('.hidden').addClass('show');
    } if (wScroll > 700) {
        $('.preview').addClass('show');
    }
})
printLetterByLetter("intro", "A Fake Apple Store", 100);
printLetterByLetter("intro-secondary", "by UnknownRori", 100);
// review this
// $(document).ready(function () {
//     $('.navbar a').on('click', function (e) {
//         href = $(this).attr('href');
//         eHref = $(href);
//         $('html').animate({
//             scrollTop: eHref.offset().top - 70
//         }, 1000, 'easeInOutBack')
//     })
// });