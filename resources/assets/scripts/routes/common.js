import barba from '../custom/barba';
import galleryPreview from '../custom/gallery/preview';
import singleGallery from '../custom/gallery/single';
import singleFieldReport from '../custom/field-report/single';

export default {
  contentInit() {
    // Load Gallery Preview JS
    galleryPreview.init()

    // Load Single Gallery JS
    singleGallery.init()

    // Load Single Field Report JS
    singleFieldReport.init()
  },
  init() {
    // JavaScript to be fired on all pages
    $.post(ajax_object.ajax_url, {action: 'is_user_admin'}, function (notAdmin) {
      if (notAdmin) {
        barba.init();
        let href = document.querySelector('#wpadminbar #wp-admin-bar-logout a').href;
        $('#logout-trigger a').attr('href',href);
      }else{
        setTimeout(function(){
          $('body').attr('style', 'margin-top: 0;');
          $('#wpadminbar').attr('style', 'display:block');
        },250)
      }
    });

    this.contentInit()

    // Show Login / Register
    $(document).on('click','.account-icon',function(){
      $('.nav-account').toggleClass('d-none');
    })
    // Hide Login / Register on mouse leave
    $(document).on('mouseleave','.nav-account',function(){
      $(this).toggleClass('d-none');
    })
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
