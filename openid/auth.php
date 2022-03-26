<?php

use Jumbojett\OpenIDConnectClient;
error_reporting(E_ALL);

session_start();

if (isset($_SESSION['klassenbuch_logged_in'])) {

} else {
    require "vendor/autoload.php";

    $server = 'https://jag-emden.eu';
    $clientID = '';
    $clientSecret = '';

    $oidc = new OpenIDConnectClient($server, $clientID, $clientSecret);
    $oidc->addScope('openid');
    $oidc->addScope('profile');
    $oidc->addScope('email');
    $oidc->addScope('groups');

    $oidc->authenticate();

    //Flag für erfolgtes Login setzen
    $_SESSION['klassenbuch_logged_in'] = true;

    //Iserv-Benutzernamen "arne.ulrichs" aus der Emailadresse ableiten.
    $email = $oidc->requestUserInfo('email');
    $user_iserv = substr($email,0,strpos($email,'@'));
    $_SESSION['user_iserv'] = $user_iserv;

    //Klasse für DB-Verbindung (übernommen aus dem Slim-Framework)
    class DB {
        private $dbuser = '';
        private $dbpass = '';
        private $connect_string = 'mysql:host=;dbname=;charset=utf8';
        public function connect() {
            $connection = new PDO($this->connect_string, $this->dbuser, $this->dbpass);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $connection;
        }
    }

    //Lehrer-ID suchen, null falls Nichtlehrer
    $user_lehrer_id = null;

    try {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->prepare('SELECT id FROM lehrer WHERE iserv = :iserv');
        $stmt->bindParam(':iserv', $user_iserv);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $id = $result['id'];

        $conn = null;
    } catch (PDOException $ex) {
        echo '{"error": {"message": "' . $ex->getMessage() . '"}}';
        session_destroy();
        die();
    }

    if ($id) {
        $user_lehrer_id = $id;
    }

    $_SESSION['user_lehrer_id'] = $user_lehrer_id;

    //Schüler-ID suchen, null falls Nichtschüler
    $user_schueler_id = null;

    try {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->prepare('SELECT id FROM schueler WHERE iserv = :iserv');
        $stmt->bindParam(':iserv', $user_iserv);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $id = $result['id'];

        $conn = null;
    } catch (PDOException $ex) {
        echo '{"error": {"message": "' . $ex->getMessage() . '"}}';
        session_destroy();
        die();
    }

    if ($id) {
        $user_schueler_id = $id;
    }

    $_SESSION['user_schueler_id'] = $user_schueler_id;


    //Report Login an LOG-Tabelle

    if (!$user_schueler_id && !$user_lehrer_id) {
        $msg = "WARN - unberechtiger Zugriff von IP " . $_SERVER['REMOTE_ADDR'];
    } else {
        $msg = "INFO - Login von IP " . $_SERVER['REMOTE_ADDR'];

        if($user_lehrer_id){
            $msg .= " als Lehrer #".$user_lehrer_id;
        }
        if($user_schueler_id){
            $msg .= " als Schueler #".$user_schueler_id;
        }
    }


    try {
        $db = new DB();
        $conn = $db->connect();
        $stmt = $conn->prepare('INSERT INTO log(`user_iserv`,`message`) VALUES (:user_iserv, :msg)');
        $stmt->bindParam(':user_iserv', $user_iserv);
        $stmt->bindParam(':msg', $msg);
        $stmt->execute();    
        
        $conn = null;
    } catch (PDOException $ex) {
        echo '{"error": {"message": "'.$ex->getMessage().'"}}';
        session_destroy();
        die();
    }

    if (!$user_schueler_id && !$user_lehrer_id) {
        session_destroy();
        die();
    }

    $name = $oidc->requestUserInfo('name');
    $groups = $oidc->requestUserInfo('groups');
    $info = $oidc->requestUserInfo(); // more info, such as groups according to OAuth scopes

    $_SESSION['name'] = $name;
    $_SESSION['groups'] = $groups;
    $_SESSION['userinfo'] = $info;
    $_SESSION['email'] = $email;
}

?>
