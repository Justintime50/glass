import "bootstrap";

import slugify from "@sindresorhus/slugify";
import hljs from "highlight.js";
import pineapple from "pineapple-library/pineapple/dist/js/pineapple";

import * as glass from "./glass";

hljs.highlightAll();
window.slugify = slugify;
window.pineapple = pineapple;
window.app = glass;
