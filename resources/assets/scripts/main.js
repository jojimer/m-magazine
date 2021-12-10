// import external dependencies
import 'jquery';

// import then needed Font Awesome functionality
import { library, dom } from '@fortawesome/fontawesome-svg-core';

// import solid fontawesome
import { faFireAlt, faCircleNotch, faExpandAlt, faHeart, faUserPlus, faAt, faKey, faSignInAlt, faSignOutAlt, faEye, faHashtag, faSearch, faBookmark as fasBookmark, faExternalLinkAlt, faArrowLeft, faArrowRight } from '@fortawesome/free-solid-svg-icons';

// import regular fontawesome
import { faBell, faCommentAlt, faSquare, faUser, faCheckSquare, faComments, faBookmark as farBookmark, faTimesCircle } from '@fortawesome/free-regular-svg-icons';

// add the imported icons to the library
library.add(faBell, faCircleNotch, faUserPlus, faKey, faAt, faExpandAlt, faCommentAlt, faSignInAlt, faSignOutAlt, faUser, faFireAlt, faSquare, faCheckSquare, faComments, fasBookmark, faExternalLinkAlt, farBookmark, faHeart, faEye, faHashtag, faSearch, faTimesCircle, faArrowLeft, faArrowRight);

// tell FontAwesome to watch the DOM and add the SVGs when it detects icon markup
dom.watch();

// Import everything from autoload
import './autoload/**/*'

// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';
import aboutUs from './routes/about';

/** Populate Router instance with DOM routes */
const routes = new Router({
  // All pages
  common,
  // Home page
  home,
  // About Us page, note the change from about-us to aboutUs.
  aboutUs,
});

// Load Events
jQuery(document).ready(() => {
  routes.loadEvents();
});
