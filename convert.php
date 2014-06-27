<?php

$geojson = new stdclass;
$geojson->type = 'FeatureCollection';
$geojson->features = array();


$db_names = array(
	'NIMA Papua New Guniea Gazetteer' 	=> 'sqlite:' . 'eGazFiles/' . 'Papua New Guinea Gazetteer.gaz',
	'NIMA Solomon Islands Gazetteer'	=> 'sqlite:' . 'eGazFiles/' . 'Solomon Islands Gazetteer.gaz'
);

//$dbh = new PDO($db_names['NIMA Papua New Guniea Gazetteer']);
$dbh = new PDO($db_names['NIMA Solomon Islands Gazetteer']);

$sql = 'SELECT * FROM tblGaz';

$modified = array();
foreach ($dbh->query($sql) as $row)
{
	$modified[] = $row['id'];
	
	
	$feature = new stdclass;
	$feature->type = 'Feature';

	$feature->properties = new stdclass;
	
	$feature->properties->GazID = $row['GazID'];
	$feature->properties->tPlace = $row['tPlace'];
	$feature->properties->tType = $row['tType'];
	$feature->properties->tDivision = $row['tDivision'];

	$feature->properties->tLatitude = $row['tLatitude'];
	$feature->properties->tLongitude = $row['tLongitude'];
	$feature->properties->dblLatitude = $row['dblLatitude'];
	$feature->properties->dblLongitude = $row['dblLongitude'];
	
	$feature->geometry = new stdclass;
	$feature->geometry->type = 'Point';
	$feature->geometry->coordinates = array();
	$feature->geometry->coordinates[] = (Double)$row['dblLongitude'];
	$feature->geometry->coordinates[] = (Double)$row['dblLatitude'];
	
	print_r($feature);
	
	$geojson->features[] = $feature;
	
	
}

file_put_contents('geojson/' . 'NIMA Solomon Islands Gazetteer.geojson', json_encode($geojson));

