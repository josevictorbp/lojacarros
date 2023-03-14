<?php
    session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8" />
	<title>Live Mysql Data Search using javaScript with PHP</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
    <div class="container">
    	<h2 class="text-center mt-4 mb-4">Live Mysql Data Search using javaScript with PHP</h2>
    	
    	<div class="card">
    		<div class="card-header">
    			<div class="row">
    				<div class="col-md-3">
                        <form action = "">
    					    <input type="text" name="search" value = "<?php if(isset($_GET['search'])) echo $_GET['search']; ?>" class="form-control" id="search" placeholder="Pesquise veículos"/>
                            <input type = "submit">
                        </form>
                    </div>
    			</div>
    		</div>
            
    	</div>
    </div>
    <?php
    //CONEXÃO
$dbServername = "lojacarros.cgafid4rkvnz.us-east-2.rds.amazonaws.com";
$dbUsername = "root";
$dbPassword = "Pmjoptr21.";
$dbName = "sitecarros";
$mysqli = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);

if ($mysqli->connect_errno) {
    die ("fail to connect");
}
// Fim da conexao

?>

<?php
if (!isset ($_GET['search'])) {
    ?>
    <tr>
        <td colspan = "3" >Digite algo ... </td>
</tr>
<?php 
} else {
    $search = $mysqli->real_escape_string($_GET['search']);
    $sql= "SELECT * FROM sitecarros 
where marca like '%$search%'
or modelo like '%$search%' ";
// a porcentagem faz com que você traga qualquer palavra com a pesquisa entre elas 

$sql_query = $mysqli->query($sql) or die ("Erro ao consultar! " . $mysqli->error);

if ($sql_query ->num_rows == 0) {
    ?>
    <tr>
        <td colspan = "3" > Nenhum resultado encontrado ... </td>
</tr>
<?php
} else {
    while ($dados = $sql_query ->fetch_assoc()) {
        ?>
        
    <tr>
    <td> <img src="data:image/png;base64,<?php echo base64_encode($dados['imagem']); ?>" alt="Car Image"> </td> <br>
    <td><?php echo $dados['dateofpost']; ?></td><br>
    <td><?php echo $dados['potencia']; ?></td><br>
    <td><?php echo $dados['turbo']; ?></td><br>
    <td><?php echo $dados['preço']; ?></td><br>
    <td><?php echo $dados['anofab']; ?></td><br>
    <td><?php echo $dados['anomodelo']; ?></td><br>
        <td><?php echo $dados['carroceria']; ?></td><br>
        <td><?php echo $dados['cor']; ?></td><br>
        <td><?php echo $dados['km']; ?></td><br>
        <td><?php echo $dados['descricao']; ?></td><br>
        <td><?php echo $dados['marca']; ?></td><br>
        <td><?php echo $dados['modelo']; ?></td><br>
    </tr>

    <?php
            
    }
}
?>
<?php
}?>
</table>

</body>
</html>