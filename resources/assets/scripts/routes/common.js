import barba from '../custom/barba';
import galleryPreview from '../custom/gallery/preview';
import singleGallery from '../custom/gallery/single';

export default {
  contentInit() {
    // Load Gallery Preview JS
    galleryPreview.init()

    // Load Single Gallery JS
    singleGallery.init()
  },
  init() {
    // JavaScript to be fired on all pages
    $.post(ajax_object.ajax_url, {action: 'is_user_admin'}, function (notAdmin) {
      if (notAdmin) barba.init();
    });

    this.contentInit()
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
