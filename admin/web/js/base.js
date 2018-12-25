window.app = {
    config: { 
        cookie_expiry: 604800, 
    },
    init: function() {
        $(".nav-list li").hover(function(){
            $(this).addClass('active');
            var f = $(this).children(".submenu")
            if (!f || f.length == 0) return 
            if (!f.is(":visible")) f.show() 
        }, function(){
            if (!$(this).hasClass("on")) {
                $(this).removeClass('active');
            }
            var f = $(this).children(".submenu")
            if (!f || f.length == 0) return 
            if (f.is(":visible")) f.hide() 
        })
    },
    funs: {
        date: function(timestamp) {
            var date = new Date(timestamp * 1000);
            var year = date.getFullYear(),
                month = date.getMonth(),
                day = date.getDate(),
                hour = date.getHours(),
                minute = date.getMinutes(),
                second = date.getSeconds();
            return year+'-'+(month<10?'0'+month:month)+'-'+(day<10?'0'+day:day)+' '+(hour<10?'0'+hour:hour)+':'+(minute<10?'0'+minute:minute)+':'+(second<10?'0'+second:second)
        },
        mergeOption: function (option, set) {
            var result = option;
            for(var i in option) {
                if(set[i]) {
                    result[i] = set[i];
                }
            }
            for(var i in set) {
                if(!option[i]) {
                    result[i] = set[i];
                }
            }
            return result;
        }
    },
    cookie: {
        get: function(c) {
            var d = document.cookie,
                g, f = c + "=",
                a;
            if (!d) { return } a = d.indexOf("; " + f);
            if (a == -1) { a = d.indexOf(f); if (a != 0) { return null } } else { a += 2 } g = d.indexOf(";", a);
            if (g == -1) { g = d.length }
            return decodeURIComponent(d.substring(a + f.length, g))
        },
        set: function(b, e, a, g, c, f) {
            var h = new Date();
            if (typeof(a) == "object" && a.toGMTString) { a = a.toGMTString() } else {
                if (parseInt(a, 10)) {
                    h.setTime(h.getTime() + (parseInt(a, 10) * 1000));
                    a = h.toGMTString()
                } else { a = "" }
            }
            document.cookie = b + "=" + encodeURIComponent(e) + ((a) ? "; expires=" + a : "") + ((g) ? "; path=" + g : "") + ((c) ? "; domain=" + c : "") + ((f) ? "; secure" : "")
        },
        remove: function(a, b) { this.set(a, "", -1000, b) }
    },
    jqgrid: {
        option: {
            obj: '#jqgridList',
            url: '',
            datatype: "json",
            height: 300,
            autowidth: true,
            rowNum: 20,
            rowList: [20, 50, 100],
            colNames: [],
            colModel: [],
            pager: "#pager",
            viewrecords: true,
            multiselect: true,
            multiselectWidth: 24,
            scrollOffset: 0,
            altRows:true,
            altclass:'alt-class',
            recordpos: 'left'
        },
        init: function(set) {
            $.jgrid.defaults.styleUI = 'Bootstrap';
            var option = app.funs.mergeOption(this.option, set);
            if(!option.url) option.url = location.href;
            $(option.obj).jqGrid(option);
        },
        reload: function(extraParams) {
            $(this.option.obj).jqGrid('setGridParam',{
                postData: extraParams,
            }).trigger("reloadGrid"); 
        }
    },
    jqvalidate: {
        option: {
            ignore: [],
            debug: false,
            obj: '',
            onfocusout: false,
            onkeyup: false,
            rules: {},
            messages: {},
            invalidHandler: function(form, validator) {
                var errors = validator.numberOfInvalids();
                if (errors) {                    
                    validator.errorList[0].element.focus();
                }
            },
            showErrors:function(errorMap,errorList) {
                if(errorList.length > 0){
                    layer.msg(errorList[0].message)
                }
            },
            submitHandler: function (form) {
                $("#submitBtn").attr("disabled","true");
                $(form).ajaxSubmit({
                    dataType : "json",
                    success: function(response) {
                        $("#submitBtn").removeAttr('disabled');
                        layer.msg(response.msg, {}, function(){
                            window.location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        $("#submitBtn").removeAttr('disabled');
                        if(status==='error'){
                            layer.msg('服务器错误');
                        }
                    }
                });
            }
        },
        init: function (set) {
            var option = app.mergeOption(this.option, set);
            $(option.obj).validate(option);
        }
    }
} 
app.init();