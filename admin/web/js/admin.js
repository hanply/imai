$(document).ready(function () {
    var jqgridHeight = $(window).height()-280
    app.jqgrid.init({
        obj: '#list',
        url: 'index',
        height: jqgridHeight,
        colNames: ['ID', '账号', '姓名', '手机号', '邮箱', '状态', '创建时间', '操作'],
        colModel: [{
            name: 'id',
            width: 60,
        }, {
            name: 'account',
            editable: true,
            sortable: false,
            width: 90,
        }, {
            name: 'realname',
            editable: true,
            sortable: false,
            width: 100
        }, {
            name: 'mobile',
            editable: true,
            sortable: false,
            width: 80,
        }, {
            name: 'email',
            editable: true,
            sortable: false,
            width: 80,
        }, {
            name: 'status',
            sortable: false,
            width: 80,
            formatter: function(value, options, row){
                return value==1 ? '<span class="green">启用</span>' : '<span class="grey">停用</span>'
            }
        }, {
            name: 'created_at',
            sortable: true,
            width: 80,
            formatter: function(value, options, row){
                return app.funs.date(value)
            }
        }, {
            fixed:true, 
            sortable:false, 
            resize:false,
            classes: 'actions',
            formatter:function(value, options, row){
                var temp = '';
                if (row.status==1) {
                    temp += '<a href="edit?id='+row.id+'" target="_blank">停用</a>';
                }else{
                    temp += '<a href="edit?id='+row.id+'" target="_blank">启用</a>';
                }
                temp += '<a href="edit?id='+row.id+'" target="_blank">编辑</a>' +
                        '<a href="javascript:" onclick="toDelete(\'delete?id='+row.id+'&status=-1\')" >删除</a>';
                return temp;
            },
        }],
    })
    laydate.render({
        elem: '#created_at',
        type: 'date',
        range: true,
        done: function(value, date, endDate){
            $("#created_at").val(value);
            doSearch()
        }
    })
    $(".search-container input,.search-container select").change(function(){
        doSearch()
    })
    $(window).bind('resize', function () {
        $('#list').setGridWidth($('.view-body').width());
        $('#list').setGridHeight($(window).height()-280);
    });
    function doSearch(){
        app.jqgrid.reload({
            'key': $("#key").val(),
            'status': $("#status").val(),
            'created_at': $("#created_at").val(),
        })
    }
});