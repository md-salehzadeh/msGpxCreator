# msGpxCreator
this script helps you simply create Gpx files and download it from your browser.

**how to use:**
```objc
include_once "some/path/to/msGpxCreator/msGpxCreator.php";
$msGpxCreator = new msGpxCreator();
$msGpxCreator->setGpxTitle('Gpx title');
$msGpxCreator->setFilePath('path/to/file/');
$msGpxCreator->setFileName('GPX-12365484964');
$msGpxCreator->setWaypoints($waypoints);
$msGpxCreator->setTrackpoints($trackpoints);
$msGpxCreator->setCreator("https://yourCompany.com");
$file = $msGpxCreator->create();
$msGpxCreator->download();
```
and Done!
