
<?php
require_once("db.php");
require_once ("MiniTemplator.class.php");
	
function generateFilterPage(){	
	try 
	{
		$dsn = DB_ENGINE .':host='. DB_HOST .';dbname='. DB_NAME;
		$db = new PDO($dsn, DB_USER, DB_PW);
		
		$t = new MiniTemplator;
		$ok = $t->readTemplateFromFile("index.html");
		if (!$ok) die ("MiniTemplator.readTemplateFromFile failed.");
		
		$query = "SELECT variety_id, variety 
					FROM grape_variety";
		foreach($db->query($query) as $row){
			$variety_id = $row['variety_id'];
			$variety_name = $row['variety'];
			$t->setVariable("variety_id",$variety_id);
			$t->setVariable("variety_name",$variety_name);
			$t->addBlock("grapeVariety");
		}
		
		$query = "SELECT region_name, region_id 
					FROM region";
		foreach($db->query($query) as $row){
			$region_id = $row['region_id'];
			$region_name = $row['region_name'];
			$t->setVariable ("region_id",$region_id);
			$t->setVariable ("region_name",$region_name);
			$t->addBlock ("region");
		}
		
		$db = null;
		
		$t->generateOutput();
	}
	catch (PDOException $e)
	{
		echo $e->getMessage();
	}

	// while($query_data = mysql_fetch_array($result)){
		// $region_id = $query_data["region_id"];
		// $region_name = $query_data["region_name"];
		
		// $t->setVariable ("region_id",$region_id);
		// $t->setVariable ("region_name",$region_name);
		// $t->addBlock ("region");
	// } 

	// $query = "SELECT DISTINCT year
				// FROM wine
				// ORDER BY  wine.year ASC";
	// $result = mysql_query($query);
	// while($query_data = mysql_fetch_array($result)){
		// $year_asc = $query_data["year"];
		// $t->setVariable ("year_asc", $year_asc);
		// $t->addBlock ("yearAsc");
	// } 
	 
	// $query = "SELECT DISTINCT year
				// FROM wine
				// ORDER BY  wine.year DESC";
	// $result = mysql_query($query);
	// while($query_data = mysql_fetch_array($result)){
		// $year_desc = $query_data["year"];    
		// $t->setVariable ("year_desc", $year_desc);
		// $t->addBlock ("yearDesc");
	// } 

	// $t->generateOutput();
}
generateFilterPage();


	?>                           
