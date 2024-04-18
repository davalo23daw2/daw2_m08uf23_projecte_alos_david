<?php
session_start();

if(!isset($_SESSION['auth']) || $_SESSION['auth'] !== true) {
    header("location: login.php");
    exit;
}

require 'vendor/autoload.php';
use Laminas\Ldap\Attribute;
use Laminas\Ldap\Ldap;

// Funció per afegir un usuari
function afegirUsuari($uid, $unorg, $uidNumber, $gidNumber, $dir_pers, $sh, $cn, $sn, $nom, $adressa, $mobil, $telefon, $titol, $descripcio) {
    // Estableix les opcions de connexió LDAP
    $domini = 'dc=fjeclot,dc=net';
    $opcions = [
        'host' => 'zend-daalga.fjeclot.net',
        'username' => "cn=admin,$domini",
        'password' => 'fjeclot',
        'bindRequiresDn' => true,
        'accountDomainName' => 'fjeclot.net',
        'baseDn' => 'dc=fjeclot,dc=net',
    ];
    
    // Crea una nova connexió LDAP i vincula
    $ldap = new Ldap($opcions);
    $ldap->bind();
    
    // Crea un array amb els atributs de l'usuari
    $nova_entrada = [];
    // Defineix els atributs amb els valors proporcionats
    Attribute::setAttribute($nova_entrada, 'objectClass', ['inetOrgPerson', 'organizationalPerson', 'person', 'posixAccount', 'shadowAccount', 'top']);
    Attribute::setAttribute($nova_entrada, 'uid', $uid);
    Attribute::setAttribute($nova_entrada, 'ou', $unorg);
    Attribute::setAttribute($nova_entrada, 'uidNumber', $uidNumber);
    Attribute::setAttribute($nova_entrada, 'gidNumber', $gidNumber);
    Attribute::setAttribute($nova_entrada, 'homeDirectory', $dir_pers);
    Attribute::setAttribute($nova_entrada, 'loginShell', $sh);
    Attribute::setAttribute($nova_entrada, 'cn', $cn);
    Attribute::setAttribute($nova_entrada, 'sn', $sn);
    Attribute::setAttribute($nova_entrada, 'givenName', $nom);
    Attribute::setAttribute($nova_entrada, 'postalAddress', $adressa);
    Attribute::setAttribute($nova_entrada, 'mobile', $mobil);
    Attribute::setAttribute($nova_entrada, 'telephoneNumber', $telefon);
    Attribute::setAttribute($nova_entrada, 'title', $titol);
    Attribute::setAttribute($nova_entrada, 'description', $descripcio);
    
    // Crea el DN per a la nova entrada
    $dn = "uid=$uid,ou=$unorg,$domini";
    
    // Afegeix l'entrada LDAP
    if ($ldap->add($dn, $nova_entrada)) {
        echo "Usuari afegit amb èxit.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_POST['uid'];
    $unorg = $_POST['unorg'];
    $uidNumber = $_POST['uidNumber'];
    $gidNumber = $_POST['gidNumber'];
    $dir_pers = $_POST['dir_pers'];
    $sh = $_POST['sh'];
    $cn = $_POST['cn'];
    $sn = $_POST['sn'];
    $nom = $_POST['nom'];
    $adressa = $_POST['adressa'];
    $mobil = $_POST['mobil'];
    $telefon = $_POST['telefon'];
    $titol = $_POST['titol'];
    $descripcio = $_POST['descripcio'];
    
    afegirUsuari($uid, $unorg, $uidNumber, $gidNumber, $dir_pers, $sh, $cn, $sn, $nom, $adressa, $mobil, $telefon, $titol, $descripcio);
}
?>

<html>
<head>
    <title>Afegir Usuari LDAP</title>
</head>
<body>
    <h2>Formulari d'afegir Usuari LDAP</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label>UID:</label>
        <input type="text" name="uid" required><br>
        <label>Unitat organitzativa:</label>
        <input type="text" name="unorg" required><br>
        <label>uidNumber:</label>
        <input type="text" name="uidNumber" required><br>
        <label>gidNumber:</label>
        <input type="text" name="gidNumber" required><br>
        <label>Directori personal:</label>
        <input type="text" name="dir_pers" required><br>
        <label>Shell:</label>
        <input type="text" name="sh" required><br>
        <label>cn:</label>
        <input type="text" name="cn" required><br>
        <label>sn:</label>
        <input type="text" name="sn" required><br>
        <label>givenName:</label>
        <input type="text" name="nom" required><br>
        <label>PostalAdress:</label>
        <input type="text" name="adressa" required><br>
        <label>mobile:</label>
        <input type="text" name="mobil" required><br>
        <label>telephoneNumber:</label>
        <input type="text" name="telefon" required><br>
        <label>title:</label>
        <input type="text" name="titol" required><br>
        <label>description:</label>
        <input type="text" name="descripcio" required><br>
        <input type="submit" value="Afegir Usuari">
    </form>
    <br>
    <a href="menu.php">Torna al menú</a>
</body>
</html>
