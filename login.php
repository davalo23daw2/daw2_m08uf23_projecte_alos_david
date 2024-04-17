<?php 
    session_start();
    
    if (isset($_SESSION['auth']) && $_SESSION['auth'] === true) {
        header("location: menu.php");
        exit;
    }
?>

<html>
	<head>
		<title>
			AUTENTICANT AMB LDAP DE L'USUARI admin
		</title>
	</head>
	<body>
		<form action="http://zend-daalga.fjeclot.net/projecteldap/auth.php" method="POST">
			Usuari amb permisos d'administració LDAP: <input type="text" name="adm"><br>
			Contrasenya de l'usuari: <input type="password" name="cts"><br>
			<input type="submit" value="Envia" />
			<input type="reset" value="Neteja" />
		</form>
	</body>
</html>