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
            
            <div class="row mt-3 pt-3 pb-3">

                <div class="input-group col-md">
                    <button class="btn btn-danger" id="neuerplan" onclick="init_sitzplan()">
                        <i class="bi-trash pr-2"></i>Neuer Plan
                    </button>
                </div>    

                <div class="input-group col-md">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Lerngruppe
                            <i class="bi-people pl-2"></i></span>
                    </div>
                    <select class="form-control" name="gruppe" id="gruppe"></select>
                </div>

                <div class="input-group col-md">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Sitzplan
                            <i class="bi-list pl-2"></i></span>
                    </div>
                    <select class="form-control" name="planselect" id="planselect"></select>
                </div>   
                
                <div class="input-group col-md">
                    <button class="btn btn-info" id="kopiespeichern" onclick="kopieanfertigen()">
                        <i class="bi-layers-half pr-2"></i>bestehenden Plan kopieren
                    </button>
                </div>     
                
            </div>
        </div>
    </section>

    


    <!-- Sitzplan UL Anfang Section Sitzplan-->
    <section id="sitzplansection">
        <div class="container-fluid  bg-secondary text-black">
            <div class="row mt-3 pt-3">

                <div class="input-group col-md">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Raum
                            <i class="bi-door-open pl-2"></i></span>
                    </div>
                    <select class="form-control" name="raum" id="raum" required></select>
                </div>

                <div class="input-group col-md">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Teilgruppe
                            <i class="bi-puzzle pl-2"></i></span>
                    </div>
                    <select class="form-control" name="teilgruppe" id="teilgruppe" required></select>
                </div>

                <div class="input-group col-md">
                    <div class="input-group-prepend">
                        <span class="input-group-text">gültig ab
                            <i class="bi-calendar-date pl-2"></i></span>
                    </div>
                    <input class="form-control" type="date" name="beginn" id="beginn" required>
                </div>

            </div>

            <div class="row pt-1 pb-1">
                <div class="input-group col-md">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Bezeichnung
                            <i class="bi-pencil pl-2"></i></span>
                    </div>
                    <input class="form-control" type="text" name="spl_name" id="spl_name" placeholder="z.B. Klassenunterricht">
                </div>

                <div class="input-group col-md">
                    <div class="input-group-prepend">
                        <span class="input-group-text">erstellt von
                            <i class="bi-person pl-2"></i></span>
                    </div>
                    <select class="form-control" name="lehrer" id="lehrer" required></select>
                </div>


                <div class="input-group col-md ">
                    <div class="input-group-prepend">
                        <span class="input-group-text pr-2">Sichtbarkeit
                            </span>
                    </div>    
                    <button class="btn btn-light" id="sort" onclick="toggle_sortierung()">
                        <i class="bi-eye-fill py-2"></i>sichtbar / auswählbar
                    </button>                    
                </div>       

            </div>



            <div class="row pt-1 pb-3">   
                
                
            
                
                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="rasteryweniger" onclick="raster_y_kleiner()">
                        <i class="bi-arrow-bar-up pr-2"></i>weniger Zeilen
                    </button>
                </div>    
                
                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="rasterymehr" onclick="raster_y_groesser()">
                        <i class="bi-arrow-bar-down pr-2"></i>mehr Zeilen
                    </button>
                </div>    
                

                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="rasterxweniger" onclick="raster_x_kleiner()">
                        <i class="bi-arrow-bar-left pr-2"></i>weniger Spalten
                    </button>
                </div>    

                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="rasterxmehr" onclick="raster_x_groesser()">
                        <i class="bi-arrow-bar-right pr-2"></i>mehr Spalten
                    </button>
                </div>

                <div class="input-group col-md">
                    <button class="btn btn-success" id="speichern" onclick="speichern()">
                        <i class="bi-save pr-2"></i>Speichern
                    </button>
                </div>                
                
            </div>

            <div class="row mt-2 py-2 px-2 text-warning" id="verwendungenhinweis">
                <div class="col-md">
                    <i class="bi-exclamation-triangle pr-2"></i>
                        <i>Dieser Sitzplan ist bereits 
                        <span id="verwendungen">5</span>
                        Unterrichten zugewiesen und kann daher nicht mehr verändert werden.
                        Sie können eine Kopie des Planes erstellen und diese als neuen Plan speichern.</i>
                </div>
            </div>



            <div class="row mt-2 py-2 px-2 border-top">
                <div class="col-sm-9">
                    <div id="plan">

                    </div>
                </div>
                <div class="col-sm-3 bg-light" id="schuelerliste_wrapper">
                    <div class="row" id="schuelerliste">
                    </div>
                    
                    <div class="row border-top" id="schuelerliste_hilfselemente">
                    </div>
                </div>

                
            </div>

           

        </div>
    </section>
    <!-- Sitzplan UL Ende Section Sitzplan-->

 

    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script>
       
        ajax_prefix = '';
        
        //Sitzplan UL Anfang Statusobjekt
        
        aktiv_gruppe_id = <?php echo $_SESSION['aktiv_gruppe_id'] ?: 'null' ?>;
        aktiv_sitzplan_id = <?php echo $_SESSION['aktiv_sitzplan_id'] ?: 'null' ?>;
        user_lehrer_id = <?php echo $_SESSION['user_lehrer_id'] ?: 'null' ?>;

        var sitzplan = {};

        function reset_sitzplan() {
            sitzplan = {
                raum_id: null,
                lehrer_id: null,
                beginn: null,
                id: -1,
                name: "",
                sitzplatz: [],
                gruppe_id : null,
                gruppe: [],
                teilgruppe : null,
                selectedSchueler: null,
                selectedSitzplatz: null,
                selectedText: null,
                verwendungen: 0,
                anzeigen: true,
                sitzplatz_idCounter: -1,
                size_x : 10,
                size_y : 10,
                sort : 'A',
                isUnsaved : false
            };
        }
           

        /**
         * Lesen aller Gruppen füe die Klassenauswahl 
         */
        function read_gruppen(event) {
            $.ajax({
                url: ajax_prefix + "/klassenbuch-api/api/gruppe",
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                    $("#gruppe").find('option').remove().end().append(new Option('(Gruppe wählen)', -1));
                    response.forEach(row => {
                        $("#gruppe").append(new Option(row.name, row.id));
                    });
                },
                error: function (e) {
                    console.log(e.message);
                }
            });
        }

        /**
         * Lesen aller Lehrer fuer die Lehrerauswahl
         * 
         * TODO: Vorbesetzen der Auswahl durch die Anmeldung
         */
        function read_lehrer(event) {
            $.ajax({
                url: ajax_prefix + "/klassenbuch-api/api/lehrer",
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                    $("#lehrer").find('option').remove().end().append(new Option('', -1));
                    response.forEach(row => {
                        $("#lehrer").append(
                            new Option(row.kuerzel + " - " + row.nachname, row.id));
                    });
                }
            });
        }


        /**
         * Befüllen des Raum-Selects in der Section Sitzplan
         */
        function read_raeume(event) {
            url = ajax_prefix + "/klassenbuch-api/api/raum";
            $.ajax({
                url: url,
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                    $("#raum").find('option').remove().end().append(new Option('(Raum wählen)', -1));
                    for (var counter = 0; counter < response.length; counter++) {
                        $("#raum").append(new Option(response[counter].name, response[counter].id));
                    }
                }
            });
        }


        function kopieanfertigen(){
            sitzplan.id = -1;
            sitzplan.name = "Kopie von "+sitzplan.name;
            sitzplan.beginn = null;
			sitzplan.verwendungen = 0;
            refresh_sitzplan();
        }


        $("document").ready(function () {
            init_sitzplan();
        });

        function init_sitzplan(){
            reset_sitzplan();
            $('#planselect').empty();

            $('#gruppe').on('change', function () {
                reset_sitzplan();

                sitzplan.gruppe_id = $('#gruppe').val();
                
                //Sitzplan UL Vorbereiten der Darstellung bei Gruppenwechsel
                read_sitzplaene_laut_gruppe();
                
                spl_read_gruppe();
                refresh_sitzplan();

            });

            $('#lehrer').on('change', function () {                
                sitzplan.lehrer_id = $('#lehrer').val();   
                sitzplan.isUnsaved = true; 
                refresh_sitzplan();           
            });

            $('#raum').on('change', function () {                
                sitzplan.raum_id = $('#raum').val();  
                sitzplan.isUnsaved = true;                          
                refresh_sitzplan();
            });

            $('#spl_name').on('change', function () {                
                sitzplan.name = $('#spl_name').val(); 
                sitzplan.isUnsaved = true;                           
                refresh_sitzplan();
            });

            $('#teilgruppe').on('change', function () {                
                sitzplan.teilgruppe = $('#teilgruppe').val();                
                sitzplan.isUnsaved = true;            
                refresh_sitzplan();
            });
            
            $('#beginn').on('change', function () {                
                sitzplan.beginn = $('#beginn').val(); 
                sitzplan.isUnsaved = true;                           
                refresh_sitzplan();
            });

            read_gruppen();
            read_lehrer();
            read_raeume();
            
            if(aktiv_gruppe_id){
                sitzplan.gruppe_id = aktiv_gruppe_id;
                $('#gruppe').val(sitzplan.gruppe_id);

                read_sitzplaene_laut_gruppe();
                //init_sitzplan();

                if(aktiv_sitzplan_id){
                    read_sitzplan(aktiv_sitzplan_id);

                    if(sitzplan.gruppe_id != aktiv_gruppe_id){
                        reset_sitzplan();
                    }

                    $('#planselect').val(sitzplan.id);
                }
            }
        

            spl_read_gruppe();
            refresh_sitzplan();

            $('#planselect').on('change', function () {
                read_sitzplan($('#planselect').val());
                sitzplan.isUnsaved = false;            
            });
          

            $("#teilgruppe").find('option').remove().end().append(new Option('A+B', 'A+B'));
            $("#teilgruppe").append(new Option('A', 'A'));
            $("#teilgruppe").append(new Option('B', 'B'));

        }

       

        /**
         * Befüllen des Sitzplan-Selects in der Section Unterricht
         * mit den der gewählten Gruppe zugehörigen Sitzplänen
         */
        function read_sitzplaene_laut_gruppe() {
            url = ajax_prefix + "/klassenbuch-api/api/sitzplan/gruppe/" + sitzplan.gruppe_id;
            $.ajax({
                url: url,
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                    $("#planselect").find('option').remove().end().append(new Option('(neuer Plan)', -1));
                    response.forEach(row => {
                        
                        if(row.sort!='A'){
                            status=' [verborgen] ';
                        } else {
                            status = '';
                        }

                        $("#planselect").append(new Option(row.raum.name + ' (' + row.teilgruppe + ') ab ' + row.beginn.split("-").reverse().join(".") + ' von '+row.lehrer.kuerzel+ ': ' + row.name +status, row.id));
                    });
                    
                    if(response.length>0){
                        $('#planselect option:first').text('(neuer Plan / Plan öffnen)');
                    }

                    if(sitzplan.id){
                        $('#planselect').val(sitzplan.id);
                    }
                }
            });
        }

       

        /**
         * Abfrage der zur gewählten Gruppe gehörenden Schüler
         * Ablage im Sitzplan-Objekt
         */
        function spl_read_gruppe() {
            sitzplan.gruppe = [];

            url = ajax_prefix + "/klassenbuch-api/api/gruppe/" + sitzplan.gruppe_id;
            $.ajax({
                url: url,
                type: "GET",
                success: function (data) {
                    sitzplan.gruppe = [];
                    var response = $.parseJSON(data);
                    
                    console.log("spl gruppe "+sitzplan.gruppe_id); 
                    //console.log(response.belegung);

                    response.belegung.forEach(belegung => {
                        sitzplan.gruppe.push(belegung.schueler);
                    });

                    refresh_sitzplan();
                }
            });
        }



        function toggle_sortierung(){
            if(sitzplan.sort == 'A'){
                sitzplan.sort = 'Z'
            } else {
                sitzplan.sort = 'A'
            }
            speichern_status();

            refresh_sitzplan();
        }


     
        function raster_y_groesser(){
            
            sitzplan.size_y = Number(sitzplan.size_y)+1;       
            refresh_sitzplan();
           
        }

        function raster_y_kleiner(){
            let ynew = sitzplan.size_y - 1;

            //Mindestgröße 4x4
            if (ynew < 4) {return; }

            //Nur, wenn nicht bereits Zuweisungen auf den Plätzen
            let index = null;
            for (let i = 0; i < sitzplan.sitzplatz.length; i++) {
                if (sitzplan.sitzplatz[i].y >= ynew ) {
                    return;
                }
            }

            sitzplan.size_y = ynew;
            refresh_sitzplan();
        }



        function raster_x_groesser(){
            sitzplan.size_x = Number(sitzplan.size_x)+1;      
            refresh_sitzplan();
        }

        function raster_x_kleiner(){
            let xnew = sitzplan.size_x - 1;

            //Mindestgröße 4x4
            if (xnew < 4) {return; }

            //Nur, wenn nicht bereits Zuweisungen auf den Plätzen
            let index = null;
            for (let i = 0; i < sitzplan.sitzplatz.length; i++) {
                if (sitzplan.sitzplatz[i].x >= xnew ) {
                    return;
                }
            }

            sitzplan.size_x = xnew;
            refresh_sitzplan();
        }


        /**
         * Retuniert true oder false
         * Prüft, ob das übergebende Schüler-Objekt innerhalb des
         * Arrays sitzplatz auftaucht, d.h. ob der Schüler einen
         * Sitzplatz zugewiesen bekommen hat
         */ 
        function hasSitzplatz(schueler) {
            let res = false;
            sitzplan.sitzplatz.forEach(sitzplatz => {
                if (sitzplatz.schueler_id == schueler.id) {
                    res = true;
                    return true;
                }
            });
            return res;
        }


        /**
         * Aktualisierung der Section Sitzplatz
         * u.a. Werte der UI-Elemente updaten
         */ 
        function refresh_sitzplan() {

          

            $("#schuelerliste").empty();
            sitzplan.gruppe.forEach(schueler => {
                if (hasSitzplatz(schueler) == false) {
                    let element = '<div><h4><span schueler_id="' + schueler.id 
                    + '" class="badge badge-secondary float-left ml-2 my-2" onclick="selectSchueler(this)">' 
                    + schueler.vorname + ' ' + schueler.nachname + '</span></h4></div>';
                    
                    $("#schuelerliste").append(element);
                }
            });

            //Darstellung der Hilfselemente in der rechten Spalte                       
            $("#schuelerliste_hilfselemente").empty();
            let seitenlaenge = 60;
            element = '<div class ="float-left ml-2 my-2" text="Tür"  onmousedown="selectText(this)" style="text-align:center;  width:' + seitenlaenge + 'px; height:' + seitenlaenge + 'px; background-color:Ivory; border: 1px solid lightgray;" >Tür</div>';
            $("#schuelerliste_hilfselemente").append(element);
            element = '<div class ="float-left ml-2 my-2" text="Pult"  onmousedown="selectText(this)" style="text-align:center;  width:' + seitenlaenge + 'px; height:' + seitenlaenge + 'px; background-color:Ivory; border: 1px solid lightgray;" >Pult</div>';
            $("#schuelerliste_hilfselemente").append(element);
            element = '<div class ="float-left ml-2 my-2" text="x"  onmousedown="selectText(this)" style="text-align:center;  width:' + seitenlaenge + 'px; height:' + seitenlaenge + 'px; background-color:Ivory; border: 1px solid lightgray;" >x</div>';
            $("#schuelerliste_hilfselemente").append(element);
            element = '<div class ="float-left ml-2 my-2" text="Fenster"  onmousedown="selectText(this)" style="text-align:center;  width:' + seitenlaenge + 'px; height:' + seitenlaenge + 'px; background-color:Ivory; border: 1px solid lightgray; word-wrap: break-word;" >Fenster</div>';
            $("#schuelerliste_hilfselemente").append(element);

            element = '<div class ="float-left ml-2 my-2" text=""  onmousedown="selectText(this)" style="text-align:center;  width:' + seitenlaenge + 'px; height:' + seitenlaenge + 'px; background-color:Ivory; border: 1px solid lightgray; word-wrap: break-word;" ><i>Freitext</i></div>';
            $("#schuelerliste_hilfselemente").append(element);
           

            //Darstellung des Sitzrasters    
            seitenlaenge = 80;
            $("#plan").empty();
            for (let i = 0; i < sitzplan.size_x; i++) {
                for (let j = 0; j < sitzplan.size_y; j++) {
                    let element = '<div oncontextmenu="return false;" id="platz' + i + '-' + j + '"  onmousedown="selectPlatz(this,event)" style="text-align:center;  width:' + seitenlaenge + 'px; height:' + seitenlaenge + 'px; background-color:Ivory; border: 1px solid lightgray; position:absolute; left:' + (i + 0.5) * seitenlaenge + 'px; top:' + j * seitenlaenge + 'px;" ></div>';
                    $("#plan").append(element);
                }
            }
            $('#plan').css("height", sitzplan.size_y * seitenlaenge + "px");

            
            //Befüllen des Sitzplans gemäß Array sitzplatz
            sitzplan.sitzplatz.forEach(sitzplatz => {
                let selektor = '#platz' + sitzplatz.x + '-' + sitzplatz.y;
                let element = '';

                if (sitzplatz.schueler_id) {
                    element += '<span class="badge badge-secondary">' + sitzplatz.schueler.vorname + '<br>' + sitzplatz.schueler.nachname + '</span>';
                }
                if (sitzplatz.text != '') {
                    element += '<p>' + sitzplatz.text + '</p>';
                }

                $(selektor).append(element);
                $(selektor).attr("sitzplatz_id", sitzplatz.id);

                if (sitzplatz.rot >= 0) {
                    $(selektor).css("border", "2px solid black");
                }
                if (sitzplatz.rot == 0) {
                    $(selektor).css("border-bottom", "6px solid black");
                }
                if (sitzplatz.rot == 90) {
                    $(selektor).css("border-right", "6px solid black");
                }
                if (sitzplatz.rot == 180) {
                    $(selektor).css("border-top", "6px solid black");
                }
                if (sitzplatz.rot == 270) {
                    $(selektor).css("border-left", "6px solid black");
                }
            });


            if (!sitzplan.beginn) {
                sitzplan.beginn = new Date().toISOString().substr(0, 10);
            }
            $('#beginn').val(sitzplan.beginn);

           
            $('#spl_name').val(sitzplan.name);

            if(! sitzplan.lehrer_id){
                $("#lehrer").val(user_lehrer_id);
                sitzplan.lehrer_id = user_lehrer_id;
            } else {
                $("#lehrer").val(sitzplan.lehrer_id);
            }
            
            if(sitzplan.raum_id){
                $("#raum").val(sitzplan.raum_id);
            } else {
                sitzplan.raum_id = -1;
                $("#raum").val(sitzplan.raum_id);
            }

            if(sitzplan.teilgruppe){
                $("#teilgruppe").val(sitzplan.teilgruppe);
            } else {
                sitzplan.teilgruppe = "A+B";
                $("#teilgruppe").val(sitzplan.teilgruppe);
            }

            if(sitzplan.sort == 'A'){
                $('#sort').html('<i class="bi-eye-fill pr-2"></i>sichtbar / auswählbar');
            } else {
                $('#sort').html('<i class="bi-eye-slash pr-2"></i>verborgen / nicht auswählbar');
            }

            if(sitzplan.id){
                $('#planselect').val(sitzplan.id);
            }

            //neuerplan kopiespeichern speichern
            if(sitzplan.verwendungen > 1) {
                $('#speichern').prop('disabled', true);
            } else {
                if(!sitzplan.name || !sitzplan.raum_id || !sitzplan.gruppe_id || !sitzplan.lehrer_id || !sitzplan.teilgruppe || !sitzplan.beginn){
                    $('#speichern').prop('disabled', true);
                } else {
                    if(sitzplan.isUnsaved){
                        $('#speichern').prop('disabled', false);
                    } else {
                        $('#speichern').prop('disabled', true);
                    }
                }
            }

            if(sitzplan.id>0){
                $('#kopiespeichern').prop('disabled', false);
            } else {
                $('#kopiespeichern').prop('disabled', true); 
            }


            if(sitzplan.verwendungen > 1){
                $('#raum').prop('disabled', true);
                $('#teilgruppe').prop('disabled', true);
                $('#beginn').prop('disabled', true);
                $('#spl_name').prop('disabled', true);
                $('#lehrer').prop('disabled', true);

                $('#rasterxmehr').prop('disabled', true);
                $('#rasterxweniger').prop('disabled', true);
                $('#rasterymehr').prop('disabled', true);
                $('#rasteryweniger').prop('disabled', true);

                $('#verwendungenhinweis').show();
                $('#verwendungen').text(sitzplan.verwendungen);

                $('#schuelerliste_wrapper').hide();
            } else {
                $('#raum').prop('disabled', false);
                $('#teilgruppe').prop('disabled', false);
                $('#beginn').prop('disabled', false);
                $('#spl_name').prop('disabled', false);
                $('#lehrer').prop('disabled', false);

                $('#rasterxmehr').prop('disabled', false);
                $('#rasterxweniger').prop('disabled', false);
                $('#rasterymehr').prop('disabled', false);
                $('#rasteryweniger').prop('disabled', false);

                $('#verwendungenhinweis').hide();
                $('#verwendungen').text(sitzplan.verwendungen);

                $('#schuelerliste_wrapper').show();
            }
            

        }


        /**
         * Spezifischen Sitzplan laden
         * ausgelöst über Select "sitzplan" in der Section Unterricht
         * -> Folgeaufruf zum Nachladen der Gruppenmitglieder
         * -> Folgeaufruf zum Aktualisieren der Anzeige
         */ 
        function read_sitzplan(id) {
            url = ajax_prefix + "/klassenbuch-api/api/sitzplan/" + id;
            $.ajax({
                url: url,
                type: "GET",
                success: function (data) {
                    reset_sitzplan();

                    var response = $.parseJSON(data);
                    
                    sitzplan.id = response.id;
                    sitzplan.sitzplatz = response.sitzplatz;
                    sitzplan.teilgruppe = response.teilgruppe;
                    sitzplan.raum_id = response.raum_id;
                    sitzplan.name = response.name;
                    sitzplan.beginn = response.beginn;
                    sitzplan.teilgruppe = response.teilgruppe;
                    sitzplan.gruppe = [];
                    sitzplan.selectedSchueler = null;
                    sitzplan.selectedSitzplatz = null;
                    sitzplan.selectedText = null;
                    sitzplan.verwendungen = response.verwendungen;
                    sitzplan.anzeigen = true;
                    sitzplan.sitzplatz_idCounter = -1;
                    sitzplan.lehrer_id = response.lehrer_id;
                    sitzplan.gruppe_id = response.gruppe_id;
                    sitzplan.size_x = response.size_x;
                    sitzplan.size_y = response.size_y;
                    sitzplan.sort = response.sort;

                    spl_read_gruppe();
                    refresh_sitzplan();
                }
            });

        }

        /**
         * Click-Handler für Sitzplanschülerliste
         * gewählten Schüler hervorheben, Referenz speichern
         * -> Folgeaufruf handleZuweisung()
         */ 
        function selectSchueler(element) {
            if (sitzplan.selectedSchueler) {
                $(sitzplan.selectedSchueler).addClass("badge-primary");
                $(sitzplan.selectedSchueler).removeClass("badge-warning");
            }
            if (sitzplan.selectedSchueler != element) {
                sitzplan.selectedSchueler = element;
                $(sitzplan.selectedSchueler).addClass("badge-warning");
                $(sitzplan.selectedSchueler).removeClass("badge-primary");
            } else {
                sitzplan.selectedSchueler = null;
            }

            handleZuweisung();
        }


        /**
         * Click-Handler für Hilfselemente (Pult, Tür, ..)
         * gewähltes Element hervorheben, Referenz speichern
         * -> Folgeaufruf handleZuweisung()
         */ 
        function selectText(elem) {
            if (sitzplan.selectedText) {
                $(sitzplan.selectedText).css("border", "1px solid lightgray");
            }
            if (sitzplan.selectedText != elem) {
                $(elem).css("border", "6px solid orange");

                sitzplan.selectedText = elem;

                if ($(elem).attr("text") == "") {
                    let text = prompt("Bitte geben Sie die freie Textbezeichnung (max 20 Zeichen) ein");
                    $(elem).attr("text", text.substring(0, 20));
                    $(elem).text(text.substring(0, 20));
                }
            } else {
                sitzplan.selectedText = null;
            }

            handleZuweisung();
        }

        /**
         * Click-Handler für Sitzplanfläche
         *
         * Bei Linksklick:
         *  - belegte Plätze leeren
         *  - freie Plätze selektieren
         *    -> Folgeaufruf handleZuweisung()
         * Bei Rechtsklick
         *  - Rotationsattribut verändern (rot<0 bedeutet keinen Rahmen)
         *    -> Folgeaufruf refresh_sitzplan();
         */
        function selectPlatz(platz, event) {
            
            let sitzplatz_id = $(platz).attr("sitzplatz_id");

            let index = null;
            for (let i = 0; i < sitzplan.sitzplatz.length; i++) {
                if (sitzplan.sitzplatz[i].id == sitzplatz_id) {
                    index = i;
                    break;
                }
            }

            //Rechtsklick auf belegten Platz Rahmen drehen / ausblenden
            if (sitzplatz_id && event.which == 3) {

                let rot = sitzplan.sitzplatz[index].rot;
                if (rot < 0) {
                    rot = 0
                } else if (rot < 270) {
                    rot = rot + 90;
                } else {
                    rot = -1;
                }

                sitzplan.sitzplatz[index].rot = rot;

                sitzplan.isUnsaved = true;
                refresh_sitzplan();
                return;
            }

            //Linksklick auf belegten Platz: Belegung entfernen.
            if (sitzplatz_id && event.which == 1) {
                sitzplan.sitzplatz.splice(index, 1);

                sitzplan.isUnsaved = true;
                refresh_sitzplan();
                return;
            }

            //Linksklick auf einen freien Platz: Platz für Zuweisung merken, ggf. alte Vormerkung löschen.
            if (!sitzplatz_id && event.which == 1) {
                if (platz == sitzplan.selectedSitzplatz) {
                    sitzplan.selectedSitzplatz = null;
                    refresh_sitzplan();
                    return;
                }

                if (sitzplan.selectedSitzplatz) {
                    $(sitzplan.selectedSitzplatz).css("border", "1px solid lightgray");
                }

                sitzplan.selectedSitzplatz = platz;
                $(platz).css("border", "6px solid orange");

                handleZuweisung();
            }

        }


        /**
         * Prüfung, ob auf Basis von selektiertem Schüler und/oder Text
         * und Platz eine Platzierung, d.h. Aufnahme in das Array
         * sitzplatz vorgenommen werden kann
         */ 
        function handleZuweisung() {

            if ((sitzplan.selectedSchueler || sitzplan.selectedText) && sitzplan.selectedSitzplatz) {
                let schueler_id = $(sitzplan.selectedSchueler).attr("schueler_id");
                let nachname = "";
                let vorname = "";

                for (let i = 0; i < sitzplan.gruppe.length; i++) {
                    if (sitzplan.gruppe[i].id == schueler_id) {
                        nachname = sitzplan.gruppe[i].nachname;
                        vorname = sitzplan.gruppe[i].vorname;
                        break;
                    }
                }

                let text = "";
                if (sitzplan.selectedText) {
                    text = $(sitzplan.selectedText).attr("text");
                }

                let platz_id = $(sitzplan.selectedSitzplatz).attr("id");
                let x = platz_id.substring(5, platz_id.indexOf("-"));
                let y = platz_id.substring(platz_id.indexOf("-") + 1);


                let sitzplatz = {
                    id: sitzplan.sitzplatz_idCounter,
                    x: x,
                    y: y,
                    rot: 0,
                    text: text,
                    schueler_id: schueler_id,
                    schueler: { id: schueler_id, nachname: nachname, vorname: vorname }
                }

                if (!sitzplan.selectedSchueler) {
                    sitzplatz = {
                        id: sitzplan.sitzplatz_idCounter,
                        x: x,
                        y: y,
                        rot: 0,
                        text: text,
                        schueler_id: null,
                        schueler: null
                    }
                }

                //console.log(sitzplatz);

                sitzplan.sitzplatz.push(sitzplatz);

                sitzplan.selectedSchueler = null;
                sitzplan.selectedSitzplatz = null;
                sitzplan.selectedText = null;
                sitzplan.sitzplatz_idCounter--;

                sitzplan.isUnsaved = true;
                refresh_sitzplan();
            }

        }







        function speichern_status(event) {
            if(!sitzplan.id || sitzplan.id < 0) {return;}            
            
            var method = 'PUT';
            var url = ajax_prefix + "/klassenbuch-api/api/sitzplan/status/" + sitzplan.id;
            var upd = true;
            var formData = JSON.stringify({sort : sitzplan.sort});
            
            $.ajax({
                type: method,
                url: url,
                data: formData,
                success: function (data) {
                    read_sitzplaene_laut_gruppe();
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
         * Daten speichern. Je, nachden, ob schon eine ID existiert, wird ein
         * Datensatz geaendert oder neu angelegt.
         */
        function speichern(event) {
            var method;
            var url;
            var upd = false;
            if (sitzplan.id && sitzplan.id > 0) {
                method = 'PUT';
                url = ajax_prefix + "/klassenbuch-api/api/sitzplan/" + sitzplan.id;
                upd = true;
            } else {
                method = 'POST';
                url = ajax_prefix + "/klassenbuch-api/api/sitzplan";
                delete sitzplan.id;                
            }

            var formData = JSON.stringify({
                teilgruppe : sitzplan.teilgruppe,
                lehrer_id : sitzplan.lehrer_id,
                beginn :  sitzplan.beginn,
                raum_id : sitzplan.raum_id,
                size_x : sitzplan.size_x,
                size_y : sitzplan.size_y,
                name : sitzplan.name,
                sitzplatz : sitzplan.sitzplatz,   
                gruppe_id : sitzplan.gruppe_id            
                });
            $.ajax({
                type: method,
                url: url,
                data: formData,
                success: function (data) {                 
                    
                    sitzplan.id = data.id;

                    read_sitzplaene_laut_gruppe();                                   
                    read_sitzplan(sitzplan.id);
                    

                },
                error: function (e, textStatus, errorThrown) {
                    console.log(e.responseJSON);
                    alert(errorThrown + "\n" + e.responseJSON.error.message);
                },
                dataType: "json",
                contentType: "application/json"
            });
        }

       
       


    </script>

</body>

</html>