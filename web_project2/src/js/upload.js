function previewFile(element) {

    var file = element.files[0];
    var url = getObjectURL(file);
    var img = document.getElementById('preview');
    img.alt = file.name;
    img.src = url;

}

function getObjectURL(file) {
    var url = null;
    if (window.createObjectURL != undefined) { // basic
        url = window.createObjectURL(file);
    } else if (window.URL != undefined) { // mozilla(firefox)
        url = window.URL.createObjectURL(file);
    } else if (window.webkitURL != undefined) { // webkit or chrome
        url = window.webkitURL.createObjectURL(file);
    }
    return url;
}
