;
var core_ops = {
    init:function(){
      this.defaults={
        smallWidth:640,
        mediumWidth:990
      };
      this.adjustWinWidth();
      // this.clearfix();
      // this.prettifySelect();
      this.tab();
      this.showPanel();
      this.hasTip();
      this.eventBind();
    },
    eventBind:function(){
      $('.box_left_nav,.menu_list').css({
        'height' : $(window).height()-170
      });
      //左侧导航菜单折叠／展开控制
      $('.menu_switch').click(function(){
        $('.menu_list li span').hide();
        //添加动画效果
        if( !$(this).parents('.box_wrap').hasClass('open') ){
          $('.box_left_nav,.menu_switch').stop().animate({
            'width' : '200px'
          });
          $('.box_main').stop().animate({
            'margin-left' : '200px'
          });
          $('.menu_switch i').eq(0).hide();
          $('.menu_switch i').eq(1).show();
          $('.menu_list li span').each(function(){
            var index = $('.menu_list li span').index(this);
            $(this).stop().delay( 1000 * parseInt( index /3 ) ).fadeIn();
          });
        }
        else{
          $('.box_left_nav,.menu_switch').stop().animate({
            'width' : '90px'
          });
          $('.box_main').stop().animate({
            'margin-left' : '90px'
          });
          $('.menu_switch i').eq(0).show();
          $('.menu_switch i').eq(1).hide();
        }
        $('.box_wrap').toggleClass('open');
      });
      //
      $('.menu_list li').hover(function(){
        if(!$(this).parents('.box_wrap').hasClass('open')){
          $(this).tip($(this).find('span').text(),[3,'right']);
        }
      },function(){
        $(this).hideTip();
      });
      $(window).resize(function(){
        core_ops.adjustWinWidth();
        $('.box_left_nav,.menu_list').css({
          'height' : $(window).height()-170
        });
      });
      //滚动条
      $(".box_left_nav .menu_list").mCustomScrollbar({
        theme:"minimal"
      });
      //edit-mode
      if($('.edit-mode').length){
        $('.edit-mode').each(function(){
          var that=$(this);
          if(that.find('.select-all').length){
            that.find('.select-all').change(function(){
              if($(this).prop('checked')==false){
                $(this).parents('.edit-mode').find('input:checkbox').not($(this)).prop('checked',false);
              }
              else{
                $(this).parents('.edit-mode').find('input:checkbox').not($(this)).prop('checked',true);
              }
            });
          }
          var elem=that.data('elem');
          var selectedClass=that.data('class');
          var disabledElem='thead tr,thead th,.disabled';
          that.find(disabledElem).css('cursor','default');
          that.on('click',elem,function(event){
            if(!$(this).hasClass('disabled')){
              $(this).parents('.edit-mode').find(elem).not($(this)).removeClass('selected').removeClass(selectedClass);
              $(this).not(disabledElem).toggleClass('selected '+selectedClass);
              if($(this).not('thead tr').find("input:checkbox").length){
                if($(this).find("input:checkbox").prop('checked')==false && $(this).hasClass('selected')){
                  $(this).find("input:checkbox").prop('checked',true);
                }
                else if(!$(this).hasClass('selected')){
                  $(this).find("input:checkbox").prop('checked',false);
                }
                $('.edit-mode').on('click','input:checkbox',function(event){
                  event.stopPropagation();
                });
              }
              event.stopPropagation();
            }
          });
        });
      }
      //preload images
      var preload_img=new Image();
      preload_img.src='https://static-s.styd.cn/201606201358/loading.gif';
    },
    adjustWinWidth:function(){
      var winWidth=$(window).width();
      if(winWidth<=this.defaults.smallWidth){
        $('body').removeClass('body-medium').removeClass('body-large').addClass('body-small');
      }
      else if(winWidth>this.defaults.smallWidth && winWidth<=this.defaults.mediumWidth){
        $('body').removeClass('body-small').removeClass('body-large').addClass('body-medium');
      }
      else{
        $('body').removeClass('body-small').removeClass('body-medium').addClass('body-large');
      }
    },
    // clearfix:function(){
    //   $('.clearfix,.row').each(function(){
    //     $(this).prepend('<before></before>').append('<after></after>');
    //   });
    // },
    prettifySelect:function(){
     $('.select-1').each(function(){
       var that=$(this);
       var num=that.find('option').length;
       var dom='<div class="select-wrap">';
       dom+='<div class="select-selected"><span>'+that.val()+'</span><i class="icon_club">&#xe614;</i></div>'
       dom+='<div class="select-options">';
       dom+='<ul>'
       for(var i=0;i<num;i++){
         dom+='<li>'+that.find('option').eq(i).text()+'</li>'
       }
       dom+='</ul></div></div>';
       that.after(dom);
     });

     $('.select-options').each(function(){
       $(this).css({
         'width':$(this).parents('.select-wrap').width()
       });
     });

     $('.select-selected').click(function(){
       var num=$(this).parents('.select-wrap').prev('.select-1').find('option').length;
       var dom='';
       for(var i=0;i<num;i++){
         dom+='<li>'+$(this).parents('.select-wrap').prev('.select-1').find('option').eq(i).text()+'</li>';
       }
       $(this).parents('.select-wrap').find('ul li').remove();
       $(this).parents('.select-wrap').find('ul').append(dom);
       var currentText=$(this).find('span').text();
       $(this).parents('.select-wrap').find('.select-options').toggle();
       $(this).parents('.select-wrap').find('.select-options li').each(function(){
         if($(this).text() == currentText){
           $(this).addClass('current').siblings('li').removeClass('current');
         }
       });
     });

     $('.select-wrap').on('click','.select-options li',function(){
       $(this).parents('.select-options').hide();
       $(this).parents('.select-wrap').find('.select-selected span').text($(this).text());
       var currentIndex=$('.select-options li').index(this);
       $(this).parents('.select-wrap').prev('.select-1').val($(this).parents('.select-wrap').prev('.select-1').find('option').eq(currentIndex).attr('value')).find('option').eq(currentIndex).attr('selected','selected').siblings('option').removeAttr('selected');
       if(!$(this).hasClass('current')){
         $(this).parents('.select-wrap').prev('.select-1').change();
       }
     });
    //  $('.select-options li').click(function(){
    //    $(this).parents('.select-options').hide();
    //    $(this).parents('.select-wrap').find('.select-selected span').text($(this).text());
    //    var currentIndex=$('.select-options li').index(this);
    //    $(this).parents('.select-wrap').prev('.select-1').val($(this).parents('.select-wrap').prev('.select-1').find('option').eq(currentIndex).attr('value')).find('option').eq(currentIndex).attr('selected','selected').siblings('option').removeAttr('selected');
    //    if(!$(this).hasClass('current')){
    //      $(this).parents('.select-wrap').prev('.select-1').change();
    //    }
    //  });

     $(document).bind("click",function(e){
       var target = $(e.target);
       if(target.closest(".select-wrap").length == 0){
         $(".select-options").hide();
       }
     });
   },
   //tab
   tab:function(){
     if($('.tab-1 .tab-title li').length){
       $('.tab-1 .tab-title li').click(function(){
         $(this).addClass('current').siblings('li').removeClass('current');
         var currentIndex=$('.tab-1 .tab-title li').index(this);
         $(this).parents('.tab-1').find('.tab-each').eq(currentIndex).show().siblings('.tab-each').hide();
       });
     }
   },
   showPanel:function(){
     var timer=null;
     if($('.has-panel').length){
       $('.has-panel').each(function(){
         var that=$(this);
         var panelTop = that.offset().top + that.height();
         $('.'+that.data('panel')).css('top',panelTop);
         that.hover(function(){
           clearTimeout(timer);
           $('.'+that.data('panel')).stop().slideDown();
         },function(){
           timer=null;
           timer=setTimeout(function(){
             $('.'+that.data('panel')).stop().slideUp();
           },500);
         });
         $('.'+that.data('panel')).hover(function(){
           clearTimeout(timer);
         },function(){
           timer=$('.'+that.data('panel')).stop().slideUp();
         });
       });
     }
   },
   hasTip: function(){
     $('i.icon_club').each(function(){
       $(this).hover(function(){
         switch( escape($(this).text()) ){
           case '%uE610':
            $(this).tip('编辑',[3,'bottom']);
            break;
           case '%uE611':
            $(this).tip('删除',[3,'bottom']);
            break;
           case '%uE613':
            $(this).tip('添加',[3,'bottom']);
            break;
           case '%uE616':
            $(this).tip('查看',[3,'bottom']);
            break;
           case '%uE61E':
            $(this).tip('生成',[3,'bottom']);
            break;
           case '%uE61C':
            $(this).tip('导入',[3,'bottom']);
            break;
           case '%uE61B':
            $(this).tip('导出',[3,'bottom']);
            break;
           defautl:;
         }
       },function(){
         $(this).hideTip();
       });
     });
     $('.hastips .icon_club,.hastip').each(function(){
       $(this).hover(function(){
         if( $(this).data('tip') ){
           $(this).tip($(this).data('tip'),[3,'bottom']);
         }
       },function(){
         $(this).hideTip();
       });
     });
   }
};

$(document).ready(function(){
  core_ops.init();
});
