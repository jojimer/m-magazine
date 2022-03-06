import barba from '../custom/barba';
import galleryPreview from '../custom/gallery/preview';
import singleGallery from '../custom/gallery/single';
import singleFieldReport from '../custom/field-report/single';
import lozad from '../custom/initLozad';

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
        if (notAdmin){
          barba.init();          
        }        
        else{
          lozad.init('.lozad').observe();
          lozad.init('.bg-lozad').observe();
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

    // Mobile Menu Toggle
    $(document).on('click','.menu-toggle, div.mobile-menu-bg, .responsive-navbar .nav-link, .nav-account a, input.search-submit',function(){
      $('.responsive-navbar-wrap').toggleClass('active-nav');
    })  
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
