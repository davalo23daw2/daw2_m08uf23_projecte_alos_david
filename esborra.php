<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header("location: login.php");
    exit;
}

require 'vendor/autoload.php';
use Laminas\Ldap\Ldap;

function esborrarUsuari($uid, $unorg) {
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
    
    // Crea el DN per a l'entrada de l'usuari que es vol esborrar
    $dn = "uid=$uid,ou=$unorg,$domini";
    
    // Intenta esborrar l'entrada LDAP
    if ($ldap->delete($dn)) {
        echo "Usuari esborrat amb èxit.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_POST['uid'];
    $unorg = $_POST['unorg'];
    
    esborrarUsuari($uid, $unorg);
}
?>

<html>
<head>
    <title>Esborrar Usuari LDAP</title>
</head>
<body>
    <h2>Formulari d'esborrar Usuari LDAP</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label>UID:</label>
        <input type="text" name="uid" required><br>
        <label>Unitat organitzativa:</label>
        <input type="text" name="unorg" required><br>
        <input type="submit" value="Esborrar Usuari">
    </form>
    <br>
    <a href="menu.php">Torna al menú</a>
</body>
</html>