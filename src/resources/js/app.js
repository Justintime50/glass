import "bootstrap";

import slugify from "@sindresorhus/slugify";
import axios from "axios";
import hljs from "highlight.js";
import pineapple from "pineapple-library/pineapple/dist/js/pineapple";

import * as glass from "./glass";

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
window.axios = axios;
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

hljs.highlightAll();
window.slugify = slugify;
window.pineapple = pineapple;
window.app = glass;
