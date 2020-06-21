function changeCities(countriesSelector, citiesSelector) {
    if (countriesSelector.value == "default") {
        citiesSelector.options.length = 0;
        citiesSelector.options[0] = new Option("Filter by City", "default");
    } else {
        var cityList = cities[countriesSelector.value];
        for (var i = 0; i < cityList.length; i++) {
            citiesSelector.options[i + 1] = new Option();
            citiesSelector.options[i + 1].text = cityList[i];
            citiesSelector.options[i + 1].value = cityList[i];
        }
    }
}

function getCities(countriesSelector, citiesSelector,upload) {
    if (countriesSelector.value == "default") {
        citiesSelector.options.length = 0;
        citiesSelector.options[0] = new Option("Filter by City", "default");
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                let result = this.responseText;
                let info = result.split('ℸ');
                for (let i = 0; i < info.length - 1; i++) {
                    let details = info[i].split('∝');
                    citiesSelector.options[i + 1] = new Option();
                    citiesSelector.options[i + 1].text = details[0];
                    citiesSelector.options[i + 1].value = details[1];
                }

            }
        };
        xmlhttp.open("GET", "getCitiesList.php?country=" + countriesSelector.value + "&upload=" + upload, true);
        xmlhttp.send();
    }
}

