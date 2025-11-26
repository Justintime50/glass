import "bootstrap-icons/font/bootstrap-icons.css";
import "trix";
import "trix/dist/trix.css";

import * as bootstrap from "bootstrap/dist/js/bootstrap.bundle";
import hljs from "highlight.js";
import pineapple from "pineapple-library/pineapple/dist/js/pineapple";
import { renderTrixContent } from "trix-tools";

import * as glass from "./glass";

window.bootstrap = bootstrap;
window.pineapple = pineapple;
window.app = glass;

// Re-render Trix content to include image links, code blocks, embeddables, and other enhancements
const trixContent = document.getElementById("trix-content");
if (trixContent) {
    trixContent.innerHTML = renderTrixContent(trixContent.innerHTML);
}

// Must be called after content is loaded to highlight code blocks
hljs.highlightAll();
