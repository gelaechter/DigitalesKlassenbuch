<?php
    require './auth.php';
    //require '../../openid/auth.php';
 
   echo "<h3> Infos aus dem Scope 'name' und 'email' </h3>";
   echo 'Name  :'.$_SESSION['name'].'<br><br>';

   echo 'Email :'.$_SESSION['email'].'<br><br>';
  

   echo "<h3> Infos aus dem Scope 'groups' </h3>";
   $groups_object = $_SESSION['groups'];
   $groups_array = get_object_vars($groups_object);

   $user_isLehrer = false;
   $user_isSchulleitung = false;
   
   $user_abitur = null;
   $user_klasse = null;
   $user_klassen = array();
   $user_klassenLehrer = array();


   foreach($groups_array as $key => $value) {
    
     echo "$key => ";

     $group_vars = get_object_vars($value);

    // Iteration über die Gruppen, Gruppen als Array
    // key 'name' gibt den Gruppennamen in lesbarer Form ("Schülerfirma" statt "schuelerfirma") an
    
    // Hier ist die Stelle zur Prüfung auf bestimmte Gruppenzugehörigkeiten
    // wenn abseits eines Rechtemanagements in der einzelnen Anwendung z.B. Grundlegende Merkmale wie
    // Lehrer? Mitglied der Schulleitung? Abiturjahrgang? Klasse?
    // ermittelt werden sollen.

     foreach($group_vars as $gkey => $gvalue){
       echo "[$gkey : $gvalue] ";
     }
  
     //Gruppe "Lehrer" 
     if($group_vars['name'] ===  "Lehrer"){
       $user_isLehrer = true;
     }

     //Gruppe "Schulleitung"
     if($group_vars['name'] ===  "Schulleitung"){
      $user_isSchulleitung = true;
     }

    //Gruppennamen nach dem Muster 'AbiturXXXX' zur Ermittlung des Abiturjahrgangs heranziehen.
    //Werden mehrere Zugehörigkeiten gefunden, so dominiert die kleinste der Angaben (Szenario "Schülertutoren aus Jg. 11 in der Gruppe von Jg. 5")
    if(strpos($group_vars['name'],"Abitur")===0){
      $int = (int) filter_var($group_vars['name'], FILTER_SANITIZE_NUMBER_INT);  
      if(!$user_abitur || $user_abitur > $int){
	$user_abitur = $int;
      }
     }

    //Gruppennamen "Klasse XYZ" werden zur Bestimmung der Klassenzugehörigkeit in der Sek. I herangezogen.
    //Bei mehreren Klassengruppen dominiert die erste, die gefunden wurde
    //Was nicht so klug ist, da z.B. wieder die Schülertutoren z.B. in der 11a und der 5b sein können.
    //Besser wäre also auch noch eine Plausibilitätsprüfung nach Abiturjahrgang und zunächst das Sammeln aller Klassennamen in einem Array...
    if( strpos($group_vars['name'],"Klasse ")===0){
      $klasse = substr($group_vars['name'], 7);
     
      $jahrgang = (int) filter_var($klasse, FILTER_SANITIZE_NUMBER_INT);  
      $user_klassen[] = $klasse;
     
      if(!$user_klasse){
	$user_klasse = $klasse;
      }
     }
     

    //Gruppennamen "Lehrer XYZ" werden zur Bestimmung der Lehrer einer Klasse in der Sek. I herangezogen.
    if(strpos($group_vars['name'],"Lehrer ")===0){
      $klasse = substr($group_vars['name'], 7);     
      $user_klassenLehrer[] = $klasse;     
     }



     echo "<br>";
   } 
  echo "<br>";

  echo "<b>Aus den Gruppennamen extrahierte Eigenschaften des Users </b><br>";
  echo "user_isLehrer : $user_isLehrer<br>";
  echo "user_isSchulleitung : $user_isSchulleitung<br>";
  echo "Abitur : $user_abitur<br>";
  echo "Stammklasse : $user_klasse<br>";
  
  $user_klassen_liste = "";
  foreach($user_klassen as $k => $v){
    $user_klassen_liste .= ", ".$v;
  }
  $user_klassen_liste = substr($user_klassen_liste, 2);

  echo "Klassengruppen : $user_klassen_liste <br>";
  

  $user_klassenLehrer_liste = "";
  foreach($user_klassenLehrer as $k => $v){
    $user_klassenLehrer_liste .= ", ".$v;
  }
  $user_klassenLehrer_liste = substr($user_klassenLehrer_liste, 2);

  echo "Lehrer-Klassengruppen : $user_klassenLehrer_liste <br>";


  
  echo "<h3> Aus allen Scopes übermittelte Infos 'requestUserInfo()' </h3>";

  $userinfo_object = $_SESSION['userinfo'];
  $userinfo_array = get_object_vars($userinfo_object);

  foreach($userinfo_array as $key => $value){
   
    if(!is_object($value)){
     echo "$key : $value <br>";
    } else {
      echo "$key : (object) <br>";
    }
  } 


  echo "<h3> Im Session-Array gespeicherte Informationen für das Klassenbuch</h3>";

  $user_iserv = $_SESSION['user_iserv'];
  if(!$user_iserv){$user_iserv="NULL";}
  
  $user_lehrer_id = $_SESSION['user_lehrer_id'];
  if(!$user_iserv){$user_iserv="NULL";}

  $user_schueler_id = $_SESSION['user_schueler_id'];
  if(!$user_schueler_id){$user_schueler_id="NULL";}

  echo "user_iserv : ". $user_iserv."<br>" ;   
  echo "user_lehrer_id : ".$user_lehrer_id."<br>";
  echo "user_schueler_id : ".$user_schueler_id."<br>";
   
  session_destroy();

?>
