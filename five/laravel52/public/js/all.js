
$(document).ready(function () {
    var indexNav = 0;
    $("#indexMoreNav").click(function () {
        indexNav = indexNav + 1;
        if (indexNav % 2 == 0) {
            $("#indexNav").hide();
        } else {
            $("#indexNav").show();
        }
    });
    $(".titleCurrent").click(function () {
        //$(this).children("a").css({ color: "#FF7300" });
        $(this).children("ul.column_ul_ul").slideToggle().siblings(".dis:visible").slideUp();
    });

    var navapp = 0;
    $("#navApp").click(function () {
        navapp = navapp + 1;
        if (navapp % 2 == 0) {
            $(this).parent().parent().next("#navShadow_list").css({ display: "none" });
            $(this).parent().parent().next().next("#navShadow").css({ display: "none" });
        } else {
            $(this).parent().parent().next("#navShadow_list").css({ display: "block" });
            $(this).parent().parent().next().next("#navShadow").css({ display: "block" });
        }
    });
});

//tab切换
(function ($) {
    $.fn.extend({
        Tabs: function (options) {
            // 处理参数
            options = $.extend({
                event: 'mouseover',//鼠标事件
                timeout: 0,
                auto: 0,
                callback: null
            }, options);

            var self = $(this),
				tabBox = self.children().children('div.tab_box').children('div'),
				menu = self.children('ul.tab_menu'),
				items = menu.find('li'),
				timer;

            var tabHandle = function (elem) {
                elem.siblings('li')
                    .removeClass('current')
                    .end()
                    .addClass('current');

                tabBox.siblings('div')
                    .addClass('hide')
                    .end()
                    .eq(elem.index())
                    .removeClass('hide');
            },

				delay = function (elem, time) {
				    time ? setTimeout(function () { tabHandle(elem); }, time) : tabHandle(elem);
				},

				start = function () {
				    if (!options.auto) return;
				    timer = setInterval(autoRun, options.auto);
				},

				autoRun = function () {
				    var current = menu.find('li.current'),
						firstItem = items.eq(0),
						len = items.length,
						index = current.index() + 1,
						item = index === len ? firstItem : current.next('li'),
						i = index === len ? 0 : index;

				    current.removeClass('current');
				    item.addClass('current');

				    tabBox.siblings('div')
						.addClass('hide')
						.end()
						.eq(i)
						.removeClass('hide');
				};

            items.bind(options.event, function () {
                delay($(this), options.timeout);
                if (options.callback) {
                    options.callback(self);
                }
            });
            if (options.auto) {
                start();
                self.hover(function () {
                    clearInterval(timer);
                    timer = undefined;
                }, function () {
                    start();
                });
            }

            return this;
        }
    });
})(jQuery);

$(function () {
    $('#tab01').Tabs({
        event: 'click'
    });
});


$(function () {
    $(window).scroll(function () {
        if ($(window).scrollTop() > 100) {
            $("#back-to-top").fadeIn(500);
        }
        else {
            $("#back-to-top").fadeOut(500);
        }
    });
    //当点击跳转链接后，回到页面顶部位置
    $("#back-to-top").click(function () {
        $('body,html').animate({ scrollTop: 0 }, 500);
        return false;
    });

    var navmoreP = 0;
    $(".navMore .navPlus").click(function () {
        navmoreP = navmoreP + 1;
        if (navmoreP % 2 == 0) {
            $(this).parent().children(".nav_more").css({ display: "none" });
        } else {
            $(this).parent().children(".nav_more").css({ display: "block" });
        }
    });
    $(".navMore .navclose").click(function () {
        navmoreP = 0;
        if (navmoreP % 2 == 0) {
            $(this).parent(".nav_more").css({ display: "none" });
        }
    });
});

$(function () {
    $(".selectcity").click(function () {
        $("#selectDq").css("display", "block");
    });
    $(".selectdqbtn").click(function () {
        var sel = $("#selectDq .qu").find("option:selected").val();
        if($("#selectDq .qu").find("option:selected").val() !=0 ){
                window.open('/'+$("#selectDq .qu").find("option:selected").val());
         }else{
            showError('请选择分站')
          }
    });
    $("#selectDq .sheng").change(function(){
        var sel = $("#selectDq .sheng").find("option:selected").val();
        if(sel=="-1"){
            $("#selectDq .shi").css("display","none");
            $("#selectDq .qu").css("display","none");
        }else{
            $("#selectDq .shi").css("display","block");
        }
    });

    $("#selectDq .qu").change(function(){
        var sel = $("#selectDq .qu").find("option:selected").val();
        if($("#selectDq .qu").find("option:selected").val() !=0 ){
            location.href = '/'+$("#selectDq .qu").find("option:selected").val();
        }
    });

    $("#selectDq .shi").change(function(){
        var sel = $("#selectDq .shi").find("option:selected").val();
        if(sel=="-1"){
            $("#selectDq .qu").css("display","none");
        }else{
            $("#selectDq .qu").css("display","block");
        }
    });
});

/******new*****/
/*
 *联动菜单
 * 第一级菜单 元素 class="combine"
 *             data-next="xxx"   // 下一级的ID
 *             data-url=“xxx”    // 下一级的菜单数据来源
 */
$(function(){
    var sel = $('.combine');
    if (sel.length > 0) {
        sel.each(function(){
            var next = $('#' + $(this).attr('data-next'));
            if (next.children('option').length <= 0) {
                getNext($(this));
            }
            $(this).change(function(){
                getNext($(this));
            });
        });
    }

    function reset(node) {
        var son = $('#' + node.attr('data-next'));
        if (son.length > 0) {
            reset(son);
        }
        node.children('option').remove();
        node.hide();
    }

    function getNext(node){
        var next = $('#' + node.attr('data-next'));
        if (next.length > 0) {
            if (node.val() > 0) {
                $.ajax({
                    url : node.attr('data-url'),
                    data : node.attr('name') + '=' + node.val(),
                    type : 'get',
                    dataType :'json',
                    success:function(data){
                        var option = '';
                        var item = 0;
                        $.each(data, function(k, v){
                            option += '<option value="' + k + '">' + v + '</option>';
                            item++;
                        });
                        reset(next);
                        if (item > 1) {
                            next.append(option);
                            next.show();
                            getNext(next);
                        }
                    }
                });
            } else {
                reset(next);
            }
        }
    }
});


function showError(){
    var text = arguments[0] || '操作失败';
    layer.msg(text, {icon: 8,shade: 0.3,time:1500});
}

function showSuccess(){
    var text = arguments[0] || '操作成功';
    layer.msg(text, {icon: 1,time:1500});

}