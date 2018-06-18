<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>FamMap</title>
  <style>
    html {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }
    #map{
      height:1000px;
      width:100%;
    }
  </style>
</head>
<body>
  <h1>FamMap</h1>
  <div id="map"></div>



  <script>
    function initMap(){
      // Map options
      var options = {
        zoom: 5,
        center:{lat:42.3601,lng:-71.0589}
      }

      // New map
      var map = new google.maps.Map(document.getElementById('map'), options);



      // Array of markers
      var markers = [
        [
          {
          coords:{lat:43.4668,lng:-70.9495},
          iconImage: 'https://png.icons8.com/metro/50/000000/contacts.png',
          content: '<h1>Index 1</h1>'
          },
          index = 1,
          id = "A"
        ],
        [
          {
          coords:{lat:45.4668,lng:-70.9495},
          iconImage:'https://png.icons8.com/metro/50/000000/contacts.png',
          content:'<h1>Index 1</h1>'
          },
          index = 1,
          id = "B"
        ],
        [
          {
          coords:{lat:47.5668,lng:-60.8495},
          iconImage:'https://png.icons8.com/metro/50/000000/contacts.png',
          content:'<h1>Index 1</h1>'
          },
          index = 1,
          id = "C"
        ],
        [
          {
          coords:{lat:50.5668,lng:-60.8495},
          iconImage:'https://png.icons8.com/metro/50/000000/contacts.png',
          content:'<h1>Index 2</h1>'
          },
          index = 2,
          id = "D"
        ],
        [
          {
            coords:{lat:42.8584,lng:-80.9300},
            iconImage:'https://png.icons8.com/metro/50/000000/contacts.png',
            content:'<h1>Index 3</h1>'
          },
          index = 3,
          id = "E"
        ],
        [
          {
            coords:{lat:24.8584,lng:-50.9300},
            iconImage:'https://png.icons8.com/metro/50/000000/contacts.png',
            content:'<h1>Index 3</h1>'
          },
          index = 4,
          id = "F"
        ]

      ];

        
      // line data grabber
      function lineData(props) {
        
        markerDetails = []
        // console.log(props[0].coords)
        markerDetails.push(props[0].coords)
        // console.log(props[1])
        markerDetails.push(props[1])

        // console.log(markerDetails)

        return markerDetails


      };


      // takes all line data to an array
      linesData = []
      for(var i = 0;i < markers.length;i++){
        // data extraction
        lineData(markers[i]);
        linesData.push(lineData(markers[i]))
        console.log(linesData)
      }
      
      console.log("*************");


      // gets highest index number
      function indexHighscore(props){

        // highest index number
        CurrentHighScore = 0;
        // console.log(CurrentHighScore)
        for(var i = 0; i < props.length; i++) {
          // console.log(props[i][1])
            if(props[i][1] > CurrentHighScore) {
              // console.log("New index highscore!")
              CurrentHighScore = props[i][1]
            }
        }

        // console.log(CurrentHighScore)
        return CurrentHighScore
      };

      // line drawing function
      function lineDrawing(props) {

        console.log("Starting Line drawing...")

        // number used for iteration
        currentNumber = 0
        
        // loop to iterate trough dataset
        while(currentNumber <= indexHighscore(markers)) {
          // temp list containg all markers except one with currentNumber[ID]
          allOtherList = []

          // current excluded marker
          currentMarker = markers[currentNumber]
          // for debuging
          console.log("current marker index is: ", currentMarker[1])
          // loop that fills the list with all other markers
          for(var i = 0; i < markers.length; i++){
            // console.log("!!!",markers[currentNumber][1])

            if(currentMarker == markers[i]) {
              // skiping the excluded marker
            }
              
            else{
              // adding the marker to the AllOtherList
              allOtherList.push(markers[i])
              
            }
          }
          // 4 debug
          console.log("all ohter list = ", allOtherList)
          
          // iterate trough all of the other markes, while searching 4 higher index values
          for(var i = 0; i < allOtherList.length; i++){

            // if current marker index is equal to  i + 1 index in all other list 
            if(currentMarker[1] == allOtherList[i][1] - 1) {
              // console.log("connection made!")
              console.log("connection made ",markers[currentNumber][1], "and", allOtherList[i][1] + 1)

              // draw the connection
              console.log(markers[currentNumber])

            
              var line = [
                markers[currentNumber][0].coords,
                allOtherList[i][0].coords
                ];

              
              console.log("NEW LINE =",line)


              var flightPath = new google.maps.Polyline({
                path: line,
                geodesic: true,
                strokeColor: '#222',
                strokeOpacity: 1.0,
                strokeWeight: 5
                });

              flightPath.setMap(map);
            }
            else {
              "connection not made"
            }


            

          }
          console.log("CURRENT NUMBER IS:", currentNumber, "CHANGING TO ", currentNumber + 1)
          currentNumber ++;

        }


      };



      console.log("INDEX HIGHSCORE = ", indexHighscore(linesData));

      lineDrawing(linesData);


      // Loop through markers
      for(var i = 0;i < markers.length;i++){
        // Add marker
        addMarker(markers[i][0]);
      }

      // Add Marker Function
      function addMarker(props){
        var marker = new google.maps.Marker({
          position:props.coords,
          map:map,
          //icon:props.iconImage
        });

        // Check for customicon
        if(props.iconImage){
          // Set icon image
          marker.setIcon(props.iconImage);
        }
        else {
         
    
        }

        // Check content
        if(props.content){
          var infoWindow = new google.maps.InfoWindow({
            content:props.content
          });

          marker.addListener('click', function(){
            infoWindow.open(map, marker);
          });
        }
      }


    }
  </script>
  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC7JyGUia-GCfFiqUppwk0tqDuMalUAFY0&callback=initMap">
    </script>

    <h1>Gabriel Mermer</h1> <br>
    <h2>2002.01.13</h2> <br>
    <h2>Warszawa</h2> <br>
    <p>Daniel Mermer</p>
    <p>Maria Mermer</p>
    <hr>
    <p>Jestem sobie małym misiem</p> <br>
    <img src="http://via.placeholder.com/350x150"> <br>

    <div id="test"></div>
</body>
</html>
