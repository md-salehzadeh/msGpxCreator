# msGpxCreator
this script helps you simply create Gpx files and download it from your browser.

**how to use**
```php
include_once "some/path/to/msGpxCreator/msGpxCreator.php";
$msGpxCreator = new msGpxCreator();
$msGpxCreator->setGpxTitle("Gpx title"); //Optional -> default: 'Gpx file' (recommended to be set)
$msGpxCreator->setFilePath("path/to/file/"); //Required
$msGpxCreator->setFileName("GPX-12365484964"); //Optional -> default: something like 'GPX-12365484964'
$msGpxCreator->setWaypoints($waypoints); //Required (array of stopovers)
$msGpxCreator->setTrackpoints($trackpoints); //Required (array of points along the route)
$msGpxCreator->setCreator("https://yourCompany.com"); //Optional -> default: 'https://github.com/hidden-shadow/msGpxCreator'
$file = $msGpxCreator->create();
$msGpxCreator->download();
```


**waypoints and trackpoints parameters example**
```php
$waypoints = [
  [
    37.5284308,
    49.1073439,
    'description for waypoint #1'
  ],
  [
    37.5194876,
    49.034353,
    'description for waypoint #2'
  ],
  [
    37.6235526,
    48.7989885,
    'description for waypoint #3'
  ]
];

$trackpoints = [
  [
    37.52843,
    49.10734
  ],
  [
    37.52774,
    49.10903
  ],
  [
    37.5304,
    49.10892
  ]
];
```


**how to get waypoints and trackpoints parameters from current map(google directions api)**
```javascript
function getWaypointsAndStepsForGpx() {
  var currentDirections = directionsDisplay.getDirections();
  var route = currentDirections.routes[0];
  var trkpts = route.overview_path;
  var coord = [];
  coord['wpt'] = [];
  coord['trkpt'] = [];

  for ( var i = 0; i < route.legs.length; i++ ) {
    var LegLoc = route.legs[i].start_location;
    var lat = LegLoc.lat();
    var lng = LegLoc.lng();
    var address = route.legs[i].start_address;
    coord['wpt'][i] = [lat, lng, address];

    if ( i+1 == route.legs.length ) {
      var LegLoc = route.legs[i].end_location;
      var lat = LegLoc.lat();
      var lng = LegLoc.lng();
      var address = route.legs[i].end_address;
      coord['wpt'][i+1] = [lat, lng, address];
    }
  }

  for ( var i = 0; i < trkpts.length; i++ ) {
    var LegLoc = trkpts[i];
    var lat = LegLoc.lat();
    var lng = LegLoc.lng();
    coord['trkpt'][i] = [lat, lng];
  }

  return coord;
}

var coord = getWaypointsAndStepsForGpx();
var wpts = JSON.stringify(coord.wpt);
var trkpts = JSON.stringify(coord.trkpt);
```
