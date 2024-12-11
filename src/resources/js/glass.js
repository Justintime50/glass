// Custom app Javascript
import slugify from "@sindresorhus/slugify";

// slugifyField slugs the title field to create a url slug
export function slugifyField(textfield, slugField) {
    let textFieldValue = document.getElementById(textfield).value;
    let slug = slugify(textFieldValue, { customReplacements: [["'", ""]] });
    document.getElementById(slugField).value = slug;
}

// selectImage inserts the image name into the url field of the form once selected from a modal
export function selectImage(imageId, imageName) {
    document.getElementById("image_id").value = imageId;
    document.getElementById(
        "banner-image-preview"
    ).src = `${window.location.origin}/storage/images/posts/${imageName}`;
}
