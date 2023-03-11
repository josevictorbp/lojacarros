<script>
Access-Control-Allow-Origin: http://localhost/newfolder/

</script>
<?php

//process_data.php

if(isset($_POST["query"]))
{

	$connect = new PDO("mysql:host=localhost; dbname=lojacarros", "root", "");

	$data = array();

	if($_POST["query"] != '')
	{

		$condition = preg_replace('/[^A-Za-z0-9\- ]/', '', $_POST["query"]); // This removes the special caracters between words

		$condition = trim($condition); // This removes the space between words

		$condition = str_replace(" ", "%", $condition);

		$sample_data = array(
			':marca'			=>	'%' . $condition . '%',
			':potencia'		=>	'%'	. $condition . '%'
		);

		$query = "
		SELECT marca, potencia 
		FROM lojacarros 
		WHERE marca LIKE :marca 
		OR potencia LIKE :potencia 
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
				'marca'		=>	str_ireplace($replace_array_1, $replace_array_2, $row["marca"]),
				'potencia'	=>	str_ireplace($replace_array_1, $replace_array_2, $row["potencia"])
			);
		}

	}
	else //This runs if search not found :c
	{

		$query = "
		SELECT marca, potencia 
		FROM lojacarros 
		ORDER BY id DESC
		";

		$result = $connect->query($query);

		foreach($result as $row)
		{
			$data[] = array(
				'marca'			=>	$row['marca'],
				'potencia'		=>	$row['potencia']
			);
		}

	}

	echo json_encode($data); // Send data back to index

}

?>