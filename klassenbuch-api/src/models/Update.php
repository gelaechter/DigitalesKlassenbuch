<?php
    class Update {
        
		public static function check_belegung() {            
			try {
				$db = new DB();
                $conn = $db->connect();
                
				$stmt = $conn->prepare('
					SELECT DISTINCT b.*, g.name, s.vorname, s.nachname
					FROM update_belegung b
					
					LEFT OUTER JOIN update_gruppe g ON (
						(g.danis_gruppe_id = b.danis_gruppe_id AND b.danis_gruppe_id IS NOT NULL)
						OR 
						(g.apollon_gruppe_id = b.apollon_gruppe_id AND b.apollon_gruppe_id IS NOT NULL AND b.danis_gruppe_id IS NULL)
					)
					
					LEFT OUTER JOIN update_schueler s ON (
							(s.danis_schueler_id = b.danis_schueler_id AND b.danis_schueler_id IS NOT NULL AND b.apollon_schueler_id IS NULL)
							OR 
							(s.apollon_schueler_id = b.apollon_schueler_id AND b.apollon_schueler_id IS NOT NULL)
					)		


					');
                				
                $stmt->execute();
                $update_belegung = $stmt->fetchAll(PDO::FETCH_ASSOC);              
				
				
				$stmt = $conn->prepare('
					SELECT b.id, g.name, s.vorname, s.nachname, 
					s.danis_id as danis_schueler_id,
					s.apollon_id as apollon_schueler_id,
					g.danis_id as danis_gruppe_id,
					g.apollon_id as apollon_gruppe_id,
					b.beginn, b.ende
					FROM belegung b
					LEFT OUTER JOIN gruppe g ON (g.id = b.gruppe_id)
					LEFT OUTER JOIN schueler s ON (s.id = b.schueler_id)
					');
                				
                $stmt->execute();
                $belegung = $stmt->fetchAll(PDO::FETCH_ASSOC);              

				$result = array();
				$result["belegung"] = $belegung;
				$result["update_belegung"] = $update_belegung;

                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            return json_encode($result);;
        }
		
		  
		public static function check_schueler() {            
			try {
				$db = new DB();
                $conn = $db->connect();
                
				$stmt = $conn->prepare('
					SELECT s.id, s.vorname, s.nachname,
					s.danis_schueler_id,
					s.apollon_schueler_id,
					s.iserv,
					g.name as stammgruppe
					FROM update_schueler s
					LEFT JOIN update_gruppe g ON g.danis_gruppe_id = s.danis_gruppe_id

					');
                				
				//Stammgruppen als Namen			


                $stmt->execute();
                $update_schueler_tmp = $stmt->fetchAll(PDO::FETCH_ASSOC);              
				
				//Bereinigung von update_schueler um doppelte Einträge der Sek. II - Schüler:
				//Danis und Apollon liefern Sek. II - SuS.
				//Wenn möglich, über die Danis-ID zusammenführen.

				
				foreach($update_schueler_tmp as &$sus){					
					$sus['loeschbar'] = 0;

					if($sus['apollon_schueler_id'] && $sus['danis_schueler_id']){

						foreach($update_schueler_tmp as &$sus2){
							if($sus2['danis_schueler_id']
								&& $sus2['danis_schueler_id'] == $sus['danis_schueler_id']
								&& $sus2['id'] != $sus['id']){
									
									$sus2['apollon_schueler_id'] = $sus['apollon_schueler_id'];
									if($sus['iserv'] && !$sus2['iserv']){
										$sus2['iserv'] = $sus['iserv'];
									}

									$sus['loeschbar'] = 1;
							}						
						}
						unset($sus2);
					}
				}
				unset($sus);

				$update_schueler = array();
				foreach( $update_schueler_tmp as $sus){
					if($sus['loeschbar']==0){
						$row = $sus;
						unset($row['loeschbar']);
						array_push($update_schueler,$row);
					}
				}
				


				
				$stmt = $conn->prepare('
					SELECT s.id, s.vorname, s.nachname,
					s.danis_id as danis_schueler_id,
					s.apollon_id as apollon_schueler_id,
					s.iserv,
					g.name as stammgruppe
					FROM schueler s
					LEFT JOIN gruppe g ON g.id = s.gruppe_id
					WHERE s.geloescht = 0
					');
                				
                $stmt->execute();
                $schueler = $stmt->fetchAll(PDO::FETCH_ASSOC);              

				$result = array();
				$result["schueler"] = $schueler;
				$result["update_schueler"] = $update_schueler;

                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            return json_encode($result);;
        }



		public static function check_gruppe() {            
			try {
				$db = new DB();
                $conn = $db->connect();
                
				$stmt = $conn->prepare('
					SELECT g.id, g.name, g.lehrer_kuerzel,
					g.danis_gruppe_id,
					g.apollon_gruppe_id					
					FROM update_gruppe g
					');
                				
				


                $stmt->execute();
                $update_gruppe = $stmt->fetchAll(PDO::FETCH_ASSOC);              
				
				
				$stmt = $conn->prepare('
						SELECT g.id, g.name, l.kuerzel as lehrer_kuerzel,
						g.danis_id as danis_gruppe_id,
						g.apollon_id as apollon_gruppe_id, COUNT(u.id) as unterricht_count
						FROM gruppe g
						LEFT JOIN lehrer l ON l.id = g.lehrer_id
						LEFT JOIN unterricht u ON u.gruppe_id = g.id
						WHERE g.geloescht = 0
						GROUP BY g.id
					');
                				
                $stmt->execute();
                $gruppe = $stmt->fetchAll(PDO::FETCH_ASSOC);              

				$result = array();
				$result["gruppe"] = $gruppe;
				$result["update_gruppe"] = $update_gruppe;

                $conn = null;
            } catch (PDOException $ex) {
                echo '{"error": {"message": "'.$ex->getMessage().'"}}';
            }
        
            return json_encode($result);;
        }





        
    }
?>