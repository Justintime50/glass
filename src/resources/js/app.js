try {
    // The Bootstrap Javascript library
    require("bootstrap");
    require("@popperjs/core");
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require("axios");

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * Place custom Node Modules below
 */
window.hljs = require("highlight.js");
window.slugify = require("@sindresorhus/slugify");
window.pineapple = require("pineapple-library/pineapple/dist/js/pineapple");

// Custom app Javascript
window.app = require("./glass");
