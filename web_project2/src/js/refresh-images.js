function refresh() {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            let room = document.getElementById('show-zone');
            let imageElements = document.getElementsByClassName('show-zone-image');
            let titleElements = document.getElementsByClassName('show-zone-title');
            let descriptionElements = document.getElementsByClassName('show-zone-description');


            let result = this.responseText;
            let info = result.split('.jpg');
            for (let i = 0; i < info.length - 1; i++) {
                let details = info[i].split('∝');

                if (!(i < imageElements.length)) {
                    let img = document.createElement('img');
                    img.src = '../../travel-images/large/' + details[3] + '.jpg';
                    img.className = 'show-zone-image ' + details[0];

                    let outer = document.createElement('a');
                    outer.href = "detail.php?ImageID=" + details[0];

                    let title = document.createElement('h3');
                    title.className = 'show-zone-title';
                    title.innerHTML = details[1];

                    let description = document.createElement('p');
                    description.className = 'show-zone-description';
                    description.innerHTML = details[2];

                    let container = document.createElement('div')

                    outer.appendChild(img);
                    container.appendChild(outer);
                    container.appendChild(title);
                    container.appendChild(description);
                    room.appendChild(container);
                } else {
                    imageElements[i].src = '../../travel-images/large/' + details[3] + '.jpg';
                    imageElements[i].parentElement.href = "detail.php?ImageID=" + details[0];
                    titleElements[i].innerHTML = details[1];
                    descriptionElements[i].innerHTML = details[2];
                }
            }

        }
    };
    xmlhttp.open("GET", "refreshImageExhibited.php", true);
    xmlhttp.send();
}