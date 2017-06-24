<!DOCTYPE html>
<html>
<head>
	<title>Avaliação</title>
	<meta charset="utf-8">

	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">

	<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript" src="js/bootstrap-inputmask.min.js"></script>
	<script type="text/javascript" src="js/jqBootstrapValidation.js"></script>
	<script type="text/javascript" src="js/jquery.maskMoney.min.js"></script>

	<script>
  	$(function () { 
  		//validação dos campos
  		$("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); 
  		
  	} );
	</script>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
   
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" 
      data-target="#menu" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="home.php">Prova A</a>
    </div>

    <div class="collapse navbar-collapse" id="menu">
      <ul class="nav navbar-nav navbar-right">
      	<li>
        	<a href="index.php">Cadastrar Produto</a>
        </li>
        <li>
        	<a href="listarProduto.php">Listar Produto</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<?php

	include "config/conecta.php";
	include "config/imagem.php";

	$id = $nome = $marca_id = $data = "";

	if ( isset ( $_GET["id"] ) ) {
		$id = trim ( $_GET["id"] );

		$sql = "select *, date_format(data,'%d/%m/%Y') dt from produto where id = ? limit 1";

		$consulta = $pdo->prepare($sql);
		$consulta->bindParam(1,$id);
		$consulta->execute();
		$dados = $consulta->fetch(PDO::FETCH_OBJ);

		$nome = $dados->nome;
		$data = $dados->dt;
		$marca_id = $dados->marca_id;

	}

?>

<div class="container" style="margin-top:90px">
	<h1>Cadastro de Produtos:</h1>

	<form name="formcadastro" method="post" action="salvarProduto.php" novalidate enctype="multipart/form-data">
		<fieldset>
			<legend>Preencha os campos:</legend>

			<div class="control-group">
				<label for="id">ID:</label>
				<div class="controls">
					<input type="text" name="id"
					class="form-control"
					readonly
					value="<?=$id;?>">
				</div>
			</div>

			<div class="control-group">
				<label for="nome">
				Nome do Produto:</label>
				<div class="controls">
					<input type="text" 
					name="nome"
					class="form-control"
					required
					data-validation-required-message="Preencha o nome do Produto" value="<?=$nome;?>">
				</div>
			</div>

			<div class="control-group">
				<label for="marca_id">
				Marca do Produto:</label>
				<div class="controls">
					<select 
					name="marca_id"
					class="form-control"
					required
					data-validation-required-message="Selecione uma Marca">
					<option value=""></option>
					<?php
						$sql = "select * from marca order by marca";
						$consulta = $pdo->prepare($sql);
						$consulta->execute();
						while ( $dados = $consulta->fetch( PDO::FETCH_OBJ ) ){
							$id = $dados->id;
							$marca = $dados->marca;

							echo "<option value='$id'>$marca</option>";
						}
					?>
					</select>
				</div>
			</div>

			<div class="control-group">
				<label for="foto">
				Foto do Produto:</label>
				<div class="controls">
					<input type="file" 
					name="foto"
					class="form-control"
					required
					data-validation-required-message="Selecione uma Foto para o Produto">
				</div>
			</div>

			<div class="control-group">
				<label for="data">
				Data de Vencimento do Produto:</label>
				<div class="controls">
					<input type="text" 
					name="data"
					data-mask="99/99/9999"
					class="form-control"
					required
					data-validation-required-message="Preencha a Data de Vencimento do Produto" value="<?=$data;?>" 
					>
				</div>
			</div>

			<button type="submit" class="btn btn-success">Salvar Dados</button>


		</fieldset>
	</form>

</body>
</html>
