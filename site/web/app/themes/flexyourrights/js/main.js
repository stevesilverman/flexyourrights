// modified http://paulirish.com/2009/markup-based-unobtrusive-comprehensive-dom-ready-execution/
// only fires on body class, not body class + id (working off strictly wordpress body_class)

FlexYourRights = {
  // all pages
  common: {
    init: function(){
      $('<select />').appendTo('#nav-main');
      $('<option />', {
        'selected': 'selected',
        'value'   : '',
        'text'    : 'Go to...'
      }).appendTo('#nav-main select');
      $('#nav-main a').each(function() {
        var el = $(this);
        $('<option />', {
          'value'   : el.attr('href'),
          'text'    : el.text()
        }).appendTo('#nav-main select');
      });
      $('#nav-main select').change(function() {
        window.location = $(this).find('option:selected').val();
      });

      $('#main').fitVids({customSelector: "iframe[src^='http://www.youtube.com']"});

      $('#content-info #input_3_2').focus(function() {
        if (!$(this).data('Email address')) {
          $(this).data('mail address', $(this).val());
        }
        if ($(this).val() == $(this).data('mail address')) {
          $(this).val('');
        }
      }).blur(function(){
        if ($(this).val() == '') {
          $(this).val($(this).data('mail address'));
        }
      });

      if (navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i)) {
        var viewportmeta = document.querySelector('meta[name="viewport"]');
        if (viewportmeta) {
          viewportmeta.content = 'width=device-width, minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0';
          document.body.addEventListener('gesturestart', function () {
            viewportmeta.content = 'width=device-width, minimum-scale=0.25, maximum-scale=1.6';
          }, false);
        }
      }

    },
    finalize: function(){ }
  },
  // ! Home page
  home: {
    init: function(){
      $('#content-slider').flexslider({'directionNav' : false});
    }
  },
  // ! Contact page
  contact: {
    init: function(){


    }
  },
}

UTIL = {
  fire : function(func,funcname, args){
    var namespace = FlexYourRights;  // indicate your obj literal namespace here
    funcname = (funcname === undefined) ? 'init' : funcname;
    if (func !== '' && namespace[func] && typeof namespace[func][funcname] == 'function'){
      namespace[func][funcname](args);
    }
  },
  loadEvents : function(){

    // hit up common first.
    UTIL.fire('common');

    // do all the classes too.
    $.each(document.body.className.split(/\s+/),function(i,classnm){
      UTIL.fire(classnm);
    });

    UTIL.fire('common','finalize');
  }
};

// kick it all off here
$(document).ready(UTIL.loadEvents);