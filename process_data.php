
<?php
$dbServername = "lojacarros.cgafid4rkvnz.us-east-2.rds.amazonaws.com";
$dbUsername = "root";
$dbPassword = "Pmjoptr21.";
$dbName = "sitecarros";
$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

$sql = "SELECT * FROM sitecarros;";
$result = mysqli_query($conn, $sql);
$resultCheck = mysqli_num_rows($result);

if ($resultCheck > 0) {
	while ($row = mysqli_fetch_assoc($result)) {
		echo $row['modelocarro']. "<br>" ;//insert number if u want specific row
	}
}
?>
<?php
/*
if(isset($_POST["query"]))
{
	$host     = "ip-10-20-0-235";
	$port     = 3306;
	$socket   = "";
	$user     = "root";
	$password = "Pmjoptr21.";
	$dbname   = "sitecarros";

	$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
    or die ('Could not connect to the database server' . mysqli_connect_error());

	$data = array();

	if($_POST["query"] != '')
	{

		$condition = preg_replace('/[^A-Za-z0-9\- ]/', '', $_POST["query"]); // This removes the special caracters between words

		$condition = trim($condition); // This removes the space between words

		$condition = str_replace(" ", "%", $condition);

		$sample_data = array(
			':marcacarro'			=>	'%' . $condition . '%',
			':modelocarro'		=>	'%'	. $condition . '%'
		);

		$query = "
		SELECT modelocarro, marcacarro 
		FROM sitecarros 
		WHERE marcacarro LIKE :marcacarro 
		OR modelocarro LIKE :modelocarro 
		ORDER BY id DESC
		";

		$statement = $con->prepare($query);

		$statement->execute($sample_data);

		$result = $statement->fetchAll();

		$replace_array_1 = explode('%', $condition); //Changes the color of searched data

		foreach($replace_array_1 as $row_data)
		{
			$replace_array_2[] = '<span style="background-color:#'.rand(100000, 999999).'; color:#fff">'.$row_data.'</span>'; //Color of searched data
		}

		foreach($result as $row)
		{
			$data[] = array(
				'marcacarro'		=>	str_ireplace($replace_array_1, $replace_array_2, $row["marcacarro"]),
				'modelocarro'	=>	str_ireplace($replace_array_1, $replace_array_2, $row["modelocarro"])
			);
		}

	}
	else //This runs if search not found :c
	{

		$query = "
		SELECT marcacarro, modelocarro 
		FROM sitecarros 
		ORDER BY id DESC
		";

		$result = $con->query($query);

		foreach($result as $row)
		{
			$data[] = array(
				'marcacarro'			=>	$row['marcacarro'],
				'modelocarro'		=>	$row['modelocarro']
			);
		}

	}

	echo json_encode($data); // Send data back to index

}

