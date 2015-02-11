/*
 * jQuery fixedUI plugin
 *
 * Copyright(C) 2007 LEARNING RESOURCE LAB.
 * http://developmentor.lrlab.to/postal/
 *
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 */
(function($) {

// $.fixedUI
$.fixedUI = function(expr) {

  var container = $('#fixedUI');
  if (container.length == 0) {
    container = $('<div />')
      .attr('id', 'fixedUI')
      .css({
        display: 'none',
        width: '100%',
        left: 0,
        bottom: 0,
        zIndex: 1024,
        position: 'fixed'
      });

    var body = $('body', document)
      .append(container);

    if ($.browser.msie) {
      var version = navigator.userAgent.match(/MSIE ([\d.]+)/)[1];
      if (!$.boxModel || version < 7.0) {

        container
          .css('position', 'absolute')
          .each(function() {
              this.setExpression('', 'this.style.filter=""');
              this.style.setExpression('width',
                'document.documentElement.clientWidth || ' +
                'document.body.clientWidth'
              );
            });

        if (body.css('backgroundImage') == 'none')  
          body.css('backgroundImage', 'url(#fixedUI)');
        body.css('backgroundAttachment', 'fixed');
      }
    }
  }

  var element = $(expr, container);
  if (element.length == 0)
    element = $(expr)
      .appendTo(container);
  element
    .addClass('fixedUI')
    .show();

  container.slideDown();
};

// $.unfixedUI
$.unfixedUI = function() {

  $('#fixedUI').slideUp(function() {
    $('.fixedUI', this).hide();
  });
};

// $.fixedUI.impl
$.fixedUI.impl = {
};

})(jQuery); // function($)
