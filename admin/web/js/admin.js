$(document).ready(function () {
    if ($("#viewAdminIndex").length>0) {
        laydate.render({
            elem: 'input[name=created_at]',
            type: 'date',
            range: true,
            done: function(value, date, endDate){
                $("#created_at").val(value);
                doSearch()
            }
        })
    }

    if ($("#viewAdminAdd").length>0) {
        app.jqvalidate.init({
            obj: '#formAdd',
            rules: {
                realname: {required: true},
                mobile: {required: true},
                email: {email: true},
            },
            messages: {
                realname: {required: '姓名不能为空'},
                mobile: {required: '手机号不能为空'},
                email: {email: '邮箱格式不正确'},
            }, 
            submitHandler: function (form) {
                $(form).ajaxSubmit({
                    dataType : "json",
                    success: function(response) {
                        layer.msg(response.msg, {}, function(){
                            if (response.code==0) {
                                window.location.href = 'index';
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        if(status==='error'){
                            layer.msg('服务器错误');
                        }
                    }
                });
            }
        })  
    }
});