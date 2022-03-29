<?php
    require './auth.php'
    //require '../../openid/auth.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

        <title>Klassenbuch</title>
    </head>

    <body onload="label_timetable()">
        <?php include './navbar.php' ?>

        <div class="container-fluid bg-secondary text-white p-2">
            <section id="ueberschrift">
                <!-- Ueberschrift -->
                <div class="m-3 p-3 row bg-dark">
                    <h1>Klassenbuch <span id="klassenbuch_fuer_wen"></span></h1>
                </div>            
            </section>

            <section>
                <!-- Auswahl Lehrer oder Lerngruppe und Woche-->
                <div class="m-3 p-3 row bg-dark">
                    <div class="input-group input-group-sm col-md">
                        <div class="input-group-prepend">
                        <input type="radio" class="btn-check" 
                                name="options-auswahl" id="gruppe-auswahl" 
                                autocomplete="off">
                            <label class="btn btn-outline-primary" 
                                for="gruppe-auswahl"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Übersicht nach Klasse / Kurs" >
                                Lerngruppe <i class="bi-people px-2"></i>
                            </label>
                        </div>
                        <select class="form-control" name="gruppe" id="gruppe" data-bs-toggle="tooltip" data-bs-placement="top" title="Wähle eine Klasse / einen Kurs" ></select>
                    </div>
    
                    <div class="input-group input-group-sm col-md">
                        <div class="input-group-prepend">
                        <input type="radio" class="btn-check" 
                                name="options-auswahl" id="lehrer-auswahl" 
                                autocomplete="off" checked>
                            <label class="btn btn-outline-primary" 
                                for="lehrer-auswahl"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Übersicht nach Lehrer / Lehrerin" >
                                Lehrer <i class="bi-person px-2"></i>
                            </label>
                        </div>
                        <select class="form-control" name="lehrer" id="lehrer" 
                            data-bs-toggle="tooltip" data-bs-placement="top" 
                            title="Wähle einen Lehrer / eine Lehrerin" ></select>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="Ich" id="ich_btn">
                            <i class="bi bi-file-earmark-person"></i>
                            </button>
                    </div>
    
                    <div class="input-group col-md">
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
                </div>            
            </section>
            
            <!-- Anzeige fuer das Erfassen des Corona-Status -->
            <section id ="coronarow">            
                <div class="row m-3 p-3 bg-dark">             
                    <div class="col-md-2">
                        <i class="bi-tag px-2"></i>Corona-Status
                    </div>                
                    <div class="col-md-10">
                        <div id="corona">
						<i>Bitte wählen Sie eine Lerngruppe</i>
                        </div>
                    </div>                
                </div>        
            </section>


            <!-- Anzeige fuer offene Erledigungen mit Eigenschaft "Anzeige auf Startseite" -->
            <section id ="erledigungrow">            
            </section>



            <!-- Anzeige fuer aktuelle Entschuldigungen -->
            <section id="entschuldigung_aktuellrow">             
                <div class="row m-3 p-3 bg-dark">             
                    <div class="col-md-2">
                        <i class="bi-tag px-2"></i>Abmeldungen
                    </div>                
                    <div class="col-md-10">
                        <div id="entschuldigung_aktuell">
						<i>Bitte wählen Sie eine Lerngruppe</i>
                        </div>
                    </div>                
                </div>        
            </section>

            <section>
                <!-- Woche als Tabelle -->
                <div class="m-3 p-3 row bg-dark">
                    <table class="table table-dark table-striped" id="timetable">
                    </table>
                </div>
            </section>

            
            <!-- Formular fuer das Anlegen/Aendern von Unterrichten -->
            <div class="modal fade" id="unterricht" tabindex="-1" aria-labelledby="unterrichtModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content bg-dark">
                        <div class="modal-header">
                            <h5 class="modal-title" id="unterrichtModalLabel">Unterricht bearbeiten</h5>                          
                        </div>
      
                        <div class="modal-body">
                            <div class="container-fluid">
                                <form class="row m-3 p-3 bg-dark needs-validation" novalidate>
                                    <!-- erste Zeile mit Gruppe, Lehrer, Datum und Stunmde -->
                                    <div class="row">
                                        <div class="input-group col-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Wähle eine Klasse oder einen Kurs">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <!-- Lerngruppe -->
                                                    <i class="bi-people px-2"></i></span>
                                            </div>
                                            <select class="form-control" name="die_gruppe" id="die_gruppe" required></select>
                                        </div>
                                        <div class="input-group col-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Wähle die Lehrkraft">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <!-- Lehrer -->
                                                    <i class="bi-person px-2"></i></span>
                                            </div>
                                            <select class="form-control" name="der_lehrer" id="der_lehrer" required></select>
                                        </div>
                                        <div class="input-group col-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Wähle das Datum des Unterrichts">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <!-- Datum -->
                                                    <i class="bi-calendar-date px-2"></i></span>
                                            </div>
                                            <input class="form-control" type="date" name="datum" id=datum required>
                                        </div>
                                        <div class="input-group col-md" data-bs-toggle="tooltip" data-bs-placement="top" title="Wähle die Stunde des Unterrichts">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <!-- Stunde -->
                                                    <i class="bi-clock px-2"></i></span>
                                            </div>
                                            <select class="form-control" name="ustunde" id="ustunde" required></select>
                                        </div>
                                    </div>
                        
                                    <!-- zweite Zeile mit Fach, Vertretung und Sitzplan-->
                                    <div class="row py-2">     
                                        <div class="col-3">
                                            <div class="input-group" data-bs-toggle="tooltip" data-bs-placement="top" title="Wähle das Fach">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <!-- Fach -->
                                                        <i class="bi-easel px-2"></i></span>
                                                </div>
                                                <select class="form-control" name="fach" id="fach" required></select>
                                            </div>
                                        </div>                       
                                                
                                        <div class="col-3">
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

                                        <div class="col-6">
                                            <div class="input-group" data-bs-toggle="tooltip" data-bs-placement="top" title="Wähle einen Sitzplan">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <!-- Sitzplan -->
                                                        <i class="bi-grid-3x2-gap px-2"></i></span>
                                                </div>
                                                <select class="form-control" name="sitzplan" id="sitzplan" required></select>
                                                <!--
                                                <button class="btn btn-info float-right ml-3" id="sitzplanzeigen" type="button" >
                                                    <i class="bi-box-arrow-right px-2"></i>Sitzpläne</button>
                                                -->
                                            </div>
                                        </div>
                                    </div>
                        
                                    <!-- Stundeninhalt, Bemerkungen und Aufgaben-->
                                    <div class="row py-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="bi-chat-right-text"></i></span>
                                            </div>
                                            <textarea id="inhalte" name="inhalte" rows="4" cols="30" placeholder="Inhalt der Stunde"
                                                class="form-control"></textarea>
                                        </div>
                                    </div>

                                    <div class="row py-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="bi-chat-right-dots"></i></span>
                                            </div>
                                            <textarea id="bemerkungen" name="bemerkungen" rows="4" cols="30"
                                                placeholder="Bemerkungen zur Stunde" class="form-control"></textarea>
                                        </div>
                                    </div>

                                    <div class="row py-2">
                                        <div class="col-9">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="bi-journal-text"></i></span>
                                                </div>
                                                <textarea id="aufgaben" name="aufgaben" rows="4" cols="30"
                                                    placeholder="Aufgaben aus der Stunde" class="form-control"></textarea>
                                            </div>
                                        </div>

                                        <!-- Zeit fuer die Aufgaben -->
                                        <div class="col-3">
                                            <div class="input-group" data-bs-toggle="tooltip" data-bs-placement="top" title="Wie viel Zeit wird für die Erledigung der Hausaufgaben benötigt?">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <!-- Aufgabenzeit -->
                                                        <i class="bi-stopwatch px-2"></i></span>
                                                </div>
                                                <select class="form-control" name="aufgaben_zeit" id="aufgaben_zeit" required>
                                                    <option value=0>0 min</option>
                                                    <option value=10>10 min</option>
                                                    <option value=20>20 min</option>
                                                    <option value=30>30 min</option>
                                                    <option value=40>40 min</option>
                                                    <option value=50>50 min</option>
                                                    <option value=60>60 min</option>
                                                    <option value=70>70 min</option>
                                                    <option value=80>80 min</option>
                                                    <option value=90>90 min</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Formular fuer das Erfassen der Anwesenheit -->
                        	        <div id="Anwesenheit">
                                        <div class="row m-3 py-2 bg-dark border">
                                            <div class="col-2 ">                                   
                                                <button class="btn btn-secondary mr-2" type="button" id="alle_praesent"><i
                                                class="bi-emoji-smile px-2"></i>alle anwesend</button>
                                            </div>        
                                            <div class="col-10">
                                                <div id="praesenzen">
                                                </div>                                    
                                            </div>
                                        </div>
                                    </div>

                                    
                                </form>                            
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

           




        </div>
            
        <!-- Popper und Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha384-vtXRMe3mGCbOeY7l30aIg8H9p3GdeSe4IFlP6G8JMa7o7lXvnz3GFKzPxzJdPfGK"></script>

        <script>
            ajax_prefix = '/fileadmin/Skripte4JAG/klassenbuch';
            // ajax_prefix = '';

            lehrer_name = '';
            gruppe_name = '';

            unterricht = {
                gruppe_id: null,
                lehrer_id: null,
                datum: null,
                ustunde_id: null,
                fach_id: null,
                vertretung: null,
                inhalte: null,
                aufgaben: null,
                aufgaben_zeit: 30,
                bemerkungen: null
            };

            unterrichte = [];

            tage = ['', 'Montag', 'Dienstag','Mittwoch', 'Donnerstag', 'Freitag', 'Samstag', 'Sonntag'];
            lehrer = [];
            gruppen = [];
            faecher = [];

            auswahl = 'LEHRER';

            corona = [];
            corona_gruppe_id = null;

            erledigung_gruppe_id = null;

            praesenzen = [];

            // Tooltips initialisieren
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });


            function create_table_cell_add(tag, block) {
                let btn = document.createElement('BUTTON');
                btn.classList.add('btn');
                btn.classList.add('btn-secondary');

                btn.classList.add('input-block-leven');
                btn.classList.add('form-control');
                btn.classList.add('px-4');
                btn.classList.add('py-4');
                btn.classList.add('tt-unterricht-add');
                btn.id = 'tt-' + tag + '-' + block;
                let div = document.createElement('DIV');
                div.innerHTML = '<i class="bi-plus-square"></i>';

                btn.onclick = function(e) {
                    e.preventDefault();
                    new_unterricht(tag, block);
                };

                btn.appendChild(div);

                return btn;
            }

            function create_table_cell_edit(unterricht_id) {
                let btn = document.createElement('BUTTON');
                btn.classList.add('btn');
                btn.classList.add('btn-primary');
                // btn.classList.add('btn-info');
                btn.classList.add('input-block-leven');
                btn.classList.add('form-control');
                btn.classList.add('px-4');
                btn.classList.add('py-4');
                btn.classList.add('tt-unterricht');
                btn.id = 'tt-unterricht-' + unterricht_id;

                btn.onclick = function() {
                    edit_unterricht(unterricht_id);
                };

                return btn;
            }

            async function init_tbody() {
                // Tabellenueberschrift generieren
                $("#ueberschrift").hide();
                
                let table = document.getElementById('timetable');
                let thead = document.createElement('THEAD');
                let row = document.createElement('TR');
                let cell = document.createElement('TH');
                cell.innerHTML = '<i class="bi-clock"></i>';
                row.appendChild(cell);
                for (let i = 1; i <= 5; i++) {
                    let cell = document.createElement('TH');
                    cell.id = 'th-tag-' + i;
                    row.appendChild(cell);
                }
                thead.appendChild(row);
                table.appendChild(thead);
                
                // Zeilen der Tabelle generieren
                let tbody = document.createElement('TBODY');
                tbody.id = 'tt-tbody';
                table.appendChild(tbody);

                // Zeit-Bloecke aus der Datenbank lesen. Pro Block eine Zeile
                read_zeiten();
            }

            function new_unterricht(tag, block) {
                // alert("neuer Unterricht: " + tag + " " + block);

                let datum = new Date(montag.getFullYear(), montag.getMonth(), Number(montag.getDate()) + Number(tag) - 1, 12);
                $("#datum").val(datum.toISOString().substr(0, 10));
                $("#ustunde").val(block);

                unterricht.id = undefined;
                unterricht.sitzplan_id = null;
                
                $("#fach").val(-1);
                $('#vertretung').prop('checked', false);
                $("#inhalte").val('');
                $("#aufgaben").val('');
                $("#bemerkungen").val('');
                $("#aufgaben_zeit").val(0);

                // Gruppe und Lehrer aus der Uebersicht vorbesetzen
                $("#die_gruppe").val($("#gruppe").val());
                $("#der_lehrer").val($("#lehrer").val());


                //Sitzpläne der gewählten Gruppe einlesen
                read_sitzplaene_laut_gruppe($("#die_gruppe").val());

                praesenzen_laut_gruppe($('#gruppe').val());

                $("#unterrichtModalLabel").text("neuen Unterricht anlegen");
                $("#loeschen").hide();
                $("#unterricht").modal('show'); //Änderung UL für Modal, vorher  $("#unterricht").show();
            }
            
            function edit_unterricht(unterricht_id) {
                var url = ajax_prefix + "/klassenbuch-api/api/unterricht/" + unterricht_id;

                $.ajax({
                    url: url,
                    type: "GET",
                    success: function (data) {
                        var response = $.parseJSON(data);
                        unterricht.id = unterricht_id;
                        $("#die_gruppe").val(response.gruppe_id);
                        $("#der_lehrer").val(response.lehrer_id);
                        $("#datum").val(response.datum);
                        $("#ustunde").val(response.ustunde_id);
                        $("#fach").val(response.fach_id);
                        $('#vertretung').prop('checked', (response.vertretung == 1 ? true : false));
                        $("#inhalte").val(response.inhalte);
                        $("#aufgaben").val(response.aufgaben);
                        $("#bemerkungen").val(response.bemerkungen);
                        $("#aufgaben_zeit").val(response.aufgaben_zeit);

                        unterricht.sitzplan_id = response.sitzplan_id;
                        read_sitzplaene_laut_gruppe(response.gruppe_id);                        
                        
                        $("#unterrichtModalLabel").text("Unterricht bearbeiten");
                        $("#loeschen").show();
                        $("#unterricht").modal('show');  // vorher: $("#unterricht").show();

                        // Gruppe und Lehrer aus der Antwort
                        $("#gruppe").val(response.gruppe_id);
                        $("#lehrer").val(response.lehrer_id);

                        praesenzen_laut_unterricht(response);
                        read_corona_by_gruppe(response.gruppe_id);
                        read_entschuldigung_aktuell_by_gruppe(response.gruppe_id);

                        if ($("#der_lehrer").val() != <?php echo $_SESSION['user_lehrer_id'];?>) {
                            $("#loeschen").hide();
                            $("#speichern").hide();
                        } else {
                            $("#loeschen").show();
                            $("#speichern").show();
                        }
                    },
                    error: function (e) {
                        console.log(e.message);
                    }
                })
            }

            function label_timetable() {
                read_lehrer();
                $("#lehrer").change(handleLehrerChange);
                $("#lehrer").select(handleLehrerSelect);
                $("#lehrer").click(handleLehrerSelect);
                read_gruppen();
                $("#gruppe").change(handleGruppeChange);
                $("#gruppe").select(handleGruppeSelect);
                $("#gruppe").click(handleGruppeSelect);
                read_faecher();
                read_ustunden();
                init_tbody();
                zeige_zeitraum();
                $("#unterricht").hide();
                $("#speichern").click(function() {speichern();});
                $("#loeschen").click(function() {loeschen();});
                $("#cancel").click(function() {$("#unterricht").modal('hide');});   //Änderung UL Modal, vorher: $("#unterricht").hide();
                $("#sitzplanzeigen").click(function() {sitzplananzeigen();});
                
                $("#die_gruppe").change(handleDie_gruppeChange);

                  // Praesenzen verwalten
                $('#alle_praesent').on('click', function (e) {
                    e.preventDefault();
                    alle_praesent();
                });
                $('#alle_absent').on('click', function (e) {
                    e.preventDefault();
                    alle_absent();
                });
                
            }            

            function sitzplananzeigen() {

            }


            /****************************************************************
             * Zeitraum- und Datumsfunktionen
             ****************************************************************/

            /**
             * Montag und Sonntag der aktuell angezeigten Woche
             */
            montag = new Date();
            sonntag = new Date();

            /**
             * Kalenderwoche bestimmen
             */
            Date.prototype.getWeek = function (dowOffset) {
                /*getWeek() was developed by Nick Baicoianu at MeanFreePath: http://www.meanfreepath.com */

                dowOffset = typeof (dowOffset) == 'int' ? dowOffset : 0; //default dowOffset to zero
                var newYear = new Date(this.getFullYear(), 0, 1);
                var day = newYear.getDay() - dowOffset; //the day of week the year begins on
                day = (day >= 0 ? day : day + 7);
                var daynum = Math.floor((this.getTime() - newYear.getTime() -
                    (this.getTimezoneOffset() - newYear.getTimezoneOffset()) * 60000) / 86400000) + 1;
                var weeknum;
                //if the year starts before the middle of a week
                if (day < 4) {
                    weeknum = Math.floor((daynum + day - 1) / 7) + 1;
                    if (weeknum > 52) {
                        nYear = new Date(this.getFullYear() + 1, 0, 1);
                        nday = nYear.getDay() - dowOffset;
                        nday = nday >= 0 ? nday : nday + 7;
                        /*if the next year starts before the middle of
                        the week, it is week #1 of that year*/
                        weeknum = nday < 4 ? 1 : 53;
                    }
                }
                else {
                    weeknum = Math.floor((daynum + day - 1) / 7);
                }
                return weeknum;
            };

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
                for (let i = 1; i <= 5; i++) {
                    let dd = new Date(montag);
                    dd.setDate(montag.getDate() + i - 1);
                    let lbl = tage[i] + ', ' + dd.getDate() + '.' + (dd.getMonth() + 1) + '.';
                    
                    let id = 'th-tag-' + i;
                    document.getElementById(id).innerHTML = lbl;

                }

                /*
                 * bei geaendertem Zeitraum immer die Unterrichte lesen
                 */
                read_unterrichte();
            }

            /**
             * Montag der aktuellen Woche bestimmen fue die Auswahl des Zeitraums
             */
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
            });
            $('#woche_vor_btn').click(function (e) {
                e.preventDefault();
                montag.setDate(montag.getDate() + 7);
                sonntag.setDate(sonntag.getDate() + 7);
                zeige_zeitraum();
            });
            $('#woche_aktuell_btn').click(function () {
                montag = getMonday(new Date());
                sonntag = new Date(montag);
                sonntag.setDate(sonntag.getDate() + 6);
                zeige_zeitraum();
            });

            /********************************************************************
             * Auswahlen fuellen und vorbesetzen
             ********************************************************************/

            // Lehrer aus der SESSION besetzen
            function set_session_lehrer() {
                // Lehrer aus der SESSION setzen
                $("#lehrer").val(<?php echo $_SESSION['user_lehrer_id'];?>);
                $("#der_lehrer").val(<?php echo $_SESSION['user_lehrer_id'];?>);
                $("#lehrer-auswahl").prop('checked',true);
                read_unterrichte();                
            }
            
            /**
             * Lehrer lesen
             */
            function read_lehrer(event) {
                $.ajax({
                    url: ajax_prefix + "/klassenbuch-api/api/lehrer",
                    // url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/lehrer",
                    type: "GET",
                    success: function (data) {
                        var response = $.parseJSON(data);
                        $("#lehrer").find('option').remove().end().append(new Option('', -1));
                        $("#der_lehrer").find('option').remove().end().append(new Option('', -1));
                        response.forEach(row => {
                            $("#lehrer").append(new Option(row.kuerzel + " - " + row.nachname, row.id));
                            $("#der_lehrer").append(new Option(row.kuerzel + " - " + row.nachname, row.id));
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

            /**
             * Lesen aller Gruppen füe die Klassenauswahl 
             */
            function read_gruppen(event) {
                $.ajax({
                    url: ajax_prefix +  "/klassenbuch-api/api/gruppe",
                    type: "GET",
                    success: function (data) {
                        var response = $.parseJSON(data);
                        $("#gruppe").find('option').remove().end().append(new Option('', -1));
                        $("#die_gruppe").find('option').remove().end().append(new Option('', -1));
                        
                        response.forEach(row => {
                            if (row.klasse && row.klasse > 0) {
                                row.sortierung = 'a' + row.sortierung;
                            } else {
                                row.sortierung = 'b' + row.sortierung;
                            }

                            if (row.lehrer_id && row.lehrer_id == $('#lehrer').val()) {
                                row.sortierung = 'a' + row.sortierung;
                            } else {
                                row.sortierung = 'b' + row.sortierung;
                            }
                        });

                        response.sort((a,b) => (a.sortierung > b.sortierung) ? 1 : ((b.sortierung > a.sortierung) ? -1 : 0));

                        response.forEach(row => {
                            $("#gruppe").append(new Option(row.name, row.id));
                            $("#die_gruppe").append(new Option(row.name, row.id));
                        });

                        console.log(response);

                        // Gruppe aus der SESSION setzen
                        aktiv_gruppe_id =<?php echo $_SESSION['aktiv_gruppe_id'] ? $_SESSION['aktiv_gruppe_id'] : 'null' ?>; 
                        if(aktiv_gruppe_id){
                            $("#gruppe").val(aktiv_gruppe_id);
                            handleGruppeChange();
                        }

                    },
                    error: function (e) {
                        console.log(e.message);
                    }
                });
            }

            /**
             * Lesen aller Faecher fur die Fach-Auswahl
             */
            function read_faecher(event) {
                $.ajax({
                    url: ajax_prefix + "/klassenbuch-api/api/fach",
                    type: "GET",
                    success: function (data) {
                        var response = $.parseJSON(data);
                        $("#fach").find('option').remove().end().append(new Option('', -1));
                        response.forEach(row => {
                            $("#fach").append(new Option(row.name, row.id));
                        });
                    }
                });
            }

            /**
             * Lesen aller Stunden fur die Stunden-Auswahl
             */
            function read_ustunden(event) {
                $.ajax({
                    url: ajax_prefix + "/klassenbuch-api/api/ustunde",
                    type: "GET",
                    success: function (data) {
                        var response = $.parseJSON(data);
                        $("#ustunde").find('option').remove().end().append(new Option('', -1));
                        response.forEach(row => {
                            $("#ustunde").append(new Option(row.name, row.id));
                        });
                    }
                });
            }

            /**
             * Lesen der Zeiten fuer die Tabelle
             */
            async function read_zeiten(event) {                
                $.ajax({
                    url: ajax_prefix + "/klassenbuch-api/api/ustunde/anzeige",
                    type: "GET",
                    success: function (data) {
                        var response = $.parseJSON(data);
                        response.forEach(row => {
                            // neue Zeile fuer die Timetable erzeugen
                            let trow = document.createElement('TR');
                            let lbl = row.beginn.substr(0, 5) + ' - ' + row.ende.substr(0, 5);
                            let cell = document.createElement('TD');
                            cell.innerHTML = lbl;
                            trow.appendChild(cell);
                            // Zellen fuer die 5 Schultage
                            for (let i = 1; i <= 5; i++) {
                                let cell = document.createElement('TD');
                                let outer_div = document.createElement('DIV');
                                outer_div.id = 'ttod-' + i + '-' + row.id;
                                outer_div.classList.add('ttod');
                                
                                outer_div.appendChild(create_table_cell_add(i, row.id));
                                cell.appendChild(outer_div);
                                trow.appendChild(cell);
                            }
                            // Zeile an die Timetable anhaengen
                            $("#tt-tbody").append(trow);
                        });
                    }
                });
            }


            /**
            * Befüllen des Sitzplan-Selects in der Section Unterricht
            * mit den der gewählten Gruppe zugehörigen Sitzplänen
            */
            function read_sitzplaene_laut_gruppe(gruppe_id) {
                url = "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/sitzplan/gruppe/" + gruppe_id;
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function (data) {
                        var response = $.parseJSON(data);
                        $("#sitzplan").find('option').remove().end().append(new Option('bitte Sitzplan auswählen', -1));
                        response.forEach(row => {
                            
                            if(row.sort!='A' 
                                && !(unterricht.sitzplan_id !== null
                                && unterricht.sitzplan_id == row.id)){
                                status=' [inaktiv] ';
                            } else {
                                status = '';
                                $("#sitzplan").append(
                                                    new Option(row.raum.name + ' (' + row.teilgruppe + ') '+row.lehrer.kuerzel + ' '+ row.beginn.split("-").reverse().join(".").substr(0,6) + ': ' + row.name +status, row.id)
                                                    
                                                    );
                            }
                        });

                        if (unterricht.sitzplan_id) {
                            $("#sitzplan").val(unterricht.sitzplan_id);                      
                        }
                        
                    }
                });
            }

            /**
             */
            function read_fach_laut_gruppe(gruppe_id) {
                if ($("#fach").val() && $("#fach").val() > 0) {

                } else {
                    url = "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/gruppe/" + gruppe_id;
                    $.ajax({
                        url: url,
                        type: "GET",
                        success: function (data) {
                            var response = $.parseJSON(data);
                            if (response.fach_id) {
                                $("#fach").val(response.fach_id);
                            }
                        }
                    });
                }
            }

            $('input[name="options-auswahl"]').change(function() {
                read_unterrichte();
            });

            function handleLehrerChange(e) {
                console.log('hlc');
                $("#der_lehrer").val($("#lehrer").val());
                // $("#gruppe").val(-1);
                if (auswahl == 'LEHRER') {                    
                    $("#klassenbuch_fuer_wen").text($("#lehrer option:selected").text());
                }
                read_unterrichte(e);  
                read_gruppen(e);              
            }

            function handleLehrerSelect(e) {
                console.log('hls');
                auswahl = 'LEHRER';
                $("#klassenbuch_fuer_wen").val($("#lehrer option:selected").text());
            }

            function handleGruppeChange(e) {
                handleGruppeSelect(e);

                console.log('hgc');
                $("#die_gruppe").val($("#gruppe").val());
                // $("#lehrer").val(-1);
                if (auswahl == 'GRUPPE') {
                    $("#klassenbuch_fuer_wen").text($("#gruppe option:selected").text());
                    read_corona_by_gruppe($("#die_gruppe").val());
                    read_entschuldigung_aktuell_by_gruppe($("#die_gruppe").val());
                    praesenzen_laut_gruppe($("#die_gruppe").val());
                    read_sitzplaene_laut_gruppe($("#die_gruppe").val());  
                    get_offene_Erledigungen($("#die_gruppe").val());
                }
                read_unterrichte(e);
            }
            
            function handleGruppeSelect(e) {
                console.log('hgs');
                auswahl = 'GRUPPE';
                $("#klassenbuch_fuer_wen").val($("#gruppe option:selected").text());
            }
            

            function handleDie_gruppeChange(e){
                console.log('hdgc');
               
                praesenzen_laut_gruppe($("#die_gruppe").val());
                read_sitzplaene_laut_gruppe($("#die_gruppe").val());  

                //Offene Erledigungen für Starseite (ABIT) lesen
                get_offene_Erledigungen($("#die_gruppe").val());

                //Corona-Status zur Gruppe lesen
                read_corona_by_gruppe($("#die_gruppe").val());

                //Entschuldigungsstatus zur Gruppe lesen.
                read_entschuldigung_aktuell_by_gruppe($("#die_gruppe").val());

                $("#gruppe").val($("#die_gruppe").val());

                // Versuche, das Fach vorzubesetzen
                read_fach_laut_gruppe($("#die_gruppe").val());
            }

            /**
             * vorhandene Unterrichte fuer die Gruppe/den Lehrer im Auswahlzeitraum lesen
             */
            function read_unterrichte(e) {
                // auswahl bestimmen (blauer button gruppe oder lehrer)
                console.log("Auswahl: %o", $('input[name="options-auswahl"]:checked').attr('id'));

                let auswahl = $('input[name="options-auswahl"]:checked').attr('id');

                if (auswahl == 'gruppe-auswahl') {
                    var url = ajax_prefix + "/klassenbuch-api/api/unterricht/gruppe/"
                    + $("#gruppe").val()
                    + "/datum/"
                    + montag.toISOString().substr(0, 10)
                    + "/"
                    + sonntag.toISOString().substr(0, 10);
                } else if (auswahl == 'lehrer-auswahl') {
                    var url = ajax_prefix + "/klassenbuch-api/api/unterricht/lehrer/"
                    + $("#lehrer").val()
                    + "/datum/"
                    + montag.toISOString().substr(0, 10)
                    + "/"
                    + sonntag.toISOString().substr(0, 10);
                }

                $.ajax({
                    url: url,
                    type: "GET",
                    success: function (data) {
                        var response = $.parseJSON(data);
                        unterrichte = response;

                        /*
                         * Tabelle der Unterrichte leeren
                         */
                        for (let outer_div of $(".ttod")) {
                            let unterricht_geloescht = false;
                            for (let tt_unterricht_btn of $("#" + outer_div.id + " .tt-unterricht")) {
                                tt_unterricht_btn.remove();
                                unterricht_geloescht = true;
                            }
                            if (unterricht_geloescht) {
                                let ary = outer_div.id.split("-");
                                outer_div.appendChild(create_table_cell_add(ary[1], ary[2]));
                            }

                        }

                        /*
                         * gelesene Unterrichte eintragen
                         */
                        $.each(response, function (i, row) {
                            datum = new Date(row.datum);
                            let el_id = "ttod-" + datum.getDay() + "-" + row.ustunde.block;
                            // console.log(el_id);
                            let el = document.getElementById(el_id);
                            for (let tt_unterricht_add_btn of $("#" + el.id + " .tt-unterricht-add")) {
                                tt_unterricht_add_btn.remove();
                            }
                            // console.log(el);

                            let btn = create_table_cell_edit(row.id);
                            
                            let lbl = row.gruppe.name + " - " + row.fach.kurz + " - " + row.lehrer.kuerzel;
                            if (row.vertretung && row.vertretung > 0) {
                                lbl = lbl + '*';
                            }
                            // console.log(lbl);
                            btn.innerText = lbl;         

                            if (row.gruppe_id != $("#gruppe").val() && auswahl == 'gruppe-auswahl') {
                                btn.classList.remove('btn-primary');
                                btn.classList.add('btn-info');
                                // btn.style.backgroundColor = "lime";
                            }           

                            el.appendChild(btn);
                        });
                    },
                    error: function (e) {
                        console.log(e.message);
                    }
                });
            }


            /**
            * Corona-Status der angezeigten Gruppe anzeigen
            * maßgeblich ist dabei nur die Gruppe, angezeigt wird immer der Status zum Zeitpunkt des Gruppenaufrufs
            */
            function read_corona_by_gruppe(id) {
                console.log('coro read '+id);
				$.ajax({
                    url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/corona/gruppe/"+id,
                    type: "GET",
                    success: function (data) {
                        
                        var response = $.parseJSON(data);                                           
                        
                        corona = [];
                        corona_gruppe_id = id;

                        $("#corona").empty();
                        
                        response.forEach(row => {
                            cls = "badge bg-dark";
                            fehlt = false;
                            now = new Date().toISOString().slice(0, 19).replace('T', ' ');

                            if(!row.von || row.bis < now || !row.bis){
                                cls = "badge bg-danger";
                                fehlt = true;
                            } else {
                                cls = "badge bg-success";
                            }
                            

                            if(fehlt){
                                
                                nachname = row.nachname.substr(0, 4)+'.';
                                if (row.nachname.substr(0,3)=='ZZ '){
                                    splitpoint = row.nachname.indexOf(' ',4)+1;
                                    nachname = row.nachname.substr(splitpoint, 4) + '. ('+row.nachname.substr(3,splitpoint-4)+')';
                                }

                                $("#corona").append($("<button></button")
                                    .addClass("btn btn-dark btn-sm")
									.attr('type', 'button')
                                    .attr('id', "btn_coronatest-" + row.id)
                                    .attr('schueler_id',  row.schueler_id)
                                    .on('click', function () {
                                        if(row.id > 0){
                                            corona_okay_speichern(row.id);
                                        }
                                        if(row.id==-1){
                                            corona_testneu(row.schueler_id);
                                        }
                                        
                                    })
                                    .append($("<span></span>")
                                        .addClass(cls)
                                        .text(row.vorname + ' ' + nachname)));
                                corona.push(row);
                            }
                        });

                        if(corona.length>0){
                            console.log("Corona "+corona.length+ "x fehlend");
                            $("#coronarow").show();
                        } else {
                            console.log("Corona okay");
                            $('#corona').append(
											$('<i></i>')
											.addClass('bi-check')
										)
										.append(
											$('<i></i>')
											.text('Alle Schülerinnen und Schüler der Gruppe '+$('#gruppe option:selected').text()+' haben für heute einen gültigen Nachweis')
										);
                            $('#coronarow').show();
                        }
                    }
                });
            }



            /**
            * Positivmeldung zum Corona-Status speichern            
            * 
            */
            function corona_okay_speichern(erledigung_id){  
                
                var date;
                date = new Date();
                date = date.getUTCFullYear() + '-' +
                    ('00' + (date.getUTCMonth()+1)).slice(-2) + '-' +
                    ('00' + date.getUTCDate()).slice(-2);
    
                var formdata = JSON.stringify({id:erledigung_id, von:date});
    
                $.ajax({
                    type: 'PUT',
                    url: '/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/corona/vorhanden/' + erledigung_id,
                    data: formdata,
                    success: function (json) {
						console.log('cor '+corona_gruppe_id);
                        read_corona_by_gruppe(corona_gruppe_id);
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
            * Positivmeldung zum Corona-Status speichern            
            * 
            */
            function corona_testneu(sus_id){  
                
                var date;
                date = new Date();
                date = date.getUTCFullYear() + '-' +
                    ('00' + (date.getUTCMonth()+1)).slice(-2) + '-' +
                    ('00' + date.getUTCDate()).slice(-2);
    
                var formdata = JSON.stringify({schueler_id:sus_id, von:date});
    
                $.ajax({
                    type: 'POST',
                    url: '/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/corona/testneu',
                    data: formdata,
                    success: function (json) {
						console.log('corNeu '+corona_gruppe_id);
                        read_corona_by_gruppe(corona_gruppe_id);
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
             * Lesen aller aktuellen Entschuldigungen für die Gruppe
             */
            function read_entschuldigung_aktuell_by_gruppe(id) {
                $.ajax({
                    url: '/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/erledigung/entschuldigung/aktuell/gruppe/' + id,
                    type: "GET",
                    success: function (data) {
                        var response = $.parseJSON(data);
                        
                        count_aktuell = 0;
                        $('#entschuldigung_aktuellrow').hide();
                        $('#entschuldigung_aktuell').empty();

                        
                        response.forEach(row => {
                            row.erledigung.forEach(er => {
                               
                                count_aktuell++;
                                btncls = "btn btn-secondary";
                                btntxt = "";

                                if (er.eigenschaft_id == -3){
                                    btntxt = "(e) ";
                                    if(!er.lehrer_id || !er.bis){
                                        btncls = "btn btn-warning";
                                    } else {
                                        btncls = "btn btn-success";
                                    }
                                }

                                if (er.eigenschaft_id == -4){
                                    btntxt = "(U) ";
                                    if(!er.lehrer_id || !er.bis){
                                        btncls = "btn btn-warning";
                                    } else {
                                        btncls = "btn btn-info";
                                    }
                                }

                                if (er.eigenschaft_id == -5){
                                    btntxt = "(s) ";
                                    btncls = "btn btn-info";                                    
                                }



                                nachname = row.nachname.substr(0, 4)+'.';
                                if (row.nachname.substr(0,3)=='ZZ '){
                                    splitpoint = row.nachname.indexOf(' ',4)+1;
                                    nachname = row.nachname.substr(splitpoint, 4) + '. ('+row.nachname.substr(3,splitpoint-4)+')';
                                }

                                von = '';
                                if (er.von){
                                    von = new Date(er.von.replace(' ','T')).toLocaleDateString();
                                }

                                bis = ' bis ?? ';
                                if (er.bis){
                                    bis = " bis " + new Date(er.bis.replace(' ','T')).toLocaleDateString();
                                }

                                lehrer_kuerzel = '';
                                if(er.lehrer_id){
                                    lehrer_kuerzel= ' ('+er.lehrer_kuerzel+') ';
                                }

                                $("#entschuldigung_aktuell").append($("<button></button")
                                    .addClass("btn btn-sm m-1")
									.attr('type', 'button')
                                    .attr('id', "entsch" + er.id)
                                    .on('click', function () {
                                        window.location.href = './entschuldigung.php?ide='+er.id;
                                        return false;
                                    })
                                    .addClass(btncls)
                                    .text(btntxt + row.vorname + ' ' + nachname +" "+von+bis+lehrer_kuerzel)
                                    
                                );


                            });
                        });

                        if(count_aktuell > 0){
                            $('#entschuldigung_aktuellrow').show();
                        }
                        
                    }
                });
            }


            /**
             * Daten speichern. Je, nachden, ob schon eine ID existiert, wird ein
             * Datensatz geaendert oder neu angelegt.
             */
            function speichern(event) {
                unterricht.gruppe_id = $("#die_gruppe").val();
                unterricht.lehrer_id = $("#der_lehrer").val();
                unterricht.datum = $("#datum").val();
                unterricht.ustunde_id = $("#ustunde").val();
                unterricht.fach_id = $("#fach").val();
                unterricht.vertretung = ($('#vertretung').prop('checked') ? 1 : 0);
                unterricht.inhalte = $("#inhalte").val();
                unterricht.aufgaben = $("#aufgaben").val();
                unterricht.bemerkungen = $("#bemerkungen").val();
                unterricht.aufgaben_zeit = $("#aufgaben_zeit").val();
                if ($("#sitzplan").val() && $("#sitzplan").val() > 0) {
                    unterricht.sitzplan_id = $("#sitzplan").val();
                } else {
                    delete unterricht.sitzplan_id;
                }
                
                var method;
                var url;
                var upd = false;
                if (unterricht.id && unterricht.id > 0) {
                    method = 'PUT';
                    url = ajax_prefix + "/klassenbuch-api/api/unterricht/" + unterricht.id;
                    upd = true;
                } else {
                    method = 'POST';
                    url = ajax_prefix + "/klassenbuch-api/api/unterricht";
                    delete unterricht.id;
                }                

                var formData = JSON.stringify(unterricht);
                $.ajax({
                    type: method,
                    url: url,
                    data: formData,
                    success: function (data) {
                        if (upd) {
                            speicher_praesenzen(data.id);                        
                        } else {
                            // Praesenzen mit der gerade erhaltenen unterrichts-ID
                            // speichern
                            speicher_praesenzen(data.id);                                                        
                        }

                        // Gruppe und Lehrer aus der Antwort
                        $("#gruppe").val(data.gruppe_id);
                        $("#lehrer").val(data.lehrer_id);

                        $("#unterricht").modal('hide'); // vorher $("#unterricht").hide();
                        read_unterrichte();
                        
                        // unterricht_vorbesetzen();
                        praesenzen_laut_gruppe($('#gruppe').val());

                    },
                    error: function (e, textStatus, errorThrown) {
                        console.log(e.responseJSON);
                        alert(errorThrown + "\n" + e.responseJSON.error.message);
                    },
                    dataType: "json",
                    contentType: "application/json"
                });
            }  

            /**
             * Unterricht loeschen (nur "geloescht" auf 1 setzen).
             */
            function loeschen(event) {                
                var method = 'PUT';
                var url = ajax_prefix + "/klassenbuch-api/api/unterricht/" + unterricht.id;
                var upd = false;
                if (unterricht.id && unterricht.id > 0) {
                    method = 'PUT';
                    upd = true;
                } else {
                    $("#unterricht").modal('hide'); // vorher $("#unterricht").hide();
                    return;
                }                

                var upd_obj = {
                    id: unterricht.id,
                    geloescht: 1
                }

                var formData = JSON.stringify(upd_obj);
                $.ajax({
                    type: method,
                    url: url,
                    data: formData,
                    success: function (data) {
                        $("#unterricht").modal('hide'); // vorher $("#unterricht").hide();
                        read_unterrichte();
                        
                        // unterricht_vorbesetzen();
                        praesenzen_laut_gruppe($('#gruppe').val());
                    },
                    error: function (e, textStatus, errorThrown) {
                        console.log(e.responseJSON);
                        alert(errorThrown + "\n" + e.responseJSON.error.message);
                    },
                    dataType: "json",
                    contentType: "application/json"
                });
            }  



             /**
            * Fuegt Praesenzen in die Datenbank ein
            */
            function speicher_praesenzen(unterricht_id) {
                for (var key in praesenzen) {

                    var method;
                    var url;

                    var praesenz = {
                        unterricht_id: unterricht_id,
                        belegung_id: praesenzen[key].belegung_id,
                        fehlt: praesenzen[key].fehlt,
                        entschuldigt: praesenzen[key].entschuldigt,
                        verspaetet: praesenzen[key].verspaetet,
                        bemerkung: praesenzen[key].bemerkung
                    };
                    if (praesenzen[key].id) {
                        praesenz.id = praesenzen[key].id;
                        method = 'PUT';
                        url = '/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/praesenz/' + praesenz.id;
                    } else {
                        method = 'POST';
                        url = '/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/praesenz';
                    }
                    console.log(praesenz);

                    var formData = JSON.stringify(praesenz);
                    $.ajax({
                        type: method,
                        url: url,
                        data: formData,
                        success: function (json) {
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


            /**
            * Setzt die Praesenzen für alle Schueler auf "anwesend" (1)
            */
            function alle_praesent() {
                for (var key in praesenzen) {
                    var val = praesenzen[key];
                    praesenzen[key].fehlt = 1;
                    var cls = 'badge bg-success';
                    $('#' + key).find('span').removeClass().addClass(cls);

                    let text = $('#' + key).find('span').text();
                    text = ':'+text.substr(1);
                    $('#' + key).find('span').text(text);
                }
                console.log(praesenzen);
            }

            /**
            * Setzt die Praesenzen für alle Schueler auf "absent" (2)
            */
            function alle_absent() {
                for (var key in praesenzen) {
                    var val = praesenzen[key];
                    praesenzen[key].fehlt = 2;
                    var cls = 'badge bg-danger';
                    $('#' + key).find('span').removeClass().addClass(cls);
                    
                    let text = $('#' + key).find('span').text();
                    text = 'a'+text.substr(1);
                    $('#' + key).find('span').text(text);
                }
                console.log(praesenzen);
            }


            function praesenzen_laut_unterricht(response){
                // Praesenzen-Anzeige neu fuellen
                $("#praesenzen").find('button').remove().end();
                praesenzen = [];

                response.praesenzen.forEach(row => {
                    praesenzen["s" + row.schueler_id] = {
                        id: row.id,
                        unterricht_id: row.unterricht_id,
                        belegung_id: row.belegung_id,
                        fehlt: parseInt(row.fehlt ? row.fehlt : "0"),
                        entschuldigt: parseInt(row.entschuldigt ? row.entschuldigt : "0"),
                        verspaetet: row.verspaetet ? row.verspaetet : '',
                        bemerkung: row.bemerkung ? row.bemerkung : ''
                    };
                    var cls = 'badge bg-info';
                    let bez = '?';
                    switch (praesenzen["s" + row.schueler_id].fehlt) {
                        case 0:
                            cls = 'badge bg-dark';
                            bez = '?';
                            break;
                        case 1:
                            cls = 'badge bg-success';
                            bez = ':';
                            break;
                        case 2:
                            cls = 'badge bg-danger';
                            bez = 'a';
                            break;
                        case 3:
                            cls = 'badge text-success bg-dark';
                            bez = 'b';
                            break;
                    }

                    nachname = row.nachname.substr(0, 4)+'.';
                    if (row.nachname.substr(0,3)=='ZZ '){
                        splitpoint = row.nachname.indexOf(' ',4)+1;
                        nachname = row.nachname.substr(splitpoint, 4) + '. ('+row.nachname.substr(3,splitpoint-4)+')';
                    }

                    $("#praesenzen").append($("<button></button")
                        .addClass("btn btn-dark")
                        .attr('id', "s" + row.schueler_id)
                        .attr('type', 'button')
                        .on('click', function () {
                            toggle_praesenz("s" + row.schueler_id);
                        })
                        .append($("<span></span>")
                            .addClass(cls)
                            .text(bez+') '+row.vorname + ' ' + nachname + '.')));
                });
                console.log(praesenzen);
            }

            function praesenzen_laut_gruppe(gruppe_id) {
            $("#praesenzen").find('button').remove().end();
            praesenzen = [];

            var url = "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/praesenz_gruppe/"
                + gruppe_id;

            $.ajax({
                url: url,
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
					let heute = new Date().toISOString().substr(0,10);

                    response
					.filter(row => (row.beginn<=heute && row.ende >= heute))
					.forEach(row => {
                        praesenzen["s" + row.schueler_id] = {
                            id: row.id,
                            unterricht_id: row.unterricht_id,
                            belegung_id: row.belegung_id,
                            fehlt: row.fehlt ? row.fehlt : 0,
                            entschuldigt: row.entschuldigt ? row.entschuldigt : 0,
                            verspaetet: row.verspaetet ? row.verspaetet : '',
                            bemerkung: row.bemerkung ? row.bemerkung : ''
                        };
                        nachname = row.nachname.substr(0, 4)+'.';
                        if (row.nachname.substr(0,3)=='ZZ '){
                            splitpoint = row.nachname.indexOf(' ',4)+1;
                            nachname = row.nachname.substr(splitpoint, 4) + '. ('+row.nachname.substr(3,splitpoint-4)+')';
                        }
                        $("#praesenzen").append($("<button></button")
                            .addClass("btn btn-dark")
                            .attr('id', "s" + row.schueler_id)
							.attr('type', 'button')
                            .on('click', function () {
                                toggle_praesenz("s" + row.schueler_id);
                            })                            
                            .append($("<span></span>")
                                .addClass("badge badge-dark")
                                .text('?) '+ row.vorname + ' ' + nachname + '.')));
                    });
                    console.log(praesenzen);
                },
                error: function (e) {
                    console.log(e.message);
                }
            })
        }

        /**
         * Aendert die Praesenz des Schuelers. Die ID des Schuelers ist
         * in diesem Zusammenhang eindeutig?
         */
        function toggle_praesenz(s_schueler_id) {
            var fehlt = praesenzen[s_schueler_id].fehlt;
            fehlt += 1;
            fehlt %= 4;
            var cls = 'badge bg-info';
            let bez = '?';
            switch (fehlt) {
                case 0:
                    cls = 'badge bg-dark';
                    bez = '?';
                    break;
                case 1:
                    cls = 'badge bg-success';
                    bez = ':';
                    break;
                case 2:
                    cls = 'badge bg-danger';
                    bez = 'a';
                    break;
                case 3:
                    cls = 'badge text-success bg-dark';
                    bez = 'b';
                    break;
            }
            $('#' + s_schueler_id).find('span').removeClass().addClass(cls);
            
            let text = $('#' + s_schueler_id).find('span').text();
            text = bez+text.substr(1);
            $('#' + s_schueler_id).find('span').text(text);
            
            praesenzen[s_schueler_id].fehlt = fehlt;
        }


        function get_offene_Erledigungen(gruppe_id){

            erledigung_gruppe_id = gruppe_id;

            url = "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/erledigung/gruppe/" + gruppe_id +"/startseite";
                $.ajax({
                    url: url,
                    type: "GET",
                    
                    success: function (data) {
                        
                        $('#erledigungrow').empty();

                        var response = $.parseJSON(data);                        
                        console.log(response);
                        response
                        .filter(row => (row.erledigung.length > 0))
                        .forEach(row => {                            
                            $("#erledigungrow").append(
                                $("<div></div>")
                                .addClass("row m-3 p-3 bg-dark")
                                .append(
                                    $("<div></div>")
                                    .addClass("col-md-2")                    
                                    .append(
                                        $("<i></i>")
                                        .addClass("bi-tag px-2")                        
                                    )
                                    .append(
                                        $("<span></span>")
                                        .text("Eigenschaft "+row.eigenschaft.eigenschaft_name)
                                    )                  
                                )
                                .append(
                                    $("<div></div>")
                                    .addClass("col-md-10")
                                    .append(
                                        $("<div></div>")
                                        .attr('id','eigenschaftrow'+row.eigenschaft.eigenschaft_id)                        
                                    )                    
                                )
                            );         

                            
                            row.erledigung.forEach(erledigung => {
                                nachname = erledigung.nachname.substr(0, 4)+'.';
                                if (erledigung.nachname.substr(0,3)=='ZZ '){
                                    splitpoint = erledigung.nachname.indexOf(' ',4)+1;
                                    nachname = erledigung.nachname.substr(splitpoint, 4) + '. ('+erledigung.nachname.substr(3,splitpoint-4)+')';
                                }
                                $('#eigenschaftrow'+row.eigenschaft.eigenschaft_id)
                                .append($("<button></button")
                                    .addClass("btn btn-dark")
                                    .attr('id', "btn_erledigung-"+row.eigenschaft.eigenschaft_id)                                    
                                    .attr('schueler_id',  erledigung.schueler_id)
                                    .attr('type', 'button')
                                    .on('click', function () {
                                        onclick_erledigung(erledigung.erledigung_id, row.eigenschaft.eigenschaft_onclick);
                                    })                            
                                    .append($("<span></span>")
                                        .addClass("badge bg-danger")
                                        .text(erledigung.vorname + ' ' + nachname + '.')
                                    )
                                );                               

                            });

                        });                        
                        
                    }
                });          

        }

        function onclick_erledigung(ide, method){
            console.log("oce #"+ide+" mit Methode "+method);

            //Methode -2 => Corona-Status (Eigenschaft -2) erneuern
            if(method==-2){
                var date;
                date = new Date();
                date = date.getUTCFullYear() + '-' +
                    ('00' + (date.getUTCMonth()+1)).slice(-2) + '-' +
                    ('00' + date.getUTCDate()).slice(-2);
    
                var formdata = JSON.stringify({id:ide, von:date});
    
                $.ajax({
                    type: 'PUT',
                    url: '/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/corona/vorhanden/' + ide,
                    data: formdata,
                    success: function (json) {
						console.log('oce/cor '+corona_gruppe_id);
                        read_corona_by_gruppe(corona_gruppe_id);
                        get_offene_Erledigungen(erledigung_gruppe_id);
                    },
                    error: function (e) {
                        console.log(e.message);
                        alert(e.message);
                    },
                    dataType: "json",
                    contentType: "application/json"
                });
            }


            //Methode 2 (Signum setzen)
            if(method==2){
                
                let user_lehrer_id = <?php echo $_SESSION['user_lehrer_id'];?>;
                
                if(!user_lehrer_id){
                    return;
                }

                var formdata = JSON.stringify({id:ide, lehrer_id:user_lehrer_id});
    
                $.ajax({
                    type: 'PUT',
                    url: '/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/erledigung/' + ide,
                    data: formdata,
                    success: function (json) {
						console.log('oce '+corona_gruppe_id);                        
                        get_offene_Erledigungen(erledigung_gruppe_id);
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


               
        </script>
    </body>
</html>