function toggleReg(){
    $('.wrapper').css({"height": "520px"});
    $('.form-box.login').css({"transform": "translateX(-400px)"});
    $('.form-box.register').css({"transform": "translateX(0)"});
    $('#btn').css({"left": "110px"});
}
function toggleLog(){
    $('.wrapper').css({"height":"440px"});
    $('.form-box.login').css({"transform": "translateX(0)"});
    $('.form-box.register').css({"transform": "translateX(400px)"});
    $('#btn').css({"left": "0"});
}
$('.register-link').click(
    function a(){
        toogleReg();
    }
);

$('.login-link').click(
    function a(){
        toggleLog();
    }
);

$('.fa-right-to-bracket').click(
    function popuplogin(){
        $('.wrapper').addClass('active-popup');
    }
);

$('.fa-xmark').click(
    function closelogin(){
        $('.wrapper').removeClass('active-popup');
    }
);