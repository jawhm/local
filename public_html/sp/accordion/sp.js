$(function(){
  //アイコン追加
  $('h2.sec-title').wrapInner('<em></em>');
  $('h2.sec-title').prepend('<span>+-</span>');
  $('td.nittei_span').append('<span>▼</span>');
  
  //SP用CSS
  $('.wh_box').css('overflow','hidden');
  $('h2.sec-title').css({
    'position':'relative',
    'padding-right':'25px',
    'margin-bottom':'20px'
  });
  $('h2.sec-title span').css({
    'display':'block',
    'position':'absolute',
    'top':'50%',
    'left':'10px',
    'margin-top':'-4px',
    'width':'20px',
    'height':'0',
    'padding-top':'20px',
    'overflow':'hidden'
  });
  $('td.nittei_span span').css({
    'display':'block',
    'position':'absolute',
    'top':'50%',
    'right':'5px',
    'margin-top':'-10px',
    'width':'21px',
    'height':'0',
    'padding-top':'21px',
    'overflow':'hidden'
  });
  
  var chBlock = $('table.nittei,table.nittei tbody,table.nittei tr,table.nittei td.nittei_span,table.nittei td.nittei_naiyou');
  $(chBlock).css({
    'display':'block',
    'width':'auto'
  });
  $('table.nittei tr').css({
    'margin-bottom':'15px'
  });
  $('table.nittei td.nittei_span').css({
    'padding':'10px',
    'border-bottom':'none',
    'position':'relative'
  });
  $('table.nittei td.nittei_naiyou').css({
    'border':'1px solid orange',
    'padding-bottom':'15px',
    'display':'none'
  });
  $('div.nittei_setumei').css({
    'margin-bottom':'15px'
  });
  
  
  //h2〜h2間をdivで囲う
  var tgt = $('h2.sec-title');
  var ex = $('.wh_box,.advbox03,.linkbox,style');
  $(tgt).each(function(){
    $(this).nextUntil(tgt).not(ex).wrapAll('<div class="acd"></div>');
    $('.acd').hide();
    $('.acd').css({
      'margin-bottom':'20px'
    });
  });
  
  //閉じるボタン
  /*$('.acd,table.nittei td.nittei_naiyou').append('<button type="button" class="btnClose">閉じる</button>');
  $('button.btnClose').css({
    'display':'block',
    'margin':'0 auto',
    'padding':'5px 0',
    'width':'40%',
    'background-color':'#D7D7D7',
    'border-radius':'5px',
    'border':'1px solid #989898',
    'font-size':'100%',
    'color':'#646464',
    'letter-spacing':'2px',
  });*/
    
  //アコーディオン化
  $(tgt).live('click',function(){
    $(this).children('span').toggleClass('open');
    $(this).next('.acd').slideToggle('fast',function(){
     myScroll.refresh();
    });
  });
  
  $('table.nittei td.nittei_span').live('click',function(){
    $(this).children('span').toggleClass('open');
    $(this).next('table.nittei td.nittei_naiyou').slideToggle('fast',function(){
      myScroll.refresh();
    });
  });
  
  //閉じるボタン
  /*$('button.btnClose').live('click',function(){
    //h2
    $(this).parent('.acd').prev(tgt).children('span').removeClass('open');
    //var parentTgt = $(this).parent('.acd').prev('h2.sec-title').offset().top;
    $(this).parent('.acd').slideUp('fast',function(){
       myScroll.refresh();
    });
    //$('#contentsbox').animate({ scrollTop: 0 }, 'fast');
    //return false;
    
    //table
    $(this).parent('.nittei_naiyou').prev('.nittei_span').children('span').removeClass('open');
    $(this).parent('table.nittei td.nittei_naiyou').slideUp('fast',function(){
       myScroll.refresh();
    });
  });*/
});
