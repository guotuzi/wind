// 这个文件的效果是全局的
/**
 * branches->create 的弹出层 Pop up
 * 当点击create 按钮的时候触发
 * get the click of the create button
 */
$(function(){
    $('#modalButton').click(function(){
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });
});