// barba.js
import barba from '@barba/core';
import gsap from 'gsap';
import ajaxContentLoader from './ajax-content-loader';

export default {
  init() {
    // JavaScript to be fired on all pages
    const mainpage = {
            'home' : 0,
            'news' : 1,
            'galleries' : 2,
            'shop' : 3,
            'field-reports' : 4,
          };

    // Get top navigation menu selector
    let nav = $('.banner .navbar-nav li');

    // Instanciate Ajax Content Loader
    let contentLoader = ajaxContentLoader.init();

    // Get Barba Dynamic Container
    let dynamicContainer = $('#dynamic-container');

    // Set global variables
    window.contentUpdate = {
      'content' : {
        'news' : 0,
        'galleries': 0,
        'shop' : 0,
        'field-reports' : 0,
      },
      'pageSkipped' : {
        'news' : dynamicContainer.data('news-numbers'),
        'galleries': dynamicContainer.data('galleries-numbers'),
        'shop' : dynamicContainer.data('shop-numbers'),
        'field-reports' : dynamicContainer.data('field-reports-numbers'),
      },
    };

    barba.init({
      transitions: [
        {
          name: 'basic',
          once: function (data){
              let initialPage = data.next.namespace;
              let next = nav[mainpage[initialPage]];
              let indexOfBeforeActive = mainpage[initialPage];

              // Add new active and before active button to top menu button
              let nextToActive = (indexOfBeforeActive > 0)? indexOfBeforeActive-1 : indexOfBeforeActive;
              if(nextToActive > -1) $(nav[nextToActive]).addClass('second-to-active');
              $(next).addClass('active');

              // Add scroll event to window if page is in the main menu
              if(mainpage[initialPage] && !$('body').hasClass('single')){
                  window.addEventListener('scroll', contentLoader, true);
              }
          },
          beforeLeave: function () {
            // Remove Lightbox if open
            $('html').css('overflow', 'auto');
          },
          leave: function (data) {
            // Run GSAP Animation
            gsap.to(data.current.container, 1, {opacity: 0});

            // Find and set new active and before active top navigation menu
            const namespace = data.current.namespace;
            const nextpage = (data.next.url.path !== '/') ? data.next.url.path.replace('/','') : 'home';
            let prev = nav[mainpage[namespace]];
            let next = nav[mainpage[nextpage]];
            let nextToActive = (mainpage[nextpage] > 0)? mainpage[nextpage]-1 : mainpage[nextpage];
            
            // Remove Current Page Class to html body tag
            $('body').removeClass(data.current.container);
            $(nav).removeClass('second-to-active active');

            // Remove current active and add new active and before active button to top menu button
            if(nextToActive > -1) $(nav[nextToActive]).addClass('second-to-active');
            $(prev).removeClass('active');
            $(next).addClass('active');

            window.removeEventListener('scroll', contentLoader, true);
          },
          beforeEnter: function (data) {
            let classes = data.next.container.dataset.bodyClass;
            let nextpage = data.next.namespace;
            $('body').attr('class', classes);
            $('a.single-previous-url').attr('href',data.current.url.href);
            $('div.single-close').removeClass('d-none');

            //Add scroll event to window if page is in the main menu
            if(mainpage[nextpage] && !$('body').hasClass('single')){
                window.addEventListener('scroll', contentLoader, true);   
            }
          },
          enter: function (data) {
            const namespace = data.next.namespace;
            if(mainpage[namespace] !== 0 && !$('body').hasClass('single')){
              if(window.contentUpdate.content[namespace].length > 0) {
                setTimeout(function(){
                  $('#dynamic-container').append(window.contentUpdate.content[namespace]);
                  $('#dynamic-container').attr('data-'+namespace+'-numbers',window.contentUpdate.pageSkipped[namespace]);
                  $('#loading-content').appendTo($('#dynamic-container[data-barba-namespace='+namespace+']'));
                },500)
              }
            }
            gsap.from(data.next.container, 1, {opacity: 0});        
          },
        },
      ],
  });

  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
