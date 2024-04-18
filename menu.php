<?php 
    session_start();
    
    if(!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
        header("location: login.php");
        exit;
    }
?>

<html>
	<head>
		<title>
			PÀGINA WEB DEL MENÚ PRINCIPAL DE L'APLICACIÓ D'ACCÉS A BASES DE DADES LDAP
		</title>
	</head>
	<body>
		<h2> MENÚ PRINCIPAL DE L'APLICACIÓ D'ACCÉS A BASES DE DADES LDAP</h2>
		<a href="visualitza.php">Visualitza les dades d'un usuari</a><br>
		<a href="afegeix.php">Afegeix un usuari</a><br>
		<a href="esborra.php">Esborra un usuari</a><br>
		<a href="modifica.php">Modifica les dades d'un usuari</a><br><br>
		<a href="index.php">Torna a la pàgina inicial</a>
	</body>
</html>
