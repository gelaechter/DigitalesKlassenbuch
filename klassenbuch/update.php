<?php
    require './auth.php'
    //require '../../openid/auth.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Klassenbuch</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="css/bootstrap-icons.css" rel="stylesheet">
    

</head>



<body>


    <?php include './navbar.php' ?>



    <section>
        <div class="container-fluid  bg-secondary text-white">
            
            <div class="row mt-2 py-2">
                <div class="input-group col-md">
                    <button class="btn btn-secondary"  onclick="reset()" >
                        <i class="bi-plus-square pr-2"></i>Anzeigen + Speicher löschen
                    </button>
                </div>   

                <div class="input-group col-md">
                    <button class="btn btn-secondary"  onclick="update_execute(0)" >
                        <i class="bi-plus-square pr-2"></i>Vorschau API-Requests
                    </button>
                </div>  

                <div class="input-group col-md">
                    <button class="btn btn-danger"  onclick="btn_update_execute()" >
                        <i class="bi-plus-square pr-2"></i>Ausführen API-Requests
                    </button>
                </div>  

                <!--
                <div class="input-group col-md">
                    <button class="btn btn-secondary"  onclick="btn_update_all()" >
                        <i class="bi-plus-square pr-2"></i>Updateroutine starten
                    </button>
                </div>   
                -->

             
                <div class="input-group col-md">
                    <div class="btn-group" role="group" id="btngrp_freigabe">
                        <button class="btn btn-secondary"  onclick="btn_freigabe()" id="btn_freigabe">
                            <i class="bi-check pr-2"></i>Zustimmungsabgabe "<span id="freigabe_txt"></span>"
                        </button>
                        <button class="btn btn-danger"  onclick="btn_fq_cancel()" >
                            <i class="bi-cancel pr-2"></i> Abbruch
                        </button>
                    </div>
                </div>   

                <div class="input-group col-md">
                     <span class="badge bg-info" id="fq_info"></span>
                </div>   
 <!--  
                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="freistellungNeu" onclick="freistellungNeu()" >
                        <i class="bi-plus-square pr-2"></i>Beurlaubung (schulisch)
                    </button>
                </div>   

                -->

            </div>


        </div>
    </section>


 <section>
        <div class="container-fluid  p-3 my-3 bg-dark text-white">
            <h3>1. Gruppen</h3>
            <div class="row mt-2 py-2">
                <!--
                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="entschuldigungNeu" onclick="btn_gruppe_abgleichen()" >
                        <i class="bi-plus-square pr-2"></i>Daten prüfen
                    </button>
                </div>   

             
                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="beurlaubungNeu" onclick="update_execute(0)" >
                        <i class="bi-plus-square pr-2"></i>Update-API-Requests vorhersagen
                    </button>
                </div>  
                -->

                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="" onclick="btn_gruppe_weg()" >
                        <i class="bi-plus-square pr-2"></i>Check DELETE
                    </button>
                </div>  

                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="" onclick="btn_gruppe_neu()" >
                        <i class="bi-plus-square pr-2"></i>Check INSERT
                    </button>
                </div>  

                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="" onclick="btn_gruppe_update()" >
                        <i class="bi-plus-square pr-2"></i>Check UPDATE
                    </button>
                </div>  

            </div>

            <table class="table table-sm table-striped table-light table-bordered">    
                <thead>
                    <tr>
                        <th>ID (Klabu)</th>
                        <th>ID (Update)</th>
                        <th>DanisID</th>
                        <th>ApollonID</th>
                        <th>Name</th>
                        <th>Lehrer</th>
                        <th>Aktion</th>
                    </tr>
                </thead>
                <tbody id="tbody_gruppe">

                </tbody>
            
            </table>
		</div>
    </section>
    

   
    <section>
        <div class="container-fluid  p-3 my-3 bg-dark text-white">
            <h3>2. Schüler</h3>
            
            <div class="row mt-2 py-2">
                <!--
                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="entschuldigungNeu" onclick="btn_sus_abgleichen()" >
                        <i class="bi-plus-square pr-2"></i>Daten prüfen
                    </button>
                </div>   

             
                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="beurlaubungNeu" onclick="update_execute(0)" >
                        <i class="bi-plus-square pr-2"></i>Update-API-Requests vorhersagen
                    </button>
                </div>  
                -->

                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="" onclick="btn_schueler_weg()" >
                        <i class="bi-plus-square pr-2"></i>Check DELETE
                    </button>
                </div>  

                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="" onclick="btn_schueler_neu()" >
                        <i class="bi-plus-square pr-2"></i>Check INSERT
                    </button>
                </div>  

                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="" onclick="btn_schueler_update()" >
                        <i class="bi-plus-square pr-2"></i>Check UPDATE
                    </button>
                </div>  

            </div>

            <table class="table table-sm table-striped table-light table-bordered">    
                <thead>
                    <tr>
                        <th>ID (Klabu)</th>
                        <th>ID (Update)</th>
                        <th>DanisID</th>
                        <th>ApollonID</th>
                        <th>Name</th>
                        <th>Vorname</th>
                        <th>Iserv</th>
                        <th>Stammgruppe</th>
                        <th>Aktion</th>
                    </tr>
                </thead>
                <tbody id="tbody_schueler">

                </tbody>
            
            </table>
		</div>
    </section>
    

   

    <section>
        <div class="container-fluid  p-3 my-3 bg-dark text-white">
            <h3>3. Belegungen</h3>

            <div class="row mt-2 py-2">
                <!--
                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="entschuldigungNeu" onclick="btn_belegung_abgleichen()" >
                        <i class="bi-plus-square pr-2"></i>Daten prüfen
                    </button>
                </div>   

             
                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="beurlaubungNeu" onclick="update_execute(0)" >
                        <i class="bi-plus-square pr-2"></i>Update-API-Requests vorhersagen
                    </button>
                </div>  
                -->

                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="" onclick="btn_belegung_weg()" >
                        <i class="bi-plus-square pr-2"></i>Check DELETE
                    </button>
                </div>  

                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="" onclick="btn_belegung_neu()" >
                        <i class="bi-plus-square pr-2"></i>Check INSERT
                    </button>
                </div>  

                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="" onclick="btn_belegung_update()" >
                        <i class="bi-plus-square pr-2"></i>Check UPDATE
                    </button>
                </div>  

            </div>

            <table class="table table-sm table-striped table-light table-bordered">    
                <thead>
                    <tr>
                        <th>ID (Klabu)</th>
                        <th>ID (Update)</th>
                        <th>Danis-Schüler-ID</th>
                        <th>Apollon-Schüler-ID</th>
                        <th>Danis-Gruppen-ID</th>
                        <th>ApollonGruppen-ID</th>
                        <th>Gruppe</th>
                        <th>Beginn</th>
                        <th>Ende</th>
                        <th>Aktion</th>
                    </tr>
                </thead>
                <tbody id="tbody_belegung">

                </tbody>
            
            </table>
		</div>
    </section>
    


    <section>
        <div class="container-fluid  my-3 bg-dark text-white" id ="ausgabe">

		</div>
    </section>


   

     <!-- Formular fuer das Anlegen/Aendern von Unterrichten -->
            
     <div class="modal fade" id="erledigungModal" tabindex="-1" aria-labelledby="erledigungModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="erledigungModalLabel"><span id="erledigungModalSchueler"></span> - <span id="erledigungModalText"></span></h5>                          
                    </div>
    
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form class="m-3 p-3 bg-dark needs-validation" novalidate>
                                
                                 <!-- erste Zeile -->
                                <div class="row">
                                   
                                    <div class="input-group col-md-6" data-bs-toggle="tooltip" data-bs-placement="top" title="Wähle das Datum der Registrierung / Kontrolle / des Gültigkeitsbeginns ">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <!-- Datum -->
                                                <i class="bi-calendar-date px-2"></i>von</span>
                                        </div>
                                        <input class="form-control" type="date" name="von" id="von" required>
                                    </div>

                                    <div class="input-group col-md-6" data-bs-toggle="tooltip" data-bs-placement="top" title="ab welcher Schulstunde?">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <!-- Stunde -->
                                                <i class="bi-clock px-2"></i>Stunde</span>
                                        </div>
                                        <select class="form-control" name="vonStunde" id="vonStunde"></select>
                                    </div>
                                   
                                </div>

                                  <!-- zweite Zeile -->
                                  <div class="row py-2">
                                   
                                   <div class="input-group col-md-6" data-bs-toggle="tooltip" data-bs-placement="top" title="Wähle das Datum der Registrierung / Kontrolle / des Gültigkeitsbeginns ">
                                       <div class="input-group-prepend">
                                           <span class="input-group-text">
                                               <!-- Datum -->
                                               <i class="bi-calendar-date px-2"></i>bis einschl.</span>
                                       </div>
                                       <input class="form-control" type="date" name="bis" id="bis" required>
                                   </div>

                                   <div class="input-group col-md-6" data-bs-toggle="tooltip" data-bs-placement="top" title="bis einschließlich welche Schulstunde?">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <!-- Stunde -->
                                                <i class="bi-clock px-2"></i>Stunde</span>
                                        </div>
                                        <select class="form-control" name="bisStunde" id="bisStunde"></select>
                                    </div>
                                  
                               </div>

                                
                                <!-- dritte Zeile -->
                                <div class="row py-2">                                                                       
                                   <div class="input-group col-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Wähle die abzeichnende Lehrkraft" id="signum">
                                        <div class="input-group-prepend">                                     
                                            <span class="input-group-text">                                                
                                                <!-- Lehrer -->
                                                <i class="bi-person px-2" id="signumKuerzel"></i>Signum
                                            </span>                                              
                                       </div>
                                       <select class="form-control" name="lehrer" id="lehrer" required></select>
                                   </div>
                                </div>
                            </form>      
                            

                            <div class="row m-3 p-3">                            
                                <div class="input-group mb-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Hier können (bald) weitere Erläuterungen hinterlegt werden. Momentan ohne Funktion">
                                    <button class="btn btn-info" type="button">
                                        <i class="bi-plus-square"></i> neue Mitteilung
                                    </button>
                                    <input type="text" class="form-control" id="mitteilungneu" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                </div>
                            </div>
                        
                        

                            <div id="mitteilung">
                            </div>

                            <div class="row m-3 p-3">
                                <div class="col-md">
                                    <small><span id="modalInfo"></span></small>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="modal-footer">
                        <div class="col-auto">
                            <button class="btn btn-danger float-right ml-3" type="button" id="loeschen">
                                <i class="bi-trash px-2"></i>Löschen
                            </button>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-secondary float-right ml-3" type="button" id="cancel">
                                <i class="bi-journal-x px-2"></i>Abbrechen
                            </button>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-success float-right ml-3" type="button" id="speichern">
                                <i class="bi-journal-check px-2"></i>Speichern
                            </button>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-success float-right ml-3" type="button" id="neu">
                                <i class="bi-plus-square px-2"></i>Neu anlegen
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

   



    <!-- Popper und Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha384-vtXRMe3mGCbOeY7l30aIg8H9p3GdeSe4IFlP6G8JMa7o7lXvnz3GFKzPxzJdPfGK"></script>

    <script>
       

       // Tooltips initialisieren
       var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        
        // Übernahme von Session-Information für Vorauswahlen
        var aktiv_gruppe_id = <?php echo $_SESSION['aktiv_gruppe_id'] ?: 'null' ?>;
        var aktiv_sitzplan_id = <?php echo $_SESSION['aktiv_sitzplan_id'] ?: 'null' ?>;
        var user_lehrer_id = <?php echo $_SESSION['user_lehrer_id'] ?: 'null' ?>;
        var user_schueler_id = <?php echo $_SESSION['user_schueler_id'] ?: 'null' ?>;

      
      
      
       
      
      
        /**
        * Deklaration globaler Variablen
        */
      
        var belegung = [];
        var update_belegung = [];

        var schueler = [];
        var update_schueler= [];

        var gruppe = [];
        var update_gruppe = [];

        var update_action = [];
        var action_id = 0;

        var klabu_lehrer = [];

        var chunk_treffer = 0;

        var ausgabe_id = 0;
        var ausgabe_tick = 0;
        var ausgabe_interval_id = null;
        var ausgabe_start = 0;

        var function_queue = [];


        var von_datum_nach_hj = ["2021-09-02", "2022-02-02","2022-08-25","2023-02-01"];
        var bis_datum_nach_hj = ["2022-01-30", "2022-07-13","2023-01-29","2023-07-05"];


        /*******************************************************
        * document OnReady
        */

        $("document").ready(function () {           
          

          /*
           $("#speichern").click(function() {modal_speichern(); $("#erledigungModal").modal('hide');});
           $("#neu").click(function() {modal_neu(); $("#erledigungModal").modal('hide');});
           $("#loeschen").click(function() {modal_loeschen(); $("#erledigungModal").modal('hide');});

           $('#gruppe').change(function() { read_schueler_by_gruppe($('#gruppe').val()); $('#liste').empty();});

           $('#schueler').change(function() {read_vorgaenge_by_schueler($('#schueler').val());});
            */

           
           //read_gruppen();
           //read_ustunden();
           
           read_lehrer();       
           $('#btngrp_freigabe').hide();
           

        });



        /********************************************
        * Handler
        */

        function api_request(freigabe, url, type, json, action_execute_id){
            
            if(freigabe == 1){           
            
                
                $.ajax({
                    type: type,
                    url: '/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/'+url,
                    data: json,
                    success: function (json) {
                        
                    },
                    error: function (e) {
                        console.log(e.message);
                        alert(e.message);
                    },
                    dataType: "json",
                    contentType: "application/json"
                }).then( function (e){                
                    setTimeout(update_execute_chunk(freigabe,action_execute_id),1);
                    
                });
                

            } else {
                ausgabe(type+" "+url+ " :"+json);
                setTimeout(function(){update_execute_chunk(freigabe,action_execute_id);},1);
            }
            
        }


        function update_execute(freigabe){

            if(freigabe==1){
                ausgabe('');
                ausgabe('*************  Update gestartet');
            } else {
                ausgabe('');
                ausgabe('*************  Update API-Request Vorschau gestartet');
            }

            update_execute_chunk(freigabe, 0);
        }


        function update_execute_chunk(freigabe, action_execute_id){
            
            if(action_execute_id >= update_action.length){
                fq_next();
                return;
            }

            a = update_action[action_execute_id];

                if(a.freigabe == 1){

                    //Soft-Delete von SuS
                    if(a.schritt == 1){
                        data = {geloescht : 1};                        
                        url = 'api/schueler/'+a.klabu_id;
                        json = JSON.stringify(data);
                        api_request(freigabe, url, 'PUT', json,action_execute_id+1);
                    }


                    //Insert von SuS
                    if(a.schritt == 2){
                        let us = update_schueler[a.update_index];
                        
                        //Stammgruppen-ID aus bestehenden Gruppen ermitteln                    
                        gruppe_id = null;                        
                        if(us.stammgruppe){
                            gruppe.forEach(g=>{
                                if(g.name == us.stammgruppe ){
                                    gruppe_id = g.id;
                                }
                            });
                        }
                        
                        data = {
                                vorname : us.vorname,
                                nachname : us.nachname,
                                danis_id : us.danis_schueler_id,
                                apollon_id : us.apollon_schueler_id,
                                iserv : us.iserv,
                                gruppe_id : gruppe_id
                            };                       

                        url = 'api/schueler';
                        json = JSON.stringify(data);
                        api_request(freigabe, url, 'POST', json,action_execute_id+1);
                    }

                    //Update von SuS
                    if(a.schritt == 3){
                        
                        data = a.data;      

                        if(data.stammgruppe){
                            //Stammgruppen-ID aus bestehenden Gruppen ermitteln                    
                            gruppe_id = null;                        
                            
                            gruppe.forEach(g=>{
                                if(g.name == data.stammgruppe ){
                                    gruppe_id = g.id;
                                }
                            });
                            
                            data.gruppe_id = gruppe_id;
                            delete data.stammgruppe;              
                        } 

                        if(data.stammgruppe === null){
                            data.gruppe_id = null;
                            delete data.stammgruppe;              
                        }

                        url = 'api/schueler/'+a.klabu_id;
                        json = JSON.stringify(data);
                        api_request(freigabe, url, 'PUT', json,action_execute_id+1);
                    }


                    //Soft-Delete von Gruppen
                    if(a.schritt == 4){
                        data = {geloescht : 1};                        
                        url = 'api/gruppe/'+a.klabu_id;
                        json = JSON.stringify(data);
                        api_request(freigabe, url, 'PUT', json,action_execute_id+1);
                    }

                    //Insert von Gruppen
                    if(a.schritt == 5){
                        let ug = update_gruppe[a.update_index];
                        
                        //Lehrer-ID nach Kürzel aus bestehenden Lehrern ermitteln   
                        lehrer_id = null;                        
                        if(ug.lehrer_kuerzel){
                            klabu_lehrer.forEach(l=>{
                                if(l.kuerzel == ug.lehrer_kuerzel ){
                                    lehrer_id = l.id;
                                }
                            });
                        }
                        
                        data = {
                                name : ug.name,
                                danis_id : ug.danis_gruppe_id,
                                apollon_id : ug.apollon_gruppe_id,
                                lehrer_id : lehrer_id                                
                            };                       

                        //Beim Einfügen von Sek.II-Gruppen (nur Apollon-ID) prüfen,
                        //ob bereits namensgleiche Gruppe mit DanisID oder kleinerer Apollon-ID existiert.
                        let treffer = false;
                        if(!ug.danis_gruppe_id){
                            update_gruppe.forEach(g=>{
                               if(g.name == ug.name && (g.danis_gruppe_id || g.apollon_gruppe_id < ug.apollon_gruppe_id)){
                                treffer = true;
                               } 
                            });
                        }

                        if(!treffer){
                            url = 'api/gruppe';
                            json = JSON.stringify(data);
                            api_request(freigabe, url, 'POST', json,action_execute_id+1);    
                        } else {
                            ausgabe ("Gruppe "+ug.name+" Action ID"+a.id+" wird wegen namensgleicher anderer Gruppe nicht eingefügt.");
                            update_execute_chunk(freigabe, action_execute_id+1);
                        }                        
                    }


                    //Update von Gruppen
                    if(a.schritt == 6){
                        let ug = update_gruppe[a.update_index];
                        data = a.data;

                        if ( data.lehrer_kuerzel ){
                            //Lehrer-ID nach Kürzel aus bestehenden Lehrern ermitteln   
                            lehrer_id = null;                        
                            if(ug.lehrer_kuerzel){
                                klabu_lehrer.forEach(l=>{
                                    if(l.kuerzel == ug.lehrer_kuerzel ){
                                        lehrer_id = l.id;
                                    }
                                });
                            }
                                                        
                            delete data.lehrer_kuerzel;
                            data.lehrer_id = lehrer_id;
                        }

                        if(data.lehrer_kuerzel === null){
                            data.lehrer_id = null;
                            delete data.lehrer_kuerzel;
                        }

                        url = 'api/gruppe/'+a.klabu_id;
                        json = JSON.stringify(data);
                        api_request(freigabe, url, 'PUT', json,action_execute_id+1);
                    }



                    //Beenden einer Belegung
                    if(a.schritt == 7){
                        data = {ende : new Date().toISOString().substr(0,10)};                        
                        url = 'api/belegung/'+a.klabu_id;
                        json = JSON.stringify(data);
                        api_request(freigabe, url, 'PUT', json,action_execute_id+1);
                    }


                    /**                    * 
                    * Für das Einfügen einer neuen Belegung muss (möglicherweise) auf eine erst gerade frisch
                    * eingefügte Gruppe oder person zurückgegriffen werden.
                    *
                    * Der Abgleich muss daher in Einzelschritten vollzogen werden
                    * 1. Gruppe. 2. Schüler 3.Belegungen
                    */
                    if(a.schritt==8){
                        let ub = update_belegung[a.update_index];
                        
                        //Beim Einfügen von Sek.II-Gruppen (nur Apollon-ID) prüfen,
                        //ob bereits namensgleiche Gruppe mit DanisID oder kleinerer Apollon-ID existiert.
                        let treffer = null;
                        if(!ub.danis_gruppe_id){
                            update_gruppe.forEach(g=>{
                               if(g.name == ub.name && (g.danis_gruppe_id || g.apollon_gruppe_id <= ub.apollon_gruppe_id)){
                                treffer = g;
                               } 
                            });
                        }
                        
                        if(treffer){
                            ub.danis_gruppe_id = treffer.danis_gruppe_id;
                            ub.apollon_gruppe_id = treffer.apollon_gruppe_id;
                            ub.gruppe_name = treffer.name;
                        }

                        //Suche der Gruppen-ID
                        let g_id = null;
                        gruppe.forEach(g=>{
                            if((ub.danis_gruppe_id && g.danis_gruppe_id == ub.danis_gruppe_id)
                                || (!ub.danis_gruppe_id && ub.gruppe_name == g.name)){
                                    g_id = g.id;
                                }
                        });

                        //Schüler-ID suchen
                        let s_id = null;
                        schueler.forEach(s=>{
                            if( (ub.danis_schueler_id && s.danis_schueler_id == ub.danis_schueler_id)
                                || (!ub.danis_schueler_id && ub.apollon_schueler_id == s.apollon_schueler_id) ){
                                    s_id = s.id;
                                }
                        });

                        if(!ub.von){
                            let von_index = (ub.von_hj-1);
                            ub.von = von_datum_nach_hj[von_index];                        
                        }

                        if(!ub.bis){
                            let bis_index = (ub.bis_hj-1);
                            ub.bis = bis_datum_nach_hj[bis_index];
                        }

                        data = {schueler_id : s_id,
                                gruppe_id : g_id,
                                beginn : ub.von,
                                ende : ub.bis};
                        
                        json = JSON.stringify(data);

                        if(s_id && g_id && ub.von && ub.bis){
                            url = 'api/belegung';                            
                            api_request(freigabe, url, 'POST', json,action_execute_id+1);  
                        } else {
                            ausgabe("INSERT Belegung Action #"+a.id+" fehlgeschlagen. Daten unvollständig "+json);
                            update_execute_chunk(freigabe, action_execute_id+1);
                        }

                    }


                    if (a.schritt == 9){
                        data = a.data;                      

                        url = 'api/belegung/'+a.klabu_id;
                        json = JSON.stringify(data);
                        api_request(freigabe, url, 'PUT', json,action_execute_id+1);
                    }


                } else {
                    ausgabe('Action #'+a.id+ ' wird nicht ausgeführt.');
                    update_execute_chunk(freigabe, action_execute_id+1);
                }            

        }


        function btn_update_all(){
            reset();
            
            fq_clear();
            fq_add("freigabe_start","Suche löschbarer Datensätze");
            fq_add("read_gruppe",null);
            fq_add("read_schueler",null);
            fq_add("read_belegung",null);
            
            fq_add("check_belegung_weg",null);
            fq_add("check_gruppe_weg",null);
            fq_add("check_schueler_weg",null);

            fq_add("zeige_action_sus",null);
            fq_add("zeige_action_gruppe",null);
            fq_add("zeige_action_belegung",null);

            fq_add("freigabe_start","Vorschau Lösch-Queries");            
            fq_add("ausgabe_clear",null);
            fq_add("update_execute",0);

            fq_add("freigabe_start","Ausführen Lösch-Queries");
            fq_add("ausgabe_clear",null);
            //fq_add("update_execute",1);

            
            fq_add("freigabe_start","Suche neuer Gruppen");            
            fq_add("ausgabe_clear",null);
            fq_add("reset",null);

            fq_add("read_gruppe",null);                      
            fq_add("check_gruppe_neu",null);
            fq_add("zeige_action_gruppe",null);

            fq_add("freigabe_start","Vorschau Insert-Queries");            
            fq_add("ausgabe_clear",null);
            fq_add("update_execute",0);

            fq_add("freigabe_start","Ausführen Insert-Queries");
            fq_add("ausgabe_clear",null);
            //fq_add("update_execute",1);


            fq_add("freigabe_start","Suche neuer Schüler");            
            fq_add("ausgabe_clear",null);
            fq_add("reset",null);

            fq_add("read_gruppe",null);                      
            fq_add("read_schueler",null);
            fq_add("check_schueler_neu",null);
            fq_add("zeige_action_schueler",null);

            fq_add("freigabe_start","Vorschau Insert-Queries");            
            fq_add("ausgabe_clear",null);
            fq_add("update_execute",0);

            fq_add("freigabe_start","Ausführen Insert-Queries");
            fq_add("ausgabe_clear",null);
            //fq_add("update_execute",1);


            fq_add("freigabe_start","Suche neuer Belegungen");            
            fq_add("ausgabe_clear",null);
            fq_add("reset",null);

            fq_add("read_gruppe",null);                      
            fq_add("read_schueler",null);
            fq_add("read_belegung",null);

            fq_add("check_belegung_neu",null);
            fq_add("zeige_action_belegung",null);

            fq_add("freigabe_start","Vorschau Insert-Queries");            
            fq_add("ausgabe_clear",null);
            fq_add("update_execute",0);

            fq_add("freigabe_start","Ausführen Insert-Queries");
            fq_add("ausgabe_clear",null);
            //fq_add("update_execute",1);


            fq_add("freigabe_start","Suche veränderter Datensätze");            
            fq_add("ausgabe_clear",null);
            fq_add("reset",null);

            fq_add("read_gruppe",null);                      
            fq_add("read_schueler",null);
            fq_add("read_belegung",null);

            fq_add("check_belegung_update",null);
            fq_add("check_gruppe_update",null);
            fq_add("check_schueler_update",null);
            
            fq_add("zeige_action_schueler",null);
            fq_add("zeige_action_gruppe",null);
            fq_add("zeige_action_belegung",null);
                        

            fq_add("freigabe_start","Vorschau Update-Queries");            
            fq_add("ausgabe_clear",null);
            fq_add("update_execute",0);

            fq_add("freigabe_start","Ausführen Update-Queries");
            fq_add("ausgabe_clear",null);
            //fq_add("update_execute",1);
           
            
            fq_start();


        }

        function reset(){
            update_action=[];

            schueler = [];
            update_schueler=[];

            belegung = [];
            update_belegung=[];

            gruppe = [];
            update_gruppe=[];

            action_id = 0;

            function_queue = [];
            btn_anzeige_reset();

            
        }

        function btn_anzeige_reset(){
            $('#ausgabe').empty();
            $('#tbody_schueler').empty();
            $('#tbody_gruppe').empty();
            $('#tbody_belegung').empty();
        }
       

       function btn_update_execute(){            
            fq_clear();
            fq_add("freigabe_start","Ausführen API-Anfragen");
            fq_add("ausgabe_clear",null);
            fq_add("update_execute",1);
            fq_add("reset",null);            
            fq_start();
       }

       function btn_gruppe_weg(){
            reset();
            fq_clear();
            fq_add("read_gruppe",null);
            fq_add("check_gruppe_weg",null);
            fq_add("zeige_action_gruppe", null);
            fq_start();
       }


       function btn_gruppe_neu(){
            reset();
            fq_clear();
            fq_add("read_gruppe",null);
            fq_add("check_gruppe_neu",null);
            fq_add("zeige_action_gruppe", null);
            fq_start();
       }



       function btn_gruppe_update(){
            reset();
            fq_clear();
            fq_add("read_gruppe",null);
            fq_add("check_gruppe_update",null);
            fq_add("zeige_action_gruppe", null);
            fq_start();
       }



       function btn_schueler_weg(){
            reset();
            fq_clear();
            fq_add("read_gruppe",null);
            fq_add("read_schueler",null);
            fq_add("check_schueler_weg",null);
            fq_add("zeige_action_sus", null);
            fq_start();
       }


       function btn_schueler_neu(){
            reset();
            fq_clear();
            fq_add("read_gruppe",null);
            fq_add("read_schueler",null);
            fq_add("check_schueler_neu",null);
            fq_add("zeige_action_sus", null);
            fq_start();
       }



       function btn_schueler_update(){
            reset();
            fq_clear();
            fq_add("read_gruppe",null);
            fq_add("read_schueler",null);
            fq_add("check_schueler_update",null);
            fq_add("zeige_action_sus", null);
            fq_start();
       }



       function btn_belegung_weg(){
            reset();
            fq_clear();
            fq_add("read_gruppe",null);
            fq_add("read_schueler",null);
            fq_add("read_belegung",null);
            fq_add("check_belegung_weg",null);
            fq_add("zeige_action_belegung", null);
            fq_start();
       }


       function btn_belegung_neu(){
            reset();
            fq_clear();
            fq_add("read_gruppe",null);
            fq_add("read_schueler",null);
            fq_add("read_belegung",null);
            fq_add("check_belegung_neu",null);
            fq_add("zeige_action_belegung", null);
            fq_start();
       }


       function btn_belegung_update(){
            reset();
            fq_clear();
            fq_add("read_gruppe",null);
            fq_add("read_schueler",null);
            fq_add("read_belegung",null);
            fq_add("check_belegung_update",null);
            fq_add("zeige_action_belegung", null);
            fq_start();
       }




        function btn_sus_abgleichen(){
            $('#ausgabe').empty();
            $('#tbody_schueler').empty();
            $('#tbody_gruppe').empty();
            $('#tbody_belegung').empty();

            update_action=[];

            //read_gruppe(1);

            fq_clear();
            fq_add("freigabe_start","Gruppen einlesen");
            fq_add("read_gruppe",null);
            fq_add("read_schueler",null);
            fq_add("freigabe_start","Löschbare Schüler ermitteln.");
            fq_add("check_schueler_weg",null);
            fq_add("check_schueler_neu", null);
            fq_add("check_schueler_update", null);
            fq_add("zeige_action_sus", null);

            fq_start();
            
        }

        function btn_gruppe_abgleichen(){
            $('#ausgabe').empty();
            $('#tbody_schueler').empty();
            $('#tbody_gruppe').empty();
            $('#tbody_belegung').empty();

            update_action=[];

            fq_clear();
            fq_add("read_gruppe",null);
            fq_add("check_gruppe_weg",null);
            fq_add("check_gruppe_neu",null);
            fq_add("check_gruppe_update",null);
            fq_add("zeige_action_gruppe",null);
            
           
            fq_add("freigabe_start","Vorschau API-Anfragen");            
            fq_add("ausgabe_clear",null);
            fq_add("update_execute",0);

            fq_add("freigabe_start","Ausführen API-Anfragen");
            fq_add("ausgabe_clear",null);
            //fq_add("update_execute",1);
           
            
            fq_start();
            
        }

        function btn_belegung_abgleichen(){
            $('#ausgabe').empty();
            $('#tbody_schueler').empty();
            $('#tbody_gruppe').empty();
            $('#tbody_belegung').empty();

            update_action=[];

            //read_gruppe(7);            
        }

        var freigabe_blinkstatus = true;
        var freigabe_interval_id = null;

        function freigabe_start(txt){
            $('#freigabe_txt').text(txt);
            $('#btngrp_freigabe').show();
            freigabe_blinkstatus = true;
            freigabe_interval_id = setInterval(freigabe_blinken,400);
        }

        function freigabe_blinken(){
            $('#btn_freigabe').removeClass()
            if(freigabe_blinkstatus){
                $('#btn_freigabe').addClass('btn btn-light');                
                freigabe_blinkstatus = false;                
            } else {
                $('#btn_freigabe').addClass('btn btn-secondary');
                freigabe_blinkstatus = true;                
            }
            
        }

        function btn_fq_cancel(){
            if(freigabe_interval_id){
                clearInterval(freigabe_interval_id);
                
                freigabe_blinkstatus = false;
                freigabe_blinken();

                $('#freigabe_txt').empty();
                $('#btngrp_freigabe').hide();

                function_queue = [];
                fq_next();             
                
            }
        }

        function btn_freigabe(){
            if(freigabe_interval_id){
                clearInterval(freigabe_interval_id);
                
                freigabe_blinkstatus = false;
                freigabe_blinken();

                $('#freigabe_txt').empty();
                $('#btngrp_freigabe').hide();
                fq_next();
                
            }
        }


        function fq_clear(){
            function_queue = [];
        }

        function fq_add(name, parameter){
            function_queue.push({name:name,parameter:parameter});
        }

        function fq_next(){            
            if(function_queue.length > 0){
                    nextFn = function_queue.shift();
                    ausgabe("Starte Funktion "+nextFn.name);
                    $('#fq_info').text("Aktueller Task: "+nextFn.name);
                    window[nextFn.name](nextFn.parameter);
                } else {
                    $('#fq_info').text("");
                }
        }

        function fq_start(){
            fq_next();
        }

        function toggle_freigabe(index){

            action = update_action[index];
            freigabe = action.freigabe;
            if(freigabe){
                freigabe = 0;
            } else {
                freigabe = 1;
            }
            update_action[index].freigabe = freigabe;

            $('#freigabe'+action.id).removeClass();
            freigabe_cls='bi bi-toggle-off mr-2';
            if(freigabe==1){
                freigabe_cls = 'bi bi-toggle-on mr-2';
            }
            $('#freigabe'+action.id).addClass(freigabe_cls);

            console.log(update_action[index]);

        }


        function zeige_action_sus(){

            /*
                    <th>ID (Klabu)</th>
                    <th>ID (Update)</th>
                    <th>Danis-ID</th>
                    <th>Apollon-ID</th>
                    <th>Name</th>
                    <th>Vorname</th>
                    <th>Stammgruppe</th>
            */
            $('#tbody_schueler').empty();

            update_action.forEach(a =>{

                if(a.schritt >= 1 && a.schritt <= 3){
                    
                    apollon_id ="?";
                    danis_id="?";
                    vorname ="?";
                    nachname="?";
                    iserv ="?";
                    stammgruppe="?";

                    danis_id_cls = null;
                    apollon_id_cls = null;
                    vorname_cls = null;
                    nachname_cls = null;
                    iserv_cls = null;
                    stammgruppe_cls = null;

                    danis_id_tt = "";
                    apollon_id_tt = "";
                    vorname_tt = "";
                    nachname_tt = "";
                    iserv_tt = "";
                    stammgruppe_tt = "";

                    freigabe_cls='bi bi-toggle-off';
                    if(a.freigabe){
                        freigabe_cls = 'bi bi-toggle-on';
                    }


                    s=null;
                    if(a.klabu_index !==null){
                        s = schueler[a.klabu_index];
                        danis_id = s.danis_schueler_id;
                        apollon_id = s.apollon_schueler_id;
                        vorname = s.vorname;
                        nachname = s.nachname;
                        iserv = s.iserv;
                        stammgruppe = s.stammgruppe;
                    }

                    us= null;
                    if(a.update_index !==null){
                        us = update_schueler[a.update_index];
                        danis_id = us.danis_schueler_id;
                        apollon_id = us.apollon_schueler_id;
                        vorname = us.vorname;
                        nachname = us.nachname;
                        iserv = us.iserv;
                        stammgruppe = us.stammgruppe;
                    }
                   

                    if(a.schritt == 3){
                        
                        /*
                        _cls = null;
                        if(us. != s.){
                            _cls = "table-warning";
                            _tt = "vorher: "+s.;
                        }
                        */

                        danis_id_cls = null;
                        if(us.danis_schueler_id != s.danis_schueler_id){
                            danis_id_cls = "table-warning";
                            danis_id_tt = "vorher: "+s.danis_schueler_id;
                        }

                        apollon_id_cls = null;
                        if(us.apollon_schueler_id != s.apollon_schueler_id){
                            apollon_id_cls = "table-warning";
                            apollon_id_tt = "vorher: "+s.apollon_schueler_id;
                        }

                        vorname_cls = null;
                        if(us.vorname != s.vorname){
                            vorname_cls = "table-warning";
                            vorname_tt = "vorher: "+s.vorname;
                        }

                        nachname_cls = null;
                        if(us.nachname != s.nachname){
                            nachname_cls = "table-warning";
                            nachname_tt = "vorher: "+s.nachname;
                        }

                        iserv_cls = null;
                        if(us.iserv != s.iserv){
                            iserv_cls = "table-warning";
                            iserv_tt = "vorher: "+s.iserv;
                        }

                        stammgruppe_cls = null;
                        if(us.stammgruppe != s.stammgruppe){
                            stammgruppe_cls = "table-warning";
                            stammgruppe_tt = "vorher: "+s.stammgruppe;
                        }


                    }
                   
                    rowclass = null;
                    if(a.schritt == 1){
                        rowclass = "table-danger";
                        aktion = "DELETE";
                    }
                    if(a.schritt == 2){
                        rowclass = "table-success";
                        aktion = "INSERT";
                    }
                    if(a.schritt == 3){
                        aktion = "UPDATE";
                    }

                    //data-bs-toggle="tooltip" data-bs-placement="top" title="bis einschl

                    $('#tbody_schueler').append(
                        $("<tr></tr>")
                        .addClass(rowclass)
                        .append(
                            $('<td></td>')
                            .text(a.klabu_id)
                        )
                        .append(
                            $('<td></td>')
                            .text(a.update_id)
                        )
                        .append(
                            $('<td></td>')
                            .text(danis_id)
                            .addClass(danis_id_cls)
                            .attr('data-bs-toggle', 'tooltip')
                            .attr('data-bs-placement', 'top')
                            .attr('title', danis_id_tt)
                            
                        )
                        .append(
                            $('<td></td>')
                            .text(apollon_id)
                            .addClass(apollon_id_cls)
                            .attr('data-bs-toggle', 'tooltip')
                            .attr('data-bs-placement', 'top')
                            .attr('title', apollon_id_tt)
                        )
                        .append(
                            $('<td></td>')
                            .text(vorname)
                            .addClass(vorname_cls)
                            .attr('data-bs-toggle', 'tooltip')
                            .attr('data-bs-placement', 'top')
                            .attr('title', vorname_tt)
                        )
                        .append(
                            $('<td></td>')
                            .text(nachname)
                            .addClass(nachname_cls)
                            .attr('data-bs-toggle', 'tooltip')
                            .attr('data-bs-placement', 'top')
                            .attr('title', nachname_tt)
                        )
                        .append(
                            $('<td></td>')
                            .text(iserv)
                            .addClass(iserv_cls)
                            .attr('data-bs-toggle', 'tooltip')
                            .attr('data-bs-placement', 'top')
                            .attr('title', iserv_tt)
                        )
                        .append(
                            $('<td></td>')
                            .text(stammgruppe)
                            .addClass(stammgruppe_cls)
                            .attr('data-bs-toggle', 'tooltip')
                            .attr('data-bs-placement', 'top')
                            .attr('title', stammgruppe_tt)
                        )
                        .append(
                            $('<td></td>')                            
                            .text(aktion)
                            .attr('data-bs-toggle', 'tooltip')
                            .attr('data-bs-placement', 'top')
                            .attr('title', a.kommentar)
                            .prepend(
                                $('<i></i>')
                                .addClass(freigabe_cls)
                                .addClass('mr-2')
                                .attr('id','freigabe'+a.id)
                                .click(function () { toggle_freigabe(update_action.indexOf(a));})
                            )
                        )
                    )

                }
            });
            
            fq_next();
        }



        function zeige_action_gruppe(){

        /*
                    <th>ID (Klabu)</th>
                    <th>ID (Update)</th>
                    <th>Danis-ID</th>
                    <th>Apollon-ID</th>
                    <th>Name</th>
                    <th>Lehrer</th>
                    <th>Aktion</th>
*/
            $('#tbody_gruppe').empty();

            update_action.forEach(a =>{

                if(a.schritt >= 4 && a.schritt <= 6){
                    
                    apollon_id ="?";
                    danis_id="?";
                    name="?";
                    lehrer ="?";
                    
                    danis_id_cls = null;
                    apollon_id_cls = null;
                    name_cls = null;
                    lehrer_cls = null;

                    danis_id_tt = "";
                    apollon_id_tt = "";
                    name_tt = "";
                    lehrer_tt = "";

                    freigabe_cls='bi bi-toggle-off';
                    if(a.freigabe){
                        freigabe_cls = 'bi bi-toggle-on';
                    }

                    g=null;
                    if(a.klabu_index !==null){
                        g = gruppe[a.klabu_index];
                        danis_id = g.danis_gruppe_id;
                        apollon_id = g.apollon_gruppe_id;
                        name = g.name;
                        lehrer = g.lehrer_kuerzel;
                    }

                    ug= null;
                    if(a.update_index !==null){
                        ug = update_gruppe[a.update_index];
                        danis_id = ug.danis_gruppe_id;
                        apollon_id = ug.apollon_gruppe_id;
                        name = ug.name;
                        lehrer = ug.lehrer_kuerzel;
                    }
                   

                    if(a.schritt == 6){
                        
                        /*
                        _cls = null;
                        if(us. != s.){
                            _cls = "table-warning";
                            _tt = "vorher: "+s.;
                        }
                        */

                        danis_id_cls = null;
                        if(ug.danis_gruppe_id != g.danis_gruppe_id){
                            danis_id_cls = "table-warning";
                            danis_id_tt = "vorher: "+g.danis_gruppe_id;
                        }

                        apollon_id_cls = null;
                        if(ug.apollon_gruppe_id != g.apollon_gruppe_id){
                            apollon_id_cls = "table-warning";
                            apollon_id_tt = "vorher: "+g.apollon_gruppe_id;
                            apollon_id_tt +="\nWird nicht übernommen, da in Sek. II nur der Gruppenname eindeutig ist.";
                            apollon_id = apollon_id+"*";
                        }

                        name_cls = null;
                        if(ug.name != g.name){
                            name_cls = "table-warning";
                            name_tt = "vorher: "+g.name;
                        }

                        lehrer_cls = null;
                        if(ug.lehrer_kuerzel != g.lehrer_kuerzel){
                            lehrer_cls = "table-warning";
                            lehrer_tt = "vorher: "+g.lehrer_kuerzel;
                        }

                    }
                   
                    rowclass = null;
                    if(a.schritt == 4){
                        rowclass = "table-danger";
                        aktion = "DELETE";
                        if(a.unterricht_count > 0){
                            aktion = "forbidden DELETE";
                        }
                    }
                    if(a.schritt == 5){
                        rowclass = "table-success";
                        aktion = "INSERT";
                    }
                    if(a.schritt == 6){
                        aktion = "UPDATE";                       
                    }

                    //data-bs-toggle="tooltip" data-bs-placement="top" title="bis einschl

                    $('#tbody_gruppe').append(
                        $("<tr></tr>")
                        .addClass(rowclass)
                        .append(
                            $('<td></td>')
                            .text(a.klabu_id)
                        )
                        .append(
                            $('<td></td>')
                            .text(a.update_id)
                        )
                        .append(
                            $('<td></td>')
                            .text(danis_id)
                            .addClass(danis_id_cls)
                            .attr('data-bs-toggle', 'tooltip')
                            .attr('data-bs-placement', 'top')
                            .attr('title', danis_id_tt)                            
                        )
                        .append(
                            $('<td></td>')
                            .text(apollon_id)
                            .addClass(apollon_id_cls)
                            .attr('data-bs-toggle', 'tooltip')
                            .attr('data-bs-placement', 'top')
                            .attr('title', apollon_id_tt)
                        )
                        .append(
                            $('<td></td>')
                            .text(name)
                            .addClass(name_cls)
                            .attr('data-bs-toggle', 'tooltip')
                            .attr('data-bs-placement', 'top')
                            .attr('title', name_tt)
                        )
                        .append(
                            $('<td></td>')
                            .text(lehrer)
                            .addClass(lehrer_cls)
                            .attr('data-bs-toggle', 'tooltip')
                            .attr('data-bs-placement', 'top')
                            .attr('title', lehrer_tt)
                        )
                        .append(
                            $('<td></td>')
                            .text(aktion)
                            .attr('data-bs-toggle', 'tooltip')
                            .attr('data-bs-placement', 'top')
                            .attr('title', a.kommentar)
                            .prepend(
                                $('<i></i>')
                                .addClass(freigabe_cls)
                                .addClass('mr-2')
                                .attr('id','freigabe'+a.id)
                                .click(function () { toggle_freigabe(update_action.indexOf(a));})
                            )
                        )
                    )

                }
            });
            fq_next();
        }




        function zeige_action_belegung(){

/*
            <th>ID (Klabu)</th>
            <th>ID (Update)</th>
            <th>Danis-Schüler-ID</th>
            <th>Apollon-Schüler-ID</th>
            <th>Danis-Gruppen-ID</th>
            <th>ApollonGruppen-ID</th>
            <th>Gruppe</th>
            <th>Beginn</th>
            <th>Ende</th>
            <th>Aktion</th>
*/
    $('#tbody_belegung').empty();

    update_action.forEach(a =>{

        if(a.schritt >= 7 && a.schritt <= 9){
            
            apollon_schueler_id ="?";
            danis_schueler_id="?";
            apollon_gruppe_id ="?";
            danis_gruppe_id="?";
            name="?";
            beginn ="?";
            ende="?";
            
            danis_schueler_id_cls = null;
            apollon_schueler_id_cls = null;
            danis_gruppe_id_cls = null;
            apollon_gruppe_id_cls = null;
            name_cls = null;
            beginn_cls = null;
            ende_cls = null;


            danis_schueler_id_tt = "";
            apollon_schueler_id_tt = "";
            danis_gruppe_id_tt = "";
            apollon_gruppe_id_tt = "";
            name_tt = "";
            beginn_tt = "";
            ende_tt = "";

            freigabe_cls='bi bi-toggle-off';
            if(a.freigabe){
                freigabe_cls = 'bi bi-toggle-on';
            }


            b=null;
            if(a.klabu_index !==null){
                b = belegung[a.klabu_index];
                danis_schueler_id = b.danis_schueler_id;
                apollon_schueler_id = b.apollon_schueler_id;
                danis_gruppe_id = b.danis_gruppe_id;
                apollon_gruppe_id = b.apollon_gruppe_id;
                name = b.name;
                beginn = b.beginn;
                ende = b.ende;
            }

            ub= null;
            if(a.update_index !== null){
                ub = update_belegung[a.update_index];
                danis_schueler_id = ub.danis_schueler_id;
                apollon_schueler_id = ub.apollon_schueler_id;
                danis_gruppe_id = ub.danis_gruppe_id;
                apollon_gruppe_id = ub.apollon_gruppe_id;
                name = ub.name;
                beginn = ub.von;
                ende = ub.bis;
            }
           

            if(a.schritt == 9){
                
                /*
                _cls = null;
                if(us. != s.){
                    _cls = "table-warning";
                    _tt = "vorher: "+s.;
                }
                */

                danis_schueler_id_cls = null;
                if(ub.danis_schueler_id != b.danis_schueler_id){
                    danis_schueler_id_cls = "table-warning";
                    danis_schueler_id_tt = "vorher: "+b.danis_schueler_id;
                    if(!ub.danis_schueler_id){
                        danis_schueler_id = "("+b.danis_schueler_id+")*";
                        danis_schueler_id_tt += "\nAlter Wert wird beibehalten";
                    }
                }

                apollon_schueler_id_cls = null;
                if(ub.apollon_schueler_id != b.apollon_schueler_id){
                    apollon_schueler_id_cls = "table-warning";
                    apollon_schueler_id_tt = "vorher: "+b.apollon_schueler_id;
                }

                danis_gruppe_id_cls = null;
                if(ub.danis_gruppe_id != b.danis_gruppe_id){
                    danis_gruppe_id_cls = "table-warning";
                    danis_gruppe_id_tt = "vorher: "+b.danis_gruppe_id;
                }

                apollon_gruppe_id_cls = null;
                if(ub.apollon_gruppe_id != b.apollon_gruppe_id){
                    apollon_gruppe_id_cls = "table-warning";
                    apollon_gruppe_id_tt = "vorher: "+b.apollon_gruppe_id;
                    apollon_gruppe_id_tt +="\nWird nicht übernommen, da in Sek. II nur der Gruppenname eindeutig ist.";
                    apollon_gruppe_id = apollon_gruppe_id+"*";
                }

                name_cls = null;
                if(ub.name != b.name){
                    name_cls = "table-warning";
                    name_tt = "vorher: "+g.name;
                }

                beginn_cls = null;
                if(ub.beginn != b.beginn){
                    beginn_cls = "table-warning";
                    beginn_tt = "vorher: "+b.beginn;
                }

                ende_cls = null;
                if(ub.ende != b.ende){
                    ende_cls = "table-warning";
                    ende_tt = "vorher: "+b.ende;
                }
            }
           
            rowclass = null;
            if(a.schritt == 7){
                rowclass = "table-danger";
                aktion = "DELETE";
                if(a.unterricht_count > 0){
                    aktion = "forbidden DELETE";
                }
            }
            if(a.schritt == 8){
                rowclass = "table-success";
                aktion = "INSERT";
            }
            if(a.schritt == 9){
                aktion = "UPDATE";                       
            }

            //data-bs-toggle="tooltip" data-bs-placement="top" title="bis einschl

            $('#tbody_belegung').append(
                $("<tr></tr>")
                .addClass(rowclass)
                .append(
                    $('<td></td>')
                    .text(a.klabu_id)
                )
                .append(
                    $('<td></td>')
                    .text(a.update_id)
                )
                .append(
                    $('<td></td>')
                    .text(danis_schueler_id)
                    .addClass(danis_schueler_id_cls)
                    .attr('data-bs-toggle', 'tooltip')
                    .attr('data-bs-placement', 'top')
                    .attr('title', danis_schueler_id_tt)                            
                )
                .append(
                    $('<td></td>')
                    .text(apollon_schueler_id)
                    .addClass(apollon_schueler_id_cls)
                    .attr('data-bs-toggle', 'tooltip')
                    .attr('data-bs-placement', 'top')
                    .attr('title', apollon_schueler_id_tt)
                )
                .append(
                    $('<td></td>')
                    .text(danis_gruppe_id)
                    .addClass(danis_gruppe_id_cls)
                    .attr('data-bs-toggle', 'tooltip')
                    .attr('data-bs-placement', 'top')
                    .attr('title', danis_gruppe_id_tt)                            
                )
                .append(
                    $('<td></td>')
                    .text(apollon_gruppe_id)
                    .addClass(apollon_gruppe_id_cls)
                    .attr('data-bs-toggle', 'tooltip')
                    .attr('data-bs-placement', 'top')
                    .attr('title', apollon_gruppe_id_tt)
                )
                .append(
                    $('<td></td>')
                    .text(name)
                    .addClass(name_cls)
                    .attr('data-bs-toggle', 'tooltip')
                    .attr('data-bs-placement', 'top')
                    .attr('title', name_tt)
                )
                .append(
                    $('<td></td>')
                    .text(beginn)
                    .addClass(beginn_cls)
                    .attr('data-bs-toggle', 'tooltip')
                    .attr('data-bs-placement', 'top')
                    .attr('title', beginn_tt)
                )
                .append(
                    $('<td></td>')
                    .text(ende)
                    .addClass(ende_cls)
                    .attr('data-bs-toggle', 'tooltip')
                    .attr('data-bs-placement', 'top')
                    .attr('title', ende_tt)
                )
                .append(
                    $('<td></td>')
                    .text(aktion)
                    .attr('data-bs-toggle', 'tooltip')
                    .attr('data-bs-placement', 'top')
                    .attr('title', a.kommentar)
                    .prepend(
                                $('<i></i>')
                                .addClass(freigabe_cls)
                                .addClass('mr-2')
                                .attr('id','freigabe'+a.id)
                                .click(function () { toggle_freigabe(update_action.indexOf(a));})
                            )
                )
            )

        }
    });
    fq_next();
}





        function ausgabe(text){
            zeitstempel = new Date().toISOString().substr(0,19).replace('T',' ');
            ausgabe_id++;            

            $('#ausgabe').append(
                $('<div></div>')
                .addClass('row')
                .append(
                    $('<div></div>')
                    .addClass("col col-md-2")
                    .text(zeitstempel)
                )
                .append(
                    $('<div></div>')
                    .addClass("col col-md-10")
                    .text(text)
                    .append(
                        $('<span></span>')
                        .attr('id','ausgabeTick'+ausgabe_id)
                    )
                )
            );

            
        }

        function ausgabe_clear(){
            $('#ausgabe').empty();
            fq_next();
        }

        function ausgabe_startTick(){
            ausgabe_tick = 0;
            ausgabe_start = new Date();

            ausgabe_interval_id = setInterval(ausgabe_addTick, 500);
        }

        function ausgabe_addTick(){
            let old = $('#ausgabeTick'+ausgabe_id).text();
            $('#ausgabeTick'+ausgabe_id).text(old+'.');

            ausgabe_tick++;
            if(ausgabe_tick >120){                
                ausgabe_stopTick();
                ausgabe("GUI-Tick-Timer nach Timeout abgebrochen.");
            }
        }

        function ausgabe_stopTick(){
            let stop = new Date();
            let old = $('#ausgabeTick'+ausgabe_id).text();
            let dauer =  stop - ausgabe_start;
            
            $('#ausgabeTick'+ausgabe_id).text(old+' ('+dauer+'ms)');
            clearInterval(ausgabe_interval_id);
        }



        /*******************************************************
        * Abgleich der Schüler 
        *
        */

      
        function read_schueler(){
            
            
            ausgabe("Fordere Schüler aus Datenbank an.");
            ausgabe_startTick();

            
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/update/schueler",
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                    
                    schueler = response.schueler;
                    update_schueler = response.update_schueler;
                    
                    ausgabe_stopTick();
                    ausgabe(schueler.length + " Klassenbuch-Schüler eingelesen.");
                    ausgabe(update_schueler.length + " Update-Schüler eingelesen.");
                },
                error: function (e) {
                    console.log(e.message);
                }                
            })
            .then( function (e){
                
                fq_next();
                
                
            });
        }
        


        /**
        Prüfung auf löschbare schueler
         */
        function check_schueler_weg(){
            ausgabe("Suche nach löschbaren Schülern");
            ausgabe_startTick();            
                      
            check_schueler_weg_chunk(0);          
        }

        function check_schueler_weg_fertig(){
            ausgabe_stopTick();
            ausgabe(chunk_treffer+" löschbare Schüler gefunden.");

            fq_next();
        }

        

        function check_schueler_weg_chunk(id){    
                
            if(id == 0){
                chunk_treffer = 0;
            }

            for(let operations = 0; operations < 100; operations++){
                
                if (id == schueler.length) {
                    check_schueler_weg_fertig();
                    return;
                }
                
                b = schueler[id];

                let treffer = null;

  
                update_schueler.every(ub => {                    

                    let treffer_sus = false;
                    let treffer_gruppe = false;

                    if( b.danis_schueler_id 
                        && ub.danis_schueler_id 
                        && b.danis_schueler_id == ub.danis_schueler_id){
                            treffer_sus = true;
                    }

                    if( !treffer_sus
                        && b.apollon_schueler_id
                        && ub.apollon_schueler_id
                        && b.apollon_schueler_id == ub.apollon_schueler_id){
                            treffer_sus = true;
                    }

                    
                    if(treffer_sus){
                        treffer = ub;
                        return false;
                    }

                    return true;

                });

                //Prüfung, ob der Schüler einem Sitzplan / einem Unterricht zugeordnet ist?
                //obsolet, da nur Soft-Delete                             

                if(!treffer){
                    update_action.push({
                        id : action_id++,
                        schritt : 1,
                        klabu_id : b.id,                        
                        update_id : null, //treffer.id,
                        klabu_index : id,
                        update_index : null, //update_schueler.indexOf(treffer),
                        kommentar : '- SuS '+b.vorname+' '+b.nachname+' nicht mehr bekannt. ',
                        freigabe : 1
                    });
                    chunk_treffer++;
                }

                id++;
            }
            
           
            setTimeout(function (){ check_schueler_weg_chunk(id);},1);
            
            
            
        }




        /**
        Prüfung auf neue schueler
         */
        function check_schueler_neu(){
            ausgabe("Suche nach neuen Schülern");
            ausgabe_startTick();            
                      
            check_schueler_neu_chunk(0);          
        }

        function check_schueler_neu_fertig(){
            ausgabe_stopTick();
            ausgabe(chunk_treffer+" neue Schüler gefunden.");
            
            fq_next();
        }

        

        function check_schueler_neu_chunk(id){    
                
            if(id == 0){
                chunk_treffer = 0;
            }

            for(let operations = 0; operations < 100; operations++){
                
                if (id == update_schueler.length) {
                    check_schueler_neu_fertig();
                    return;
                }
                
                ub = update_schueler[id];

                let treffer = null;
     
                schueler.every(b => {                    

                    let treffer_sus = false;                

                    if( b.danis_schueler_id 
                        && ub.danis_schueler_id 
                        && b.danis_schueler_id == ub.danis_schueler_id){
                            treffer_sus = true;
                    }

                    if( !treffer_sus
                        && b.apollon_schueler_id
                        && ub.apollon_schueler_id
                        && b.apollon_schueler_id == ub.apollon_schueler_id){
                            treffer_sus = true;
                    }
                    
                    if(treffer_sus){
                        treffer = b;
                        return false;
                    }

                    return true;

                });
                             

                if(!treffer){
                    update_action.push({
                        id : action_id++,
                        schritt : 2,
                        klabu_id : null, //treffer.id,
                        klabu_index : null, //schueler.indexOf(treffer),
                        update_index : id,
                        update_id : ub.id,
                        kommentar : '+ SuS '+ub.vorname+' '+ub.nachname+' ist neu. ',
                        freigabe : 1
                    });
                    chunk_treffer++;
                }

                id++;
            }
            
           
            setTimeout(function (){ check_schueler_neu_chunk(id);},1);
            
            
            
        }



        /**
        Prüfung auf zu verändernde schueler
         */
        function check_schueler_update(){
            ausgabe("Suche nach veränderte Schülern");
            ausgabe_startTick();            
                      
            check_schueler_update_chunk(0);          
        }

        function check_schueler_update_fertig(){
            ausgabe_stopTick();
            ausgabe(chunk_treffer+" zu verändernde Schüler gefunden.");

            ausgabe("***** Überprüfung der Schüler abgeschlossen *****");
            ausgabe ("");

            fq_next();

        }

        

        function check_schueler_update_chunk(id){    
                
            if(id == 0){
                chunk_treffer = 0;
            }

            for(let operations = 0; operations < 100; operations++){
                
                if (id == schueler.length) {
                    check_schueler_update_fertig();
                    return;
                }
                
                b = schueler[id];

                let treffer = null;
                

                update_schueler.every(ub => {                    

                    let treffer_sus = false;
         
                    if( b.danis_schueler_id 
                        && ub.danis_schueler_id 
                        && b.danis_schueler_id == ub.danis_schueler_id){
                            treffer_sus = true;
                    }

                    if( !treffer_sus
                        && b.apollon_schueler_id
                        && ub.apollon_schueler_id
                        && b.apollon_schueler_id == ub.apollon_schueler_id){
                            treffer_sus = true;
                    }

                    
                    if(treffer_sus){
                        treffer = ub;
                        return false;
                    }

                    return true;

                });
                             

                if(treffer){

                    let ub = treffer;
                    let upd = false;
                    let data = {};
                    updtxt = "";

                    
                    if(b.vorname != ub.vorname){
                        upd = true;
                        updtxt += ", Vorname "+ub.vorname+" statt "+b.vorname;
                        data.vorname = ub.vorname;
                    }

                    if(b.nachname != ub.nachname){
                        upd = true;
                        updtxt += ", Nachname "+ub.nachname+" statt "+b.nachname;
                        data.nachname = ub.nachname;
                    }

                    if(ub.iserv && b.iserv != ub.iserv){
                        upd = true;
                        updtxt += ", IServ-Account "+ub.iserv+" statt "+b.iserv;
                        data.iserv = ub.iserv;
                    }

                    if(ub.stammgruppe &&  ub.stammgruppe != b.stammgruppe){
                        upd = true;
                        updtxt += ", Stammgruppe "+ub.stammgruppe+" statt "+b.stammgruppe;
                        data.stammgruppe = ub.stammgruppe;
                    }

                    if(upd){                  
                        update_action.push({
                            id : action_id++,
                            schritt : 3,
                            data : data,
                            klabu_id : b.id,
                            update_id : treffer.id,
                            klabu_index : id,
                            update_index : update_schueler.indexOf(treffer),
                            kommentar : updtxt.substr(2)+"\n"+JSON.stringify(data),
                            freigabe : 1
                        });
                        chunk_treffer++;
                    }
                }

                id++;
            }
            
            
            setTimeout(function (){ check_schueler_update_chunk(id);},1);
            
            
            
        }




        /*******************************************************
        * Abgleich der Gruppen
        *
        */

      
        function read_gruppe(){
            
            
            ausgabe("Fordere Gruppen aus Datenbank an.");
            ausgabe_startTick();

            
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/update/gruppe",
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                    
                    gruppe = response.gruppe;
                    update_gruppe = response.update_gruppe;
                    
                    ausgabe_stopTick();
                    ausgabe(gruppe.length + " Klassenbuch-Gruppen eingelesen.");
                    ausgabe(update_gruppe.length + " Update-Gruppen eingelesen.");
                },
                error: function (e) {
                    console.log(e.message);
                }                
            })
            .then( function (e){
                fq_next();
            });
        }
        


        /**
        Prüfung auf löschbare gruppe
         */
        function check_gruppe_weg(){
            ausgabe("Suche nach löschbaren Gruppen");
            ausgabe_startTick();            
                      
            check_gruppe_weg_chunk(0);          
        }

        function check_gruppe_weg_fertig(){
            ausgabe_stopTick();
            ausgabe(chunk_treffer+" löschbare Gruppen gefunden.");
            
            fq_next();
        }

        

        function check_gruppe_weg_chunk(id){    
                
            if(id == 0){
                chunk_treffer = 0;
            }

            for(let operations = 0; operations < 100; operations++){
                
                if (id == gruppe.length) {
                    check_gruppe_weg_fertig();
                    return;
                }
                
                b = gruppe[id];

                let treffer = null;
            
                update_gruppe.every(ub => {                    

                    let treffer_gruppe = false;

                    if( b.danis_gruppe_id 
                        && ub.danis_gruppe_id 
                        && b.danis_gruppe_id == ub.danis_gruppe_id){
                            treffer_gruppe = true;
                    }

                    if( !treffer_gruppe
                        && b.apollon_gruppe_id
                        && ub.apollon_gruppe_id
                        && b.apollon_gruppe_id == ub.apollon_gruppe_id){
                            treffer_gruppe = true;
                    }

                    if( !treffer_gruppe
                        && !(b.apollon_gruppe_id && ub.apollon_gruppe_id)
                        && !(b.danis_gruppe_id && ub.danis_gruppe_id)
                        && b.name == ub.name){
                            treffer_gruppe = true;
                    }
                    
                    if(treffer_gruppe){
                        treffer = ub;
                        return false;
                    }

                    return true;

                });
                             

                if(!treffer){

                    //Bei zu löschenden Gruppen prüfen, ob diese Klassenbucheinträge (=Unterrichte)
                    
                    update_action.push({
                        id : action_id++,
                        schritt : 4,
                        klabu_id : b.id,
                        klabu_index : id,
                        update_id : null,
                        update_index : null,
                        unterricht_count : b.unterricht_count,
                        kommentar : '- Grp '+b.name+' nicht mehr bekannt. Klassenbucheinträge (Unterrichte) '+ b.unterricht_count,
                        freigabe : (b.unterricht_count == 0 ? 1 : 0)
                    });
                    chunk_treffer++;
                }

                id++;
            }
            
            
            setTimeout(function (){ check_gruppe_weg_chunk(id);},1);
            
            
            
        }




        /**
        Prüfung auf neue gruppe
         */
        function check_gruppe_neu(){
            ausgabe("Suche nach neuen Gruppen");
            ausgabe_startTick();            
                      
            check_gruppe_neu_chunk(0);          
        }

        function check_gruppe_neu_fertig(){
            ausgabe_stopTick();
            ausgabe(chunk_treffer+" neue Gruppen gefunden.");
            
            fq_next();
        }

        

        function check_gruppe_neu_chunk(id){    
                
            if(id == 0){
                chunk_treffer = 0;
            }

            for(let operations = 0; operations < 100; operations++){
                
                if (id == update_gruppe.length) {
                    check_gruppe_neu_fertig();
                    return;
                }
                
                ub = update_gruppe[id];

                let treffer = null;
            
                gruppe.every(b => {                    

                    let treffer_gruppe = false;                

                    if( b.danis_gruppe_id 
                        && ub.danis_gruppe_id 
                        && b.danis_gruppe_id == ub.danis_gruppe_id){
                            treffer_gruppe = true;
                    }

                    if( !treffer_gruppe
                        && b.apollon_gruppe_id
                        && ub.apollon_gruppe_id
                        && b.apollon_gruppe_id == ub.apollon_gruppe_id){
                            treffer_gruppe = true;
                    }

                    if( !treffer_gruppe
                        && !(b.apollon_gruppe_id && ub.apollon_gruppe_id)
                        && !(b.danis_gruppe_id && ub.danis_gruppe_id)
                        && b.name == ub.name){
                            treffer_gruppe = true;
                    }
                    
                    if(treffer_gruppe){
                        treffer = b;
                        return false;
                    }

                    return true;

                });
                             

                if(!treffer){
                    update_action.push({
                        id : action_id++,
                        schritt : 5,
                        klabu_id : null,
                        klabu_index : null,
                        update_id : ub.id,
                        update_index : id,
                        kommentar : '+ Grp '+ub.name+' ist neu. ',
                        freigabe : 1
                    });
                    chunk_treffer++;
                }

                id++;
            }
            
           
            setTimeout(function (){ check_gruppe_neu_chunk(id);},1);
            
            
            
        }



        /**
        Prüfung auf zu verändernde gruppe
         */
        function check_gruppe_update(){
            ausgabe("Suche nach veränderte Gruppen");
            ausgabe_startTick();            
                      
            check_gruppe_update_chunk(0);          
        }

        function check_gruppe_update_fertig(){
            ausgabe_stopTick();
            ausgabe(chunk_treffer+" zu verändernde Gruppen gefunden.");            

            fq_next();
        }

        

        function check_gruppe_update_chunk(id){    
                
            if(id == 0){
                chunk_treffer = 0;
            }

            for(let operations = 0; operations < 100; operations++){
                
                if (id == gruppe.length) {
                    check_gruppe_update_fertig();
                    return;
                }
                
                b = gruppe[id];

                let treffer = null;
                

                update_gruppe.every(ub => {                    

                    let treffer_gruppe = false;
                
                    if( b.danis_gruppe_id 
                        && ub.danis_gruppe_id 
                        && b.danis_gruppe_id == ub.danis_gruppe_id){
                            treffer_gruppe = true;
                    }

                    if( !treffer_gruppe
                        && b.apollon_gruppe_id
                        && ub.apollon_gruppe_id
                        && b.apollon_gruppe_id == ub.apollon_gruppe_id){
                            treffer_gruppe = true;
                    }

                    if( !treffer_gruppe
                        && !(b.apollon_gruppe_id && ub.apollon_gruppe_id)
                        && !(b.danis_gruppe_id && ub.danis_gruppe_id)
                        && b.name == ub.name){
                            treffer_gruppe = true;
                    }
                    
                    if(treffer_gruppe){
                        treffer = ub;
                        return false;
                    }

                    return true;

                });
                             

                if(treffer){

                    let ub = treffer;
                    let upd = false;
                    let data = {};
                    updtxt = "";

                    
                    if(b.name != ub.name){
                        upd = true;
                        updtxt += ", Bezeichnung "+ub.name+" statt "+b.name;
                        data.name = ub.name;
                    }

                    if(b.lehrer_kuerzel != ub.lehrer_kuerzel){
                        upd = true;
                        updtxt += ", Lehrkraft "+ub.lehrer_kuerzel+" statt "+b.lehrer_kuerzel;
                        data.lehrer_kuerzel = ub.lehrer_kuerzel;
                    }

                    /* Nicht sinnvoll, da Sek.II anhand von eindeutigem Kursnamen identifiziert.
                    if(b.apollon_gruppe_id != ub.apollon_gruppe_id){
                        upd = true;
                        updtxt += ", Lehrkraft "+ub.lehrer_kuerzel+" statt "+b.lehrer_kuerzel;
                    }
                    */

                    if(upd){                  
                        update_action.push({
                            id : action_id++,
                            schritt : 6,
                            data : data,
                            klabu_id : b.id,
                            klabu_index : id,
                            update_id : treffer.id,
                            update_index : update_gruppe.indexOf(treffer),
                            kommentar : updtxt.substr(2)+"\n"+JSON.stringify(data),
                            freigabe : 1
                        });
                        chunk_treffer++;
                    }
                }

                id++;
            }
            
            
            setTimeout(function (){ check_gruppe_update_chunk(id);},1);
            
            
            
        }








        /********************************************************
         * Abgleich der Belegungen
         * 
         */
        function read_belegung(){
            
            
            ausgabe("Fordere Belegungsdaten aus Datenbank an.");
            ausgabe_startTick();

            
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/update/belegung",
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                    
                    belegung = response.belegung;
                    update_belegung = response.update_belegung;
                    
                    ausgabe_stopTick();
                    ausgabe(belegung.length + " Klassenbuch-Belegungen eingelesen.");
                    ausgabe(update_belegung.length + " Update-Belegungen eingelesen.");

                    /*
                    response.forEach(row => {
                        $("#gruppe").append(new Option(row.name, row.id));
                    });
                    */

                    

                    
                },
                error: function (e) {
                    console.log(e.message);
                }                
            })
            .then( function (e){
                fq_next();
            });
        }
        


        /**
        Prüfung auf löschbare Belegungen
         */
        function check_belegung_weg(){
            ausgabe("Suche nach löschbaren Belegungen");
            ausgabe_startTick();            
                      
            check_belegung_weg_chunk(0);          
        }

        function check_belegung_weg_fertig(){
            ausgabe_stopTick();
            ausgabe(chunk_treffer+" löschbare Belegungen gefunden.");
            fq_next();
        }

        

        function check_belegung_weg_chunk(id){    
                
            if(id == 0){
                chunk_treffer = 0;
            }

            let heute = new Date().toISOString().substr(0,10);

            for(let operations = 0; operations < 100; operations++){
                
                if (id == belegung.length) {
                    check_belegung_weg_fertig();
                    return;
                }
                
                b = belegung[id];

                let treffer = null;
                let treffer_sus = false;
                let treffer_gruppe = false;

               

                update_belegung.every(ub => {                    

                    treffer_sus = false;
                    treffer_gruppe = false;

                    if( b.danis_schueler_id 
                        && ub.danis_schueler_id 
                        && b.danis_schueler_id == ub.danis_schueler_id){
                            treffer_sus = true;
                    }

                    if( !treffer_sus
                        && b.apollon_schueler_id
                        && ub.apollon_schueler_id
                        && b.apollon_schueler_id == ub.apollon_schueler_id){
                            treffer_sus = true;
                    }

                    if (treffer_sus){
                        if( b.danis_gruppe_id
                            && ub.danis_gruppe_id
                            && b.danis_gruppe_id == ub.danis_gruppe_id){
                                treffer_gruppe = true;
                        }

                        if( !treffer_gruppe
                            && b.apollon_gruppe_id
                            && ub.apollon_gruppe_id
                            && b.apollon_gruppe_id == ub.apollon_gruppe_id){
                                treffer_gruppe = true;
                            }

                        if( !treffer_gruppe
                            && !(b.apollon_gruppe_id && ub.apollon_gruppe_id)
                            && !(b.danis_gruppe_id &&  ub.danis_gruppe_id)
                            && b.name == ub.name){
                                treffer_gruppe = true;
                            }
                    }


                    
                    

                   if(treffer_sus && treffer_gruppe){
                        treffer = ub;
                        return false;
                    }

                    return true;

                });
                
                
                
            //Eine Belegung ist nur dann "gültig", wenn das ende-Datum größer dem jetzt-Datum ist.
                if(!(treffer &&  b.ende > heute)){
                    update_action.push({
                        id : action_id++,
                        schritt : 7,
                        klabu_id : b.id,
                        klabu_index : id,
                        update_id : null,
                        update_index : null,
                        kommentar : '- Bel '+b.vorname+' '+b.nachname+' ('+b.name+'): SuS: '+(treffer_sus ? ' weiter bekannt ' : ' nicht mehr bekannt ') +', Gruppe: '+(treffer_gruppe ? ' weiter bekannt' : ' nicht mehr bekannt'),
                        freigabe : 1
                    });
                    chunk_treffer++;
                }

                id++;
            }
            
            
            setTimeout(function (){ check_belegung_weg_chunk(id);},1);
            
            
            
        }





        /**
        Prüfung auf hinzuzufügende Belegungen
         */
        function check_belegung_neu(){
            ausgabe("Suche nach neuen Belegungen");
            ausgabe_startTick();            
                      
            check_belegung_neu_chunk(0);          
        }

        function check_belegung_neu_fertig(){
            ausgabe_stopTick();
            ausgabe(chunk_treffer+" neue Belegungen gefunden.");
            
            //console.log(update_action);

            fq_next();
        }

        

        function check_belegung_neu_chunk(id){    
                
            if(id == 0){
                chunk_treffer = 0;
            }

            for(let operations = 0; operations < 100; operations++){
                
                if (id == update_belegung.length) {
                    check_belegung_neu_fertig();
                    return;
                }
                
                ub = update_belegung[id];

                let treffer = null;
                let treffer_sus = false;
                let treffer_gruppe = false;
                
                belegung.every(b => {                    
                    
                    treffer_sus = false;
                    treffer_gruppe = false;

                    if( b.danis_schueler_id 
                        && ub.danis_schueler_id 
                        && b.danis_schueler_id == ub.danis_schueler_id){
                            treffer_sus = true;
                    }

                    if( !treffer_sus
                        && b.apollon_schueler_id
                        && ub.apollon_schueler_id
                        && b.apollon_schueler_id == ub.apollon_schueler_id){
                            treffer_sus = true;
                    }

                    if (treffer_sus){
                        if( b.danis_gruppe_id
                            && ub.danis_gruppe_id
                            && b.danis_gruppe_id == ub.danis_gruppe_id){
                                treffer_gruppe = true;
                        }

                        if( !treffer_gruppe
                            && b.apollon_gruppe_id
                            && ub.apollon_gruppe_id
                            && b.apollon_gruppe_id == ub.apollon_gruppe_id){
                                treffer_gruppe = true;
                            }

                        if( !treffer_gruppe
                            && !(b.apollon_gruppe_id && ub.apollon_gruppe_id)
                            && !(b.danis_gruppe_id &&  ub.danis_gruppe_id)
                            && b.name == ub.name){
                                treffer_gruppe = true;
                            }
                    }


                    if(treffer_sus && treffer_gruppe){
                        treffer = b;
                        return false;
                    }

                    return true;

                });
                
               


                if(!treffer){
                    update_action.push({
                        id : action_id++,
                        schritt : 8,
                        update_id : ub.id,
                        update_index : id,
                        klabu_id : null,
                        klabu_index : null,
                        kommentar : '+ Bel '+ub.vorname+' '+ub.nachname+' ('+ub.name+'): SuS: '+(treffer_sus ? ' bekannt' : ' neu') +', Gruppe: '+(treffer_gruppe ? ' bekannt' : ' neu'),
                        freigabe : 1
                    });
                    chunk_treffer++;
                }

                id++;
            }
            
            
            setTimeout(function (){ check_belegung_neu_chunk(id);},1);
            
            
            
        }




        /**
        Prüfung auf abzuändernde Belegungen
         */
        function check_belegung_update(){
            ausgabe("Suche nach veränderten Belegungen");
            ausgabe_startTick();            
                      
            check_belegung_update_chunk(0);          
        }

        function check_belegung_update_fertig(){
            ausgabe_stopTick();
            ausgabe(chunk_treffer+" zu verändernde Belegungen gefunden.");
            fq_next();
        }

        

        function check_belegung_update_chunk(id){    
                
            if(id == 0){
                chunk_treffer = 0;
            }

            for(let operations = 0; operations < 100; operations++){
                
                if (id == belegung.length) {
                    check_belegung_update_fertig();
                    return;
                }
                
                b = belegung[id];

                let treffer = null;
                let treffer_sus = false;
                let treffer_gruppe = false;

                
                update_belegung.every(ub => {                    

                    treffer_sus = false;
                    treffer_gruppe = false;

                    if( b.danis_schueler_id 
                        && ub.danis_schueler_id 
                        && b.danis_schueler_id == ub.danis_schueler_id){
                            treffer_sus = true;
                    }

                    if( !treffer_sus
                        && b.apollon_schueler_id
                        && ub.apollon_schueler_id
                        && b.apollon_schueler_id == ub.apollon_schueler_id){
                            treffer_sus = true;
                    }

                    if (treffer_sus){
                        if( b.danis_gruppe_id
                            && ub.danis_gruppe_id
                            && b.danis_gruppe_id == ub.danis_gruppe_id){
                                treffer_gruppe = true;
                        }

                        if( !treffer_gruppe
                            && b.apollon_gruppe_id
                            && ub.apollon_gruppe_id
                            && b.apollon_gruppe_id == ub.apollon_gruppe_id){
                                treffer_gruppe = true;
                            }

                        if( !treffer_gruppe
                            && !(b.apollon_gruppe_id && ub.apollon_gruppe_id)
                            && !(b.danis_gruppe_id &&  ub.danis_gruppe_id)
                            && b.name == ub.name){
                                treffer_gruppe = true;
                            }
                    }


                    if(treffer_sus && treffer_gruppe){
                        treffer = ub;
                        return false;
                    }

                    return true;

                });
                
                               

                if(treffer){
                    
                    let ub = treffer;
                    let upd = false;
                    let updtxt = "";
                    let data = {}

       
                    if(!ub.von){
                        let von_index = (ub.von_hj-1) ;
                        ub.von = von_datum_nach_hj[von_index];                        
                    }

                    if(!ub.bis){
                        let bis_index = (ub.bis_hj-1) ;
                        ub.bis = bis_datum_nach_hj[bis_index];
                    }
                    

                    if(b.beginn != ub.von){
                        upd = true;
                        updtxt += ", Beginn "+ub.von+ " statt "+b.beginn;
                        data.beginn = ub.von;
                    }

                    if(b.ende != ub.bis){
                        upd = true;
                        updtxt += ", Ende "+ub.bis+ " statt "+b.ende;
                        data.ende = ub.bis;
                    }


                    if(upd){
                        update_action.push({
                        id : action_id++,
                        data : data,
                        schritt : 9,
                        update_id : treffer.id,
                        update_index : update_belegung.indexOf(treffer),
                        klabu_id : b.id,
                        klabu_index : id,
                        kommentar : updtxt.substr(2)+"\n"+JSON.stringify(data),
                        freigabe : 1
                        });
                        chunk_treffer++;
                    }

                    
                }

                id++;
            }
            
            
            setTimeout(function (){ check_belegung_update_chunk(id);},1);
             
            
            
        }


        /**
        * Lehrer lesen
        */
        function read_lehrer() {
            $.ajax({
                url:  "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/lehrer",                    
                type: "GET",
                success: function (data) {
                    klabu_lehrer = $.parseJSON(data);
                }
            });
        }


    </script>

</body>

</html>