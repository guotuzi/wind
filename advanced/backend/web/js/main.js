// 这个文件的效果是全局的

$(function(){
    /**
     *  events 事件页面的 pop up 用的；
     */
//日历js
    $(document).on("click",'.fc-day',function(){      //事件托管(document, 找到整个页面)
        var url = 'index.php?r=events/create';
        var date = $(this).attr('data-date');         // 获取当时 日历当天的日期值
        $.get(url, {'date': date} ,function(data){    // {'date': date}： 用 ajax get传给controller的参数(日期值),
                                                      // data ajax回调的数据
            $('#modal').modal('show')
                .find('#modalContent')                // find() 方法获得当前元素集合中每个元素的后代
                .html(data);                          // 将收到的数据写入 #modalContent
        });

    });


    /**
     * branches->create 的弹出层 Pop up
     * 当点击create 按钮的时候触发
     * get the click of the create button
     */
    $('#modalButton').click(function(){
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));   // load， 页面所有元素加载完了以后，触发
    });



});

