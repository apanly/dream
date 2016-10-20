;
var msgs = {
  defaults:{
    common:{//tip与confirm的通用配置信息
      time:2000,
      fadeInTime:400,
      fadeOutTime:700,
    },
    tip:{//tip的配置信息
      timingClosure:true,
      position:'middle',
      shade:false,
    },
    confirm:{//confirm的默认配置信息
      timingClosure:false,
      shade:true,
      shadeClose:false,
      confirmBtnText:'确定',
      cancelBtnText:'取消'
    }
  },
  //tip方法
  tip:function(msg,options,fn){
    if(typeof(arguments[0])!='string'){
      msg='请输入提示信息';
    }
    for(var i in arguments){
      if(typeof(arguments[i])=='object'){
        options=arguments[i];
      }
      else if(typeof(arguments[i])=='function'){
        fn=arguments[i];
      }
    }
    var msgs=this;
    var opts = $.extend({},msgs.defaults.common,msgs.defaults.tip,options);
    var timingClosure=(opts.timingClosure=="false"||opts.timingClosure==false)?false:true;
    var time=opts.time;
    var fadeInTime=opts.fadeInTime;
    var fadeOutTime=opts.fadeOutTime;
    var position=opts.position;
    var shade=(opts.shade=="false"||opts.shade==false)?false:true;
    if($('.msgs_tip_wrap').length){
      $('.msgs_tip_wrap').remove();
    }
    function closeMsgs(){
      $('.msgs_tip_wrap').remove();
      if(fn){
        fn();
      }
    }
    $('body').append('<div class="msgs_tip_wrap"><span class="msgs_tip">'+msg+'</span></div>');
    if(shade){
      $('.msgs_tip_wrap').append('<div class="msgs_shade"></div>');
    }
    switch (position) {
      case 'top':
        $('.msgs_tip_wrap').css({
          'top':'15px'
        });
        break;
      case 'middle':
        $('.msgs_tip_wrap').css({
          'top':'50%',
          'margin-top':-$('.msgs_tip_wrap').height()/2
        });
        break;
      default:
      $('.msgs_tip_wrap').css({
        'bottom':'15px'
      });
    }
    $('.msgs_tip_wrap').stop().fadeIn(fadeInTime);
    if(timingClosure){
      setTimeout(function(){
        $('.msgs_tip_wrap').stop().fadeOut(fadeOutTime);
      },time);
      setTimeout(closeMsgs,time+fadeInTime+fadeOutTime);
    };
  },
  //confirm方法
  confirm:function(msg,options,confirmFn,cancelFn){
    if(typeof(arguments[0])=='function'){
      confirmFn=arguments[0];
      msg='';
      if(arguments.length==2){
        cancelFn=arguments[1];
      }
    }
    if(arguments.length>2){
      for(var i=0;i<arguments.length;i++){
        if(typeof(arguments[i])=='object'){
          options=arguments[i];
          console.log(options);
        }
      }
      for(var i=0;i<arguments.length;i++){
        if(typeof(arguments[i])=='function' && typeof(arguments[i-1])=='function'){
          confirmFn=arguments[i-1];
          cancelFn=arguments[i];
        }
        else if(typeof(arguments[i])=='function' && typeof(arguments[i-1])!='function'){
          confirmFn=arguments[i];
        }
      }
    }
    var msg=msg;
    var confirm=this;
    var opts = $.extend({},msgs.defaults.common,msgs.defaults.confirm,options);
    var confirmBtnText=opts.confirmBtnText;
    var cancelBtnText=opts.cancelBtnText;
    var shade=opts.shade;
    var shadeClose=(opts.shadeClose=="false"||opts.shadeClose==false)?false:true;
    var timingClosure=(opts.timingClosure=="false"||opts.timingClosure==false)?false:true;
    var time=opts.time;
    var fadeInTime=opts.fadeInTime;
    var fadeOutTime=opts.fadeOutTime;
    var timer=null;
    if($('.msgs_confirm_wrap').length){
      $('.msgs_confirm_wrap').remove();
    }
    $('body').append('<div class="msgs_confirm_wrap"><div class="msgs_confirm"><div class="msgs_confirm_msg">'+msg+'</div><button class="msgs_btn msgs_btn_confirm">'+confirmBtnText+'</button><button class="msgs_btn msgs_btn_cancel">'+cancelBtnText+'</button></div></div>');
    $('.msgs_confirm_wrap').stop().fadeIn(fadeInTime);
    if(shade){
      $('.msgs_confirm_wrap').append('<div class="msgs_shade"></div>');
    }
    function closeMsgs(){
      $('.msgs_confirm_wrap').stop().fadeOut(fadeOutTime);
      setTimeout(function(){
        $('.msgs_confirm_wrap').remove();
      },fadeOutTime);
    }
      //confirm fn
    $('.msgs_btn_confirm').click(function(){
      closeMsgs();
      if(confirmFn){
        confirmFn();
      }
    });
    //cancel fn
    $('.msgs_btn_cancel').click(function(){
      closeMsgs();
      if(cancelFn){
        cancelFn();
      }
    });
    //timimg closure
    if(timingClosure){
      timer=setTimeout(function(){
        closeMsgs();
        if(confirmFn){
          confirmFn();
        }
      },time);
      $('.msgs_btn_cancel').click(function(){
        clearTimeout(timer);
      });
    }
    //shade close
    if(shadeClose){
      $('.msgs_shade').click(closeMsgs);
    }
  }
}
