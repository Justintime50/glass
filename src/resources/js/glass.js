// Custom app Javascript
import slugify from "@sindresorhus/slugify";

// slugifyField slugs the title field to create a url slug
export function slugifyField(textfield, slugField) {
    let textFieldValue = document.getElementById(textfield).value;
    let slug = slugify(textFieldValue, { customReplacements: [["'", ""]] });
    document.getElementById(slugField).value = slug;
}

// selectImage inserts the image name into the url field of the form once selected from a modal
export function selectImage(imageId, path) {
    document.getElementById("image_id").value = imageId;
    document.getElementById("banner-image-preview").src = path;
}

// Show a prompt to update the category name and replace it in the form as we submit it
export function updateCategory(id) {
    const newCategoryName = prompt("Enter a new category name:");

    if (newCategoryName != null) {
        document.getElementById(`newCategoryName${id}`).value = newCategoryName;
        document.getElementById(`updateCategory${id}`).submit();
    }
}
