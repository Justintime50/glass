import "bootstrap-icons/font/bootstrap-icons.css";

import * as bootstrap from "bootstrap/dist/js/bootstrap.bundle";
import hljs from "highlight.js";
import pineapple from "pineapple-library/pineapple/dist/js/pineapple";

import * as glass from "./glass";

window.bootstrap = bootstrap;
hljs.highlightAll();
window.pineapple = pineapple;
window.app = glass;
