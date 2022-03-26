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
                    <div class="input-group-prepend">
                        <span class="input-group-text">Lerngruppe
                            <i class="bi-people pl-2"></i></span>
                    </div>
                    <select class="form-control" name="gruppe" id="gruppe"></select>
                </div>


                <div class="input-group col-md">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Schüler
                            <i class="bi-person pl-2"></i></span>
                    </div>
                    <select class="form-control" name="schueler" id="schueler">
                        <option value="-1">(Zuerst Gruppe wählen)</option>
                    </select>
                </div>                
            </div>

            <div class="row mt-2 py-2">
                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="entschuldigungNeu" onclick="entschuldigungNeu()" >
                        <i class="bi-plus-square pr-2"></i>Entschuldigung/Krankmeldung
                    </button>
                </div>   

                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="beurlaubungNeu" onclick="beurlaubungNeu()" >
                        <i class="bi-plus-square pr-2"></i>Beurlaubung (privat)
                    </button>
                </div>   

                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="freistellungNeu" onclick="freistellungNeu()" >
                        <i class="bi-plus-square pr-2"></i>Beurlaubung (schulisch)
                    </button>
                </div>   
            </div>


        </div>
    </section>


  
    <section>
        <div class="container-fluid  my-3 bg-dark text-white" id="zustimmungSection">
            <div class="row p-3" >
                <div class="col-md-2">
                    Abgabe digitale Unterschrift
                </div>
                <div class="col-md-10" id="zustimmungListe">
                </div>
            </div>
		</div>
    </section>



    <section>
        <div class="container-fluid  my-3 bg-dark text-white">
            <div class="row pt-3 px-3">
                <div class="col">
                    </small>Übersicht Entschuldigungen, Beurlaubungen und Freistellungen - Bearbeiten über das Stiftsymbol, Bogendruck über das Druckersymbol</small>
                </div>                
            </div>    
            <div class="row p-3" id="liste">                
            </div>
		</div>
    </section>


    

    <section>
        <div class="container-fluid  bg-dark text-white">
    	    <div class="row p-3" id="fehlzeitenuebersicht-steuerung">
                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="beurlaubungNeu" onclick="toggle_fzue_reihenfolge()" >
                        <i class="bi-arrow-down-up pr-2"></i>Reihenfolge ändern
                    </button>
                </div>   

                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="beurlaubungNeu" onclick="fzue_drucken()" >
                        <i class="bi-printer pr-2"></i>Übersicht Drucken
                    </button>
                </div>   

            </div>
		</div>
    </section>


    <section>
        <div class="container-fluid  bg-dark text-white " id="fzue-container">
    	    <div class="row p-3" id="fehlzeitenuebersicht">
            </div>
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
                                       <button type="button" class="btn btn-secondary" data-bs-toggle="tooltip" 
                                            data-bs-placement="top" title="Ich oder niemand" id="ich_btn">
                                            <i class="bi bi-file-earmark-person"></i>
                                        </button>
                                   </div>
                                   <div id="signum_sek2hinweis">
                                   <i class="bi bi-info-circle-fill pr-2"></i> 
                                   <i>Bei Schülern der Sek. II erfolgt die Unterschrift zur wirksamen Anerkennung der Entschuldigung bzw.
                                      des Urlaubsantrages durch die Abgabe des zugehörigen PDF-Ausdrucks im Sekretariat.</i>

                                    </div>
                                </div>
                            </form>      
                            

                            <div class="row m-3 p-3">                            
                                <div class="input-group mb-3" >
                                    <button class="btn btn-info" type="button" id="btn_mitteilung_neu">
                                        <i class="bi-plus-square"></i> neue Mitteilung
                                    </button>
                                    <input type="text" class="form-control" id="txt_mitteilung_neu" data-bs-toggle="tooltip" data-bs-placement="top" title="Platz für Erläuterungen / Hinweise" placeholder="">
                                    <button class="btn btn-secondary" type="button" id="btn_mitteilung_neu_eltern" data-bs-toggle="tooltip" data-bs-placement="top" title="Erfolgte die Mitteilung durch Erziehungsberechtigte?">
                                        <i class="bi-person-check pr-2" id="spn_mitteilung_neu_eltern"></i> Eltern
                                    </button>
                                </div>
                            </div>
                        
                        

                            <div id="mitteilung">
                            </div>

                            
                            <div class="row m-3 p-3 border-top" id="modalZustimmung">
                                <div class="col-md-3">                                    
                                    Zustimmungen
                                </div>    
                                <div class="col-md-9" id="modalZustimmungListe">                                    
                                </div>
                            </div>

                            <!-- Formular fuer das Erfassen des betroffenen Personenkreises -->
                            <div id="modalPersonenkreis">
                                <div class="row m-3 py-2 bg-dark border">
                                    <div class="col-2 ">                                   
                                        <button class="btn btn-secondary mr-2" type="button" id="btn_personenkreis_alle"><i
                                        class="bi bi-toggles px-2"></i>Auswahl umkehren</button>
                                    </div>        
                                    <div class="col-10">
                                        <div id="modalPersonenkreisListe">
                                        </div>                                    
                                    </div>
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

   



        <!-- Formular fuer das Einscannen von Entschuldigungsbögen -->
            
        <div class="modal fade" id="scannerModal" tabindex="-1" aria-labelledby="scannerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="scannerModalLabel">Einscannen von Entschuldigungsbögen / Urlaubsanträgen</h5>                          
                    </div>
    
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row m-3 p-3">                            
                                <div class="col-md" id="scannerModal_msg" >
                                    
                                </div>                                
                            </div>
                            <div class="row m-3 p-3">                            
                                <div class="col-md">
                                    <i>Bei Handeingabe Vorgang mit Enter abschließen, Schaltfläche "Ende" zum abbrechen</i>                                    
                                </div>                                
                            </div>
                        </div>
                    </div>


                    <div class="modal-footer">                        
                        <div class="col-auto">
                            <button class="btn btn-secondary float-right ml-3" type="button" id="btn_scannerCancel">
                                <i class="bi-journal-x px-2"></i>Ende
                            </button>
                        </div>                        
                        
                    </div>

                </div>
            </div>
        </div>


    


        <!-- Modal fuer das Anzeigen der Fehltage -->            
        <div class="modal fade" id="fehltageModal" tabindex="-1" aria-labelledby="fehltageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="fehltageModalLabel">Fehltagszusammenfassung</h5>                          
                    </div>
    
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row m-3 p-3">                            
                            
                                <div class="input-group col-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Sollen die Tage vor Weihnachten, an denen eine Befreiung möglich war, mitgezählt werden?">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="bi-calendar-range px-2"></i></span>
                                            </div>
                                            <div class="form-control text-white bg-secondary" name="chk_ftXmas" id="chk_ftXmas">
                                            Fehltage am 20. - 22.12.2021 ignorieren
                                            </div>    
                                                                       
                                </div>

                                <div class="input-group col-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Sollen Tage, an denen ein Schüler nur an einem Unterricht als nicht fehlend eingetragen wurden, trotzdem als ganze Fehltage zählen?">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="bi-exclude px-2"></i></span>
                                            </div>
                                            <div class="form-control text-white bg-secondary" name="chk_ftIgnore" id="chk_ftIgnore">
                                              Fehltag auch bei singulären Anwesenheiten
                                            </div>                           
                                </div>

                                <div class="input-group" data-bs-toggle="tooltip" data-bs-placement="top" title="Hier kann angegeben werden, dass ein Vertretungsunterricht stattgefunden hat">
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0" 
                                                type="checkbox" 
                                                value="" 
                                                aria-label="Checkbox for following text input"
                                                name="vertretung" id="vertretung">
                                    </div>
                                    <input type="text" class="form-control" value="Vertretung" aria-label="Text input with checkbox" disabled>
                                </div>

                            </div>
                            <div class="row m-3 p-3">                            
                                <div class="col-md" id="fehltageModal_msg" >
                                    
                                </div>                                
                            </div>                            
                        </div>
                    </div>


                    <div class="modal-footer">                        
                        <div class="col-auto">
                            <button class="btn btn-secondary float-right ml-3" type="button" id="btn_fehltageCancel">
                                <i class="bi-journal-x px-2"></i>Ende
                            </button>
                        </div>                        
                        
                    </div>

                </div>
            </div>
        </div>





    <!-- Popper und Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- jsPDF zur Clientseitigen Erzeugung von PDFs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/barcodes/JsBarcode.code128.min.js"></script>

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
      
        var schueler = {};
        var lehrer = {};
        var erledigung = {};
        var gruppe = {};

        var erledigungen = [];
        var stunden = [];
        var get_id = null;

        var mitteilung = {};

        var fehlzeitenuebersicht=[];

        var layout={};

        api_url_modifier = '';

        function initVars(){
                erledigung = {
                    id : null,
                    id_eigenschaft : null,
                    id_schueler : user_schueler_id,
                    id_lehrer : null,
                    von : null,
                    bis : null,
                    mitteilung : [],
                    zustimmung : [],
                    zustimmung_offen : 0,
                    mitteilung_count : 0
                };

                lehrer = {
                    id : user_lehrer_id
                };

                gruppe = {
                    id: null
                };

                mitteilung = {
                    id: null
                };

                fehlzeitenuebersicht = [];

                layout={
                    sizex : 50,
                    sizey : 50,
                    direction : 1,
                    textcolor : 'ivory',
                    my : 10,
                    mx : 10,
                    hxgap : 5,
                    hygap : 5,
                    xgap : 5,
                    ygap : 2
                };

                if(!user_lehrer_id){
                    api_url_modifier = '/eingeschraenkt';
                }
                
        }
        
     

        /*******************************************************
        * document OnReady
        */

        $("document").ready(function () {           
           initVars();

           if(!user_lehrer_id){            
               $('#freistellungNeu').hide();
               $('#signum').hide();
               $('#btn_mitteilung_neu_eltern').hide();
               $('#zustimmungSection').hide();
           }

           $("#cancel").click(function() {
                $("#erledigungModal").modal('hide');
                if(get_id){
                        window.location.href = './weekviewtest.php';
                        return false;
                }
                resetModal();
               });

           $('#btn_personenkreis_alle').click(function(){
                btn_personenkreis_alle();
           });

           $("#speichern").click(function() {modal_speichern(); $("#erledigungModal").modal('hide');});
           $("#neu").click(function() {modal_neu(); $("#erledigungModal").modal('hide');});
           $("#loeschen").click(function() {modal_loeschen(); $("#erledigungModal").modal('hide');});

           $('#gruppe').change(function() { 
                                            read_schueler_by_gruppe($('#gruppe').val()); 
                                            $('#liste').empty();
                                            
                                            schueler = {};
                                            fehlzeitenuebersicht = [];                                            
                                            zeige_fehlzeitenuebersicht(fehlzeitenuebersicht);
                                            });

           $('#schueler').change(function() {
                                                if($('#schueler').val()>=0){
                                                    read_schueler($('#schueler').val());                                                
                                                    read_vorgaenge_by_schueler($('#schueler').val());
                                                } else {
                                                    $('#liste').empty();
                                                    schueler = {};
                                                    fehlzeitenuebersicht = [];                                            
                                                    zeige_fehlzeitenuebersicht(fehlzeitenuebersicht); 
                                                }
                                                
                                            });

           $('#btn_mitteilung_neu_eltern').click(function(){btn_mitteilung_neu_eltern();});
           $('#btn_mitteilung_neu').click(function(){btn_mitteilung_neu();});

           $('#btn_scannerCancel').click(function(){$('#scannerModal').modal('hide');scannerManualInput = false;scannerString="";scannerCount=0;});

           $('#btn_fehltageCancel').click(function(){$('#fehltageModal').modal('hide');});

           read_gruppen();
           read_ustunden();
           if(user_lehrer_id){
            read_lehrer();
            read_zustimmungen();
           }

           
           get_id = <?php echo $_GET['ide'] ?  $_GET['ide'] : 'null' ?>;
           if(get_id){
               erledigungBearbeiten({data:{id:get_id}});
           }

		   /*
		   minWidth = 5*5*50+100;
           if(window.innerWidth<minWidth){
			window.resizeTo(minWidth, window.innerHeight);
		   }
		   */
		   


        });


        /********************************************
        * Handler
        */

       
        //window.jsPDF = window.jspdf.jsPDF;

        var ebogenDrucken_erledigung_ladeversuche = 0;

        function ebogenDrucken(event){
            er_id = event.data.id;
            ei_id = event.data.eigenschaft_id;

            
            if(ebogenDrucken_erledigung_ladeversuche<10){
                               
                if(ebogenDrucken_erledigung_ladeversuche==0){
                    erledigung = {id : -1};
                    read_erledigung(er_id);
                }
                ebogenDrucken_erledigung_ladeversuche++;
                if(erledigung.id==-1){
                    setTimeout(function(){ebogenDrucken(event);},1000);
                    return;
                }
                
            } else {
                if(erledigung.id == -1){
                    console.log("eBg-Druck: Laden der Erledigung fehlgeschlagen.");
                    ebogenDrucken_erledigung_ladeversuche=0;
                    return;
                }                
            }
            
            ebogenDrucken_erledigung_ladeversuche = 0;

            
            let pdf = new jspdf.jsPDF("p", "mm", "a4");
            
            let mx = 11;
            let my = 11;

            pdf.setFontSize(10);            
            pdf.text ("Johannes-Althusius-Gymnasium", mx, my);
            pdf.text ("Oberstufe", mx, my+4);
            
            pdf.setFontSize(16);
            //pdf.setFont("arial", "bold", "normal");
            if(ei_id==-3){
                pdf.text ("Entschuldigungsbogen " + schueler.apollon_id +"-"+erledigung.id, mx, my+10);
            }
            if(ei_id==-4){
                pdf.text ("Urlaubsantrag " + schueler.apollon_id +"-"+erledigung.id, mx, my+10);
            }
            


            pdf.setFontSize(12);
            //pdf.setFont("arial", "normal", "normal");
            pdf.text ("Name, Vorname",mx,my+20);            
            pdf.text (schueler.nachname+", "+schueler.vorname,mx+60,my+20);

            
            pdf.text ("volljährig",mx,my+25);
            pdf.text ("(unbekannt)",mx+60,my+25);

            pdf.text ("Tutor(in)",mx,my+30);
            pdf.text (schueler.tutor_kuerzel,mx+60,my+30);
            
            pdf.text ("von",mx,my+45);
            pdf.text(new Date(erledigung.von.replace(' ','T')).toLocaleString(),mx+60,my+45);

            pdf.text ("bis (einschl.)",mx,my+50);
            pdf.text(new Date(erledigung.bis.replace(' ','T')).toLocaleString(),mx+60,my+50);
            

            let canvas = document.createElement("canvas");
            JsBarcode(canvas, "OK"+erledigung.id, {
                                          format: "CODE128",
                                          displayValue: false
                                          }
                     );

            let img = canvas.toDataURL("image/png");
            pdf.rect (mx+135, my+20, 45, 15);
            pdf.addImage(img, 'PNG',mx+135,my+20,45,15);            
            pdf.text ("Vorgang <"+er_id+">",mx+135,my+9);
                        
            pdf.setFillColor('Black');
            pdf.setTextColor('White');
            pdf.rect(mx+185, my+9, 10, 10, 'F');
            pdf.text(schueler.tutor_kuerzel, mx+187, my+14);
            pdf.setFillColor('White');
            pdf.setTextColor('Black');

            if(ei_id == -3){
                let betroffen=[];
                fehlzeitenuebersicht
                .filter(f=>f.erledigung_id==er_id)
                .forEach(un => {
                    gruppe_id = un.gruppe_id;

                    let treffer_index = -1;
                    for(let i=0; i<betroffen.length && treffer_index<0; i++){
                        if(betroffen[i].gruppe_id && betroffen[i].fach == un.fach){
                            treffer_index = i;
                        }
                    }
                    if(treffer_index>=0){
                        let datum = new Date(un.datum.replace(' ','T')); 
                        betroffen[treffer_index].daten = datum.getDate()+'.'+(datum.getMonth()+1)+'., '+betroffen[treffer_index].daten;
                    } else {                    
                        let datum = new Date(un.datum.replace(' ','T'));                        
                        betroffen.push(
                            {
                                gruppe_id : gruppe_id,
                                gruppe : un.gruppe,
                                fach : un.fach,
                                daten : datum.getDate()+'.'+(datum.getMonth()+1)+'.',
                                lehrer_id : un.lehrer_id,
                                kuerzel : un.kuerzel

                            }
                        );
                    }

                });

                let x = mx;
                let y = my+70;

                y = y-12;
                pdf.rect (x-2, y-5, 20, 12);
                pdf.rect (x+18, y-5, 20, 12);
                pdf.rect (x+38, y-5, 120, 12);
                pdf.rect (x+158, y-5, 20, 12);
                
                pdf.text ("Kurs",x,y);
                pdf.text ("Fach /",x+20,y);
                pdf.text ("Lehrkraft",x+20,y+6);
                pdf.text ("betroffene Daten",x+40,y);
                pdf.text ("Signum",x+160,y);
                y=y+12;

                betroffen
                .forEach(b=>{
                    pdf.text (b.gruppe,x,y);
                    
                    if(b.lehrer_id){
                        pdf.text (b.fach,x+20,y);
                        pdf.text (b.kuerzel,x+20,y+6);
                    } else {
                        pdf.text (b.fach,x+20,y);
                    }

                    
                    if(b.daten.length<49){
                        pdf.text (b.daten,x+40,y);
                    } else {
                        pdf.text (b.daten.substring(0,30)+'...',x+40,y);
                    }

                    if(b.lehrer_id){
                        //console.log(b.kuerzel);
                        

                        treffer = -1;
                        for(let i = 0; i<erledigung.zustimmung.length;i++){
                            let zs = erledigung.zustimmung[i];
                            if(zs.lehrer_id == b.lehrer_id && zs.zustimmung != 0 && zs.gruppe_id==b.gruppe_id){
                                pdf.text (b.kuerzel,x+160,y);
                                pdf.setFontSize(6);
                                pdf.text ("gez., "+new Date(zs.updated_at.substring(0,10)).toLocaleDateString(),x+160,y+5);
                                pdf.setFontSize(12);
                                
                            }
                        }

                    } else {
                        pdf.line(x+158,y-5,x+178,y-5+12);
                    }

                    pdf.rect (x-2, y-5, 20, 12);
                    pdf.rect (x+18, y-5, 20, 12);
                    pdf.rect (x+38, y-5, 120, 12);
                    pdf.rect (x+158, y-5, 20, 12);

                    y = y+12;
                });

                pdf.text("Grund der Abwesenheit (z.B. 'Krankheit'), Attest ggf. aufkleben:",mx,y+6);

                y=y+12;
                pdf.setFontSize(8);
                pdf.text("Zu diesem Vorgang hinterlegte Mitteilungen:",mx,y);
                y=y+5;

                for(i=0; i<erledigung.mitteilung.length && y<250;i++){
                    mt = erledigung.mitteilung[i];
                    pdf.text(new Date(mt.created_at.substring(0,10)).toLocaleDateString(),mx,y);
                    pdf.text(mt.mitteilung,mx+50,y);
                    y=y+3;
                }
                pdf.setFontSize(12);
            }


            if(ei_id==-4){
                let y = my+70;
                for(let i = 0; i<erledigung.zustimmung.length;i++){
                    let zs = erledigung.zustimmung[i];
                    if(zs.lehrer_id != schueler.tutor_id && zs.lehrer_id != null){

                        if(zs.info == null){
                            zs.info = "(ohne Angabe eines Grundes)";
                        }                                           

                        pdf.text(zs.kuerzel,mx+2,y);
                        pdf.text(zs.info,mx+40,y);
                        if(zs.zustimmung > 0){
                            pdf.text ("gez. "+zs.kuerzel+", "+new Date(zs.updated_at.substring(0,10)).toLocaleDateString(),mx+140,y);
                        }      
                        
                        pdf.rect (mx-2, y-6, 40, 12);
                        pdf.rect (mx+38, y-6, 100, 12);                    
                        pdf.rect (mx+138, y-6, 40, 12);

                        y=y+12;
                    }
                }

                y=y+6;
                pdf.text("Mitteilungen zum Antrag / Begründung(en)",mx,y);
                y=y+16;

                for(i=0; i<erledigung.mitteilung.length;i++){
                    mt = erledigung.mitteilung[i];
                    pdf.text(new Date(mt.created_at.substring(0,10)).toLocaleDateString(),mx,y);
                    pdf.text(mt.mitteilung,mx+50,y);
                    y=y+8;
                }



            }


            pdf.setFontSize(8);
            pdf.line(mx,my+255,mx+50,my+255);
            pdf.text("Unterschrift "+schueler.vorname+ " "+schueler.nachname,mx,my+258);

            
            
            for(let i = 0; i<erledigung.zustimmung.length;i++){
                let zs = erledigung.zustimmung[i];
                if(zs.lehrer_id == null && zs.zustimmung != 0 && zs.gruppe_id==null){
                    pdf.setFontSize(12);
                    pdf.text ("gez. Eltern, "+new Date(zs.updated_at.substring(0,10)).toLocaleDateString(),mx+70,my+250);
                    pdf.setFontSize(8);
                    
                }
            }
            pdf.line(mx+70,my+255,mx+70+50,my+255);
            pdf.text("Unterschrift Sorgeberechtigte ODER",mx+70,my+258);
            pdf.text("Volljährige mit Attest (ab 3. Tag / 3.3.1 EB-NSchG)",mx+70,my+261);
            
            
            for(let i = 0; i<erledigung.zustimmung.length;i++){
                let zs = erledigung.zustimmung[i];
                if(zs.lehrer_id == schueler.tutor_id && zs.zustimmung != 0 && zs.gruppe_id==null){
                    pdf.setFontSize(12);
                    pdf.text ("gez. "+schueler.tutor_kuerzel+", "+new Date(zs.updated_at.substring(0,10)).toLocaleDateString(),mx+140,my+250);
                    pdf.setFontSize(8);
                    
                }
            }
            pdf.line(mx+140,my+255,mx+140+50,my+255);
            pdf.text("Unterschrift Tutor",mx+140,my+258);

            pdf.text("JAG Emden / EFZ2.0-KlaBu - erstellt am "+new Date().toLocaleString(),mx,my+270);

            if(ei_id==-3){
                pdf.save ("Entschuldigungsbogen-"+erledigung.id+".pdf");
            }
            if(ei_id==-4){
                pdf.save ("Urlaubsantrag-"+erledigung.id+".pdf");
            }
            
        }


        function toggle_fzue_reihenfolge(){
            layout.direction *= -1;
            zeige_fehlzeitenuebersicht(fehlzeitenuebersicht);
        }

        function fzue_drucken(){
            $('#fzue-container').removeClass('bg-dark').addClass('bg-white');
            layout.textcolor = 'black';
            zeige_fehlzeitenuebersicht(fehlzeitenuebersicht);

            $('#fehlzeitenuebersicht-steuerung').hide();
            $('#liste').hide();
            $('#zustimmungSection').hide();

            window.print();

            setTimeout(function(e) {
                $('#fzue-container').removeClass('bg-white').addClass('bg-dark');
                layout.textcolor = 'ivory';
                zeige_fehlzeitenuebersicht(fehlzeitenuebersicht);
                $('#fehlzeitenuebersicht-steuerung').show();
                if(user_lehrer_id){
                    $('#zustimmungSection').show();
                }                
                $('#liste').show();
            }, 500);
            
        }

        function btn_mitteilung_neu_eltern(){
            if(!mitteilung.eltern){
                mitteilung.eltern = 1;
                $('#spn_mitteilung_neu_eltern').removeClass().addClass("bi-person-check-fill pr-2");
                $('#btn_mitteilung_neu_eltern').removeClass().addClass("btn btn-info");
            } else {
                mitteilung.eltern = 0;
                $('#spn_mitteilung_neu_eltern').removeClass().addClass("bi-person-check pr-2");
                $('#btn_mitteilung_neu_eltern').removeClass().addClass("btn btn-secondary");
            }
        }

        function btn_mitteilung_neu(){
            
            mitteilung.id = -1;
            mitteilung.mitteilung = $('#txt_mitteilung_neu').val();
            mitteilung.erledigung_id = erledigung.id;
            mitteilung.created_at = new Date().toISOString();
            mitteilung.geloescht = 0;
            

            erledigung.mitteilung.unshift(mitteilung);

            $('#txt_mitteilung_neu').val("");
            
            mitteilung ={id: -1, eltern: 1};
            btn_mitteilung_neu_eltern();

            zeige_mitteilungen();
            
        }



        function read_vorgaenge_by_schueler(schueler_id){

            erledigungen = [];

            read_erledigungen(schueler_id,-3);
            read_erledigungen(schueler_id,-4);
            read_erledigungen(schueler_id,-5);

            read_fehlzeitenuebersicht(schueler_id);

        }

        function entschuldigungNeu(){
            
            sus_id = $('#schueler').val();
            if(!sus_id ||sus_id < 0){
                alert('Für eine neue Krankmeldung muss vorher ein Schüler ausgewählt werden.')
                return;
            }
            read_schueler(sus_id);
            
            resetModal();
            
            $('#neu').show();
            $('#erledigungModalText').text('Neue Entschuldigung');
            
            erledigung.id = -1;
            erledigung.eigenschaft_id = -3;
            erledigung.mitteilung = [];
            
            $('#erledigungModal').modal('show');

        }


        function beurlaubungNeu(){
            
            sus_id = $('#schueler').val();
            if(!sus_id ||sus_id < 0){
                alert('Für eine neue Beurlaubung muss vorher ein Schüler ausgewählt werden.')
                return;
            }
            read_schueler(sus_id);
            
            resetModal();
            
            $('#neu').show();
            $('#erledigungModalText').text('Neue Beurlaubung (privat)');
            
            erledigung.id = -1;
            erledigung.eigenschaft_id = -4;
            erledigung.mitteilung = [];
            
            $('#erledigungModal').modal('show');

        }


        function freistellungNeu(){
            
            //Prüfung auf ausgewählte Schüler-ID?            
            resetModal();

            $('#modalPersonenkreis').show();  

            
            sus_id = $('#schueler').val();
            if(!sus_id ||sus_id < 0){
                schueler.id = -1;
                $('#erledigungModalSchueler').text("Gruppe "+$('#gruppe option:selected').text());
            } else {
                read_schueler(sus_id);
            }
            

            
            $('#neu').show();
            $('#erledigungModalText').text('Neue Freistellung (schulisch)');
            
            erledigung.id = -1;
            erledigung.eigenschaft_id = -5;
            erledigung.mitteilung = [];
            
            $('#erledigungModal').modal('show');

        }


        function erledigungBearbeiten(event){
            er_id = event.data.id;
            ei_id = event.data.eigenschaft_id;

            resetModal();
            $('#neu').hide();
            $('#speichern').show();
            $('#loeschen').show();

            read_erledigung(er_id);
            
            $('#erledigungModal').modal('show');

        }


        function modal_loeschen(){
            update_erledigung(erledigung.id,{geloescht : 1});
        }


        function modal_speichern(){
            
            vont = '06:00:00';
            id_von = $('#vonStunde').val();
            stunden.forEach (stunde => {
                if(stunde.id  == id_von) {
                    vont = stunde.beginn;
                }
            });

            bist = '20:00:00';
            id_bis = $('#bisStunde').val();
            stunden.forEach (stunde => {
                if(stunde.id  == id_bis) {
                    bist = stunde.ende;
                }
            })

            vond = $('#von').val();
            bisd = $('#bis').val();

            von = null;
            bis = null;

            if(vond!=''){
                von = new Date(vond+"T"+vont); //Safari T
                von.setTime(von.getTime() - von.getTimezoneOffset()*60*1000);
                von = von.toISOString().slice(0, 19).replace('T', ' ');
            }
            
            if(bisd !=''){
                bis = new Date(bisd+"T"+bist); //Safari T
                bis.setTime(bis.getTime() - bis.getTimezoneOffset()*60*1000);
                bis = bis.toISOString().slice(0, 19).replace('T', ' ');
            }

    
            lehrer_id = $('#lehrer').val();
            if(!lehrer_id || lehrer_id < 0){
                lehrer_id = null;
            }
            
            data = {                 
                        von : von,
                        bis : bis,
                        lehrer_id : lehrer_id
                    };

            console.log(data);

            if($('#txt_mitteilung_neu').val()!=''){
                btn_mitteilung_neu();
            }

            update_erledigung(erledigung.id, data);
        }




        function modal_neu(){
            
            vont = '06:00:00';
            id_von = $('#vonStunde').val();
            stunden.forEach (stunde => {
                if(stunde.id  == id_von) {
                    vont = stunde.beginn;
                }
            });

            bist = '20:00:00';
            id_bis = $('#bisStunde').val();
            stunden.forEach (stunde => {
                if(stunde.id  == id_bis) {
                    bist = stunde.ende;
                }
            })

            vond = $('#von').val();
            bisd = $('#bis').val();

            von = null;
            bis = null;

            if(vond!=''){
                von = new Date(vond+"T"+vont); //Safari T
                von.setTime(von.getTime() - von.getTimezoneOffset()*60*1000);
                von = von.toISOString().slice(0, 19).replace('T', ' ');
            }
            
            if(bisd !=''){
                bis = new Date(bisd+"T"+bist); //Safari T
                bis.setTime(bis.getTime() - bis.getTimezoneOffset()*60*1000);
                bis = bis.toISOString().slice(0, 19).replace('T', ' ');
            }

    
            lehrer_id = $('#lehrer').val();
            if(!lehrer_id || lehrer_id < 0){
                lehrer_id = null;
            }

            data = {                 
                        eigenschaft_id : erledigung.eigenschaft_id,
                        schueler_id : $('#schueler').val(),
                        von : von,
                        bis : bis,
                        lehrer_id : lehrer_id
                    };

            console.log(data);

            if($('#txt_mitteilung_neu').val()!=''){
                btn_mitteilung_neu();
            }

            //Beurlaubung ganzer Kurse
            if(data.schueler_id == -1 && data.eigenschaft_id == -5){
                
                if(!data.von || !data.bis){
                    alert("Fehlerhafte Daten! - Von und Bis-Zeitpunkt müssen gesetzt sein");
                    return;
                }

                console.log("Freistellung ganzer Kurs: "+gruppe.belegung.filter(sus=>sus.pk_selected==true).length+" Personen");
                gruppe.belegung.filter(sus=>sus.pk_selected==true).forEach(b=>{
                    console.log(b.schueler.vorname+" #"+b.schueler.id);

                    data.schueler_id = b.schueler.id;
                    speicher_erledigung(data);
                });                
                return;
            }

            speicher_erledigung(data);
        }




        /**
        * Bei Klick auf das Erledigungs-DIV aufgerufene Methode
        * z.B. unterschreiben
        */
        function erledigungClick(event){
            er_id = event.data.id;
            ei_id = event.data.eigenschaft_id;

            if(!user_lehrer_id) return;


            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api"+api_url_modifier+"/erledigung/"+er_id,
                type: "GET",
                success: function (data) {
                    
                    var response = $.parseJSON(data);
                    console.log(response);

                    if(response.eigenschaft_id == -3){
                        if(response.von == null){
                            alert("Fehlerhafte Entschuldigung\nEs muss ein Startzeitpunkt vorhanden sein. Bitte editieren Sie den Vorgang.");
                            return;
                        }

                        if(response.bis == null){
                            alert("Unvollständige Entschuldigung\nEs fehlt der Endzeitpunkt. Bitte editerien Sie den Vorgang oder warten auf die Gesundmeldung durch den Schüler.");
                            return;
                        }

                        if(response.lehrer_id){
                            //response.lehrer_id = null;
                        } else {
                            response.lehrer_id = user_lehrer_id;
                        }
                        
                        if(response.zustimmung_offen > 0){
                            alert("Noch "+response.zustimmung_offen+" Zustimmungen ausstehend.\nWenn Sie den Vorgang wirklich vorzeitig anerkennen wollen, klicken Sie auf den Stift");
                            return;
                        }

                        if(response.schueler.apollon_id){
                            alert("Die Anerkennung bei Oberstufenschülern erfolgt über das Sekretariat und den ausgedruckten Entschuldigungsbogen.\nWenn Sie den Vorgang wirklich vorzeitig anerkennen wollen, klicken Sie auf den Stift");
                            return;
                        }

                        update_erledigung(response.id, {lehrer_id : response.lehrer_id});

                    }


                    if(response.eigenschaft_id == -4){
                        if(response.von == null || response.bis == null){
                            alert("Fehlerhafter Urlaubsantrag\nEs muss ein Start- und Endzeitpunkt vorhanden sein. Bitte editieren Sie den Vorgang.");
                            return;
                        }

                        if(response.zustimmung_offen > 0){
                            alert("Zustimmungen ausstehend.\nWenn Sie den Antrag wirklich vorzeitig anerkennen wollen, klicken Sie auf den Stift");
                            return;
                        }

                        if(response.schueler.apollon_id){
                            alert("Die Anerkennung bei Oberstufenschülern erfolgt über das Sekretariat und den ausgedruckten Urlaubsantrag.\nWenn Sie den Vorgang wirklich vorzeitig anerkennen wollen, klicken Sie auf den Stift");
                            return;
                        }

                        if(response.lehrer_id){
                            //response.lehrer_id = null;
                        } else {
                            response.lehrer_id = user_lehrer_id;
                        }

                        update_erledigung(response.id, {lehrer_id : response.lehrer_id});
                    }
                    
                    
                }
            });
            
        }


        function resetModal(){
            $('#erledigungModalText').text('');
			$('#erledigungModalSchueler').text('');
			

            $('#von').val(new Date().toISOString().substr(0,10));            
            $('#bis').val(null);
            
            
            $('#lehrer').val(user_lehrer_id);

            //Vorbesetzung des Signum-Lehrer-Selects NICHT für Schulmitarbeiter
            //telefonische Annahme von Krankmeldungen
            let lehrer_kuerzel = $('#lehrer option:selected').text().substr(0,3);
            console.log("sig lul "+lehrer_kuerzel);
            if(    lehrer_kuerzel == 'HUP'
                || lehrer_kuerzel == 'KIR'){
                    $('#lehrer').val(-1);
            }

            $('#mitteilung').empty();
            $('#txt_mitteilung_neu').val("");

            $('#modalZustimmungListe').empty();  
            $('#modalZustimmung').hide();  

            $('#modalPersonenkreis').hide();  

            $('#loeschen').hide();
            $('#speichern').hide();
            $('#neu').hide();

            $('#signum_sek2hinweis').hide();
        }


        function update_view_erledigung(){
            console.log('uve');
            console.log(erledigungen);

            $('#liste').empty();

            erledigungen.sort(function(a,b){
                if(a.von > b.von){
                    return -1;
                }
                if(a.von < b.von){
                    return 1;
                }
                return 0;
            });



            erledigungen.forEach(rowe => {
                            

                warn = 0;
                btncls = "btn btn-secondary";
                btntxt = "#"+rowe.id+" Typ:"+rowe.eigenschaft_id;
                btnzustimmung = null;
                btndrucken = null;

                //Darstellung von Entschuldigungen
                if(rowe.eigenschaft_id == -3){
                
                    btntxt = "(e) ";                  
                    
                    if(rowe.von){
                        von = new Date(rowe.von.replace(' ','T')).toLocaleDateString(); //Safari T
                    } else {
                        von ="--.--.----";
                        warn += 1;
                    }
                    
                    if(rowe.bis){
                        bis = new Date(rowe.bis.replace(' ','T')).toLocaleDateString(); //Safari T
                    } else {
                        bis = "--.--.----";
                        warn +=1;
                    }
                                                
                    
                    btntxt += von + " bis " + bis;
                    if(rowe.lehrer_id){
                        btntxt += " ("+rowe.lehrer_kuerzel+")";
                    } else {
                        btntxt += " (__)";
                        warn +=1;
                    }

                   
                    if(warn > 0){
                        btncls = "btn btn-warning";
                    } else {                    
                        btncls = "btn btn-success";                    
                    }

                    //Liegen alle Zustimmungen/Unterschriften vor 
                    //UND ist der Vorgang noch nicht anerkannt <=> !rowe.lehrer_id ?
                    btnzustimmung = null;
                    if(rowe.zustimmung_gruppe_offen>0 && !rowe.lehrer_id){
                        btnzustimmung = $("<i></i>")
                                    .addClass("bi-exclamation-triangle-fill px-2");
                    }
                    
                    //Druck-Button für Entschuldigungsbogen
                    btndrucken = $("<button></button>")
                                .addClass("btn btn-secondary")
                                .on('click', {id : rowe.id, eigenschaft_id : rowe.eigenschaft_id}, ebogenDrucken)                                       
                                .append(
                                    $("<i></i>")
                                    .addClass("bi-printer")                                            
                                );

                }


                //Darstellung von Beurlaubungen (privat)
                if(rowe.eigenschaft_id == -4){
                
                    btntxt = "(u) ";
                    
                    if(rowe.von){
                        von = new Date(rowe.von.replace(' ','T')).toLocaleDateString(); //Safari T
                    } else {
                        von ="--.--.----";
                        warn += 1;
                        btncls = "btn btn-danger";
                    }
                    
                    if(rowe.bis){
                        bis = new Date(rowe.bis.replace(' ','T')).toLocaleDateString(); //Safari T
                    } else {
                        bis = "--.--.----";
                        warn +=1;
                        btncls = "btn btn-danger";
                    }
                                                
                    
                    btntxt += von + " bis " + bis;
                    if(warn==0){
                        if(rowe.lehrer_id){
                            btntxt += " ("+rowe.lehrer_kuerzel+")";
                        } else {
                            btntxt += " (__)";
                            warn +=1;
                            btncls = "btn btn-warning";
                        }
                    } else {
                        btntxt += " Antrag unvollständig!";
                        btncls = "btn btn-danger";
                    }

                   
                    if(warn == 0){                        
                        btncls = "btn btn-info";                    
                    }

                    //Liegen alle Zustimmungen/Unterschriften vor?
                     //UND ist der Vorgang noch nicht anerkannt <=> !rowe.lehrer_id ?
                    btnzustimmung = null;
                    if(rowe.zustimmung_offen>0 && !rowe.lehrer_id ){
                        btnzustimmung = $("<i></i>")
                                    .addClass("bi-exclamation-triangle-fill px-2");
                    }                 
                   
                    //Druck-Button für Entschuldigungsbogen
                    btndrucken = $("<button></button>")
                    .addClass("btn btn-secondary")
                    .on('click', {id : rowe.id, eigenschaft_id : rowe.eigenschaft_id}, ebogenDrucken)                                       
                    .append(
                        $("<i></i>")
                        .addClass("bi-printer")                                            
                    );

                    
                }


                //Darstellung von Beurlaubungen (schulisch)
                if(rowe.eigenschaft_id == -5){
                    
                    btntxt = "(s) ";
                    

                    if(rowe.von){
                        von = new Date(rowe.von.replace(' ','T')).toLocaleDateString(); //Safari T
                    } else {
                        von ="--.--.----";
                        warn += 1;
                        btncls = "btn btn-danger";
                    }
                    
                    if(rowe.bis){
                        bis = new Date(rowe.bis.replace(' ','T')).toLocaleDateString(); //Safari T
                    } else {
                        bis = "--.--.----";
                        warn +=1;
                        btncls = "btn btn-danger";
                    }
                                                
                    
                    btntxt += von + " bis " + bis;
                    if(rowe.lehrer_id && warn == 0){
                        btntxt += " ("+rowe.lehrer_kuerzel+")";
                    } else {
                        btntxt += " (__)";
                        warn +=1;
                        btncls = "btn btn-danger";
                    }
                    

                    if(warn > 0){
                        btncls = "btn btn-danger";
                    } else {                    
                        btncls = "btn btn-primary";                    
                    }

                    
                }

                ttmtg =  "keine Mitteilung";
                if (rowe.mitteilung.length > 0) {
                    ttmtg = rowe.mitteilung.length + " Einträge, letzter vom " + new Date(rowe.mitteilung[rowe.mitteilung.length-1].created_at.replace(' ','T')).toLocaleString() +": "+rowe.mitteilung[0].mitteilung; //Safari T
                }

                ttext = "Vorgang <"+rowe.id+">"
                +"\nvon: \t\t\t\t"+ (rowe.von ? new Date(rowe.von.replace(' ','T')).toLocaleString().substr(0,20) : '--.--.----')
                +"\nbis (einschl.): \t\t"+(rowe.bis ? new Date(rowe.bis.replace(' ','T')).toLocaleString().substr(0,20) : '--.--.----')
                +"\nZustimmung: \t\t"+( rowe.zustimmung.length >0 ? (rowe.zustimmung.length - rowe.zustimmung_offen) + " von " + (rowe.zustimmung.length) : "ohne Zustimmung")
                +"\nMitteilungen: \t\t"+ ttmtg
                +"\nUrheber: \t\t\t"+ (rowe.created_by ? rowe.created_by : "ohne") 
                +"\nletzte Änderung: \t"+ (rowe.updated_by ? rowe.updated_by + " am "+new Date(rowe.updated_at.replace(' ','T')).toLocaleString() : "ohne") ;
                //3x Safari T

                $('#liste').append(
                    $("<div></div>")
                    .addClass("col-md-3")
                        .append(
                        $("<div></div>")
                        .attr("data-bs-toggle","tooltip")
                        .attr("data-bs-placement", "top")
                        .attr("title", ttext)
                        .addClass("m-1 float-left")
                        .append(
                            $("<div></div>")
                            .addClass('btn-group btn-group-sm')                            
                            .attr("role","group")
                            .append(
                                $("<button></button>")
                                .on('click', {id : rowe.id, eigenschaft_id : rowe.eigenschaft_id}, erledigungClick) 
                                .addClass(btncls)
                                .text(btntxt)
                                .append(btnzustimmung)
                                
                            )
                            .append(btndrucken)
                            .append(
                                $("<button></button>")
                                .addClass("btn btn-secondary")
                                .on('click', {id : rowe.id, eigenschaft_id : rowe.eigenschaft_id}, erledigungBearbeiten)                                       
                                .append(
                                    $("<i></i>")
                                    .addClass("bi-pencil")                                            
                                )
                            )
                            
                        )
                    )
                );
            });  



        }



        /***************************************************************
        * Vorbesetzungen der Auswahlfehlder
        */


        /**
            * Lehrer lesen
            */
        function read_lehrer(event) {
            $.ajax({
                url:  "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api"+api_url_modifier+"/lehrer",                    
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                    $("#lehrer").find('option').remove().end().append(new Option('', -1));                        
                    response.forEach(row => {
                        $("#lehrer").append(new Option(row.kuerzel + " - " + row.nachname, row.id));                            
                    });

                    // Lehrer aus der SESSION setzen                        
                    set_session_lehrer();

                    // Button "ICH" funktioniert ab jetzt
                    $("#ich_btn").click(function() {
                            set_session_lehrer();
                    });
                    
                }
            });
        }

        function set_session_lehrer(){
            let lehrer_id = $('#lehrer').val();            
            if(lehrer_id < 0 || !lehrer_id){
                $("#lehrer").val(<?php echo $_SESSION['user_lehrer_id'];?>);
            } else {
                $('#lehrer').val(-1);
            }
        }


        /**
        * Lesen aller Stunden fur die Stunden-Auswahl
        */
        function read_ustunden(event) {
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/ustunde",
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                    
                    stunden = response;

                    $("#vonStunde").find('option').remove().end().append(new Option('', -1));
                    $("#bisStunde").find('option').remove().end().append(new Option('', -1));
                    response.forEach(row => {
                        $("#vonStunde").append(new Option(row.name + " ( ab "+row.beginn+ " Uhr)", row.id));
                        $("#bisStunde").append(new Option(row.name + " ( bis "+row.ende+ " Uhr)", row.id));
                    });
                }
            });
        }



         /**
         * Lesen aller Gruppen füe die Klassenauswahl 
         * (API-Zugriff wird bei Schülern nur auf eigenes Tutoriat beschränkt)
         */
        function read_gruppen(event) {
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api"+api_url_modifier+"/gruppe",
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                    $("#gruppe").find('option').remove().end().append(new Option('(Gruppe wählen)', -1));
                    response.forEach(row => {
                        $("#gruppe").append(new Option(row.name, row.id));
                    });
                    
                    if(aktiv_gruppe_id){
                        $('#gruppe').val(aktiv_gruppe_id);
                        read_schueler_by_gruppe($('#gruppe').val()); 
                        $('#liste').empty();
                    }

                    if(!user_lehrer_id){
                        $('#gruppe').val(response[0].id);
                        read_schueler_by_gruppe($('#gruppe').val()); 
                    }
                },
                error: function (e) {
                    console.log(e.message);
                }
            });
        }


        /**
         * Lesen aller Gruppen füe die Klassenauswahl 
         * (API-Zugriff wird bei Schülern nur auf eigene Identität)
         */
        function read_schueler_by_gruppe(id) {
            console.log('sus rbg '+id);
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api"+api_url_modifier+"/gruppe/"+id,
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                    gruppe = response;
                    gruppe.belegung.sort((a,b)=> a.schueler.nachname > b.schueler.nachname && 1 || -1);

                    $("#schueler").find('option').remove().end().append(new Option('(mehrere/alle Schüler der Gruppe)', -1));                    
                    $("#modalPersonenkreisListe").empty();
                    console.log(gruppe);
                    gruppe.belegung.forEach(row => {
                        nachname = row.schueler.nachname;
                                if (row.schueler.nachname.substr(0,3)=='ZZ '){
                                    splitpoint = row.schueler.nachname.indexOf(' ',4)+1;
                                    nachname = row.schueler.nachname.substr(splitpoint) + ' ('+row.schueler.nachname.substr(3,splitpoint-4)+')';
                                }
                                if(row.schueler.apollon_id){
                                    nachname += ' ('+row.schueler.apollon_id+')';
                                }
                        
                        row.pk_selected = true;

                        $("#schueler").append(new Option(row.schueler.vorname +' '+nachname, row.schueler.id));

                        $("#modalPersonenkreisListe").append($("<button></button")
                                    .addClass("btn btn-dark ")
									.attr('type', 'button')
                                    .attr('id', "btn_pk" + row.id)
                                    .on('click', function () {
                                        btn_pk_toggle(row.id)
                                    })
                                    .append($("<span></span>")
                                        .addClass("badge badge-info")
                                        .attr('id', "badge_pk" + row.id)
                                        .text(row.schueler.vorname + ' ' + nachname)
                                    )
                                );

                    });
                    
                    if(user_schueler_id){                       
                       $('#schueler').val(user_schueler_id);
                       if(!user_lehrer_id){
                        read_vorgaenge_by_schueler(user_schueler_id);
                       }
                    } else if(schueler.id){                       
                       $('#schueler').val(schueler.id);
                       read_vorgaenge_by_schueler(schueler.id);
                    }

                },
                error: function (e) {
                    console.log(e.message);
                }
            });
        }


        function btn_pk_toggle(id){
            let elem = $('#badge_pk'+id);
            let sus = gruppe.belegung.find(sus => sus.id == id);

            if(elem && sus){
                let cls = "badge badge-info";
                if(sus.pk_selected){
                    sus.pk_selected = false;
                    cls = "badge badge-secondary";
                } else {
                    sus.pk_selected = true;
                }
                elem.removeClass().addClass(cls);
            }
        }

        function btn_personenkreis_alle(){
            gruppe.belegung.forEach(sus=>{
               btn_pk_toggle(sus.id);
            });
        }

        function read_schueler(id) {
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api"+api_url_modifier+"/schueler/"+id,
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                    
                    console.log(response);

                    schueler = response;			
					
					$('#erledigungModalSchueler').text(schueler.vorname+' '+schueler.nachname);

                    if($('#schueler').val()<0){
                        $('#gruppe').val(schueler.gruppe_id);
                        read_schueler_by_gruppe(schueler.gruppe_id);
                    }

                    if(user_lehrer_id && schueler.apollon_id && erledigung.eigenschaft_id != -5){
                        $('#signum').hide();
                        $('#signum_sek2hinweis').show();                        
                        if(erledigung.id < 0){
                            $('#lehrer').val(-1); 
                            console.log('Sig -> null');
                        }                        
                    } else {
                       $('#signum').show(); 
                       $('#signum_sek2hinweis').hide();                       
                       if(erledigung.id < 0){
                            $('#lehrer').val(user_lehrer_id);
                            console.log('Sig -> user');
                       }
                    }


                },
                error: function (e) {
                    console.log(e.message);
                }
            });
        }



        /**
        * Lesen aller Erledigungen eines Schülers
        */
        function read_erledigungen(schueler_id, eigenschaft_id) {
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api"+api_url_modifier+"/erledigung/schueler/"+schueler_id+"/eigenschaft/"+eigenschaft_id,
                type: "GET",
                success: function (data) {
                    
                    var response = $.parseJSON(data);
                    console.log(response);

                    erledigungen = erledigungen.concat(response);
                    update_view_erledigung();
                }
            });
        }

        // Returns the ISO week of the date.
        //https://weeknumber.com/how-to/javascript
        Date.prototype.getWeek = function() {
            var date = new Date(this.getTime());
            date.setHours(0, 0, 0, 0);
            // Thursday in current week decides the year.
            date.setDate(date.getDate() + 3 - (date.getDay() + 6) % 7);
            // January 4 is always in week 1.
            var week1 = new Date(date.getFullYear(), 0, 4);
            // Adjust to Thursday in week 1 and count number of weeks from date to week1.
            return 1 + Math.round(((date.getTime() - week1.getTime()) / 86400000 - 3 + (week1.getDay() + 6) % 7) / 7);
        }


        // Gibt die Wochendifferenz zwischen dem übergebenen Referenzdatum an
        // 
        Date.prototype.getWeekDiff = function(refdate) {
             refdate.setHours(0, 0, 0, 0);
             
             //Normierung Wochenanfang auf Montag, 00:00:00
             var date = new Date(this.getTime());
             date.setHours(0, 0, 0, 0);
             date.setDate( date.getDate()-((date.getDay()+6)%7) );
                          
             var timediff = refdate - date;
             let dst_diff = date.getTimezoneOffset() - refdate.getTimezoneOffset();
             return Math.floor((timediff+dst_diff*60*1000) / (1000 * 60 * 60 * 24 * 7));            
        }


        function read_fehlzeitenuebersicht(schueler_id){            
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api"+api_url_modifier+"/erledigung/entschuldigung/fehlzeitenuebersicht/"+schueler_id,
                type: "GET",
                success: function (data) {
                    
                    var response = $.parseJSON(data);                    
                    fehlzeitenuebersicht = response;
                    
                    zeige_fehlzeitenuebersicht(fehlzeitenuebersicht);
                }
            });
        }


        function zeige_fehlzeitenuebersicht(daten){
                                  
            
            $('#fehlzeitenuebersicht').empty();
            $('#fehlzeitenuebersicht').css('position', 'relative');

            let pos = $("#fehlzeitenuebersicht").offset();            
            let element = null;
            let x = 0;
            let y = 0;
            
            
            size = Math.floor( ($(window).width() - layout.hxgap - 5*layout.xgap - 2*layout.mx ) / (5*5+2) );
            layout.sizex = (size>25 ? size : 25);
            layout.sizey = (size>50 ? size : 50);

            

            /*
                direction = 1 (neuester Eintrag zuerst)
                direction = -1 (ältester Eintrag zuerrst)

                Horizontale Abstände / Größen

                    [my]          5x Tag à 5*sizex+1*xgap                       1x sizex Unterrichte Sa, So
                (mx)(sizex)(hxgap)(sizex)(sizex)(sizex)(sizex)(sizex)(xgap) ... (sizex)(mx)
                    KW49          M      D      En

                Vertikale Abstände

                    [my]    margin zum Parent-DIV
                    [sizey] Überschrift Wochentag
                    [hygap] Lücke zwischen Überschrift und Inhalt
                    [ygap]  Lücke zwischen den Zeilen
            */

            let heute = new Date();
            //console.log(heute);
            heute.setDate(heute.getDate()+7);
            //console.log(heute);
            let startmontag =  new Date(heute.setDate(heute.getDate() - ((heute.getDay()+6)%7)));
            //console.log(startmontag);
            startmontag.setHours(0, 0, 0, 0);
            //console.log(startmontag);
            let kw_start = startmontag.getWeek();
            
            //Bestimmen der notwendigen Zeilenanzahl
            let maxreihe = 0;
            daten.forEach(un=>{
                let datum = new Date(un.datum.replace(' ','T'));         //Safari T
                let reihe = datum.getWeekDiff(heute);
                if(reihe > maxreihe){
                    maxreihe = reihe;
                }
            })

            //Array nach Tagen; 14.01.22
            let tage = [];

            daten.forEach(un => {

                let datum = new Date(un.datum.replace(' ','T'));     // Safari T
                
                
                let reihe = datum.getWeekDiff(heute);
                if(layout.direction == -1) {
                    reihe = maxreihe - reihe;
                }
                

                let block = un.block-1;
                if(block > 4){
                    block = 4;
                }

                let wochentag = (datum.getDay() + 6) % 7;
                if(wochentag > 5){
                    wochentag == 6;
                    block = 0;                            
                }

                
                let y = layout.my +  1 * layout.sizey + layout.hygap + reihe * (layout.sizey+layout.ygap);
                let x = layout.mx +  1 * layout.sizex + layout.hxgap + wochentag * (5 * layout.sizex+layout.xgap) + block * layout.sizex;


                //14.01.22 - Aufnehmen in Tage-Reihung
                let tag = tage.find(t => t.datum == un.datum);
                if(!tag){
                    tag = {datum : un.datum,
                        wochentag :  wochentag,
                        reihe : reihe,
                        y : y,
                        x : x - block*layout.sizex,
                        unterrichte : []
                    }
                    tage.push(tag);
                }

             

                //Grundelement "Unterricht"
                //Farbverhalten bei fehlt==0 <=> SuS trotz Belegung nicht vom Unterricht betroffen
                un.fehlenZaehlen = 1;
                un.entschuldigt = 0;
                un.ueberlagert = 0;

                let elg_c = layout.textcolor;
                if(un.fehlt == 0){
                    elg_c = "darkorange";                       
                }
                if(wochentag > 5){
                    elg_c = "yellow";                       
                }                        
                let elementg = $('<div></div>')
                                .css('padding-left','2px')
                                .css('width', layout.sizex+'px')
                                .css('height', layout.sizey+'px')
                                .click(function(){praesenzVeraendern(un);})
                                .css('position', 'absolute')
                                .css('left', x+'px')
                                .css('top', y+'px')
                                .css('border', '1px solid '+elg_c)
                                .css('color', elg_c)
                                .html(un.fach+"<br>"+un.gruppe.substr(0,5));
                                
                
                //Overlayelement "Entschuldigung"
                //Farbverhalten bei fehlt==0 <=> SuS trotz Belegung nicht vom Unterricht betroffen                
                let ele = null;
                if(un.erledigung_id){
                    let ele_bg = "yellow";

                    un.fehlenZaehlen = 1;
                    un.entschuldigt = 0;
                    un.ueberlagert = 0;
                    
                    if(un.eigenschaft_id == -3 && un.erledigung_lehrer_id && un.bis){
                        ele_bg = "green";                       
                        un.entschuldigt = 1;                        
                    } else if(un.eigenschaft_id == -3 && !un.erledigung_lehrer_id){
                        ele_bg = "yellow";                                                   
                    } else if (un.eigenschaft_id == -4 && un.erledigung_lehrer_id){
                        un.entschuldigt = 1;
                        ele_bg = "cyan";                       
                    } else if (un.eigenschaft_id == -4 && !un.erledigung_lehrer_id){
                        ele_bg = "yellow";                       
                    } else if (un.eigenschaft_id == -5){
                        ele_bg = "lightcyan";                       
                        un.entschuldigt = 1;
                        un.fehlenZaehlen = 0;
                    } 

                    ele = $('<div></div>')
                                    .css('padding-left','2px')
                                    .css('width', layout.sizex+'px')
                                    .css('height', (4*layout.sizey/5)+'px')
                                    .css('position', 'absolute')
                                    .css('left', x+'px')
                                    .css('top', (y+0)+'px')                                            
                                    .css('background-color', ele_bg)
                                    .css('opacity', 0.65)
                                    .click(function(){erledigungBearbeiten({data:{id:un.erledigung_id}});})
                                    .css('color','white')
                                    .css('text-align', 'center')
                                    .css('vertical-align', 'middle')
                                    .css('line-height', size+'px')
                                    .append(
                                        $('<span></span>')
                                        .css('background-color', 'black')
                                        .css('opacity', 1)
                                        .append(
                                            $('<small></small>')
                                            .append(
                                                $('<b></b>')
                                                .text(un.erledigung_id)
                                            )                                        
                                        )
                                    )
                                    ;
                                    
                }


                //Overlayelement "Absenz"                        
                //14.01.: zuvor if(un.fehlt==2 && !ele)  jetzt:  Element ele mit 4/5 Höhe
                let ela = null;
                if(un.fehlt==2 ){
                    let ela_bg = "pink";

                    ela = $('<div></div>')
                                    .css('padding-left','2px')
                                    .click(function(){praesenzVeraendern(un);})
                                    .css('width', layout.sizex+'px')
                                    .css('height', (5*layout.sizey/5)+'px')
                                    .css('position', 'absolute')
                                    .css('left', x+'px')
                                    .css('top', y+'px')                                            
                                    .css('background-color', ela_bg)
                                    .css('opacity', 0.8);                                            
                }

                //Overlayelement "zu spät"                        
                if(un.fehlt==3 ){
                    let ela_bg = "orange";

                    ela = $('<div></div>')
                                    .css('padding-left','2px')
                                    .click(function(){praesenzVeraendern(un);})
                                    .css('width', layout.sizex+'px')
                                    .css('height', (5*layout.sizey/5)+'px')
                                    .css('position', 'absolute')
                                    .css('left', x+'px')
                                    .css('top', y+'px')                                            
                                    .css('background-color', ela_bg)
                                    .css('opacity', 0.8);                                            
                }


                //Zukünftige Einträge nur eine Woche im Vorraus
                if(reihe >=0){
                    $("#fehlzeitenuebersicht").append(elementg);                        
                    $("#fehlzeitenuebersicht").append(ela);                        
                    $("#fehlzeitenuebersicht").append(ele);                        
                    
                }
                
                //Suche nach Unterrichtsüberlagerungen und überlagerten Vorgängen
                //Dominant ist immer der Unterricht, in welchem eine Anwesenheit registriert wurde.
                //Dominant ist immer die anerkannte Entschuldigung und der nicht zu zählende Fehltag
                let t_un = tag.unterrichte.find(u => u.block == un.block && u.ueberlagert == 0);
                if(t_un){                    
                    //Überlagerung eines vorhandenen Unterrichts durch anderen Unterricht(Kurs)
                    if(un.fehlt==1){
                        t_un.ueberlagert = 1;
                    } 
                    //Überlagerung durch anderen Vorgang
                    else if(un.entschuldigt == 1 || un.fehlenZaehlen==0){
                        t_un.ueberlagert = 1;
                    } 
                    //Neuer Unterricht/Vorgang ist von altem überlagert
                    else {
                        un.ueberlagert = 1;
                    }
                } 
                tag.unterrichte.push(un);
                

                
             

            });

            
            

            maxreihe++;
            let totalheight = (maxreihe+1)*(layout.sizey+layout.ygap)+layout.hygap-layout.ygap;
            let totalwidth = (layout.sizex+layout.hxgap+5*(5*layout.sizex+layout.xgap)+layout.sizex);

            //Höhe des Anzeige-DIVs anpassen
            $('#fehlzeitenuebersicht').css("height", totalheight + 20 +2*layout.sizey + "px");
            
            //KW-Anzeige am Rand links
            //horizontale Trennlinien
            for(let i = 0; i<maxreihe; i++){
                
                let pos = i;
                if(layout.direction == -1) {
                    pos = maxreihe - i-1;
                }

                let y = layout.my +  1*layout.sizey + layout.hygap + pos * (layout.sizey+layout.ygap);
                let x = layout.mx;
                               
                
                let monday = new Date(startmontag - i*7*24*60*60*1000);                
                
                //getTimezoneOffset liefert während MESZ einen größeren Wert
                let dst_diff = monday.getTimezoneOffset() - startmontag.getTimezoneOffset();
                //console.log(dst_diff);

                monday = new Date(monday.getTime()+dst_diff*60*1000);
                let kw = monday.getWeek();

                

                let abtxt = ((monday.getDate()) < 10 ? '0'+(monday.getDate()): (monday.getDate())) 
                            +"."
                            + ((monday.getMonth()+1) < 10 ? '0'+(monday.getMonth()+1): (monday.getMonth()+1)) 
                            +".";

                let element = $('<div></div>')
                                .css('width', layout.sizex+'px')
                                .css('height', layout.sizey+'px')
                                .css('position', 'absolute')
                                .css('left', x+'px')
                                .css('top', y+'px')
                                .css('border', '1px solid lightgray')
                                .css('color', layout.textcolor)
                                .html('KW'+(kw)+'<br><small>'+abtxt+'</small>');
                                
                $("#fehlzeitenuebersicht").append(element);                        

                element = $('<div></div>')
                            .css('width', totalwidth+'px' )
                            .css('height', layout.ygap+'px')
                            .css('position', 'absolute')
                            .css('left', x+'px')
                            .css('top', y+'px')
                            .css('border', '1px solid lightgray')
                            .css('background-color', 'lightgray');    
                $("#fehlzeitenuebersicht").append(element);   
                
            }

            //Wochentage oben
            let wochentage=['Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag', 'Sonntag'];
            for(let i = 0; i<5;i++){
                let y = layout.my;
                let x = layout.mx + 1*layout.sizex + layout.hxgap +i*(5*layout.sizex+layout.xgap);
                
                let element = $('<div></div>')
                                .css('width', 5*layout.sizex+'px')
                                .css('height', layout.sizey+'px')
                                .css('position', 'absolute')
                                .css('left', x+'px')
                                .css('top', y+'px')
                                .css('border', '1px solid lightgray')
                                .css('padding-left', '2px')
                                .css('color', layout.textcolor)
                                .text(wochentage[i]);                                
                $("#fehlzeitenuebersicht").append(element);                        
            }

            //Stundenblock oben
            let blocknamen = ['1./2.','3./4.','5./6.','7./8.','9.+'];
            for(let j = 0; j <5; j++){
                for(let i = 0; i<5;i++){
                    let y = layout.my+layout.sizey/2;
                    let x = layout.mx + 1*layout.sizex + layout.hxgap +j*(5*layout.sizex+layout.xgap)+i*layout.sizex;
                    
                    let element = $('<div></div>')
                                    .css('width', layout.sizex+'px')
                                    .css('height', (layout.sizey/2)+'px')
                                    .css('position', 'absolute')
                                    .css('left', x+'px')
                                    .css('top', y+'px')                                    
                                    .css('padding-left', '2px')
                                    .css('border-right', '1px solid lightgray')
                                    .css('color', layout.textcolor)
                                    .text(blocknamen[i]);                                
                    $("#fehlzeitenuebersicht").append(element);                        
                }
            }

            //Beschriftung Spalte "Wochende"
            y = layout.my;
            x = layout.mx + 1*layout.sizex + layout.hxgap +5*(5*layout.sizex+layout.xgap);            
            element = $('<div></div>')
                            .css('width', 1*layout.sizex+'px')
                            .css('height', layout.sizey+'px')
                            .css('position', 'absolute')
                            .css('left', x+'px')
                            .css('top', y+'px')
                            .css('border', '1px solid lightgray')
                            .css('padding-left', '2px')
                            .css('color', layout.textcolor)
                            .text('WE');                            
            $("#fehlzeitenuebersicht").append(element); 


            //Horizontale Trennlinie nach Überschrift
            y = layout.my + layout.sizey;
            x = layout.mx;
            element = $('<div></div>')
                            .css('width', totalwidth+'px' )
                            .css('height', layout.hygap+'px')
                            .css('position', 'absolute')
                            .css('left', x+'px')
                            .css('top', y+'px')
                            .css('border', '1px solid lightgray')
                            .css('background-color', 'lightgray');                                        
                            
            $("#fehlzeitenuebersicht").append(element);                        

            //Vertikale Trennlinien innerhalb der Tabelle
            for(let i = 0; i<5;i++){
                let y = layout.my;
                let x = layout.mx + 1*layout.sizex + layout.hxgap +i*(5*layout.sizex+layout.xgap) + 5*layout.sizex;
                
                let element = $('<div></div>')
                                .css('width', layout.xgap+'px')
                                .css('height', totalheight+'px')
                                .css('position', 'absolute')
                                .css('left', x+'px')
                                .css('top', y+'px')
                                .css('border', '1px solid lightgray')
                                .css('background-color', 'lightgray');                                        
                                
                $("#fehlzeitenuebersicht").append(element);                        
            }
            //Vertikale Trennlinie nach Überschrift
            y = layout.my;
            x = layout.mx + 1*layout.sizex;            
            element = $('<div></div>')
                            .css('width', layout.hxgap+'px')
                            .css('height', totalheight+'px')
                            .css('position', 'absolute')
                            .css('left', x+'px')
                            .css('top', y+'px')
                            .css('border', '1px solid lightgray')
                            .css('background-color', 'lightgray');                                        
                            
            $("#fehlzeitenuebersicht").append(element);                        
            //Umrandung
            y = layout.my;
            x = layout.mx;                
            element = $('<div></div>')
                            .css('width', totalwidth+'px')
                            .css('height', totalheight+'px')
                            .css('position', 'absolute')
                            .css('left', x+'px')
                            .css('top', y+'px')
                            .css('border', '1px solid lightgray')                           
                            
                            
            $("#fehlzeitenuebersicht").prepend(element);

            
            //Legenden
            let legendeg = $('<div></div>')
                                .css('padding-left','2px')
                                .css('width', layout.sizex+'px')
                                .css('height', layout.sizey+'px')
                                .css('position', 'absolute')
                                .css('left', layout.mx + layout.sizex+'px')
                                .css('top', totalheight+layout.my+10+'px')
                                .css('border', '1px solid '+layout.textcolor)
                                .css('color', layout.textcolor)
                                .html("De<br>8b");
            
            let legendegt = $('<div></div>')
                                .css('padding-left','2px')
                                .css('width', layout.sizex+'px')
                                .css('height', layout.sizey+'px')
                                .css('position', 'absolute')
                                .css('left', layout.mx + layout.sizex+'px')
                                .css('top', totalheight+layout.sizey+layout.my+10+'px')
                                .css('color', layout.textcolor)
                                .html("<small>besuchter<br>Unterricht</small>");

            $("#fehlzeitenuebersicht").append(legendeg);
            $("#fehlzeitenuebersicht").append(legendegt);


            legendeg = $('<div></div>')
                                .css('padding-left','2px')
                                .css('width', layout.sizex+'px')
                                .css('height', layout.sizey+'px')
                                .css('position', 'absolute')
                                .css('left', layout.mx + 3*layout.sizex+'px')
                                .css('top', totalheight+layout.my+10+'px')
                                .css('border', '1px solid darkorange')
                                .css('color', 'darkorange')
                                .html("De<br>8b");
            
            legendegt = $('<div></div>')
                                .css('padding-left','2px')
                                .css('width', layout.sizex+'px')
                                .css('height', layout.sizey+'px')
                                .css('position', 'absolute')
                                .css('left', layout.mx + 3*layout.sizex+'px')
                                .css('top', totalheight+layout.sizey+layout.my+10+'px')
                                .css('color', layout.textcolor)
                                .html("<small>U. ohne<br>Schüler</small>");

            $("#fehlzeitenuebersicht").append(legendeg);
            $("#fehlzeitenuebersicht").append(legendegt);

        
            //Legende "gelb"
            let legendeo = $('<div></div>')
                            .css('padding-left','2px')
                            .css('width', layout.sizex+'px')
                            .css('height', layout.sizey+'px')
                            .css('position', 'absolute')
                            .css('left', layout.mx + 5*layout.sizex+'px')
                            .css('top', totalheight+layout.my+10+'px')                                          
                            .css('background-color', 'yellow')
                            .css('opacity', 0.5)
                            .css('color','white')
                            .css('text-align', 'center')
                            .css('vertical-align', 'middle')
                            .css('line-height', size+'px')
                            .append(
                                $('<span></span>')
                                .css('background-color', 'black')
                                .css('opacity', 1)
                                .append(
                                    $('<small></small>')
                                    .append(
                                        $('<b></b>')
                                        .text('<ID>')
                                    )                                        
                                )
                            )
                            ;

            legendeg = $('<div></div>')
                                .css('padding-left','2px')
                                .css('width', layout.sizex+'px')
                                .css('height', layout.sizey+'px')
                                .css('position', 'absolute')
                                .css('left', layout.mx + 5*layout.sizex+'px')
                                .css('top', totalheight+layout.my+10+'px')
                                .css('border', '1px solid '+layout.textcolor)
                                .css('color', layout.textcolor)
                                .html("De<br>8b");
            
            legendegt = $('<div></div>')
                                .css('padding-left','2px')
                                .css('width', layout.sizex+'px')
                                .css('height', layout.sizey+'px')
                                .css('position', 'absolute')
                                .css('left', layout.mx + 5*layout.sizex+'px')
                                .css('top', totalheight+layout.sizey+layout.my+10+'px')
                                .css('color', layout.textcolor)
                                .html("<small>Unterschrift<br>fehlt</small>");

            $("#fehlzeitenuebersicht").append(legendeg);
            $("#fehlzeitenuebersicht").append(legendegt);
            $("#fehlzeitenuebersicht").append(legendeo);


            //Legende "grün"
            legendeo = $('<div></div>')
                            .css('padding-left','2px')
                            .css('width', layout.sizex+'px')
                            .css('height', layout.sizey+'px')
                            .css('position', 'absolute')
                            .css('left', layout.mx + 7*layout.sizex+'px')
                            .css('top', totalheight+layout.my+10+'px')                                          
                            .css('background-color', 'green')
                            .css('opacity', 0.5)
                            .css('color','white')
                            .css('text-align', 'center')
                            .css('vertical-align', 'middle')
                            .css('line-height', size+'px')
                            .append(
                                $('<span></span>')
                                .css('background-color', 'black')
                                .css('opacity', 1)
                                .append(
                                    $('<small></small>')
                                    .append(
                                        $('<b></b>')
                                        .text('<ID>')
                                    )                                        
                                )
                            )
                            ;

            legendeg = $('<div></div>')
                                .css('padding-left','2px')
                                .css('width', layout.sizex+'px')
                                .css('height', layout.sizey+'px')
                                .css('position', 'absolute')
                                .css('left', layout.mx + 7*layout.sizex+'px')
                                .css('top', totalheight+layout.my+10+'px')
                                .css('border', '1px solid '+layout.textcolor)
                                .css('color', layout.textcolor)
                                .html("De<br>8b");
            
            legendegt = $('<div></div>')
                                .css('padding-left','2px')
                                .css('width', layout.sizex+'px')
                                .css('height', layout.sizey+'px')
                                .css('position', 'absolute')
                                .css('left', layout.mx + 7*layout.sizex+'px')
                                .css('top', totalheight+layout.sizey+layout.my+10+'px')
                                .css('color', layout.textcolor)
                                .html("<small>wirksam<br>entschuldigt</small>");

            $("#fehlzeitenuebersicht").append(legendeg);
            $("#fehlzeitenuebersicht").append(legendegt);
            $("#fehlzeitenuebersicht").append(legendeo);



      //Legende "lightcyan / Freistellung"
      legendeo = $('<div></div>')
                            .css('padding-left','2px')
                            .css('width', layout.sizex+'px')
                            .css('height', layout.sizey+'px')
                            .css('position', 'absolute')
                            .css('left', layout.mx + 9*layout.sizex+'px')
                            .css('top', totalheight+layout.my+10+'px')                                          
                            .css('background-color', 'lightcyan')
                            .css('opacity', 0.5)
                            .css('color','white')
                            .css('text-align', 'center')
                            .css('vertical-align', 'middle')
                            .css('line-height', size+'px')
                            .append(
                                $('<span></span>')
                                .css('background-color', 'black')
                                .css('opacity', 1)
                                .append(
                                    $('<small></small>')
                                    .append(
                                        $('<b></b>')
                                        .text('<ID>')
                                    )                                        
                                )
                            )
                            ;

            legendeg = $('<div></div>')
                                .css('padding-left','2px')
                                .css('width', layout.sizex+'px')
                                .css('height', layout.sizey+'px')
                                .css('position', 'absolute')
                                .css('left', layout.mx + 9*layout.sizex+'px')
                                .css('top', totalheight+layout.my+10+'px')
                                .css('border', '1px solid '+layout.textcolor)
                                .css('color', layout.textcolor)
                                .html("De<br>8b");
            
            legendegt = $('<div></div>')
                                .css('padding-left','2px')
                                .css('width', layout.sizex+'px')
                                .css('height', layout.sizey+'px')
                                .css('position', 'absolute')
                                .css('left', layout.mx + 9*layout.sizex+'px')
                                .css('top', totalheight+layout.sizey+layout.my+10+'px')
                                .css('color', layout.textcolor)
                                .html("<small>schulische<br>Freistellung</small>");

            $("#fehlzeitenuebersicht").append(legendeg);
            $("#fehlzeitenuebersicht").append(legendegt);
            $("#fehlzeitenuebersicht").append(legendeo);


            //Legende "cyan / Urlaub"
            legendeo = $('<div></div>')
                            .css('padding-left','2px')
                            .css('width', layout.sizex+'px')
                            .css('height', layout.sizey+'px')
                            .css('position', 'absolute')
                            .css('left', layout.mx + 11*layout.sizex+'px')
                            .css('top', totalheight+layout.my+10+'px')                                          
                            .css('background-color', 'cyan')
                            .css('opacity', 0.5)
                            .css('color','white')
                            .css('text-align', 'center')
                            .css('vertical-align', 'middle')
                            .css('line-height', size+'px')
                            .append(
                                $('<span></span>')
                                .css('background-color', 'black')
                                .css('opacity', 1)
                                .append(
                                    $('<small></small>')
                                    .append(
                                        $('<b></b>')
                                        .text('<ID>')
                                    )                                        
                                )
                            )
                            ;

            legendeg = $('<div></div>')
                                .css('padding-left','2px')
                                .css('width', layout.sizex+'px')
                                .css('height', layout.sizey+'px')
                                .css('position', 'absolute')
                                .css('left', layout.mx + 11*layout.sizex+'px')
                                .css('top', totalheight+layout.my+10+'px')
                                .css('border', '1px solid '+layout.textcolor)
                                .css('color', layout.textcolor)
                                .html("De<br>8b");
            
            legendegt = $('<div></div>')
                                .css('padding-left','2px')
                                .css('width', layout.sizex+'px')
                                .css('height', layout.sizey+'px')
                                .css('position', 'absolute')
                                .css('left', layout.mx + 11*layout.sizex+'px')
                                .css('top', totalheight+layout.sizey+layout.my+10+'px')
                                .css('color', layout.textcolor)
                                .html("<small>private<br>Beurlaubung</small>");

            $("#fehlzeitenuebersicht").append(legendeg);
            $("#fehlzeitenuebersicht").append(legendegt);
            $("#fehlzeitenuebersicht").append(legendeo);


            //Legende "pink / Absenz"
            legendeo = $('<div></div>')
                            .css('padding-left','2px')
                            .css('width', layout.sizex+'px')
                            .css('height', layout.sizey+'px')
                            .css('position', 'absolute')
                            .css('left', layout.mx + 13*layout.sizex+'px')
                            .css('top', totalheight+layout.my+10+'px')                                          
                            .css('background-color', 'pink')
                            .css('opacity', 0.8)
                            ;

            legendeg = $('<div></div>')
                                .css('padding-left','2px')
                                .css('width', layout.sizex+'px')
                                .css('height', layout.sizey+'px')
                                .css('position', 'absolute')
                                .css('left', layout.mx + 13*layout.sizex+'px')
                                .css('top', totalheight+layout.my+10+'px')
                                .css('border', '1px solid '+layout.textcolor)
                                .css('color', layout.textcolor)
                                .html("De<br>8b");
            
            legendegt = $('<div></div>')
                                .css('padding-left','2px')
                                .css('width', layout.sizex+'px')
                                .css('height', layout.sizey+'px')
                                .css('position', 'absolute')
                                .css('left', layout.mx + 13*layout.sizex+'px')
                                .css('top', totalheight+layout.sizey+layout.my+10+'px')
                                .css('color', layout.textcolor)
                                .html("<small>unentsch.<br>Fehlen</small>");

            $("#fehlzeitenuebersicht").append(legendeg);
            $("#fehlzeitenuebersicht").append(legendegt);
            $("#fehlzeitenuebersicht").append(legendeo);


            //Legende "orange / zu spät"
            legendeo = $('<div></div>')
                            .css('padding-left','2px')
                            .css('width', layout.sizex+'px')
                            .css('height', layout.sizey+'px')
                            .css('position', 'absolute')
                            .css('left', layout.mx + 15*layout.sizex+'px')
                            .css('top', totalheight+layout.my+10+'px')                                          
                            .css('background-color', 'orange')
                            .css('opacity', 0.8)
                            ;

            legendeg = $('<div></div>')
                                .css('padding-left','2px')
                                .css('width', layout.sizex+'px')
                                .css('height', layout.sizey+'px')
                                .css('position', 'absolute')
                                .css('left', layout.mx + 15*layout.sizex+'px')
                                .css('top', totalheight+layout.my+10+'px')
                                .css('border', '1px solid '+layout.textcolor)
                                .css('color', layout.textcolor)
                                .html("De<br>8b");
            
            legendegt = $('<div></div>')
                                .css('padding-left','2px')
                                .css('width', layout.sizex+'px')
                                .css('height', layout.sizey+'px')
                                .css('position', 'absolute')
                                .css('left', layout.mx + 15*layout.sizex+'px')
                                .css('top', totalheight+layout.sizey+layout.my+10+'px')
                                .css('color', layout.textcolor)
                                .html("<small>unpünktliches<br>Erscheinen</small>");

            $("#fehlzeitenuebersicht").append(legendeg);
            $("#fehlzeitenuebersicht").append(legendegt);
            $("#fehlzeitenuebersicht").append(legendeo);



//Auszählung und Darstellung der Fehltage
           console.log(tage);
            
            $('#fehltageModal_msg').empty();
            $('#fehltageModal_msg').append($("<div></div>").attr('id','fehltageModal_msg_ft').addClass("row mb-2").text("Entschuldigte Fehltage: "));
            $('#fehltageModal_msg').append($("<div></div>").attr('id','fehltageModal_msg_ftu').addClass("row mb-2").text("Unentschuldigte Fehltage: "));
            let fehltage_count = 0;
            let fehltageEntschuldigt_count = 0;
            tage.forEach(tag=>{
                
                let unterrichte_valid = tag.unterrichte.filter(u => u.ueberlagert == 0)
                let unterrichte_count = unterrichte_valid.length;
                let unterrichte_anwesend = unterrichte_valid.filter(u => u.fehlt == 1 || u.fehlt == 3).length;
                let unterrichte_abwesend = unterrichte_valid.filter(u => u.fehlt == 2).length;
                let unterrichte_unklar = unterrichte_valid.filter(u => u.fehlt == 0).length;
                
                if(unterrichte_anwesend == 0 && unterrichte_abwesend > 0){
                    unterrichte_abwesend += unterrichte_unklar;
                } else if (unterrichte_unklar == unterrichte_count && unterrichte_valid.every(u => u.erledigung_id)) {
                    unterrichte_abwesend = unterrichte_unklar;
                } else {
                    unterrichte_anwesend += unterrichte_unklar;
                }
                /*
                if(tag.unterrichte.filter(u => u.ueberlagert == 0).every(u => u.fehlt==2 || u.fehlt==0)){
                    if(tag.unterrichte.filter(u => u.ueberlagert == 0).every(u => u.fehlenZaehlen == 1) || tag.unterrichte.every(u => u.fehlt == 0)){
                */
                if(     unterrichte_count == unterrichte_abwesend ||
                        (unterrichte_abwesend >= unterrichte_count-1 && unterrichte_anwesend <=1 && unterrichte_valid.every(u => u.erledigung_id))
                    ){
                    if(unterrichte_valid.every(u => u.fehlenZaehlen == 1) 
                        && tag.datum != '2021-12-20'
                        && tag.datum != '2021-12-21'
                        && tag.datum != '2021-12-22'
                         ){
                        fehltage_count++;
                        let txt_datum = (new Date(tag.datum.replace(' ','T')).getDate())+ '.'+ (new Date(tag.datum.replace(' ','T')).getMonth()+1)+'.'
                        if(tag.unterrichte.every(u => u.entschuldigt == 1)) {                            
                            $('#fehltageModal_msg_ft').append($("<div></div>").addClass("m-2 p-1 border border-info").text(txt_datum));
                            fehltageEntschuldigt_count++;
                            
                            let rahmen = $('<div></div>')                                    
                                    .css('padding-left','2px')
                                    .css('width', 5*layout.sizex+'px')
                                    .css('height', '5px')
                                    .css('position', 'absolute')
                                    .css('left', tag.x+'px')
                                    .css('top', tag.y+'px')                                                                                
                                    .css('opacity', 1) 
                                    .css('border', '5px solid green');
                                    

                            $("#fehlzeitenuebersicht").append(rahmen);

                        } else {                            
                            $('#fehltageModal_msg_ftu').append($("<div></div>").addClass("m-2 p-1 border border-warning").text(txt_datum));
                            let rahmen = $('<div></div>')                                    
                                    .css('padding-left','2px')
                                    .css('width', 5*layout.sizex+'px')
                                    .css('height', '5px')
                                    .css('position', 'absolute')
                                    .css('left', tag.x+'px')
                                    .css('top', tag.y+'px')                                                                                
                                    .css('opacity', 1) 
                                    .css('border', '5px solid red');
                                    

                            $("#fehlzeitenuebersicht").append(rahmen);

                        }                        
                    } else {
                        //console.log("Nicht zu zählender Fehltag am "+tag.datum);
                        let rahmen = $('<div></div>')                                    
                                    .css('padding-left','2px')
                                    .css('width', 5*layout.sizex+'px')
                                    .css('height', '5px')
                                    .css('position', 'absolute')
                                    .css('left', tag.x+'px')
                                    .css('top', tag.y+'px')                                                                                
                                    .css('opacity', 1) 
                                    .css('border', '5px dashed green');
                                    

                            $("#fehlzeitenuebersicht").append(rahmen);
                    }                    
                }
            });
            
            
            //Fehltageszählung oberhalb der Übersicht in der Liste der Vorgänge
            $('#btn_fehltagszaehlung').remove();
            $('#fehlzeitenuebersicht-steuerung').append(
                    $("<div></div>")
                    .addClass("input-group col-md")
                    .attr('id','btn_fehltagszaehlung')
                        .append(
                        $("<div></div>")
                        .attr("data-bs-toggle","tooltip")
                        .attr("data-bs-placement", "top")
                        .attr("title", "Als Fehltage zählen Tage, an denen nur Unterrichte mit Abwesenheit und keine schulische Freistellung vorliegen")
                        .addClass("m-1 float-left")
                        .append(
                            $("<div></div>")
                            .addClass('btn-group btn-group-sm')                            
                            .attr("role","group")
                            .append(
                                $("<button></button>")
                                .addClass("btn btn-secondary")                             
                                .append(
                                    $("<i></i>")
                                    .addClass("bi-info-circle")                                            
                                )
                            )
                            .append(
                                $("<button></button>")                                
                                .addClass("btn btn-secondary")
                                .click(function(){$('#fehltageModal').modal('show');})
                                .text(fehltage_count+" Fehltage, davon "+(fehltage_count-fehltageEntschuldigt_count)+" unentschuldigt")
                            )
                        )
                    )
                );


          

        }


        var praesenzVeraendern_confirm_unterrichtId = null;

        function praesenzVeraendern(un){
            
            if(!schueler || !user_lehrer_id || schueler.tutor_id != user_lehrer_id){
                console.log("unzulässiger Klick");
                return;
            }

            
            if(!praesenzVeraendern_confirm_unterrichtId  || praesenzVeraendern_confirm_unterrichtId != un.unterricht_id){
                let response = confirm("Achtung! Sie verändern eine Angabe zur Präsenz des Unterrichts #"+un.unterricht_id+". Wollen Sie das wirklich?")

                if(response){
                    praesenzVeraendern_confirm_unterrichtId = un.unterricht_id;
                } else {
                    return;
                }
            }

            un.fehlt += 1;
            un.fehlt = un.fehlt % 4;

            data = JSON.stringify({fehlt : un.fehlt});
            
            $.ajax({
                type: 'PUT',
                url: '/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/praesenz/' + un.praesenz_id,
                data: data,
                success: function (json) {
                    zeige_fehlzeitenuebersicht(fehlzeitenuebersicht);
                },
                error: function (e) {
                    console.log(e.message);
                    alert(e.message);
                },
                dataType: "json",
                contentType: "application/json"
            });
        }


        /**
        * Lesen einer Erledigung
        */
        function read_erledigung(id){

            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api"+api_url_modifier+"/erledigung/"+id,
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                    
                    console.log(response);
                    erledigung = response;					
					
                    read_schueler(erledigung.schueler_id);

					if(erledigung.eigenschaft_id==-3){
                        $('#erledigungModalText').text('Entschuldigung <'+erledigung.id+'> bearbeiten');
                    }
                    if(erledigung.eigenschaft_id==-4){
                        $('#erledigungModalText').text('Beurlaubung <'+erledigung.id+'> (privat) bearbeiten');
                    }
                    if(erledigung.eigenschaft_id==-5){
                        $('#erledigungModalText').text('Freistellung <'+erledigung.id+'> (schulisch) bearbeiten');
                    }

                    if(erledigung.von){
                        von = new Date(erledigung.von.substr(0,10)).toISOString().substr(0,10);
                        $('#von').val(von);                    
                        vonStunde_besetzen(erledigung.von);
                    }

                    if(erledigung.bis){
                        bis = new Date(erledigung.bis.substr(0,10)).toISOString().substr(0,10);
                        $('#bis').val(bis);
                        bisStunde_besetzen(erledigung.bis);
                    }

                    
                    ttext = "Vorgang <"+erledigung.id+">"
                +"<br>von: "+ (erledigung.von ? new Date(erledigung.von.replace(' ','T')).toLocaleString().substr(0,20) : '--.--.----')
                +"<br>bis (einschl.): "+(erledigung.bis ? new Date(erledigung.bis.replace(' ','T')).toLocaleString().substr(0,20) : '--.--.----')
                +"<br>Zustimmung: "+( erledigung.zustimmung.length >0 ? (erledigung.zustimmung.length - erledigung.zustimmung_offen) + " von " + (erledigung.zustimmung.length) : "ohne Zustimmung")
                +"<br>Mitteilungen: "+ (erledigung.mitteilung.length > 0 ? erledigung.mitteilung.length + " Einträge" : "keine Mitteilung")
                +"<br>Urheber: "+ (erledigung.created_by ? erledigung.created_by : "ohne") 
                +"<br>letzte Änderung: "+ (erledigung.updated_by ? erledigung.updated_by + " am "+new Date(erledigung.updated_at.replace(' ','T')).toLocaleString() : "ohne") ;
                    // 3x Safari T

                    //$('#modalInfo').html(ttext);  

                    if(!erledigung.lehrer_id){
                        $('#lehrer').val(-1);
                    } else {
                        $('#lehrer').val(erledigung.lehrer_id);
                    }
                    

                    zeige_mitteilungen();

                    zeige_zustimmungen();

                    

                },
                error: function (e) {
                    console.log(e.message);
                }
            });
        }

        function zeige_zustimmungen(){
            $('#modalZustimmungListe').empty();  
            $('#modalZustimmung').hide();  
            if(erledigung.zustimmung.length>0){
                $('#modalZustimmung').show();  

                erledigung.zustimmung.forEach(zs => {
                    let bgcolor = "bg-secondary";

                    if(zs.zustimmung == 0){
                        bgcolor = "bg-secondary";
                    }
                    if(zs.zustimmung > 0){
                        bgcolor = "bg-success";
                    }
                    if(zs.zustimmung < 0){
                        bgcolor = "bg-danger";
                    }

                    if(user_lehrer_id && zs.lehrer_id==user_lehrer_id){
                        $('#modalZustimmungListe').append(
                            $('<span></span>')
                            .addClass("badge "+bgcolor+" mx-2 px-2")
                            .text(zs.kuerzel+" / "+zs.info)
                            .click(function(){zustimmung_wechseln(zs);})
                        )
                    } else {
                        $('#modalZustimmungListe').append(
                            $('<span></span>')
                            .addClass("badge "+bgcolor+" mx-2 px-2")
                            .text(zs.kuerzel+" / "+zs.info)
                        );
                    }

                });
            }
            
        }

        function zeige_mitteilungen(){
            $('#mitteilung').empty();

            erledigung.mitteilung.filter(mtg => mtg.geloescht == 0).forEach(mitteilung => {

                let mtg_von = new Date(mitteilung.created_at.replace(' ','T')); //Safari T

                let mtg_text = mtg_von.toLocaleString() + ' - '+mitteilung.mitteilung;

                let  vonEltern = null;
                if(mitteilung.eltern == 1){
                    vonEltern = $('<i></i>').addClass("bi-person-check-fill px-2");
                }

                $('#mitteilung').append(
                    $('<div></div>')
                    .addClass('row ml-3 pl-3')
                    .append(
                        $('<div></div>')
                        .addClass('col-md-1')
                        .append(
                            $('<i></i>')
                            .addClass('bi-trash pr-2')
                            .click(function(){mitteilung_loeschen(erledigung.mitteilung.indexOf(mitteilung));})                            
                        )
                        .append(vonEltern)
                    )
                    .append(
                        $('<div></div>')
                        .addClass('col-md-11')
                        .text(mtg_text)                        
                    )
                );
            });
        }


        function read_zustimmungen(){            
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/zustimmung/lehrer/"+user_lehrer_id,
                type: "GET",
                success: function (data) {
                    
                    var response = $.parseJSON(data);
                    
                    $('#zustimmungListe').empty();
                    if(response.length > 0){
                        $('#zustimmungSection').show();
                        
                        //Darstellung von Zustimmungen nur, wenn
                        //Kursunterricht
                        //oder zu dem betreffenden Vorgang keine Kursunterrichte mehr zustimmungspflichtig sind
                        response
                        .filter(z => z.erledigung.bis != null && (z.gruppe_id != null || z.erledigung.zustimmung_gruppe_offen == 0))
                        .forEach(zs => {
                            console.log(zs);
                        btntxt = zs.info + ': '+ zs.erledigung.schueler.vorname +' '+zs.erledigung.schueler.nachname
                                + ': '+ new Date(zs.erledigung.von.replace(' ','T')).toLocaleDateString()   // Safari T
                                + " - " + new Date(zs.erledigung.bis.replace(' ','T')).toLocaleDateString(); //Safari T
                        
                        $('#zustimmungListe').append(
                                                $("<div></div>")                                                
                                                .attr("data-bs-toggle","tooltip")
                                                .attr("data-bs-placement", "top")
                                                .attr("title", "Klicken Sie zur Zustimmung auf diesen Button. Mit dem Bleistift können Sie dem Schüler eine Nachricht zukommen lassen.")
                                                .addClass("m-1 float-left")
                                                .append(
                                                    $("<div></div>")
                                                    .addClass('btn-group btn-group-lg')                            
                                                    .attr("role","group")
                                                    .append(
                                                        $("<button></button>")
                                                        .on('click', function(){ zustimmung_abgeben(zs.id);}) 
                                                        .addClass("btn btn-info btn-lg")
                                                        .text(btntxt)
                                                    )
                                                    .append(
                                                        $("<button></button>")
                                                        .addClass("btn btn-secondary btn-lg")
                                                        .on('click', {id : zs.erledigung.id, eigenschaft_id : zs.erledigung.eigenschaft_id}, erledigungBearbeiten)                                       
                                                        .append(
                                                            $("<i></i>")
                                                            .addClass("bi-pencil")                                            
                                                        )
                                                    )
                                                    
                                                )
                                            
                                        );
                        });

                    } else {
                        $('#zustimmungSection').hide();
                    }

                    
                }
            });
        }


        function vonStunde_besetzen(time){
            von = time.substr(11,8);
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/ustunde/beginn/"+von,
                type: "GET",
                success: function (data) {
                    
                    var response = $.parseJSON(data);
                    console.log(response);

                    $('#vonStunde').val(response.id);
                }
            });
        }


        function bisStunde_besetzen(time){
            bis = time.substr(11,8);
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/ustunde/ende/"+bis,
                type: "GET",
                success: function (data) {
                    
                    var response = $.parseJSON(data);
                    console.log(response);

                    $('#bisStunde').val(response.id);
                }
            });
        }


        function zustimmung_abgeben(id){
            data = JSON.stringify({zustimmung : 1});
            
            $.ajax({
                type: 'PUT',
                url: '/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/zustimmung/' + id,
                data: data,
                success: function (json) {
                    read_zustimmungen();                   
                },
                error: function (e) {
                    console.log(e.message);
                    alert(e.message);
                },
                dataType: "json",
                contentType: "application/json"
            });
        }

        function zustimmung_wechseln(zs){
            zs.zustimmung = parseInt(zs.zustimmung) + 1;
            if(zs.zustimmung > 1){
                zs.zustimmung = -1;
            }
            data = JSON.stringify({zustimmung : zs.zustimmung});
            
            $.ajax({
                type: 'PUT',
                url: '/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/zustimmung/' + zs.id,
                data: data,
                success: function (json) {
                    zeige_zustimmungen();         
                    read_zustimmungen();           
                },
                error: function (e) {
                    console.log(e.message);
                    alert(e.message);
                },
                dataType: "json",
                contentType: "application/json"
            });
        }

        function update_erledigung(erledigung_id, data){                  
            
            formdata = JSON.stringify(data);
            
            $.ajax({
                type: 'PUT',
                url: '/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api'+api_url_modifier+'/erledigung/' + erledigung_id,
                data: formdata,
                success: function (json) {
                    speicher_mitteilungen();

                    if(get_id){
                        window.location.href = './weekviewtest.php';
                        return false;
                    }
                    read_vorgaenge_by_schueler($('#schueler').val());
                    
                   
                },
                error: function (e) {
                    console.log(e.message);
                    alert(e.message);
                },
                dataType: "json",
                contentType: "application/json"
            });
        }


        function speicher_erledigung(data){                  
            
            formdata = JSON.stringify(data);
            
            $.ajax({
                type: 'POST',
                url: '/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api'+api_url_modifier+'/erledigung',
                data: formdata,
                success: function (json) {
                    read_vorgaenge_by_schueler($('#schueler').val());
                                       
                    erledigung.id = json.id;

                    speicher_mitteilungen();
                    
                },
                error: function (e) {
                    console.log(e.message);
                    alert(e.message);
                },
                dataType: "json",
                contentType: "application/json"
            });
        }


        function mitteilung_loeschen(index){            
            let mtg = erledigung.mitteilung[index];
            mtg.geloescht = 1;
            zeige_mitteilungen();            
        }



        function speicher_mitteilungen(){
            speicher_mitteilungen_chunk(0);
        }

        function speicher_mitteilungen_chunk(id){                  

                if(id >= erledigung.mitteilung.length){                    
                    return;
                }    

                mtg = erledigung.mitteilung[id];

                if((mtg.id == -1 && mtg.geloescht == 1) || (mtg.id >=0 && mtg.geloescht == 0)){
                    speicher_mitteilungen_chunk(id+1);
                    return;
                }

                let type = null;
                if(mtg.id == -1 && mtg.geloescht == 0 && erledigung.id){
                    type = 'POST';
                    url = '/mitteilung';
                    data={mitteilung:mtg.mitteilung, eltern : mtg.eltern, erledigung_id : erledigung.id};
                }

                if(mtg.id >= 0 && mtg.geloescht == 1){
                    type = 'PUT';
                    url = '/mitteilung/'+mtg.id;
                    data={geloescht : 1};
                }

                if(type){
                    let formdata = JSON.stringify(data);                    

                    $.ajax({
                        type: type,
                        url: '/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api'+api_url_modifier+url,
                        data: formdata,
                        success: function (json) {
                            speicher_mitteilungen_chunk(id+1);
                        
                        },
                        error: function (e) {
                            console.log(e.message);
                            alert(e.message);
                        },
                        dataType: "json",
                        contentType: "application/json"
                    });
                }           
            
        }


        //Entschuldigungsannahme / Sekretariat / Scanner
        var scannerString = "";
        var scannerCount = 0;
        var scannerManualInput = false;

        $(document).on('keypress', function (event){

                    if(!user_lehrer_id){                    
                        return;
                    }

					//Testen, ob Modal aktiv ist.                    
                    if($('#erledigungModal').hasClass('show')){                    
                        return;
                    }

					
					//Nur druckbare Zeichen aus dem Standard-ASCII-Satz akzeptieren
					if(event.keyCode >= 32 && event.keyCode<=128){
						
                        if(event.key=='#' && scannerCount ==0){
                            scannerManualInput = true;
                        } else {
                            scannerString += event.key;
						    scannerCount++;
                        }
                        
                        

                        $('#scannerModal').modal('show');
                        $('#scannerModal_msg').empty();
                        $('#scannerModal_msg')
                        .append(
                                $('<h1></h1>')
                                .addClass("bg-info")                                
                                .text("Vorgangsnummer <"+scannerString+">")
                                .prepend(
                                        $('<i></i>')
                                        .addClass("bi-pencil pr-2")                                    
                                )
                        );

					}
					
					
					//Test auf "OK" am Anfang??
					
					
					//Test auf Eingabezeichen "13";
					if(event.keyCode==13){
						
                        if(scannerManualInput){
                            scannerString = "OK"+scannerString;
                            scannerCount += 2;
                        }
                        
                        if(scannerCount < 3){
                            return;
                        }

                        console.log("Scanner: "+scannerString);
                        scannerManualInput = false;                            
                        
                        var scannerAktion = scannerString.substr(0,2);
						var scannerAktionText ="unbekannte Aktion";
						
                        var scannerID = scannerString.substr(2);
						
                        if(scannerAktion=="OK"){
							scannerAktionText = "Annahme eines Entschuldigungsbogens.";
							
							unterschreibe_erledigung(scannerID); 
                                            
							
						} else {
                           
                                $('#scannerModal_msg').empty();
                                $('#scannerModal_msg')
                                .append(
                                        $('<h1></h1>')
                                        .addClass("bg-danger")                                
                                        .text("Fehler beim Einscannen, unbekannte Aktion "+scannerString)
                                        .prepend(
                                                $('<i></i>')
                                                .addClass("bi-x pr-2")                                    
                                        )
                                );

                            $('#scannerModal').modal('show');
                        }
												
						
						scannerCount = 0;
						scannerString = "";
					}
															
					//500ms Zeit zur Eingabe
                    if(!scannerManualInput){
                        setTimeout(function(){
                            scannerCount = 0;
                            scannerString = "";	                            					  
                        },500);
                    }
					
				});

        

        function unterschreibe_erledigung(erledigung_id){                  
            
           
            erledigung = {  id : erledigung_id,
                            mitteilung : []
                           };

            mitteilung.id = -1;
            mitteilung.mitteilung = "Scanner-Annahme / Sekretariat";
            mitteilung.erledigung_id = erledigung.id;
            mitteilung.created_at = new Date();
            mitteilung.geloescht = 0;
            
            erledigung.mitteilung.unshift(mitteilung);                           
            
            $.ajax({
                type: 'PUT',
                url: '/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api'+api_url_modifier+'/erledigung/' + erledigung_id,
                data: JSON.stringify({lehrer_id : user_lehrer_id}),
                success: function (json) {
                    speicher_mitteilungen();

                    if(json.id){
                                               
                        $('#scannerModal_msg').empty();
                        $('#scannerModal_msg')
                        .append(
                                $('<h1></h1>')
                                .addClass("bg-success")                                
                                .text("Vorgang <"+json.id+"> erfolgreich anerkannt")
                                .prepend(
                                        $('<i></i>')
                                        .addClass("bi-x pr-2")                                    
                                )
                        );

                       let gruppe_id = json.schueler.gruppe_id;                    
                        if(gruppe_id){
                            $('#gruppe').val(gruppe_id);

                            let schueler_id = json.schueler.id;
                            schueler.id = schueler_id;
                            read_schueler_by_gruppe(gruppe_id);
                        } else {
                            let schueler_id = json.schueler.id;
                            schueler.id = schueler_id;
                            read_vorgaenge_by_schueler(schueler.id);
                        }
                        

                    } else {
                        $('#scannerModal_msg').empty();
                        $('#scannerModal_msg')
                        .append(
                                $('<h1></h1>')
                                .addClass("bg-danger")                                
                                .text("Fehler beim Anerkennen des Vorgangs "+erledigung_id)
                                .prepend(
                                        $('<i></i>')
                                        .addClass("bi-x pr-2")                                    
                                )
                        );
                    }

                    $('#scannerModal').modal('show');

                },
                error: function (e) {
                    console.log(e.message);
                    alert(e.message);
                },
                dataType: "json",
                contentType: "application/json"
            });
        }




    </script>

</body>

</html>