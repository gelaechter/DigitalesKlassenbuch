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
                        <span class="input-group-text">Eigenschaft
                            <i class="bi-list pl-2"></i></span>
                    </div>
                    <select class="form-control" name="eigenschaft" id="eigenschaft" disabled>
                        <option selected>Corona-Testausgabe</option>
                    </select>
                </div>   

                <div class="input-group col-md">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Menge
                            <i class="bi-list pl-2"></i></span>
                    </div>
                    <select class="form-control" name="anzahl" id="anzahl">
                        <option value="0" selected> (Stückzahl vorwählen oder spätere Abfrage)</option>                        
                        <option value="1">1</option>    
                        <option value="2">2</option>    
                        <option value="3">3</option>    
                        <option value="4">4</option>    
                        <option value="5">5</option>                        
                        <option value="6">6</option>    
                        <option value="7">7</option>    
                        <option value="8">8</option>    
                        <option value="9">9</option> 
                        <option value="10">10</option>       
                    </select>
                </div>   

                <div class="input-group col-md">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Infotext
                            <i class="bi-list pl-2"></i></span>
                    </div>
                   <input class="form-control" placeholder ="z.B. ABIT oder Selbsttestung" id="info">
                </div>   
                
                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="btn_rfid" onclick="btn_rfid()">
                        <i class="bi-tag pr-2"></i>RFID
                    </button>
                </div>    
            
            </div>

            <div class="row mt-2 py-2" id="row_statistik">
                <div class="input-group col-md-3">
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Woche zurück" id="woche_zurueck_btn">
                            <i class="bi-caret-left"></i>
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="aktuelle Woche" id="woche_aktuell_btn">
                            <i class="bi-calendar3"></i>
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="Woche vor" id="woche_vor_btn">
                            <i class="bi-caret-right"></i>
                        </button>
                    </div>
                    <input type="text" class="form-control" placeholder="Zeitraum" id="zeitraum" readonly>
                </div>
            
                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="btn_rfid" onclick="btn_statistik_drucken()">
                        <i class="bi-printer pr-2"></i>Drucken
                    </button>
                </div>    
            </div>  


        </div>
    </section>


  


    <section>
        <div class="container-fluid  bg-dark text-white" id="liste">    
		
		</div>
    </section>



     <!-- Formular fuer das Anlegen/Aendern von Unterrichten -->
            
     <div class="modal fade" id="erledigungModal" tabindex="-1" aria-labelledby="erledigungModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="erledigungModalLabel">Erledigung bearbeiten</h5>                          
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
                                                <i class="bi-calendar-date px-2"></i>ab</span>
                                        </div>
                                        <input class="form-control" type="date" name="von" id="von" required>
                                    </div>

                                    <div class="input-group col-md-6" data-bs-toggle="tooltip" data-bs-placement="top" title="Wähle das Enddatum der Gültigkeit">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <!-- Datum -->
                                                <i class="bi-calendar-date px-2"></i>bis</span>
                                        </div>
                                        <input class="form-control" type="date" name="bis" id="bis" required>
                                    </div>
                                   
                                </div>

                                
                                <!-- zweite Zeile -->
                                <div class="row py-2">                                                                       
                                   <div class="input-group col-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Wähle die abzeichnende Lehrkraft">
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
                    </div>
                </div>
            </div>
        </div>

   

    <!-- Formular fuer Hinweise beim Datenladen -->
                
    <div class="modal fade" id="loadingModal" tabindex="-1" aria-labelledby="loadingModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="loadingModalLabel">Lade Daten</h5>                          
                    </div>
    
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row m-3 p-3">                            
                                <div class="col-md" id="loadingModal_msg" >
                                    
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


    <!-- Popper und Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
       
        
        //Sitzplan UL Anfang Statusobjekt
        
        aktiv_gruppe_id = <?php echo $_SESSION['aktiv_gruppe_id'] ?: 'null' ?>;
        aktiv_sitzplan_id = <?php echo $_SESSION['aktiv_sitzplan_id'] ?: 'null' ?>;
        user_lehrer_id = <?php echo $_SESSION['user_lehrer_id'] ?: 'null' ?>;

      
      
      
       // Tooltips initialisieren
       var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

      
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

          /**
             * Montag der aktuellen Woche bestimmen fue die Auswahl des Zeitraums
             */
            tage = ['', 'Montag', 'Dienstag','Mittwoch', 'Donnerstag', 'Freitag', 'Samstag', 'Sonntag'];
            
            function getMonday(d) {
                d = new Date(d);
                var day = d.getDay(),
                    diff = d.getDate() - day + (day == 0 ? -6 : 1); // wg sonntag = 0
                return new Date(d.setDate(diff));
            }

            montag = getMonday(new Date());
            sonntag = new Date(montag);
            sonntag.setDate(sonntag.getDate() + 6);
            // zeige_zeitraum();

            // Knoepfe fur die Aenderung des Zeitraum mit Funktionen belegen
            $('#woche_zurueck_btn').click(function () {
                montag.setDate(montag.getDate() - 7);
                sonntag.setDate(sonntag.getDate() - 7);
                zeige_zeitraum();
                $('#woche_zurueck_btn').blur();
            });
            $('#woche_vor_btn').click(function (e) {
                e.preventDefault();
                montag.setDate(montag.getDate() + 7);
                sonntag.setDate(sonntag.getDate() + 7);
                zeige_zeitraum();
                $('#woche_vor_btn').blur();
            });
            $('#woche_aktuell_btn').click(function () {
                montag = getMonday(new Date());
                sonntag = new Date(montag);
                sonntag.setDate(sonntag.getDate() + 6);
                zeige_zeitraum();
                $('#woche_aktuell_btn').blur();
            });

            /**
             * Zeitraum (Woche) neben den Zeitraum-Knoepfen anzeigen
             */
            function zeige_zeitraum() {
                var woche = montag.getWeek(1);
                document.getElementById("zeitraum").value = 
                    montag.toLocaleDateString()
                        + " - " + sonntag.toLocaleDateString()
                        + " (KW: "
                        + woche
                        + ", "
                        +    (woche % 2 == 0 ? "B" : "A")
                        + "-Woche)";
                
                /*
                 * bei geaendertem Zeitraum immer die Unterrichte lesen
                 */
                let dd = new Date(montag);
                let date = dd.getDate() + '.' + (dd.getMonth() + 1) + '.'+dd.getFullYear();
                read_statistik(date);
            }


            function btn_statistik_drucken(){
                window.print();
            }

      
        schueler = {};
      
        erledigung = {
            id : null,
            id_schueler : null,
            id_lehrer : null,
            von : null,
            bis : null,
            mitteilung : [],
            zustimmung : [],
            zustimmung_offen : 0,
            mitteilung_count : 0
        };

        eigenschaft = {
            id : -6,
            name : 'Corona-Schnelltestausgabe',
            default_bis : '2022-08-01',
            default_click : 0
        };
        
        var mitteilung={};

        var rfid_enable = false;

        var corona_typen=[];


        function btn_rfid(){

            rfid_enable = !rfid_enable;

            let btn = $('#btn_rfid');
            
            btn.removeClass();

            if(rfid_enable){
                btn.addClass("btn btn-info");
            } else {
                btn.addClass("btn btn-secondary");
            }

            $(':focus').blur();
            
        }


        /**
        * Lesen der wöchentlichen Statistik
        *
         */
        function read_statistik(date){
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/erledigung/coronatestausgabe/wochenstatistik/"+date,
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);

                    //console.log(response);                    

                    $('#liste').empty();
                    response.forEach(row => {

                        let values = Object.values(row);

                        $('#liste').append(
                            $("<div></div>")
                            .addClass("row border-bottom")
                            .append(
                                $("<div></div>")
                                .addClass("col-5")
                                .text(values[1])
                            )
                            .append(
                                $("<div></div>")
                                .addClass("col-5")
                                .text(values[2])
                            )
                            .append(
                                $("<div></div>")
                                .addClass("col-2")
                                .text("zugehörige ID: " +values[0])
                            )
                        )

                    });
                    
                }   
            });
        }

        /**
        * Lesen aller von einem Lehrer gezeichneten Erledigungen
        * einer Gruppe (null <=> ohne Gruppezuordnung (z.B. Corona-Schnellttest für Lehrkraft))
         */
        function read_erledigung_by_lehrer(id_g, id_e){
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/erledigung/lehrer/gruppe/null/eigenschaft/"+id_e,
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                                        
                    if(id_e == -6){
                        //Gruppenwahlfeld auf "Lehrer/Personal"
                        if($('#gruppe').val()==-2){
                                                        
                            response.forEach(row => {
                                    row.nachname = row.nachname+", "+row.vorname.substr(0,1)+".";
                                    row.vorname = row.kuerzel;                                    
                                });
                            show_eigenschaft_testausgabe(response);
                            
                            //Hinzulesen der ABIT-Informationen
                            //read_erledigung_by_gruppe(id_g, 4)       
                        }
                    }
                }   
            });
        }


    


        /**
         * Lesen aller Erledigungen einer Gruppe         
         *
         */
        function read_erledigung_by_gruppe(id_g,  id_e) {
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/erledigung/gruppe/"+id_g+"/eigenschaft/"+id_e,
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                                        
                    if(id_e == -6){
                        show_eigenschaft_testausgabe(response);

                        //Hinzulesen der ABIT-Informationen
                        read_erledigung_by_gruppe(id_g, 4)       
                    }

                    if(id_e==4){                            
                        show_abit_status(response);
                        
                        //Hinzulesen der 2G-Informationen
                        read_erledigung_by_gruppe(id_g, -2)       
                    }

                    if(id_e==-2){                            
                        show_2g_status(response);
                    }
                    
                }
            });
        }



        //Aufgerufen, nachdem die Eigenschaft "Testausgabe" abgefragt wurde.
        function show_eigenschaft_testausgabe(response){
            
            $("#liste").empty();                                       
            response.forEach(row => {
                
                let namenstext = row.vorname+' '+row.nachname;
                
                if(row.belegung_jetzt && row.belegung_jetzt == 0){
                    let ende =  new Date(row.ende.replace(' ','T')).toLocaleDateString();
                    namenstext = '('+row.vorname+' '+row.nachname+ ' bis '+ ende+')'  ;
                }
                
                
                    
                
                $('#liste').append(
                                $("<div></div>")
                                .addClass("row mt-1 border-bottom")
                                .attr('id','zeile'+row.id)  
                                .on('click', {id : row.id}, zeilehervorheben)                                       
                                .append($("<div></div>")                                    
                                    .addClass("col-md-2 d-flex align-items-center")
                                    .text(namenstext)
                                    .prepend(
                                            $("<button></button>")
                                            .attr('data-bs-target', '#details'+row.id)
                                            .attr('data-bs-toggle', 'collapse')           
                                            .addClass("btn btn-sm btn-secondary mx-2")                                            
                                            .append(
                                                $("<i></i>")
                                                .addClass("bi-arrows-expand")                                                        
                                            )
                                        )
                                )
                                .append($("<div></div>")
                                    .addClass("col-md-2")
                                    .attr('data-bs-target', '#details'+row.id)
                                    .attr('data-bs-toggle', 'collapse')                                            
                                    .append(
                                        $("<div></div>")
                                        .addClass("m-1 float-left px-2")
                                        .attr('id','s2g'+row.id)                                            
                                        .append(
                                            $("<span></span>")                                            
                                            .addClass("badge bg-secondary")                                                    
                                            .append(
                                                $("<i></i>")
                                                .addClass("bi-check")                                                        
                                            )
                                            .append(
                                                $("<span></span>")
                                                .attr('id','s2gt'+row.id)                                            
                                                .text("2G ??")
                                            )
                                        )
                                    )
                                    .append(
                                        $("<div></div>")
                                        .attr('data-bs-target', '#details'+row.id)
                                        .attr('data-bs-toggle', 'collapse')
                                        .addClass("m-1 float-left px-2")
                                        .attr('id','sabit'+row.id)                                            
                                        .append(
                                            $("<span></span>")                                            
                                            .addClass("badge bg-secondary")  
                                            .append(
                                                $("<i></i>")
                                                .addClass("bi-check")                                                        
                                            )
                                            .append(
                                                $("<span></span>")                                            
                                                .text("ABIT ??")
                                            )
                                        )
                                    )
                                
                                )   
                                .append($("<div></div>")
                                    .addClass("col-md-3")                                            
                                    .attr('id','skwheute'+row.id)    
                                    .append(
                                        $("<div></div>")
                                        .addClass("m-1 float-left")
                                        .append(
                                            $("<button></button>")
                                            .addClass("btn btn-sm btn-secondary")
                                            .on('click', {id : row.id}, testausgabe)                                       
                                            .append(
                                                $("<i></i>")
                                                .addClass("bi-plus-square")                                                        
                                            )
                                        )
                                    )
                                )   
                                .append($("<div></div>")
                                    .addClass("col-md-5")
                                    .attr('id','s'+row.id)                                            
                                    .append(
                                        $("<div></div>")
                                    )
                                )   
                            )
                            .append(
                                $("<div></div>")
                                .addClass("row mt-1 border-bottom collapse")
                                .attr('id','details'+row.id)  
                                .append($("<div></div>")
                                        .addClass("col-md-4")
                                        .attr('id','detailA'+row.id)                                            
                                        .append(
                                            $("<div></div>")
                                        )
                                )
                                .append($("<div></div>")
                                        .addClass("col-md-4")
                                        .attr('id','detailB'+row.id)                                            
                                        .append(
                                            $("<div></div>")
                                        )
                                )
                                .append($("<div></div>")
                                        .addClass("col-md-4")
                                        .attr('id','detailC'+row.id)                                            
                                        .append(
                                            $("<div></div>")
                                        )
                                )
                            )   
                            
                            ;
                
                if(rfid_enable && schueler.id && schueler.id == row.id){
                    schueler = row;
                    zeilehervorheben({data: {id : schueler.id}});
                    document.getElementById('s'+row.id).scrollIntoView();
                }
                
                let detailC = $('#detailC'+row.id);
                detailC.empty();

                let ausgabe_count = 0;
                let termin_count = 0;

                if(!row.erledigung){
                    row.erledigung=[];
                }

                row.erledigung.forEach(rowe => {
                    

                    warn = 0;
                    heute = new Date().toISOString();
                    kwheute = new Date().getWeek();

                    if(rowe.von){
                        von = new Date(rowe.von.replace(' ','T')).toLocaleDateString().slice(0,-4);
                        kw = new Date(rowe.von.replace(' ','T')).getWeek();
                    } else {
                        von ="--.--.----";
                        kw = kwheute;
                        warn += 1;
                    }                         
                    
                    btntxt = von;
                    if(rowe.lehrer_id){
                        btntxt += " ("+rowe.lehrer_kuerzel+")";
                    } else {
                        btntxt += " (__)";
                        warn +=1;
                    }

                    let col = null;
                    if(kw==kwheute){
                        col = "#skwheute"+row.id;
                    } else {
                        termin_count++;
                        if(termin_count < 5){
                            col = "#s"+row.id;
                        }
                    }

                    btncls = "btn btn-info  border border-secondary";
                    if(warn > 0){
                        btncls = "btn btn-warning  border border-secondary";
                    } 

                    let testanzahl = '?';
                    let infotext = "";
                    if(rowe.mitteilung && rowe.mitteilung.length>0){
                        testanzahl = rowe.mitteilung[0].mitteilung;
                        ausgabe_count += parseInt(testanzahl);

                        for(i=1; i<rowe.mitteilung.length; i++){
                            infotext += ", "+rowe.mitteilung[i].mitteilung;
                        }
                    
                    }

                    
                    $(col).append(
                        $("<div></div>")
                        .addClass("m-1 float-left")
                        .append(
                            $("<div></div>")
                            .addClass('btn-group btn-group-sm')
                            .attr("role","group")
                            .append(
                                $("<button></button>")
                                .addClass("btn btn-secondary")
                                .append(
                                    $("<span></span>")                                            
                                    .text("+"+testanzahl)                                                                              
                                )
                            )
                            .append(
                                $("<button></button>")
                                .addClass(btncls)
                                .text(btntxt)                                        
                                .on('click', {id : rowe.id}, erledigungBearbeiten)                                       
                            )
                        )
                    );


                    detailC.append(
                        $('<div></div>')
                        .text("Ausgabe "+testanzahl+" Stück "+btntxt+infotext)
                    )

                });  

                $('#s'+row.id).append(
                        $("<div></div>")
                        .addClass("m-1 float-right")
                        .append(
                            $("<div></div>")
                            .addClass('btn-group btn-group-sm')
                            .attr("role","group")
                            .append(
                                $("<button></button>")
                                .addClass("btn btn-secondary")
                                .append(
                                    $("<span></span>")                                            
                                    .text(ausgabe_count)                                                                              
                                )
                            )
                            .append(
                                $("<button></button>")
                                .addClass("btn btn-info border border-secondary")
                                .attr('data-bs-target', '#details'+row.id)
                                .attr('data-bs-toggle', 'collapse')
                                .text(" Total bei "+row.erledigung.length+ " Ausgaben")

                            )
                        )
                    );
                
            

            });
        }


        function show_abit_status(response){
            response.forEach(sus => {
                
                let abit_count = 0;
                let abit_aktuell_count = 0;
                let heute = new Date().toISOString().substr(0,10);

                
                let detailB = $('#detailB'+sus.id);                
                detailB.empty();

                sus.erledigung.forEach(abit=>{                                        
                    abit_count++;
                    if(abit.von >= heute){
                        detailB.prepend(
                            $('<div></div>')
                            .text("ABIT-Pflicht am "+new Date(abit.von.replace('T', ' ')).toLocaleString().slice(0,-10))
                        )
                        abit_aktuell_count++;
                    } else {
                        detailB.append(
                        $('<div></div>')
                        .text("vergangene ABIT-Pflicht am "+new Date(abit.von.replace('T', ' ')).toLocaleString().slice(0,-10))
                    )
                    }
                });

                let abit_elem = $('#sabit'+sus.id);
                

                abit_elem.empty();

                if(abit_aktuell_count==0){
                    if(abit_count>0){
                        abit_elem.append(
                            $("<span></span>")                                            
                            .addClass("badge bg-secondary")  
                            .append(
                                $("<i></i>")
                                .addClass("bi-check")                                                        
                            )
                            .append(
                                $("<span></span>")                                            
                                .text(abit_count+" ABIT erledigt")
                            )
                        );
                    }
                } else {
                    abit_elem.append(
                        $("<span></span>")                                            
                        .addClass("badge bg-success")  
                        .append(
                            $("<i></i>")
                            .addClass("bi-check")                                                        
                        )
                        .append(
                            $("<span></span>")                                            
                            .text(abit_aktuell_count+" ABIT anstehend, "+abit_count+" erledigt")
                        )
                    );
                }

                
            });
        }



        function show_2g_status(response){
            response.forEach(sus => {
                
                let treffer = false;                
                let heute = new Date();
                let nextWeek = new Date(heute.getTime()+7*24*60*60*1000);

                let detailA = $('#detailA'+sus.id);
                detailA.empty();

                sus.erledigung.forEach(s2g=>{                    
                    
                    if(s2g.von && s2g.lehrer_id){    
                        
                        let von = '--.--.';
                        if(s2g.von){
                            von = new Date(s2g.von.replace('T', ' ')).toLocaleString().slice(0,-10)
                        }

                        let bis = '--.--.';
                        if(s2g.bis){
                            bis = new Date(s2g.bis.replace('T', ' ')).toLocaleString().slice(0,-10)
                        }

                        if(s2g.corona_status){
                            if(!s2g.corona_testpflicht && s2g.corona_status){
                                treffer = true;
                            }

                            let nachweis ="(?)";
                            if(s2g.corona_typ){
                                let typen_id = s2g.corona_typ.corona_typen_id;
                                let ct = corona_typen.find(t=> t.id == typen_id);

                                if(ct){
                                    nachweis = ct.kuerzel;
                                } else {
                                    nachweis ="(? Typ "+typen_id+")";
                                }
                            }

                            detailA.append(
                            $('<div></div>')
                            .text("Nachweis "+nachweis+" "+ von
                                  + " bis " + bis
                                  + " ("+s2g.lehrer_kuerzel+")"
                                  )

                            );
                        }

                        /*
                        let von = new Date(s2g.von.replace(' ','T'));
                        let bis = new Date(s2g.bis.replace(' ','T'));
                        let days = Math.floor((bis - von) / (1000*60*60*24));

                        if(days > 30 && von <= heute && bis >= nextWeek){
                            treffer = true;
                            detailA.append(
                            $('<div></div>')
                            .text("2-G-Nachweis "+new Date(s2g.von.replace('T', ' ')).toLocaleString().slice(0,-10)
                                  + " bis " + new Date(s2g.bis.replace('T', ' ')).toLocaleString().slice(0,-10)
                                  + " ("+s2g.lehrer_kuerzel+")"
                                  )

                            );
                        } else {
                            detailA.append(
                            $('<div></div>')
                            .text("Nachweis Corona-Status vom "+new Date(s2g.von.replace('T', ' ')).toLocaleString().slice(0,-10)
                                  + " bis " + new Date(s2g.bis.replace('T', ' ')).toLocaleString().slice(0,-10)
                                  + " ("+s2g.lehrer_kuerzel+")"
                                  )

                            );
                        }
                        */

                        
                    }
                });

                let s2g_elem = $('#s2g'+sus.id);
                s2g_elem.empty();

                if(treffer){
                   s2g_elem.append(
                        $("<span></span>")                                            
                        .addClass("badge bg-success")                                                    
                        .append(
                            $("<i></i>")
                            .addClass("bi-check")                                                        
                        )
                        .append(
                            $("<span></span>")
                            .attr('id','s2gt'+sus.id)                                            
                            .text("2G erfüllt")
                        )
                    );
                } else {
                    s2g_elem.append(
                        $("<span></span>")                                            
                        .addClass("badge bg-danger")                                                    
                        .append(
                            $("<i></i>")
                            .addClass("bi-check")                                                        
                        )
                        .append(
                            $("<span></span>")
                            .attr('id','s2gt'+sus.id)                                            
                            .text("testplichtig")
                        )
                    );
                }

                
            });
        }


        function zeilehervorheben(event){

            let zeile = $('#zeile'+event.data.id);

            if(!zeile) {return};

            zeile.addClass("bg-info");
            
        }


        function speichern(){
            
            if($('#txt_mitteilung_neu').val()!=''){
                btn_mitteilung_neu();
            }

            if(erledigung.id){                
                update_erledigung();
            } else {
                insert_erledigung();
            }
        }


        function loeschen(){
            var formdata = JSON.stringify(
                                        {                                               
                                            geloescht : 1
                                        });

            $.ajax({
                type: 'PUT',
                url: '/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/erledigung/' + erledigung.id,
                data: formdata,
                success: function (json) {
                    $('#erledigungModal').modal('hide');
                    read_erledigung_by_gruppe($('#gruppe').val(),eigenschaft.id);
                },
                error: function (e) {
                    console.log(e.message);
                    alert(e.message);
                },
                dataType: "json",
                contentType: "application/json"
            });
        }


        
        function update_erledigung(){                  
            
            lehrer_id = $('#lehrer').val();
            if(lehrer_id < 0) {
               lehrer_id = null;
            }

            von = $('#von').val();
            if(von==''){
                von = null;
            }

            bis = $('#bis').val();
            if(bis==''){
                bis = null;
            }
            

            var formdata = JSON.stringify(
                                        {                                               
                                            von: von,
                                            bis: bis,
                                            lehrer_id: lehrer_id

                                        });

            $.ajax({
                type: 'PUT',
                url: '/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/erledigung/' + erledigung.id,
                data: formdata,
                success: function (json) {
                    $('#erledigungModal').modal('hide');
                    //read_erledigung_by_gruppe($('#gruppe').val(),eigenschaft.id);
                    handle_gruppenwechsel();

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


        function insert_erledigung(){
            
            lehrer_id = $('#lehrer').val();
            if(lehrer_id < 0) {
               lehrer_id = null;
            }
            
            von = $('#von').val();
            if(von==''){
                von = null;
            }

            bis = $('#bis').val();
            if(bis==''){
                bis = null;
            }
            

            var formdata = JSON.stringify(
                                        {                                               
                                            von: von,
                                            bis: bis,
                                            lehrer_id: lehrer_id,
                                            schueler_id: schueler.id,
                                            eigenschaft_id: eigenschaft.id

                                        });
            
            

            $.ajax({
                type: 'POST',
                url: '/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/erledigung',
                data: formdata,
                success: function (json) {
                    $('#erledigungModal').modal('hide');
                    read_erledigung_by_gruppe($('#gruppe').val(),eigenschaft.id);

                    response = $.parseJSON(json);
                    erledigung.id = response.id;
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



        function speicher_mitteilungen(){
            speicher_mitteilungen_chunk(0);
        }

        function speicher_mitteilungen_chunk(id){                  

                if(id >= erledigung.mitteilung.length){                    
                    //Reload der Seite  nach Abspeichern aller Mitteilungen!
                    //read_erledigung_by_gruppe($('#gruppe').val(),eigenschaft.id);
                    handle_gruppenwechsel();
                    return;
                }    

                mtg = erledigung.mitteilung[id];

                if((mtg.id == -1 && mtg.geloescht == 1) || (mtg.id >=0 && mtg.geloescht == 0)){
                    speicher_mitteilungen_chunk(id+1);
                    return;
                }

                let type = null;
                if(mtg.id == -1 && mtg.geloescht == 0){
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
                        url: '/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api'+url,
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





        $("document").ready(function () {            
            read_gruppen();
            read_lehrer();
            read_corona_typen();

            $("#speichern").click(function() {speichern();});
            $("#loeschen").click(function() {loeschen();});
            $("#cancel").click(function() {$("#erledigungModal").modal('hide');});   //Änderung UL Modal, vorher: $("#unterricht").hide();

            $("#btn_scannerCancel").click(function() {$("#loadingModal").modal('hide');}); 

			$('#gruppe').change(handle_gruppenwechsel);
            $('#gruppe').select(handle_gruppenselect);

            $('#btn_mitteilung_neu_eltern').click(function(){btn_mitteilung_neu_eltern();});
            $('#btn_mitteilung_neu').click(function(){btn_mitteilung_neu();});

            $('#row_statistik').hide();
        });


        function mitteilung_loeschen(index){            
            let mtg = erledigung.mitteilung[index];
            mtg.geloescht = 1;
            zeige_mitteilungen();            
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
            mitteilung.created_at = new Date();
            mitteilung.geloescht = 0;
            

            erledigung.mitteilung.unshift(mitteilung);

            $('#txt_mitteilung_neu').val("");
            
            mitteilung ={id: -1, eltern: 1};
            btn_mitteilung_neu_eltern();

            zeige_mitteilungen();
            
        }


        function handle_gruppenselect(){
            
        }

		function handle_gruppenwechsel(){
			$('#row_statistik').hide();

            let gruppe_id = $('#gruppe').val();
            if(gruppe_id > 0) {
                read_erledigung_by_gruppe(gruppe_id,eigenschaft.id);
            }
            
            if(gruppe_id == -2) {
                read_erledigung_by_lehrer(null,eigenschaft.id);
            }

            if(gruppe_id ==-3){
                $('#row_statistik').show();
                zeige_zeitraum();
                
                //let now = new Date();
                //let heute = now.getDate() + '.' + (now.getMonth() + 1) + '.' + now.getFullYear();
                //let date = prompt("Bitte Startdatum im Format TT.MM.JJJJ (01.03.2022 für 3. Januar 2022) eingeben",heute);
                
            }
            
			
		}


        function erledigungBearbeiten(event){
            id = event.data.id;
            console.log("edit er "+id);

            
            $('#von').val(new Date().toISOString());
            $('#bis').val(new Date(eigenschaft.default_bis).toISOString());
            $('#mitteilungneu').val(null);
            $('#mitteilung').empty();

            $('#erledigungModalLabel').text(eigenschaft.name +' - Erledigung #'+id+' bearbeiten');
            read_erledigung(id);

            $('#erledigungModal').modal('show');
        }


        function erledigungneu(event){
            schueler_id = event.data.id;
            console.log("neu er "+schueler_id);

            
            $('#von').val(new Date().toISOString().substr(0,10));
            $('#bis').val(new Date(eigenschaft.default_bis).toISOString().substr(0,10));
            $('#lehrer').val(user_lehrer_id);
            
            $('#mitteilungneu').val(null);
            $('#mitteilung').empty();

            $('#erledigungModalLabel').text(eigenschaft.name +' - Neue Erledigung hinzufügen');
            read_schueler(schueler_id);

            erledigung.id = null;

            $('#erledigungModal').modal('show');

        }


        /*
        Speichern (POST) einer Testausgabe.
        Als angehängte Mitteilung dabei immer erste Mitteilung = Stückzahl als String
        und optional weitere Mitteilung gemäß Texteingabefeld Info
        */
        function testausgabe(event){
            schueler_id = event.data.id;
            console.log("testaugabe er "+schueler_id);           
           
            erledigung.id = null;

            lehrer_id = user_lehrer_id;
            if(lehrer_id < 0 || !lehrer_id) {
               lehrer_id = null;
            }

            if($('#gruppe').val()==-2){
                lehrer_id = event.data.id;
                schueler_id = null;                
            }
            
            erledigung.mitteilung = [];

            let anzahl = $('#anzahl').val();
            if(anzahl==0){
                anzahl = parseInt(prompt("Welche Anzahl an Tests wurde ausgegeben?","1"));
                if(isNaN(anzahl)){
                    return;
                }
                if(anzahl > 0 && anzahl < 11){
                    $('#anzahl').val(anzahl);
                }
            }

            mitteilung = { id : -1};
            mitteilung.mitteilung = anzahl;
            mitteilung.erledigung_id = erledigung.id;
            mitteilung.created_at = new Date();
            mitteilung.geloescht = 0;            
            erledigung.mitteilung.push(mitteilung);

            mitteilung = { id : -1};
            mitteilung.mitteilung = $('#info').val();
            if(mitteilung.mitteilung !=""){
                mitteilung.erledigung_id = erledigung.id;
                mitteilung.created_at = new Date();
                mitteilung.geloescht = 0;                        
                erledigung.mitteilung.push(mitteilung);
            }


            von = new Date().toISOString().substr(0,10);
            
            var formdata = JSON.stringify(
                                        {                                               
                                            von: von,            
                                            lehrer_id: lehrer_id,
                                            schueler_id: schueler_id,
                                            eigenschaft_id: eigenschaft.id
                                        });
                       

            $.ajax({
                type: 'POST',
                url: '/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/erledigung',
                data: formdata,
                success: function (json) {
                    $('#erledigungModal').modal('hide');
                    handle_gruppenwechsel();
                    //read_erledigung_by_gruppe($('#gruppe').val(),eigenschaft.id);

                    response = json; 
                    erledigung.id = response.id;
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




        function read_erledigung(id){
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/erledigung/"+id,
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                    console.log(response);

                    erledigung = response;
                    
                    if(erledigung.von){
                        erledigung.von = new Date(erledigung.von.substr(0,10)).toISOString().substr(0,10);
                    }
                    if(erledigung.bis){
                        erledigung.bis = new Date(erledigung.bis.substr(0,10)).toISOString().substr(0,10);
                    }

                    $('#von').val(erledigung.von);                    
                    $('#bis').val(erledigung.bis);

                    if(erledigung.lehrer_id){
                        $('#lehrer').val(erledigung.lehrer_id);
                    } else {
                        $('#lehrer').val(user_lehrer_id);
                    }
                    

                    $('#erledigungModalLabel').text(erledigung.eigenschaft.name +' - Erledigung #'+id+' von '+erledigung.schueler.vorname+' ' +erledigung.schueler.nachname+' bearbeiten');
                    
                    zeige_mitteilungen();


                },
                error: function (e) {
                    console.log(e.message);
                }
            });
        }



        function zeige_mitteilungen(){
            $('#mitteilung').empty();

            erledigung.mitteilung.filter(mtg => mtg.geloescht == 0).forEach(mitteilung => {

                let mtg_von = new Date(mitteilung.created_at);

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



        /**
            * Corona-Typen lesen
            */
        function read_corona_typen(event) {
            $.ajax({
                url:  "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/corona/typen",                    
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                    corona_typen = response;                        
                }
            });
        }



        /**
         * Lesen aller Gruppen füe die Klassenauswahl 
         */
        function read_gruppen(event) {
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/gruppe",
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                    $("#gruppe")
                    .find('option').remove().end()
                    .append(new Option('(Statistik aufrufen)', -3))
                    .append(new Option('(Gruppe wählen)', -1))
                    .append(new Option('(Lehrer/Personal)', -2));
                    response.forEach(row => {
                        $("#gruppe").append(new Option(row.name, row.id));
                    });
                    
                    if(aktiv_gruppe_id){
                        $('#gruppe').val(aktiv_gruppe_id);
                        read_erledigung_by_gruppe(aktiv_gruppe_id, eigenschaft.id);
                    } else {
                        $('#gruppe').val(-1);
                    }
                },
                error: function (e) {
                    console.log(e.message);
                }
            });
        }


            /**
             * Lehrer lesen
             */
            function read_lehrer(event) {
                $.ajax({
                    url:  "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/lehrer",                    
                    type: "GET",
                    success: function (data) {
                        var response = $.parseJSON(data);
                                                
                        $("#lehrer").find('option').remove().end().append(new Option('', -1));                        
                        response.forEach(row => {
                            $("#lehrer").append(new Option(row.kuerzel + " - " + row.nachname, row.id));                            
                        });

                        // Lehrer aus der SESSION setzen                        
                        $("#lehrer").val(<?php echo $_SESSION['user_lehrer_id'];?>);

                    }
                });
            }


             /**
             * einzelnen Schüler lesen
             */
            function read_schueler(id) {
                $.ajax({
                    url:  "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/schueler/"+id,                    
                    type: "GET",
                    success: function (data) {
                        var response = $.parseJSON(data);

                        schueler = response;
                        
                        $('#erledigungModalLabel').text(eigenschaft.name +' - Neue Erledigung für '+ response.vorname + ' ' + response.nachname + ' hinzufügen');
                        
                    }
                });
            }



    //ID und Gruppen-ID von Schüler oder Lehrer gemäß übergebender RFID-Kennung abfragen
    //Bei Erfolg Darstellung enstprechend aufrufen.
    function read_by_rfid(rfidString){
        $('#loadingModal').modal('show');
        $('#loadingModal_msg').empty().append($('<div></div>').text("Suche nach RFID (32-Bit ID in Bezimalschreibweise) <"+rfidString+">"));

        $.ajax({
            url:  "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/rfid/"+rfidString,                    
            type: "GET",
            success: function (data) {
                let response = $.parseJSON(data);
                load_by_id(response);
            }
        });
    }

    //Gruppe gemäß übergebender Gruppen-ID und übergegebener SuS-ID laden
    //Falls eine Lehrer-ID übergeben wurde, so die Lehreransicht laden.
    function load_by_id(response){

        console.log(response);
        

        if(response.lehrer_id){
            setTimeout(function(){$('#loadingModal').modal('hide');},1000);
        
            schueler = {id : response.lehrer_id};
            $('#gruppe').val(-2);
            handle_gruppenwechsel();

            return;
        }

        if(!response.lehrer_id && response.schueler_id){
            setTimeout(function(){$('#loadingModal').modal('hide');},1000);

            //Bei Schülern ohne Stammgruppe (Gast) wird durch die Api eine der belegten Gruppen als Stammgruppe gewählt
            if(response.gruppe_id){
                $('#gruppe').val(response.gruppe_id);
            } else {
                return;
            }

            schueler = {id : response.schueler_id};
            handle_gruppenwechsel();

            return;            
        }
        
        $('#loadingModal_msg').append($('<div></div>').text("Fehler: Weder Schüler noch Lehrer mit diesem RFID-Tag bekannt."));

    }


    
    //RFID-Anmeldung 
    //Abfangen von Tastatureingaben
    
    var rfidString = "";
    var rfidCount = 0;    
    
    $(document).on('keypress', function (event){

            if(!user_lehrer_id){                    
                return;
            }

            //Testen, ob RFID-Annahme eingeschaltet ist                    
            if(!rfid_enable){                    
                return;
            }

            //DEBUG Space = Abfrage mit Tag "demo" <=> zufällige Wahl von Schüler oder Lehrer.
            //Zufall in der Api im Modell zu Schueler hinterlegt.
            if(event.keyCode==32 && rfidCount == 0){
                console.log("Scanner: Demo-Abfrage");                                                                   
                read_by_rfid("demo");
                return;
            }
        
            //Nur druckbare Zeichen aus dem Standard-ASCII-Satz dem rfidString hinzufügen
            if(event.keyCode >= 32 && event.keyCode<=128){
                    rfidString += event.key;
                    rfidCount++;
            }
            
            
            //Test auf Eingabezeichen "13";
            if(event.keyCode==13){
                
                if(rfidCount < 5 || rfidCount > 12){
                    return;
                }
                

                console.log("Scanner: "+rfidString);                                       
                               
                read_by_rfid(rfidString)

               
                                
                rfidCount = 0;
                rfidString = "";
            }
                                                    
            
            setTimeout(function(){
                rfidCount = 0;
                rfidString = "";	                            					  
            },500);
        });

    
    

    </script>

</body>

</html>