
<?php

//process_data.php

if(isset($_POST["query"]))
{

	$connect = new PDO("mysql:host=ip-10-20-0-235; dbname=sitecarros", "root", "Pmjoptr21.");

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

		$statement = $connect->prepare($query);

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

		$result = $connect->query($query);

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

?>
