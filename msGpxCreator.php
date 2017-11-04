<?php
/**
 * @author Mohammad Salehzad <hidden.shadow.phcj@gmail.com>
 * @link https://github.com/hidden-shadow/msGpxCreator
 */
class msGpxCreator {
	
	private $GpxTitle;
	private $FilePath;
	private $FileName;
	private $file;
	private $waypoints;
	private $trackpoints;
	private $creator;
	
	/**
	 * @param string $GpxTitle
	 * @return msGpxCreator
	 */
	public function setGpxTitle( $GpxTitle ) {
		$this->GpxTitle = trim(addslashes($GpxTitle));
		
		return $this;
	}
	
	/**
	 * @param string $FilePath
	 * @return msGpxCreator
	 */
	public function setFilePath( $FilePath ) {
		if ( substr($FilePath, -1) != '/' ) {
			$FilePath .= '/';
		}
		$this->FilePath = $FilePath;
		
		return $this;
	}
	
	/**
	 * @param string $FileName name of file that we are going to create without extension(.gpx)
	 * @return msGpxCreator
	 */
	public function setFileName( $FileName ) {
		$this->FileName = trim(addslashes($FileName));
		
		return $this;
	}
	
	/**
	 * @param $waypoints
	 * @return $this
	 * @throws Exception
	 */
	public function setWaypoints( $waypoints ) {
		if ( !is_array($waypoints) ) {
			throw new Exception('waypoints variable is not array');
		}
		$this->waypoints = $waypoints;
		
		return $this;
	}
	
	/**
	 * @param $trackpoints
	 * @return $this
	 * @throws Exception
	 */
	public function setTrackpoints( $trackpoints ) {
		if ( !is_array($trackpoints) ) {
			throw new Exception('trackpoints variable is not array');
		}
		$this->trackpoints = $trackpoints;
		
		return $this;
	}
	
	/**
	 * @param string $creator name of your company or your site url
	 * @return msGpxCreator
	 */
	public function setCreator( $creator ) {
		$this->creator = trim(addslashes($creator));
		
		return $this;
	}
	
	/**
	 * msGpxCreator constructor.
	 */
	function __construct() {
		$this->GpxTitle = 'Gpx file';
		$this->creator = 'https://github.com/hidden-shadow/msGpxCreator';
    }
	
	/**
	 * @return bool|string
	 */
	private function FileNameGenerate() {
	    $file = $this->FilePath.'GPX-'.time().'.gpx';
	    
    	return $file;
    }
	
	/**
	 * creates gpx file
	 * @return bool|string
	 * @throws Exception
	 */
	public function create() {
		// validating parameters
		if ( !$this->FilePath ) {
			throw new Exception('file path is empty');
		}
		$this->file = ( $this->FileName ) ? $this->FilePath.$this->FileName.'.gpx' : $this->FileNameGenerate();
		if ( !$this->waypoints ) {
			throw new Exception('waypoints variable is empty');
		}
		if ( !$this->trackpoints ) {
			throw new Exception('trackpoints variable is empty');
		}
		
	    if ( !$FileHandle = fopen($this->file, 'w') ) {
			throw new Exception("can't create file!");
	    }
	
	    $domtree = new DOMDocument('1.0', 'UTF-8');
	    $domtree->formatOutput = true;
	
	    $gpx = $domtree->createElement("gpx");
	    $gpx->setAttribute('xmlns', 'http://www.topografix.com/GPX/1/1');
	    $gpx->setAttribute('creator', $this->creator);
	    $domtree->appendChild($gpx);
	
	    foreach ( $this->waypoints as $waypoint ) {
		    $wpt = $domtree->createElement("wpt");
		    $wpt->setAttribute('lat', $waypoint[0]);
		    $wpt->setAttribute('lon', $waypoint[1]);
		    $wpt->appendChild($domtree->createElement('name', $waypoint[2]));
		    $wpt->appendChild($domtree->createElement('desc', $waypoint[2]));
		    $gpx->appendChild($wpt);
	    }
	
	    $trk = $domtree->createElement("trk");
	    $gpx->appendChild($trk);
	
	    $name = $domtree->createElement("name", $this->GpxTitle);
	    $trk->appendChild($name);
	
	    $trkseg = $domtree->createElement("trkseg");
	    $trk->appendChild($trkseg);
	
	    foreach ( $this->trackpoints as $trackpoint ) {
		    $trkpt = $domtree->createElement("trkpt");
		    $trkpt->setAttribute('lat', $trackpoint[0]);
		    $trkpt->setAttribute('lon', $trackpoint[1]);
		    $trkseg->appendChild($trkpt);
	    }
	
	    $content = ($domtree->saveXML());
	
	    file_put_contents($this->file, $content);
	    fclose($FileHandle);
	    
	    return $this->file;
    }
	
	/**
	 * @param bool $unlinkAfter if this parameter is true file will be removed after download
	 * @return bool|string
	 * @throws Exception
	 */
	public function download( $unlinkAfter = false) {
		if ( !$this->file ) {
			throw new Exception("file is not defined!");
		}
	    header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename="'.basename($this->file).'"');
	    header('Content-Transfer-Encoding: binary');
	    header('Connection: Keep-Alive');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($this->file));
	
	    readfile($this->file);
	    if ( $unlinkAfter ) unlink($this->file);
	
	    return $this->file;
    }
	
}