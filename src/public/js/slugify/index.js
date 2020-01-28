// Slugify a string.
const slugify = (text) => {
    // Setup our slug rules
    return text.toString().toLowerCase()    // Make the text lowercase and a string
    .replace(/\s+/g, '-')                   // Replace spaces with "-"
    .replace(/[^\w-]+/g, '')                // Remove all non-word chars
    .replace(/--+/g, '-')                   // Replace multiple "-" with single "-"
    .replace(/^-+/, '')                     // Trim "-" from start of text
    .replace(/-+$/, '')                     // Trim "-" from end of text
    .replace(/[\s_-]+/g, '-');
}

/* TODO: Add in options to pass with slug
options = {
    separator: '-',
    lowercase: true,
};

if (options.lowercase) {
    string = text.toLowerCase();
    patternSlug = /[^a-z\d]+/g;
}
*/

// Whenever the $textfield field changes, slugify the $slugfield
var $;
var $slug;
// eslint-disable-next-line no-unused-vars
const slugifyField = (textfield, slugfield) => {
    $(textfield).keyup(function() {
        $slug = slugify($(this).val());
        $(slugfield).val($slug);
    }
)}
