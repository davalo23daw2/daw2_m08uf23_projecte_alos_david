<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header("location: login.php");
    exit;
}

require 'vendor/autoload.php';
use Laminas\Ldap\Ldap;

function modificarAtributUsuari($uid, $unorg, $atribut, $nouValor) {
    $domini = 'dc=fjeclot,dc=net';
    $opcions = [
        'host' => 'zend-daalga.fjeclot.net',
        'username' => "cn=admin,$domini",
        'password' => 'fjeclot',
        'bindRequiresDn' => true,
        'accountDomainName' => 'fjeclot.net',
        'baseDn' => 'dc=fjeclot,dc=net',
    ];
    
    $ldap = new Ldap($opcions);
    $ldap->bind();
    
    // Crea el DN per a l'entrada de l'usuari que es vol modificar
    $dn = "uid=$uid,ou=$unorg,$domini";
    
    // Crea un array per emmagatzemar el nou valor de l'atribut a modificar
    $nousValors = [$atribut => $nouValor];
    
    if ($ldap->update($dn, $nousValors)) {
        echo "Atribut '$atribut' de l'usuari modificat amb èxit.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_POST['uid'];
    $unorg = $_POST['unorg'];
    $atribut = $_POST['atribut'];
    $nouValor = $_POST['nou_valor'];
    
    modificarAtributUsuari($uid, $unorg, $atribut, $nouValor);
}
?>

<html>
<head>
    <title>Modificar Atributs d'Usuari LDAP</title>
</head>
<body>
    <h2>Formulari de modificar Atributs d'Usuari LDAP</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label>UID:</label>
        <input type="text" name="uid" required><br>
        <label>Unitat organitzativa:</label>
        <input type="text" name="unorg" required><br>
        <label>Selecciona l'atribut a modificar:</label><br>
        <input type="radio" name="atribut" value="uidNumber"> uidNumber<br>
        <input type="radio" name="atribut" value="gidNumber"> gidNumber<br>
        <input type="radio" name="atribut" value="homeDirectory"> Directori personal<br>
        <input type="radio" name="atribut" value="loginShell"> Shell<br>
        <input type="radio" name="atribut" value="cn"> cn<br>
        <input type="radio" name="atribut" value="sn"> sn<br>
        <input type="radio" name="atribut" value="givenName"> givenName<br>
        <input type="radio" name="atribut" value="postalAddress"> PostalAdress<br>
        <input type="radio" name="atribut" value="mobile"> mobile<br>
        <input type="radio" name="atribut" value="telephoneNumber"> telephoneNumber<br>
        <input type="radio" name="atribut" value="title"> title<br>
        <input type="radio" name="atribut" value="description"> description<br>
        <label>Nou valor:</label>
        <input type="text" name="nou_valor" required><br>
        <input type="submit" value="Modificar Atribut">
    </form>
    <br>
    <a href="menu.php">Torna al menú</a>
</body>
</html>