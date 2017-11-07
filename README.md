# msGpxCreator
this script helps you simply create Gpx files and download it from your browser.

**how to use:**
```php
include_once "some/path/to/msGpxCreator/msGpxCreator.php";
$msGpxCreator = new msGpxCreator();
$msGpxCreator->setGpxTitle("Gpx title");// Optional -> default: 'Gpx file' (recommended to be set)
$msGpxCreator->setFilePath("path/to/file/"); // Required
$msGpxCreator->setFileName("GPX-12365484964");
$msGpxCreator->setWaypoints($waypoints);// Required (array of stopovers)
$msGpxCreator->setTrackpoints($trackpoints);// Required (array of points along the way)
$msGpxCreator->setCreator("https://yourCompany.com");// Optional -> default: 'https://github.com/hidden-shadow/msGpxCreator'
$file = $msGpxCreator->create();
$msGpxCreator->download();
```
and Done!
