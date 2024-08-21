function fShowPassword(){
    var cambio = document.getElementById("password");
    var cambio2 = document.getElementById("password-confirm");
    if(cambio.type === "password" || cambio2.type === "password"){
        cambio.type = "text";
        cambio2.type = "text";
        $('.icon').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
    }else{
        cambio.type = "password";
        cambio2.type = "password";
        $('.icon').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
    }
}