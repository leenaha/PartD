
<?php
require_once("db.php");
require_once ("MiniTemplator.class.php");
	
function generateFilterPage(){	
	
	if(!$dbconn = mysql_connect(DB_HOST, DB_USER, DB_PW)) {
      		echo 'Could not connect to mysql on ' . DB_HOST . '\n';
      		exit;
   	}
	
	if(!mysql_select_db(DB_NAME, $dbconn)) {
      		echo 'Could not user database ' . DB_NAME . '\n';
     	 	echo mysql_error() . '\n';
      		exit;
   	}
	
	$t = new MiniTemplator;
	$ok = $t->readTemplateFromFile("index.html");
	if (!$ok) die ("MiniTemplator.readTemplateFromFile failed.");
    
	$query = "SELECT variety_id, variety 
				FROM grape_variety";
	$result = mysql_query($query);
	while($query_data = mysql_fetch_array($result)){
		$variety_id = $query_data["variety_id"];
		$variety_name = $query_data["variety"];
		
		$t->setVariable ("variety_id",$variety_id);
		$t->setVariable ("variety_name",$variety_name);
		$t->addBlock ("grapeVariety");
	} 
	
	$query = "SELECT region_name, region_id 
				FROM region";
	$result = mysql_query($query);
	while($query_data = mysql_fetch_array($result)){
		$region_id = $query_data["region_id"];
		$region_name = $query_data["region_name"];
		
		$t->setVariable ("region_id",$region_id);
		$t->setVariable ("region_name",$region_name);
		$t->addBlock ("region");
	} 

	$query = "SELECT DISTINCT year
				FROM wine
				ORDER BY  wine.year ASC";
	$result = mysql_query($query);
	while($query_data = mysql_fetch_array($result)){
		$year_asc = $query_data["year"];
		$t->setVariable ("year_asc", $year_asc);
		$t->addBlock ("yearAsc");
	} 
	 
	$query = "SELECT DISTINCT year
				FROM wine
				ORDER BY  wine.year DESC";
	$result = mysql_query($query);
	while($query_data = mysql_fetch_array($result)){
		$year_desc = $query_data["year"];    
		$t->setVariable ("year_desc", $year_desc);
		$t->addBlock ("yearDesc");
	} 

	$t->generateOutput();
}
generateFilterPage();


	?>                           
