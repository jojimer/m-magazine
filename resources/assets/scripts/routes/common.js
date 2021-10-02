import barba from '../custom/barba';

export default {
  init() {
    // JavaScript to be fired on all pages
    $.post(ajax_object.ajax_url, {action: 'is_user_admin'}, function (notAdmin) {
      if (notAdmin) barba.init();
    });
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
