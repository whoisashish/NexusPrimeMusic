$(document).ready(function() {
    console.log('Document Ready');
    $("#hideLogin").click(function () {
        $("#loginForm").hide();
        $("#registerForm").show();
    });
    $("#hideRegister").click(function () {
        $("#loginForm").show();
        $("#registerForm").hide();
    });
});
