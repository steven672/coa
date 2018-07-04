<?php


/*	$json = '{"data":
	{"2017-02-10":[{"region":"DDTC","count":"204","errorMinutes":"195"}],
	"2017-02-17":[{"region":"KAN","count":"93","errorMinutes":"93"},
		{"region":"LAS","count":"24","errorMinutes":"24"},
		{"region":"ORG","count":"13","errorMinutes":"13"},
		{"region":"TUL","count":"10","errorMinutes":"10"}],
	"2017-02-15":[{"region":"DDTC","count":"46","errorMinutes":"46"}],
	"2017-02-12":[{"region":"DDTC","count":"28","errorMinutes":"28"}],
	"2017-02-16":[{"region":"HRD","count":"26","errorMinutes":"26"},
		{"region":"NVA","count":"22","errorMinutes":"22"},
		{"region":"GAN","count":"4","errorMinutes":"4"},
		{"region":"LOU","count":"2","errorMinutes":"2"}],
	"2017-02-11":[{"region":"DDTC","count":"23","errorMinutes":"23"},
		{"region":"CON","count":"6","errorMinutes":"6"}],
	"2017-02-13":[{"region":"BTR","count":"20","errorMinutes":"20"}],
	"2017-02-18":[{"region":"CLE","count":"13","errorMinutes":"13"}]}}';


	var_dump(json_decode($json,true));

	$phpArray = { ["data"]=> array(8) { ["2017-02-10"]=> array(1) { [0]=> array(3) { ["region"]=> string(4) "DDTC" ["count"]=> string(3) "204" ["errorMinutes"]=> string(3) "195" } } ["2017-02-17"]=> array(4) { [0]=> array(3) { ["region"]=> string(3) "KAN" ["count"]=> string(2) "93" ["errorMinutes"]=> string(2) "93" } [1]=> array(3) { ["region"]=> string(3) "LAS" ["count"]=> string(2) "24" ["errorMinutes"]=> string(2) "24" } [2]=> array(3) { ["region"]=> string(3) "ORG" ["count"]=> string(2) "13" ["errorMinutes"]=> string(2) "13" } [3]=> array(3) { ["region"]=> string(3) "TUL" ["count"]=> string(2) "10" ["errorMinutes"]=> string(2) "10" } } ["2017-02-15"]=> array(1) { [0]=> array(3) { ["region"]=> string(4) "DDTC" ["count"]=> string(2) "46" ["errorMinutes"]=> string(2) "46" } } ["2017-02-12"]=> array(1) { [0]=> array(3) { ["region"]=> string(4) "DDTC" ["count"]=> string(2) "28" ["errorMinutes"]=> string(2) "28" } } ["2017-02-16"]=> array(4) { [0]=> array(3) { ["region"]=> string(3) "HRD" ["count"]=> string(2) "26" ["errorMinutes"]=> string(2) "26" } [1]=> array(3) { ["region"]=> string(3) "NVA" ["count"]=> string(2) "22" ["errorMinutes"]=> string(2) "22" } [2]=> array(3) { ["region"]=> string(3) "GAN" ["count"]=> string(1) "4" ["errorMinutes"]=> string(1) "4" } [3]=> array(3) { ["region"]=> string(3) "LOU" ["count"]=> string(1) "2" ["errorMinutes"]=> string(1) "2" } } ["2017-02-11"]=> array(2) { [0]=> array(3) { ["region"]=> string(4) "DDTC" ["count"]=> string(2) "23" ["errorMinutes"]=> string(2) "23" } [1]=> array(3) { ["region"]=> string(3) "CON" ["count"]=> string(1) "6" ["errorMinutes"]=> string(1) "6" } } ["2017-02-13"]=> array(1) { [0]=> array(3) { ["region"]=> string(3) "BTR" ["count"]=> string(2) "20" ["errorMinutes"]=> string(2) "20" } } ["2017-02-18"]=> array(1) { [0]=> array(3) { ["region"]=> string(3) "CLE" ["count"]=> string(2) "13" ["errorMinutes"]=> string(2) "13" } } } };

        // Create a new container -- this will hold the new date buckets
        $newContainer = array();
        // Iterate through all records returned from the database and group them into buckets based on date
        foreach($phpArray as $date => $element)
        {
 			var_dump(json_decode($element));
 		};*/


        //     // Extract the date for this element
        //     $thisDate = $element[$count];
        //     // Create the new date bucket if it doesn't exist yet
        //     if (!array_key_exists($thisDate, $newContainer))
        //     {
        //         $newContainer[$thisDate] = array();
        //     }
        //     // Delete the redundant date field to minimize payload size
        //     unset($element[$searchFieldInArray]);
        //     // Add the record to the correct date bucket
        //     $newContainer[$thisDate][] = $element;
        // }
        // // Update the response variable with the new bucket-ized dataset
        // return $newContainer;

// $date = new DateTime();
// $date->sub(new DateInterval('P1D'));
// echo $date->format('Y-m-d') . "\n\n\n";
// // echo gettype($date);


//                 $date = new DateTime();
// $date->sub(new DateInterval('P2D'));
// echo $date->format('Y-m-d') . "\n\n";
// echo gettype($date);

// $result = $date->format('Y-m-d');
// echo $result;
// echo gettype($result);


$user='vopsp_migration';
$pass='******';

// $user='root';
// $pass='';
try {
    $dbh = new PDO('mysql:host=tvxmdb-c3-c00008-g.ch.tvx.comcast.com;dbname=headwaters', $user, $pass);
} catch (Exception $e) {
    throw $e;
}




var_dump($dbh);




?>