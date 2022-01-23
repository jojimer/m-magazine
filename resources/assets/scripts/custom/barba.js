// barba.js
import barba from '@barba/core';
import gsap from 'gsap';
import ajaxContentLoader from './ajax-content-loader';
import lozad from 'lozad';

export default {
  init() {
    // JavaScript to be fired on all pages
    const mainpage = {
            'home' : 0,
            'news' : 1,
            'galleries' : 2,
            'shop' : 3,
            'field-reports' : 4,
            'page' : 5,
          };

    //Initialize Lozad
    let initLozad = function(classSelector) {
      //Observe selected img element
      return lozad(classSelector, {
        rootMargin: '500px 0px',
        threshold: 0.1,
        load: function(el) {          
          if(classSelector === '.lozad'){
            el.src = el.dataset.src;
            el.classList.remove('lozad');
          }else{
            el.style.backgroundImage = 'url('+el.dataset.src+')';
            setTimeout(function(){
              el.classList.remove('bg-lozad');
            },500)
          }          
        },
      });
    }

    let loadImage = function() {
      initLozad('.lozad').observe();
      initLozad('.bg-lozad').observe();
    }

    const updatePageContent = function(namespace){
      $('#dynamic-container').append(window.contentUpdate.content[namespace]);
      loadImage();
    }

    // Get top navigation menu selector
    let nav = $('.banner .navbar-nav li');

    // Instanciate Ajax Content Loader
    let contentLoader = ajaxContentLoader.init(loadImage);

    // Find Excluded ID
    const excludeID = function(namespace) {
      let excluder = $('#dynamic-container[data-barba-namespace='+namespace+'] div[data-post-id]');
      let excluding = '';
      let exclude;
      for(let i=0; i<excluder.length;i++){
        exclude = $(excluder[i]).data('post-id');
        if(exclude !== $(excluder[i-1]).data('post-id')){
          excluding += (i === 0) ? exclude : ','+ exclude;
        }        
      }
      window.contentUpdate.exclude[namespace] = excluding;
    }

    // Set global variables
    window.contentUpdate = {
      'content' : {
        'home' : 0,
        'news' : 0,
        'galleries': 0,
        'shop' : 0,
        'field-reports' : 0,
      },
      'exclude' : {
        'home' : 0,
        'news' : 0,
        'galleries': 0,
        'shop' : 0,
        'field-reports' : 0,
      },
    };

    barba.init({
      transitions: [
        {
          name: 'basic',
          once: function (data){
              let initialPage = data.next.namespace;
              if(mainpage[initialPage] < 5){
                let next = nav[mainpage[initialPage]];
                let indexOfBeforeActive = mainpage[initialPage];

                // Add new active and before active button to top menu button
                let nextToActive = (indexOfBeforeActive > 0)? indexOfBeforeActive-1 : indexOfBeforeActive;
                if(nextToActive > -1) $(nav[nextToActive]).addClass('second-to-active');
                $(next).addClass('active');

                // Add scroll event to window if page is in the main menu
                if(mainpage[initialPage] || $('body').hasClass('home') && !$('body').hasClass('single')){
                    window.addEventListener('scroll', contentLoader, true);
                }
                excludeID(initialPage);
              }
              let currentUser = data.next.container.dataset.isUserloggedin;
              let classes = data.next.container.dataset.bodyClass;
              classes += (data.next.url.path === '/profile/'+currentUser) ? ' self-profile' : '';
              $('body').attr('class', classes);
              $('a.single-previous-url').attr('href',data.current.url.href);
              if($('body').hasClass('home')) window.contentUpdate.content[initialPage] = $('#dynamic-container').html();
              loadImage();
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
            if(mainpage[nextpage] < 5) $(next).addClass('active');

            window.removeEventListener('scroll', contentLoader, true);
          },
          beforeEnter: function (data) {
            let classes = data.next.container.dataset.bodyClass;
            let currentUser = data.next.container.dataset.isUserloggedin;
            let nextpage = data.next.namespace;
            classes += (data.next.url.path === '/profile/'+currentUser) ? ' self-profile' : '';
            $('body').attr('class', classes);
            $('a.single-previous-url').attr('href',data.current.url.href);
            $('div.single-close').removeClass('d-none');

            //Add scroll event to window if page is in the main menu
            if(mainpage[nextpage] || $('body').hasClass('home') && !$('body').hasClass('single')){
                window.addEventListener('scroll', contentLoader, true);   
            }
          },
          enter: function (data) {
            let processPage = function(callback){ 
              const namespace = data.next.namespace;
              if(mainpage[namespace] !== 0 && mainpage[namespace] < 5 && !$('body').hasClass('single')){
                if(window.contentUpdate.content[namespace].length > 0) {                
                  setTimeout(function(){
                    updatePageContent(namespace);
                    $('#loading-content').appendTo($('#dynamic-container[data-barba-namespace='+namespace+']'));
                  },500)
                }else if(!$('main.main').hasClass(namespace+'-event-active') && !$('main.main').hasClass(namespace+'-ended')){
                  excludeID(namespace);           
                }  
              }else if($('body').hasClass('home') && window.contentUpdate.content[namespace] !== 0){
                $('#top-feed').addClass('hide-dynamic-container');
                setTimeout(function(){
                  updatePageContent(namespace);
                  $('#top-feed').removeClass('hide-dynamic-container');
                  console.log('Home page updating content');
                },500)
              }

              return callback();
            }
            processPage(loadImage);
            gsap.from(data.next.container, 2, {opacity: 0});
          },
        },
      ],
  });

  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
