      // makes the map var global 
      // var map;

      // variables needed for the line drawing
      linesData = [];
      indexHighscore = 0;
      markersArray = [];


      var customLabel = {
        restaurant: {
          label: 'R'
        },
        bar: {
          label: 'B'
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
              var type = markerElem.getAttribute('type');
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

              if(currentIndex > indexHighscore) {
                indexHighscore = currentIndex
              };
              
              
              

              markerDetailsForArray = {coords: latlng}, index = currentIndex

              markersArray.push(markerDetailsForArray)              
              

              console.log('lines data = ', linesData)

              var icon = customLabel[type] || {};
              var marker = new google.maps.Marker({
                map: map,
                position: point,
                label: icon.label
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

      function lineDrawing(props, map) {

        console.log("Starting Line drawing...")

        // number used for iteration
        currentNumber = 0

        // loop to iterate trough dataset
        while(currentNumber <= indexHighscore) {
          // temp list containg all markers except one with currentNumber[ID]
          allOtherList = []

          // current excluded marker
          currentMarker = linesData[currentNumber]
          // for debuging
          console.log("current marker index is: ", linesData[currentNumber])
          // loop that fills the list with all other markers
          for(var i = 0; i < linesData.length; i++){
            // console.log("!!!",markers[currentNumber][1])

            if(currentMarker == linesData[i]) {
              // skiping the excluded marker
            }
              
            else{
              // adding the marker to the AllOtherList
              allOtherList.push(linesData[i])
              
            }
          }
          // 4 debug
          console.log("all ohter list = ", allOtherList)
          
          // iterate trough all of the other markes, while searching 4 higher index values
          for(var i = 0; i < allOtherList.length; i++){

            // if current marker index is equal to  i + 1 index in all other list 
            if(currentMarker[1] == allOtherList[i][1] - 1) {
              // console.log("connection made!")
              console.log("connection made ",linesData[currentNumber][1], "and", allOtherList[i][1] + 1)

              // draw the connection
              // console.log(linesData[currentNumber])
              
              console.log("%%%%% TESTING %%%%%")
              console.log(linesData[currentNumber][0]["lat"])
              console.log(allOtherList[i][0])
              console.log(typeof parseFloat(linesData[currentNumber][0]["lat"]))
              
                var line = [
                    {
                      lat: parseFloat(linesData[currentNumber][0]["lat"]),
                      lng: parseFloat(linesData[currentNumber][0]["lng"])
                    },
                    {
                      lat: parseFloat(allOtherList[i][0]["lat"]),
                      lng: parseFloat(allOtherList[i][0]["lng"])
                    }
                ];
              

              
              console.log("NEW LINE =",line)


              var flightPath = new google.maps.Polyline({
                path: line,
                geodesic: true,
                strokeColor: '#222',
                strokeOpacity: 1.0,
                strokeWeight: 5
                });


              console.log("drawing the line!")
              flightPath.setMap(map);
            }
            else {
              // console.log("connection not made");
            }


            

          }
          console.log("CURRENT NUMBER IS:", currentNumber, "CHANGING TO ", currentNumber + 1)
          currentNumber ++;

        };


            };


      

    
