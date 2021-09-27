import myBarba from '../custom/barba';

export default {
  init() {
    // JavaScript to be fired on all pages
    myBarba.init();
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
