// 添加按钮操作
$('#button-add').click(function() {
    var url = SCOPE.add_url;
    window.location.href = url;
});

// 提交和编辑form表单操作
$("#singcms-button-submit").click(function() {
    var data = $("#singcms-form").serializeArray();
    var postData = {};
    $(data).each(function(i) {
        postData[this.name] = this.value;
    });
    // 将获取到的数据post给服务器
    var url = SCOPE.save_url;
    var jump_url = SCOPE.jump_url;
    $.post(url, postData, function(result) {
        if (result.status === 1) {
        	// 成功
        	return dialog.success(result.message, jump_url);
        } else if (result.status === 0) {
            return dialog.error(result.message);
        }
    }, "JSON");
});
// 进入编辑模式
$('.singcms-table #singcms-edit').on('click', function(event) {
    var id = $(this).attr('attr-id');
    var url = SCOPE.edit_url + '&id=' + id;
    window.location.href = url;
});

// 菜单管理中前端后台菜单的切换
$('#menu-select').on('change', function(e) {

    var url = SCOPE.index_url;
    var data = {};
    var index = this.options.selectedIndex;
    data.type = this.options[index].value;
    if (data.type !== '') {
        $.get(url, data, function(res) {
            window.location = '/admin.php?c=menu&a=index&type=' + data.type; 
        });
    }
    return false;
});

// 删除操作
$('.singcms-table #singcms-delete').on('click', function() {
    var id = $(this).attr('attr-id');
    var a = $(this).attr('attr-a');
    var message = $(this).attr('attr-message');
    var url = SCOPE.set_status_url;

    var data = {};
    data['id'] = id;
    data['status'] = -1;

    layer.open({
        type: 0,
        title: '是否提交?',
        btn: ['yes', 'no'],
        icon: 3,
        closeBtn: 2,
        content: '是否确定' + message,
        scrollbar: true,
        yes: function() {
            todelete(url, data);
        }
    });
});

function todelete(url, data) {
    $.post(url, data, function(s) {
        if (s.status === 1) {
            // return dialog.success(s.message, '');
            return dialog.success(s.message, SCOPE.jump_url);
        } else {
            return dialog.error(s.message);
        }
    }, 'JSON');
}

// 排序操作
$('#button-listorder').click(function() {
    // 获取listorder内容
    var data = $('#singcms-listorder').serializeArray();
    postData = {};
    $(data).each(function(i) {
        postData[this.name] = this.value;
    });
    // console.log(postData);
    var url = SCOPE.listorder_url;
    $.post(url, postData, function(result) {
        if (result.status === 1) {
            // 成功
            return dialog.success(result.message, result['data']['jump_url']);
        }
        // 失败
        return dialog.error(result.message, result['data']['jump_url']);
        
    }, 'JSON');
});

// 修改状态(可以和删除合并)
$('.singcms-table #singcms-on-off').on('click', function() {
    var id = $(this).attr('attr-id');
    var status = $(this).attr('attr-status');
    var url = SCOPE.set_status_url;

    var data = {};
    data['id'] = id;
    data['status'] = status;

    layer.open({
        type: 0,
        title: '是否提交?',
        btn: ['yes', 'no'],
        icon: 3,
        closeBtn: 2,
        content: '是否确定更改状态',
        scrollbar: true,
        yes: function() {
            todelete(url, data);
        }
    });
});

// 推送js相关代码
$('#singcms-push').click(function(e) {
    var id = $('#select-push').val();
    if (!id) {
        return dialog.error("请选择推荐位!");
    }
    var push = {},
        postData = {};
    $('input[name=pushcheck]:checked').each(function(i) {
        push[i] = $(this).val();
    });

    postData['push'] = push; // 选中文章的主键ID数组
    postData['position_id'] = id; // 推荐位iD
    var url = SCOPE.push_url;
    $.post(url, postData, function(result) {
        if (result.status === 1) {
            return dialog.success(result.message, result['data']['jump_url']);
        }
        if (result.status === 0) {
            return dialog.error(result.message);
        }
    }, 'JSON');
});