<?php 
/*
	filename 	: cis355api.php
	author   	: Binh Dang
	course   	: cis355 (winter2020)
	description	: demonstrate JSON API functions
				  return number of new covid19 cases
	input    	: https://api.covid19api.com/summary
	functions   : main()
	                curl_get_contents()
*/

main();

#-----------------------------------------------------------------------------
# FUNCTIONS
#-----------------------------------------------------------------------------
function main () {
	
	$apiCall = 'https://api.covid19api.com/summary';

	//gather into an array all countries’ deaths data
	$json_string = curl_get_contents($apiCall);
	$obj = json_decode($json_string);
	
	$death_arr = Array() ;

	foreach($obj->Countries as $i){
		$death_arr[$i->Country] = $i->TotalDeaths;
	}

	//sort array in Desecending order 
	arsort($death_arr);

	// echo html head section
	echo '<html>';
	echo '<head>';
	echo '<title>COVID-19 API by Binh Dang</title>';
	echo '<style>';
	echo "table, th, td {
			border: 1px solid black;
	  	}";
	echo '</style>';
	echo '</head>';
	
	// open html body section
	echo '<body onload="loadDoc()">';

	//clickable link to the code you just pushed to GitHub.
	echo '<a target="_blank" href="https://github.com/bddang23/covidAPI/blob/main/cis355api.php">Link to source code Github </a> <br><br>';
	
	$death_arr = array_slice($death_arr,0,10); //  top 10 highest number of deaths.
	//print_r($death_arr);
	$JSONString=json_encode($death_arr);
	$JSONObject = json_decode($JSONString);
	echo '<b>Filtered JSON Object From $death_arr</b><br>';
	echo var_dump($JSONObject);
	echo '<br><br>';
	echo "<div><b>Table With PHP Array</b>";
	echo "<table>";
        echo "<tr>";
		  	echo "<th>PHP</th>";
            echo "<th>Country</th>";
            echo "<th>Total Death Cases</th>";
		echo "</tr>";
		$i=1;
		foreach ($death_arr as $country => $cases) {
			echo "<tr>";
			echo "<td>{$i}</td>";
			echo "<td>{$country}</td>";
			echo "<td>{$cases}</td>";
			echo "</tr>";
			$i++;
		 }
	echo "</table>";
	echo '</div>';
	echo '</body>';
	echo '</html>';
}


#-----------------------------------------------------------------------------
// read data from a URL into a string
function curl_get_contents($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
?>
