// makes the map var global 
// var map;

// variables needed for the line drawing
linesData = [];
indexHighscore = 0;
markersArray = [];


var customLabel = {
alive: {
    label: 'A'
},
dead: {
    label: 'D'
}
};

function initMap() {
var map = new google.maps.Map(document.getElementById('map'), {
    center: new google.maps.LatLng(52.229092829135396, 21.021759016811984),
    zoom: 10
});
var infoWindow = new google.maps.InfoWindow;

    // Change this depending on the name of your PHP or XML file
    downloadUrl('data.xml', function(data) {
    var xml = data.responseXML;

    console.log(xml)

    var markers = xml.documentElement.getElementsByTagName('marker');
    Array.prototype.forEach.call(markers, function(markerElem) {
        var id = markerElem.getAttribute('id');
        var currentIndex = markerElem.getAttribute('index');
        var name = markerElem.getAttribute('name');
        var surname = markerElem.getAttribute('surname');
        var fullName = name + ' ' + surname
        var address = markerElem.getAttribute('address');
        var bio = markerElem.getAttribute('bio');
        var type = markerElem.getAttribute('dd');
        var bd = markerElem.getAttribute('bd');

    //   marker coloring
    if(type == "") {
        var label = customLabel["alive"]
    }

        var point = new google.maps.LatLng(
            parseFloat(markerElem.getAttribute('lat')),
            parseFloat(markerElem.getAttribute('lng')));

        var infowincontent = document.createElement('div');
        var strong = document.createElement('strong');
        strong.textContent = fullName
        infowincontent.appendChild(strong);
        infowincontent.appendChild(document.createElement('br'));

        var text = document.createElement('text');
        text.textContent = address
        infowincontent.appendChild(text);
        infowincontent.appendChild(document.createElement('br'));
        
        var biotext = document.createElement('text');
        biotext.textContent = bio
        infowincontent.appendChild(biotext);
        infowincontent.appendChild(document.createElement('br'));

        var bdtext = document.createElement('text');
        bdtext.textContent = bd
        infowincontent.appendChild(bdtext);
        infowincontent.appendChild(document.createTextNode("-"));


        var deadOrAlive = document.createElement('text');
        deadOrAlive.textContent = type
        infowincontent.appendChild(deadOrAlive);
        infowincontent.appendChild(document.createElement('br'));



        markerDetails = []
        latlng = {'lat': markerElem.getAttribute('lat'),'lng': markerElem.getAttribute('lng')};
        markerDetails.push(latlng)
        markerDetails.push(currentIndex)
        console.log(markerDetails)
        linesData.push(markerDetails)

    
        markerDetailsForArray = {coords: latlng}, index = currentIndex

        markersArray.push(markerDetailsForArray)              
        

        console.log('lines data = ', linesData)
        
        
        var icon = "img/baseline_account_circle_black_18dp.png"
        // var icon = label
        var marker = new google.maps.Marker({
        map: map,
        position: point,
        label: icon.label,
        icon: icon
        });
        marker.addListener('click', function() {
        infoWindow.setContent(infowincontent);
        infoWindow.open(map, marker);
        });
    });

    lineDrawing(markersArray, map);
    });

    
}

console.log("****")
console.log(markersArray)



function downloadUrl(url, callback) {
var request = window.ActiveXObject ?
    new ActiveXObject('Microsoft.XMLHTTP') :
    new XMLHttpRequest;

request.onreadystatechange = function() {
    if (request.readyState == 4) {
    request.onreadystatechange = doNothing;
    callback(request, request.status);
    }
};

request.open('GET', url, true);
request.send(null);
}

function doNothing() {}

// code imported from index.html