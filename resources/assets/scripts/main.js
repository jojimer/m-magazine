// import external dependencies
import 'jquery';

// import then needed Font Awesome functionality
import { library, dom } from '@fortawesome/fontawesome-svg-core';

// import solid fontawesome
import { faFireAlt, faList, faGripLines, faCloudUploadAlt, faCheckCircle, faExclamationCircle, faPlus, faCircleNotch, faPlane, faCubes, faThList, faTh, faUpload, faEyeSlash as fasEyeSlash, faEnvelope as fasEnvelope, faInfoCircle, faComments as fasComments, faCamera, faPencilAlt, faExpandAlt, faLock, faAsterisk, faUser as fasUser, faHeart, faUserPlus, faAt, faKey, faSignInAlt, faSignOutAlt, faEye, faHashtag, faSearch, faBookmark as fasBookmark, faExternalLinkAlt, faArrowLeft, faArrowRight } from '@fortawesome/free-solid-svg-icons';

// import regular fontawesome
import { faBell, faCommentAlt, faSquare, faEyeSlash as farEyeSlash, faEnvelope as farEnvelope, faUser as farUser, faCheckSquare, faComments as farComments, faBookmark as farBookmark, faTimesCircle } from '@fortawesome/free-regular-svg-icons';

// add the imported icons to the library
library.add(faBell, faList, faGripLines, faCloudUploadAlt, faCheckCircle, faExclamationCircle, faPlus, faCircleNotch, faUpload, faPlane, faCubes, faThList, faTh, fasEyeSlash, farEyeSlash, fasComments,fasEnvelope, farEnvelope, faInfoCircle, faPencilAlt, faCamera, faUserPlus, faLock, faAsterisk, faKey, fasUser, faAt, faExpandAlt, faCommentAlt, faSignInAlt, faSignOutAlt, farUser, faFireAlt, faSquare, faCheckSquare, farComments, fasBookmark, faExternalLinkAlt, farBookmark, faHeart, faEye, faHashtag, faSearch, faTimesCircle, faArrowLeft, faArrowRight);

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
