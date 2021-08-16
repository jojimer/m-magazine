// import external dependencies
import 'jquery';

// import then needed Font Awesome functionality
import { library, dom } from '@fortawesome/fontawesome-svg-core';

// import solid fontawesome
import { faFireAlt, faHeart, faEye, faHashtag, faSearch } from '@fortawesome/free-solid-svg-icons';

// import regular fontawesome
import { faBell, faCommentAlt, faSquare, faCheckSquare, faComments } from '@fortawesome/free-regular-svg-icons';

// add the imported icons to the library
library.add(faBell, faCommentAlt, faFireAlt, faSquare, faCheckSquare, faComments, faHeart, faEye, faHashtag, faSearch);

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
jQuery(document).ready(() => routes.loadEvents());
