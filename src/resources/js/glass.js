// Custom app Javascript

// slugifyField slugs the title field to create a url slug
// `slugify` imported via "@sindresorhus/slugify"
export function slugifyField(textfield, slugField) {
    let textFieldValue = document.getElementById(textfield).value;
    let slug = slugify(textFieldValue, { customReplacements: [["'", ""]] });
    document.getElementById(slugField).value = slug;
}
