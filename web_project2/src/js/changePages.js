window.onload = showSpecificImages();

function changePage(elementClicked) {
    let currentPageElement = document.getElementById("current-page");
    let currentIndex = currentPageElement.innerText - 1;
    let next = elementClicked.innerText;
    let indexes = document.getElementsByClassName("page-index");

    if (next == '>' && currentIndex != indexes.length - 1) {
        currentPageElement.id = null;
        indexes[currentIndex + 1].id = 'current-page';
    } else if (next == '<' && currentIndex != 0) {
        currentPageElement.id = null;
        indexes[currentIndex - 1].id = 'current-page';
    } else if (next < 6 && next > 0) {
        next = next - 1;
        currentPageElement.id = null;
        indexes[next].id = 'current-page';
    }
    showSpecificImages();
}

function showSpecificImages() {
    let imagesToShow = document.getElementsByClassName('show-zone-image');
    let containers = document.getElementsByClassName('show-zone-container');
    for (let j = 0; j < imagesToShow.length; j++) {
        containers[j].style = 'display:none';
    }
    let currentPageElement = document.getElementById("current-page");
    let currentIndex = currentPageElement.innerText;
    let i = currentIndex * 20 - 1;
    if (i > imagesToShow.length)
        i = imagesToShow.length - 1;
    while (i >= (currentIndex - 1) * 20) {
        containers[i].style = null;
        i--;
    }
}