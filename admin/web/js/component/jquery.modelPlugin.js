;
(function($){
  $.extend({
    defaults:{
      common:{//alert与confirm的通用配置信息
        time:2000,
        fadeInTime:400,
        fadeOutTime:400,
        delayTime:0,
        timingClosure:false,
        shade:true,
        shadeClose:false,
        closeIcon:true,
        title:'提示信息',
        confirmBtn:true,
        confirmBtnText:'确定',
        cancelBtnText:'取消',
        ok:null,
        cancel:null,
        okDefaultFn:null,
        cancelDefaultFn:null,
        area:['','']
      },
      alert:{//alert的配置信息
        cancelBtn:false
      }
    },
    //alert方法
    alert:function(msg,options){
      var msg,options;
      var i=arguments.length;
      switch(i){
        case 0:
        msg='';
        break;
        case 1:
        if(typeof(arguments[0])=='object'){
          options=arguments[0];
          msg='';
        }
        break;
        case 2:
        for(var j in arguments){
          if(typeof(arguments[j])=='string'){
            msg=arguments[j];
          }
          else if(typeof(arguments[j])=='object'){
            options=arguments[j];
          }
        }
        break;
        default:
        msg='';
        options=null;
      }
      var opts = $.extend({},$.defaults.common,$.defaults.alert,options);
      var that=this;
      var time=opts.time;
      var fadeInTime=opts.fadeInTime;
      var fadeOutTime=opts.fadeOutTime;
      var delayTime=opts.delayTime;
      var timingClosure=(opts.timingClosure=="false"||opts.timingClosure==false)?false:true;
      var shade=(opts.shade=="false"||opts.shade==false)?false:true;
      var shadeClose=(opts.shadeClose=="false"||opts.shadeClose==false)?false:true;
      var title=opts.title;
      var confirmBtn=(opts.confirmBtn=="false"||opts.confirmBtn==false)?false:true;
      var confirmBtnText=opts.confirmBtnText;
      var cancelBtn=(opts.cancelBtn=="false"||opts.cancelBtn==false)?false:true;
      var cancelBtnText=opts.cancelBtnText;
      var confirmFn=opts.ok;
      var cancelFn=opts.cancel;
      var okDefaultFn=opts.okDefaultFn;
      var cancelDefaultFn=opts.cancelDefaultFn;
      //
      var msg_dom='';
      var d={
        a: '<div class="layer_wrap">',
        b:    '<div class="layer_shade"></div>',
        c:    '<div class="layer_inner">',
        d:        '<span class="layer_close">&times;</span>',
        e:        '<div class="layer_title">' + title + '</div>',
        f:        '<div class="layer_body">',
        g:            '<div class="layer_content">' + msg + '</div>',
        h:            '<div class="layer_btns">',
        i:                '<button class="layer_btn layer_confirm_btn">' + confirmBtnText + '</button>',
        j:                '<button class="layer_btn layer_cancel_btn">' + cancelBtnText + '</button>',
        ge:           '</div>',
        ee:       '</div>',
        be:   '</div>',
        ae: '</div>',
      }
      msg_dom+=d.a;
      msg_dom+=d.b;
      msg_dom+=d.c;
      msg_dom+=d.d;
      if(title && title !=='false'){
        msg_dom+=d.e;
      }
      msg_dom+=d.f;
      msg_dom+=d.g;
      msg_dom+=d.h;
      if(confirmBtn){
        msg_dom+=d.i;
      }
      if(cancelBtn){
        msg_dom+=d.j;
      }
      msg_dom+=d.ge;
      msg_dom+=d.ee;
      msg_dom+=d.be;
      msg_dom+=d.ae;
      $('body').append(msg_dom);
      $('.layer_wrap').fadeIn(fadeInTime);
      var margin_top=-$('.layer_wrap').height()/2;
      $('.layer_wrap').css({
        'margin-top':margin_top
      });
      $('html').css('overflow','hidden');
      //function close
      function layer_close(){
        $('.layer_wrap').fadeOut(fadeOutTime);
        $('html').css('overflow','auto');
        setTimeout(function(){
          $('.layer_wrap').remove();
        },fadeOutTime + delayTime);
      }
      //confirm condition
      function confirmCondition(){
        if(confirmFn){
          setTimeout(function(){
            confirmFn();
          },fadeOutTime + delayTime);
        }
        else if(okDefaultFn){
          setTimeout(function(){
            okDefaultFn();//点击确认的默认回调函数
          },fadeOutTime + delayTime);
        }
      }
      //cancel condition
      function cancelCondition(){
        if(cancelFn){
          setTimeout(function(){
            cancelFn();
          },fadeOutTime + delayTime);
        }
        else if(cancelDefaultFn){
          setTimeout(function(){
            cancelDefaultFn();//点击确认的默认回调函数
          },fadeOutTime + delayTime);
        }
      }
      //close btn
      $('.layer_close').click(function(){
        layer_close();
        cancelCondition();
      });
      //shadeClose
      if(shadeClose){
        $('.layer_shade').click(function(){
          layer_close();
          cancelCondition();
        });
      }
      //confirm fn
      $('.layer_confirm_btn').click(function(){
        layer_close();
        confirmCondition();
      });
      //cancel fn
      $('.layer_cancel_btn').click(function(){
        layer_close();
        cancelCondition();
      });
    },
    //confirm方法
    confirm:function(msg,options){
      var msg,options;
      var i=arguments.length;
      switch(i){
        case 0:
        msg='';
        break;
        case 1:
        if(typeof(arguments[0])=='object'){
          options=arguments[0];
          msg='';
        }
        break;
        case 2:
        for(var j in arguments){
          if(typeof(arguments[j])=='string'){
            msg=arguments[j];
          }
          else if(typeof(arguments[j])=='object'){
            options=arguments[j];
          }
        }
        break;
        default:
        msg='';
        options=null;
      }
      var opts = $.extend({},$.defaults.common,$.defaults.confirm,options);
      var that=this;
      var time=opts.time;
      var fadeInTime=opts.fadeInTime;
      var fadeOutTime=opts.fadeOutTime;
      var delayTime=opts.delayTime;
      var timingClosure=(opts.timingClosure=="false"||opts.timingClosure==false)?false:true;
      var shade=(opts.shade=="false"||opts.shade==false)?false:true;
      var shadeClose=(opts.shadeClose=="false"||opts.shadeClose==false)?false:true;
      var title=opts.title;
      var confirmBtn=(opts.confirmBtn=="false"||opts.confirmBtn==false)?false:true;
      var confirmBtnText=opts.confirmBtnText;
      var cancelBtn=(opts.cancelBtn=="false"||opts.cancelBtn==false)?false:true;
      var cancelBtnText=opts.cancelBtnText;
      var confirmFn=opts.ok;
      var cancelFn=opts.cancel;
      var okDefaultFn=opts.okDefaultFn;
      var cancelDefaultFn=opts.cancelDefaultFn;
      var params=opts.params;
      //
      var msg_dom='';
      var d={
        a: '<div class="layer_wrap">',
        b:    '<div class="layer_shade"></div>',
        c:    '<div class="layer_inner">',
        d:        '<span class="layer_close">&times;</span>',
        e:        '<div class="layer_title">' + title + '</div>',
        f:        '<div class="layer_body">',
        g:            '<div class="layer_content">' + msg + '</div>',
        h:            '<div class="layer_btns">',
        i:                '<button class="layer_btn layer_confirm_btn">' + confirmBtnText + '</button>',
        j:                '<button class="layer_btn layer_cancel_btn">' + cancelBtnText + '</button>',
        ge:           '</div>',
        ee:       '</div>',
        be:   '</div>',
        ae: '</div>',
      }
      msg_dom+=d.a;
      msg_dom+=d.b;
      msg_dom+=d.c;
      msg_dom+=d.d;
      if(title && title !=='false'){
        msg_dom+=d.e;
      }
      msg_dom+=d.f;
      msg_dom+=d.g;
      msg_dom+=d.h;
      if(confirmBtn){
        msg_dom+=d.i;
      }
      if(cancelBtn){
        msg_dom+=d.j;
      }
      msg_dom+=d.ge;
      msg_dom+=d.ee;
      msg_dom+=d.be;
      msg_dom+=d.ae;
      $('body').append(msg_dom);
      $('.layer_wrap').fadeIn(fadeInTime);
      var margin_top=-$('.layer_wrap').height()/2;
      $('.layer_wrap').css({
        'margin-top':margin_top
      });
      $('html').css('overflow','hidden');
      //function close
      function layer_close(){
        $('.layer_wrap').fadeOut(fadeOutTime);
        $('html').css('overflow','auto');
        setTimeout(function(){
          $('.layer_wrap').remove();
        },fadeOutTime + delayTime);
      }
      //confirm condition
      function confirmCondition(){
        if(confirmFn){
          setTimeout(function(){
            if(params){
              confirmFn(params);
            }
            else{
              confirmFn();
            }
          },fadeOutTime + delayTime);
        }
        else if(okDefaultFn){
          setTimeout(function(){
            okDefaultFn();//点击确认的默认回调函数
          },fadeOutTime + delayTime);
        }
      }
      //cancel condition
      function cancelCondition(){
        if(cancelFn){
          setTimeout(function(){
            cancelFn();
          },fadeOutTime + delayTime);
        }
        else if(cancelDefaultFn){
          setTimeout(function(){
            cancelDefaultFn();//点击确认的默认回调函数
          },fadeOutTime + delayTime);
        }
      }
      //close btn
      $('.layer_close').click(function(){
        layer_close();
        cancelCondition();
      });
      //shadeClose
      if(shadeClose){
        $('.layer_shade').click(function(){
          layer_close();
          cancelCondition();
        });
      }
      //confirm fn
      $('.layer_confirm_btn').click(function(){
        layer_close();
        confirmCondition();
      });
      //cancel fn
      $('.layer_cancel_btn').click(function(){
        layer_close();
        cancelCondition();
      });
    },
    //弹出层方法 lay
    lay:{
      //open方法
      open:function(options){
        var options;
        var opts = $.extend({},$.defaults.common,$.defaults.alert,options);
        var that=this;
        var time=opts.time;
        var fadeInTime=opts.fadeInTime;
        var fadeOutTime=opts.fadeOutTime;
        var delayTime=opts.delayTime;
        var timingClosure=(opts.timingClosure=="false"||opts.timingClosure==false)?false:true;
        var shade=(opts.shade=="false"||opts.shade==false)?false:true;
        var shadeClose=(opts.shadeClose=="false"||opts.shadeClose==false)?false:true;
        var title=opts.title;
        var msg_dom='';
        var content=opts.content;
        var area=opts.area;
        var winWidth=$(window).width();
        var winHeight=$(window).height();
        var layWidth=area[0];
        var layHeight=area[1];
        var closeIcon=(opts.closeIcon=="false"||opts.closeIcon==false)?false:true;
        if(parseInt(layWidth)>winWidth-70){
          layWidth=winWidth-70+'px';
        }
        if(parseInt(layHeight)>winHeight-70){
          layHeight=winHeight-70+'px';
        }
        var layBasicDom='<div class="layer_wrap_2 lay"><div class="layer_shade"></div></div>';
        if(!$('body').find('.layer_wrap_2').length){
          $('body').append(layBasicDom);
        }
        $('.layer_wrap_2').fadeIn(fadeInTime);
        content.addClass('lay-active-inner').wrap('<div class="lay_wrap lay-active"></div>').fadeIn(fadeInTime);
        if(layWidth){
          content.css({
            'width':layWidth
          });
        }
        if(layHeight){
          content.css({
            'height':layHeight
          });
        }
        if($('.lay-active').width()>winWidth-50){
          $('.lay-active-inner').width(winWidth-50);
        }
        if($('.lay-active').height()>winHeight-50){
          $('.lay-active-inner').height(winHeight-50);
        }
        var margin_top=-$('.lay-active').height()/2;
        var margin_left=-$('.lay-active').width()/2;
        $('.lay-active').css({
          'margin-top':margin_top,
          'margin-left':margin_left
        });
        if(closeIcon){
          $('.lay-active').append('<i class="layer_close">&times;</i>');
        }
        $('.lay-active-inner').css('max-height',winHeight-50);
        //close btn
        $('.layer_close').click(function(){
          $.lay.close();
        });
        //shadeClose
        if(shadeClose){
          $('.layer_shade').click($.lay.close);
        }
        $('html').css('overflow','hidden');
      } ,
      //close方法
      close:function(){
        $('.lay-active').hide();
        $('.lay-active-inner').unwrap().removeClass('lay-active-inner').hide();
        $('.layer_close').remove();
        $('.layer_wrap_2').hide();
        $('html').css('overflow','auto');
      }
    }
  });
  $.fn.extend({
    tip:function(msg){
      var that=$(this);
      that.focus();
      var tipDom='<div class="tip-wrap error">'+msg+'</div>';
      if(that.next('div').hasClass('tip-wrap')){
        that.next('div').show();
      }
      else{
        that.after(tipDom);
      }
      var tip=that.next('.tip-wrap');
      var offsetL=that.offset().left;
      var offsetT=that.offset().top;
      tip.offset({
        'top':offsetT+that.outerHeight()+8,
        'left':offsetL
      });
    },
    hideTip:function(){
      var that=$(this);
      if(that.next('div').hasClass('tip-wrap')){
        that.next('.tip-wrap').hide();
      }
    }
  });
})(jQuery);
