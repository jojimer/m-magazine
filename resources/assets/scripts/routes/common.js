import barba from '@barba/core';
import gsap from 'gsap';

export default {
  init() {
    // JavaScript to be fired on all pages
    const mainpage = {
            'home' : 0,
            'news' : 1,
            'galleries' : 2,
            'shop' : 3,
            'field-report' : 4,
          };

    let nav = $('.banner .navbar-nav li');

    barba.init({
      transitions: [
        {
          name: 'basic',
          leave: function (data) {
            gsap.to(data.current.container, 1, {opacity: 0});
            const namespace = data.current.namespace;
            const nextpage = (data.next.url.path !== '/') ? data.next.url.path.replace('/','') : 'home';
            let prev = nav[mainpage[namespace]];
            let next = nav[mainpage[nextpage]];
            let nextToActive = (mainpage[nextpage] > 0)? mainpage[nextpage]-1 : mainpage[nextpage];
            $('body').removeClass(data.current.container);
            $(nav).removeClass('second-to-active active');
            if(nextToActive > -1) $(nav[nextToActive]).addClass('second-to-active');
            $(prev).removeClass('active');
            $(next).addClass('active');
          },
          enter: function (data) {
            gsap.from(data.next.container, 1, {opacity: 0});
            let classes = data.next.container.dataset.bodyClass;
            $('body').attr('class', classes);
            $('a.single-previous-url').attr('href',data.current.url.href);
            console.log(data.current.url.href);
          },
        },
      ],
  });

  let initialPage = $('div#dynamic-container').data('barba-namespace');
  initialPage = (initialPage == 'gallery') ? 'galleries' : initialPage;
  let next = nav[mainpage[initialPage]];
  let indexOfBeforeActive = mainpage[initialPage];
  let nextToActive = (indexOfBeforeActive > 0)? indexOfBeforeActive-1 : indexOfBeforeActive;
  if(nextToActive > -1) $(nav[nextToActive]).addClass('second-to-active');
  $(next).addClass('active');


  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
