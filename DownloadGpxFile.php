function DownloadGpxFile($GpxTitle, $waypoints, $trackpoints, $file, $creator) {
    $FileHandle = fopen($file, 'w') or die("can't create file");

    $domtree = new DOMDocument('1.0', 'UTF-8');
    $domtree->formatOutput = true;

    $gpx = $domtree->createElement("gpx");
    $gpx->setAttribute('xmlns', 'http://www.topografix.com/GPX/1/1');
    $gpx->setAttribute('creator', $creator);
    $domtree->appendChild($gpx);

    foreach ( $waypoints as $waypoint ) {
        $wpt = $domtree->createElement("wpt");
        $wpt->setAttribute('lat', $waypoint[0]);
        $wpt->setAttribute('lon', $waypoint[1]);
        $wpt->appendChild($domtree->createElement('name', $waypoint[2]));
        $wpt->appendChild($domtree->createElement('desc', $waypoint[2]));
        $gpx->appendChild($wpt);
    }

    $trk = $domtree->createElement("trk");
    $gpx->appendChild($trk);

    $name = $domtree->createElement("name", $GpxTitle);
    $trk->appendChild($name);

    $trkseg = $domtree->createElement("trkseg");
    $trk->appendChild($trkseg);

    foreach ( $trackpoints as $trackpoint ) {
        $trkpt = $domtree->createElement("trkpt");
        $trkpt->setAttribute('lat', $trackpoint[0]);
        $trkpt->setAttribute('lon', $trackpoint[1]);
        $trkseg->appendChild($trkpt);
    }

    $content = ($domtree->saveXML());

    file_put_contents($file, $content);
    fclose($FileHandle);

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"'); //<<< Note the " " surrounding the file name
    header('Content-Transfer-Encoding: binary');
    header('Connection: Keep-Alive');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));

    readfile($file);
    unlink($file);
}
