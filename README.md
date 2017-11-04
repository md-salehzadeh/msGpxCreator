# msGpxCreator
this script helps you simply create Gpx files and download it from your browser.

**how to use:**
```objc
  include_once "core/lib/msGpxCreator/msGpxCreator.php";
	$msGpxCreator = new msGpxCreator();
	$msGpxCreator->setGpxTitle($GpxTitle);
	$msGpxCreator->setFilePath('uploads/attachment/map/');
	$msGpxCreator->setFileName('salam');
	$msGpxCreator->setWaypoints($waypoints);
	$msGpxCreator->setTrackpoints($trackpoints);
	$msGpxCreator->setCreator('https://safarsalam.com');
	$msGpxCreator->create();
	$msGpxCreator->download(true);
```
and Done!
