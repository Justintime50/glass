import "bootstrap";

import hljs from "highlight.js";
import pineapple from "pineapple-library/pineapple/dist/js/pineapple";

import * as glass from "./glass";

hljs.highlightAll();
window.pineapple = pineapple;
window.app = glass;
