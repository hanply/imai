$(function(){
    $(".input-group input").keyup(function(){
        if($("#account").val() && $("#passwd").val()) {
            $("#loginBtn").attr("disabled", false);
        }else{
            $("#loginBtn").attr("disabled", true);
        }
    })
    $("#loginBtn").click(function(){
        $(this).attr("disabled", true).val("正在登录 ...");
        var csrfAdmin = $("#csrfAdmin").val(), 
            account = $("#account").val(), 
            passwd = $("#passwd").val(),
            rememberMe = $("#rememberMe").is(":checked") ? 1 : 0;
        $.ajax({
            method: 'post',
            data:{
                csrfAdmin: csrfAdmin,
                account: account,
                passwd: passwd,
                rememberMe: rememberMe,
            },
            dataType: 'json',
            success: function(response) {
                if(response.code==0) {
                    layer.msg(response.msg, {offset: '100px', icon:1}, function(){
                        window.location.href = '/';
                    });
                }else{
                    layer.msg(response.msg, {offset: '100px', icon:5}, function(){
                        $("#loginBtn").attr("disabled", false).val("登录");
                    });
                }
            },
            fail: function() {
                layer.msg('登录失败，请重试', {offset: '100px', icon:5}, function(){
                    $("#loginBtn").attr("disabled", false).val("登录");
                });
            }
        })
    })
})