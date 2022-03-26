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
                    <select class="form-control" name="eigenschaft" id="eigenschaft">
                        <option selected>(alle der Gruppe)</option>
                    </select>
                </div>   
                
                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="btn_eigenschaft_neu" onclick="btn_eigenschaft_neu()">
                        <i class="bi-plus-square pr-2"></i>neue Liste
                    </button>
                </div>     

            </div>
        </div>
    </section>


  

    <section>
        <div class="container-fluid  bg-dark text-white">

            <!-- Template Tabelle, welche mittels clone() kopiert wird -->
            <div class="row m-2 p-2 bg-dark">            
                <table id="template-table" class="table table-striped table-dark table-sm d-none">
                    <thead class="thead-dark">
                        <tr>  
                            <th class="tmpl tmpl_th1 border-left border-right" scope="col" colspan = "2" >eigenschaft.name</th>                            
                        </tr>
                        <tr>                                                                                   
                            <th class="tmpl tmpl_th2 border-left border-right" scope="col" colspan = "2">created_at/ created_by_kuerzel </th>                            
                        </tr>
                        <tr>
                             <th class="tmpl tmpl_th3 border-left border-right" scope="col" colspan="1">
                                <button type="button" class="btn btn-secondary tmpl_btn_leftscroll" data-bs-toggle="tooltip" data-bs-placement="top" title="Woche zurück">
                                    <i class="bi-caret-left"></i>
                                </button>                                        
                                <button type="button" class="btn btn-secondary tmpl_btn_rightscroll" data-bs-toggle="tooltip" data-bs-placement="top" title="Woche vor">
                                    <i class="bi-caret-right"></i>
                                </button>
                                
                                <button type="button" class="btn btn-secondary tmpl_btn_eigenschaft_bearbeiten" data-bs-toggle="tooltip" data-bs-placement="top" title="Woche vor">
                                    <i class="bi-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-secondary tmpl_btn_mitteilung" data-bs-toggle="tooltip" data-bs-placement="top" title="Woche vor">
                                    <i class="bi-chat mx-1"></i><span class="tmpl_btn_mitteilung_count">?</span>
                                </button>  
                            </th>
                            <th class ="tmpl tmpl_th3 border-left border-right" > Mitteilungen</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="tmpl">                          
                            <td class ="tmpl tmpl_status">                                
                                <div class="bg-danger">
                                    <i class="bi-x"></i>                                    
                                    Status ??
                                    - <i class="bi-chat"></i>: mitteilungen ??
                                </div>
                            </td>
                            <td class = "tmpl tmpl_mitteilung">(Mitteilung) ??</td>
                        <tr>
                    </tbody>
                </table>


                <!-- Tabelle mit den Daten -->
                <div class="row m-2 p-2 bg-dark">            
                <table id="table" class="table table-striped table-dark table-sm table-hover">
                    <thead id="thead-liste" class="thead-dark">
                        <tr id="th1">
                            <th scope="col">Name</th>
                            <th scope="col">Vorname</th>    
                            <th id = "th1-0" scope="col">Klasse</th>                            
                        <tr id="th2"><th id="th2-0" scope="col" colspan = "3"></th><tr>
                        <tr id ="th3">
                            <th id="th3-1-0" scope="col" colspan = "3"></th></tr>   
                        </tr>
                    </thead>
                    <tbody id ="tbody-liste">                        
                    </tbody>
                </table>
            </div>

        </div>
    </section>



     <!-- Formular fuer das Anlegen/Aendern von Erledigungen -->
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

                                    <div class="input-group col-md-6" data-bs-toggle="tooltip" data-bs-placement="top" title="ab welcher Uhrzeit?">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <!-- Stunde -->
                                                <i class="bi-clock px-2"></i>Uhrzeit</span>
                                        </div>
                                        <input type="time" class="form-control" name="vonStunde" id="vonStunde"></input>
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

                                   <div class="input-group col-md-6" data-bs-toggle="tooltip" data-bs-placement="top" title="bis einschließlich welche Uhrzeit?">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <!-- Stunde -->
                                                <i class="bi-clock px-2"></i>Uhrzeit</span>
                                        </div>
                                        <input type="time" class="form-control" name="bisStunde" id="bisStunde"></input>
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
                                    <div class="input-group col-md" id="btn_signum">
                                       <button type="button" class="btn btn-secondary" data-bs-toggle="tooltip" 
                                            data-bs-placement="top" title="Unterschreiben mit eigenem Signum / Unterschrift löschen" id="ich_btn">
                                            <i class="bi bi-file-earmark-person"></i>
                                            <span id="ich_btn_txt"></span>
                                        </button>
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

      
        var api_url_modifier = "";
      
        schueler = {};
        schuelerliste = [];
      
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
            column : 1,
            collapse_mitteilung : false,
            id : -2,
            name : 'Corona-Status',
            created_by_kuerzel : 'UL',
            created_at : '2021-08-01T15:32:02',
            default_bis : '2022-08-01',
            default_click : 0,
            erledigungen : []
        };

        eigenschaften = [];
        eigenschaften.push(eigenschaft);

        Array.prototype.swap = function (x,y) {
            var b = this[x];
            this[x] = this[y];
            this[y] = b;
            return this;
        }

       
        

        /**
         * Lesen der Erledigungungen einer Eigenschaft
         *
         *
         */
        function read_erledigungen_by_gruppe(id_g,  index) {            
            
            if(index >= eigenschaften.length){
                $('#loadingModal_msg').append($('<div></div>').text('Erzeuge tabellarische Darstellung'));
                show_liste();
                return;
            }

            $('#loadingModal_msg').find('div').last().text('Lade Erledigungen zur Eigenschaft '+(index+1)+' von '+eigenschaften.length);
            eigenschaft = eigenschaften[index];
            let id_e = eigenschaft.id;

            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/erledigung/gruppe/"+id_g+"/eigenschaft/"+id_e,
                type: "GET",
                success: function (data) {
                    let response = $.parseJSON(data);

                    eigenschaft.erledigungen=[];

                    response.forEach(teilnehmer=>{
                        teilnehmer.erledigung.forEach(erledigung=>{
                            eigenschaft.erledigungen.push(erledigung);
                        });
                    });
                                                                      
                    
                    read_erledigungen_by_gruppe(id_g,  index+1);                    
                }
            });
        }

        
        /**
        Darstellung der Kontrollisten erzeugen
        Schülerliste (Zeilen) gemäß Reihung schuelerliste,
        Eigenschaften (Spalten) gemäß Reihung Eigenschaften,
        Erledigungen gemäß bei den Eigenschaften hinterlegten Reihungen Erledigungen
         */
        function show_liste(){
            
            let id_before = 0;
            $("#tbody-liste").empty();
            $('#thead-liste').find('.tmpl').remove();

            
            schuelerliste.forEach(row=>{
                let elem = $('#s'+row.id);
                    
                    if(elem.length==0) {

                        let stammgruppe = row.tutor_kuerzel;
                        if(row.gruppe_id){
                            stammgruppe = row.gruppe.name+"/"+stammgruppe;
                        } else {
                            stammgruppe = "-- / "+stammgruppe;
                        }
                        

                        let heute = new Date().toISOString().substr(0,10);
                        let appendix = null;
                        if(row.ende < heute){
                            let beginn = new Date(row.beginn.replace(' ','T')).getDate()+'.'+(new Date(row.beginn.replace(' ','T')).getMonth()+1)+'.';
                            let ende = new Date(row.ende.replace(' ','T')).getDate()+'.'+(new Date(row.ende.replace(' ','T')).getMonth()+1)+'.'+(new Date(row.ende.replace(' ','T')).getFullYear());
                            appendix = "<small><i>vom "+beginn+" bis "+ende+"</i></small>";
                        }

                        elem = $("<tr></tr>")
                                    .attr('id','s'+row.id)
                                    .append(
                                        $("<td></td>")
                                        .text(row.nachname)
                                    )
                                    .append(
                                        $("<td></td>")
                                        .text(row.vorname)
                                    )
                                    .append(
                                        $("<td></td>")
                                        .attr("id","s"+row.id+"-tdm-0")                                        
                                        .text(stammgruppe)
                                    );
                        $("#tbody-liste").append(elem);

                        if(appendix){
                            $('#s'+row.id).find('td').first()
                            .append($('<div></div>')
                                .html(appendix)
                            );
                        }
                    }

            });
            
            //Erzeugen der Felder für das Eintragen der Erledigungen
            //Feld-IDs der Form
            //s<schueler_id>-tdm-<eigenschaft_id> für das td mit den Mitteilungen
            //(td für Mitteilung zusätzlich mit Klasse col-mtg-<eigenschaft_id> )
            //s<schueler_id>-tds-<eigenschaft_id> für das td mit den Erledigungen
            eigenschaften.forEach(eigenschaft=>{

                let id_e = eigenschaft.id;
                
                schuelerliste.forEach(schueler=>{
                    let elem = $('#s'+schueler.id);
                    let mtg = $("<td></td>")
                                .attr("id","s"+schueler.id+"-tdm-"+id_e)                                                    
                                .addClass("col-mtg-"+id_e)
                                .addClass("border-right");

                    let status = $("<td></td>")
                                .attr("id","s"+schueler.id+"-tds-"+id_e)  
                                .text("")
                                .addClass("border-left")
                                .click(function(){
                                    erledigungneu(schueler,eigenschaft);
                                    })                                              
                                ;

                    elem.find("#s"+schueler.id+"-tdm-"+id_before).after(mtg).after(status);
                });

                //Erzeugen der Spaltenüberschriften
                let elem = $('.tmpl_th1').clone().removeClass("tmpl_th1");
                elem = elem.attr('id', 'th1-'+id_e).text(eigenschaft.name);
                $('#th1-'+id_before).after(elem);

                let d = eigenschaft.created_at.replace(' ','T');
                if(isNaN(new Date(d))){
                    eigenschaft.created_at = new Date().toISOString();
                }                

                elem = $('.tmpl_th2').clone().removeClass("tmpl_th2");
                let datum = new Date(eigenschaft.created_at.replace(' ','T')).getDate() +'.'+(new Date(eigenschaft.created_at.replace(' ','T')).getMonth()+1)+'.';
                elem = elem.attr('id', 'th2-'+id_e).text('erstellt: '+datum +' von: '+eigenschaft.created_by_kuerzel);
                $('#th2-'+id_before).after(elem);

               
                elem = $('.tmpl_th3').clone().removeClass("tmpl_th3");                
                elem.first().attr('id', 'th3-0-'+id_e);
                elem.last().attr('id', 'th3-1-'+id_e);
                $('#th3-1-'+id_before).after(elem);

                elem.find('.tmpl_btn_mitteilung_count')
                .removeClass()                
                .attr('id', 'btn_mitteilung_count-'+id_e);


                $('#th3-0-'+id_e)
                .find('.tmpl_btn_mitteilung')
                .attr('id','btn_mitteilung-'+id_e)
                .click(function(){
                    toggle_mitteilungen(id_e);
                });
                
                $('#th3-0-'+id_e)
                .find('.tmpl_btn_rightscroll')
                .attr('id','btn_rightscroll-'+id_e)
                .click(function(){
                    column_swap(id_e, 1);
                });

                $('#th3-0-'+id_e)
                .find('.tmpl_btn_leftscroll')
                .attr('id','btn_leftscroll-'+id_e)
                .click(function(){
                    column_swap(id_e, -1);
                });

                $('#th3-0-'+id_e)
                .find('.tmpl_btn_eigenschaft_bearbeiten')
                .attr('id','btn_eigenschaft-'+id_e)
                .click(function(){
                    //eigenschaft_bearbeiten(id_e);
                });

                
                eigenschaft.collapse_mitteilungen = !eigenschaft.collapse_mitteilungen;
                toggle_mitteilungen(id_e);
                


                //Eintragen der Erledigungen und Mitteilungen
                //Auszählen der Summe der Mitteilungen
                let mtg_count = 0;
                eigenschaft.erledigungen.forEach(row => {                       

                    mtg_count += row.mitteilung.length;
                    
                    //Schüler muss in der Liste vorhanden sein
                    let elem = $('#s'+row.schueler_id);
                    if(elem.length==0) {
                        elem = $("<tr></tr>")
                                    .attr('id','s'+row.schueler_id)
                                    .append(
                                        $("<td></td>")
                                        .text("Fehler! #"+row.schueler_id)
                                    )
                                    .append(
                                        $("<td></td>")
                                        .text("SuS fehlt in Gruppen-Liste")
                                    )
                                    .append(
                                        $("<td></td>")
                                        .attr("id","s"+row.schueler_id+"-td-0")                                        
                                        .text("?")
                                    );
                        $("#tbody-liste").append(elem);
                    } else {

                        let mtg = $("#s"+row.schueler_id+"-tdm-"+id_e);
                        let status = $("#s"+row.schueler_id+"-tds-"+id_e);

                        status.append(get_erledigung_elem(row));
                    
                        /*
                        status.append($("<div></div>")
                                        .addClass("my-1 bg-secondary border border-warning")
                                        .text('#'+row.id)
                                        .append($('<button></button>')
                                            .addClass("btn btn-secondary")
                                            .attr('type', 'button')
                                            .append($("<i></i>")
                                                .addClass('bi-pencil')
                                            )
                                            .click(function(){
                                                erledigungBearbeiten(row, id_e);
                                            })
                                        )
                                        
                                    );                                        
                         */        

                        
                        let max_mtg_shown = 2;
                        for(let i=0; i<row.mitteilung.length && i<max_mtg_shown; i++){
                            let d = new Date(row.mitteilung[i].created_at.replace(' ','T'));
                            let datum = d.getDate()+'.'+(d.getMonth()+1)+'.';
                            mtg.append($("<div></div>")                                        
                                        .text("@"+row.id+" "+datum + ": "+row.mitteilung[i].mitteilung)
                                        );
                            //mtg.append($("<br>"));
                        }

                        if(row.mitteilung.length>max_mtg_shown){
                            mtg.append($("<div></div>")
                                        .text("+"+(row.mitteilung.length-max_mtg_shown)+" weitere")
                                        );
                        }


                    }
                });
                
                $('#btn_mitteilung_count-'+id_e).text(mtg_count);
                   
                id_before = id_e;
            });

            $('#loadingModal').modal('hide');
        }


        /*
        Liefert das Dokument-Objekt, welches eine Erledigung repräsentiert.
        Das Aussehen ist abhängig vom Attribut "regel" der Eigenschaft und den Attributen der Erledigung
        
        regel=0 (Typ "2G-Status")
        -Eine Erledigung ist gültig, wenn von<=heute<=bis und ein Signum gesetzt ist.
        -Zustimmungen werden nicht berücksichtigt.
        -Wenn ein Schüler mehr als keine Erledigung hat, so muss mindestens eine gültig sein.

        regel=1 (Typ "ABIT"-Erledigung)
        -Eine Erledigung ist gültig, wenn von<=heute<=bis und ein Signum gesetzt ist
        -Ist von>=heute oder bis<= heute, so ist der Status der Erledigung unerheblich
        -Zustimmungen werden nicht ausgewertet

        regel=2 ("Normales Abhaken mit mögl. Elternmitwirkung")
        grün, Hakensymol:
        -Eine Erledigung ist gültig, wenn ein Signum vorhanden ist und keine Zustimmungen vorliegen
        -Eine Erledigung ist gültig&angenommen, wenn ein Signum vorhanden ist und alle Zustimmungen > 0 sind
        
        rot, Kreuzsymbol
        -Eine Erledigung ist gültig&abgelehnt, wenn ein Signum vorhanden ist und eine Zustimmung < 0 ist

        rot gerahmt, Kreuzsymbol
        - Eine Erledigung ist "wartend abgelehnt", wenn kein Signum vorhanden ist und eine Zustimmung > 0 ist
        
        grün gerahmt, Hakensymbol
        - Eine Erledigung ist "wartend angenommen", wenn kein Signum, aber alle Zustimmungen > 0

        gelb gerahmt, Uhrsymbol
        - Eine Erledigung ist "wartend unklar", wenn kein Signum vorhanden ist und offene Zustimmungen (=0) vorliegen
        
        ohne hervorhebung, Uhrsymbol:
        - Eine Erledigung ist "wartend unklar", wenn kein Signum vorliegt und keine Zustimmungen hinterlegt sind.

        */
        function get_erledigung_elem(row){
            //Fallback für nicht implementierte Darstellungsform
            let elem = $("<div></div>")
                        .addClass("my-1 bg-secondary border border-2 border-warning")
                        .attr('id','er'+row.id)
                        .text('#'+row.id)
                        .append($('<button></button>')
                            .addClass("btn btn-secondary")
                            .attr('type', 'button')
                            .append($("<i></i>")
                                .addClass('bi-pencil')
                            )
                            .click(function(event){
                                event.stopPropagation(); event.preventDefault();
                                erledigungBearbeiten(row.id, row.eigenschaft_id);
                            })
                        );
            
            eigenschaft = null;
            eigenschaften.forEach(e=>{
                if(e.id == row.eigenschaft_id){
                    eigenschaft = e;
                }
            });

            if(!eigenschaft){
                return elem;
            }

            if (eigenschaft.regel==2){
               let bg = "bg-secondary";
               let border = "border-secondary";
               let symbol = "bi-exclamation";

               let kuerzel = "__";

               if(!row.lehrer_id){
                   if(check_zustimmungen(row.zustimmung)==0){
                     symbol = "bi-hourglass-split";
                   }
                   if(check_zustimmungen(row.zustimmung)==-1){
                     border = "border-danger";
                     symbol = "bi-x";
                   }
                   if(check_zustimmungen(row.zustimmung)==1){
                     border = "border-warning";
                     symbol = "bi-hourglass-split";
                   }
                   if(check_zustimmungen(row.zustimmung)==2){
                     border = "border-success";
                     symbol = "bi-check";
                   }
               } else {
                kuerzel = row.lehrer_kuerzel;
                if(check_zustimmungen(row.zustimmung)==0){
                     bg = "bg-success";
                     symbol = "bi-check";
                   }
                   if(check_zustimmungen(row.zustimmung)==-1){
                     bg = "bg-danger";
                     symbol = "bi-x";
                   }
                   if(check_zustimmungen(row.zustimmung)==1){
                     bg = "bg-success";
                     symbol = "bi-check";
                   }
                   if(check_zustimmungen(row.zustimmung)==2){
                    bg = "bg-success";
                     symbol = "bi-check-all";
                   }
               }

               let von = "--.--."
               if(row.von){
                   let d = new Date(row.von.replace(' ','T'));
                    von = d.getDate()+'.'+(d.getMonth()+1)+'.';
               }

               bis = "--.--."
               if(row.bis){
                   let d = new Date(row.bis.replace(' ','T'));
                    bis = d.getDate()+'.'+(d.getMonth()+1)+'.';
               }
               
               let text = von+" ("+kuerzel+")";
               if(row.bis){
                text = von+" - "+bis+ " ("+kuerzel+")";
               }

                elem = $("<div></div>")
                        .addClass("my-1 "+bg+" border border-3 "+border)
                        .attr('style','border-width: 3px !important;')
                        .attr('id','er'+row.id)
                        .text(text)
                        .append($('<button></button>')
                            .addClass("btn btn-secondary btn-sm mx-1")
                            .attr('type', 'button')
                            .append($("<i></i>")
                                .addClass('bi-pencil')
                            )
                            .click(function(event){
                                event.stopPropagation(); event.preventDefault();
                                erledigungBearbeiten(row.id, row.eigenschaft_id);
                            })
                        )
                        .prepend($("<i></i>")
                                .addClass(symbol+ " mx-1")
                        )
                        ;
            
            }

            return elem;
        }


        /*Bewertet die zu einer Erledigung vorliegenden Zustimmungen
        Rückgaben 
        0: keine Zustimmungen vorliegend
        -1: Ablehung
        1: offene
        2: Zustimmung
        */
        function check_zustimmungen(zustimmungen){

            let ablehnung = false;
            let zustimmung = true;
            let offene = false;

            zustimmungen.forEach(z=>{
                if(z.zustimmung < 0){
                    ablehnung = true;
                    zustimmung = false;
                }
                if(z.zustimmung == 0){
                    zustimmung = false;
                    offene = true;
                }

            });

            if(zustimmungen.length==0){
                return 0;
            }
            
            if(ablehnung){return -1;}

            if(offene){return 1};

            if(zustimmung){return 2};

            return 0;
        }

        function toggle_mitteilungen(id_e){

            let btn_mitteilung = $('#btn_mitteilung-'+id_e);
            
            let index = -1;
            for(let i=0;i<eigenschaften.length && index ==-1; i++){
                if(eigenschaften[i].id == id_e){
                    index = i;
                }
            }
            if(index == -1) { return; }
            let eigenschaft = eigenschaften[index];

            btn_mitteilung.removeClass();
            eigenschaft.collapse_mitteilungen = !eigenschaft.collapse_mitteilungen;

            if(eigenschaft.collapse_mitteilungen){
                btn_mitteilung.addClass("btn btn-info");
                $('.col-mtg-'+id_e).show();
                $('#th1-'+id_e).attr('colspan', '2');
                $('#th2-'+id_e).attr('colspan', '2');
                $('#th3-1-'+id_e).show();

            } else {
                btn_mitteilung.addClass("btn btn-secondary");
                $('.col-mtg-'+id_e).hide();
                $('#th1-'+id_e).attr('colspan', '1');
                $('#th2-'+id_e).attr('colspan', '1');
                $('#th3-1-'+id_e).hide();

            }
            
        }

        function column_swap(id_e, delta){
            let index = -1;
            for(let i=0;i<eigenschaften.length && index ==-1; i++){
                if(eigenschaften[i].id == id_e){
                    index = i;
                }
            }
            if(index == -1) { return; }

            index_neu = index + delta;
            if(index_neu < 0 || index_neu > eigenschaften.length){
                return;
            }

            eigenschaften.swap(index, index_neu);
            show_liste();
        }
        

        function speichern(){
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
                    read_erledigungen_by_gruppe($('#gruppe').val(),0);
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
                    read_erledigungen_by_gruppe($('#gruppe').val(),0);
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
                    read_erledigungen_by_gruppe($('#gruppe').val(),0);
                },
                error: function (e) {
                    console.log(e.message);
                    alert(e.message);
                },
                dataType: "json",
                contentType: "application/json"
            }); 
        }



        $("document").ready(function () {            
            

            read_gruppen();
            read_lehrer();
            read_ustunden();

            $("#speichern").click(function() {speichern();});
            $("#loeschen").click(function() {loeschen();});
            $("#cancel").click(function() {$("#erledigungModal").modal('hide');});   //Änderung UL Modal, vorher: $("#unterricht").hide();

            //read_erledigungen_by_gruppe(109,0);
			
			$('#gruppe').change(handle_gruppenwechsel);

            
        });


		function handle_gruppenwechsel(){
            let gruppen_id = $('#gruppe').val();
            
            $('#loadingModal_msg').empty();
            $('#loadingModal').modal('show');

            schuelerliste = [];
            read_gruppe(gruppen_id);  
		}

        function get_eigenschaften_by_gruppe(id_g){
            eigenschaften = [];

            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/eigenschaft/gruppe/"+id_g,
                type: "GET",
                success: function (data) {
                    let response = $.parseJSON(data);                    
                    
                    let count = 0;
                    response.forEach(eigenschaft=>{                        
                        eigenschaft.column = count;
                        eigenschaft.collapse_mitteilungen = false;
                        eigenschaft.erledigungen = [];
                        eigenschaften.push(eigenschaft);                                            
                        count++;
                    });                    
                    
                    $('#loadingModal_msg').find('div').last().text('Lade Eigenschaften der Gruppe OK');
                        
                    $('#loadingModal_msg').append($('<div></div>').text('Lade Erledigungen zur Eigenschaft 1 von '+eigenschaften.length));
       
                    read_erledigungen_by_gruppe($('#gruppe').val(),0);			    
                    
                }
            });
            
            
        }


        function erledigungBearbeiten(erledigung, id_e){
            id = erledigung; //.id;
            console.log("edit er "+id);

            eigenschaft = null;
            for(let i=0; i<eigenschaften.length && eigenschaft==null; i++){
                if(eigenschaften[i].id==id_e){
                    eigenschaft = eigenschaften[i];
                }
            }
            if(!eigenschaft){
                console.log("Fehler - Eigenschaft #"+id_e+" nicht geladen");
                return;
            }

            $('#von').val(new Date().toISOString());
            //$('#bis').val(new Date(eigenschaft.default_bis).toISOString());
            $('#mitteilungneu').val(null);
            $('#mitteilung').empty();

            $('#erledigungModalLabel').text(eigenschaft.name +' - Erledigung #'+id+' bearbeiten');
            read_erledigung(id);

            $('#erledigungModal').modal('show');
        }


        function erledigungneu(schueler, eigenschaft){
            
            console.log("neu er "+schueler.id);
            this.eigenschaft = eigenschaft;
            
            $('#von').val(new Date().toISOString().substr(0,10));
            //$('#bis').val(new Date(eigenschaft.default_bis).toISOString().substr(0,10));
            
            $('#mitteilungneu').val(null);
            $('#mitteilung').empty();

            $('#erledigungModalLabel').text(eigenschaft.name +' - Neue Erledigung hinzufügen');
          
            erledigung.id = null;
            read_schueler(schueler.id);


            $('#erledigungModal').modal('show');

        }

/* ALT
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
                    
                    erledigung.mitteilung.forEach(mitteilung => {

                        mtg_von = new Date(mitteilung.created_at);
                        
                        mtg_text = mtg_von.toLocaleString() + ' '+mitteilung.mitteilung;

                        $('#mitteilung').append(
                            $('<div></div>')
                            .addClass('row ml-3 pl-3')
                            .append(
                                $('<div></div>')
                                .addClass('col-md-1')
                                .append(
                                    $('<i></i>')
                                    .addClass('bi-trash')
                                )
                            )
                            .append(
                                $('<div></div>')
                                .addClass('col-md-11')
                                .text(mtg_text)
                            )
                        );
                    });


                },
                error: function (e) {
                    console.log(e.message);
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
*/


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

                    $('#erledigungModalLabel').text(erledigung.eigenschaft.name +' - Erledigung #'+id+' von '+erledigung.schueler.vorname+' ' +erledigung.schueler.nachname+' bearbeiten');
                                
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
                    update_btn_ich();
                    

                    zeige_mitteilungen();

                    $('#modalZustimmungListe').empty();  
                    $('#modalZustimmung').hide();  
                    if(erledigung.zustimmung.length>0){
                        $('#modalZustimmung').show();  

                        erledigung.zustimmung.forEach(zs => {
                            if(zs.zustimmung == 0){
                                $('#modalZustimmungListe').append(
                                    $('<span></span>')
                                    .addClass("badge bg-danger mx-2 px-2")
                                    .text(zs.kuerzel+" / "+zs.info)
                                )
                            }
                            if(zs.zustimmung != 0){
                                $('#modalZustimmungListe').append(
                                    $('<span></span>')
                                    .addClass("badge bg-success mx-2 px-2")
                                    .text(zs.kuerzel+" / "+zs.info)
                                )
                            }
                        });
                    }

                    let status = $("#s"+erledigung.schueler_id+"-tds-"+erledigung.eigenschaft_id);
                    if(status){
                        $('#er'+erledigung.id).replaceWith(get_erledigung_elem(erledigung));
                        console.log(get_erledigung_elem(erledigung));
                        //status.append(get_erledigung_elem(erledigung));

                        eigenschaften.forEach(ei=>{
                            ei.erledigungen.forEach(er=>{
                                if(er.id == erledigung.id){
                                    er = erledigung;
                                }
                            });
                        });
                    }



                },
                error: function (e) {
                    console.log(e.message);
                }
            });
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
            $('#vonStunde').val(von);

            /*
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/ustunde/beginn/"+von,
                type: "GET",
                success: function (data) {
                    
                    var response = $.parseJSON(data);
                    console.log(response);

                    $('#vonStunde').val(response.id);
                }
            });
            */

        }


        function bisStunde_besetzen(time){
            bis = time.substr(11,8);
            $('#bisStunde').val(bis);

            /*
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/ustunde/ende/"+bis,
                type: "GET",
                success: function (data) {
                    
                    var response = $.parseJSON(data);
                    console.log(response);

                    $('#bisStunde').val(response.id);
                }
            });
            */
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
                    $("#gruppe").find('option').remove().end().append(new Option('(Gruppe wählen)', -1));
                    response.forEach(row => {
                        $("#gruppe").append(new Option(row.name, row.id));
                    });
                    
                    if(aktiv_gruppe_id){
                        $('#gruppe').val(aktiv_gruppe_id);
                        handle_gruppenwechsel();
                    }
                },
                error: function (e) {
                    console.log(e.message);
                }
            });
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
                    set_session_lehrer();

                    // Button "ICH" funktioniert ab jetzt
                    $("#ich_btn").click(function() {
                            set_session_lehrer();
                            $('#ich_btn').blur();
                    });
                                        
                }
            });
        }


        function set_session_lehrer(){
            let lehrer_id = $('#lehrer').val();            
            
            if(user_lehrer_id){
                if(lehrer_id < 0 || !lehrer_id){
                    $("#lehrer").val(<?php echo $_SESSION['user_lehrer_id'];?>);
                } else {
                    $('#lehrer').val(-1);
                }
                update_btn_ich();
            } else {
                $('#lehrer').prop('disabled');
            }
        }

        function update_btn_ich(){
            let lehrer_id = $('#lehrer').val();            
            
            if(user_lehrer_id){
                if(lehrer_id > 0 && lehrer_id){
                    $('#ich_btn_txt').text("Unterschrift zurückziehen");
                } else {
                    let kuerzel = $('#lehrer').find("[value="+user_lehrer_id+"]").text();
                    $('#ich_btn_txt').text("Als "+kuerzel+" unterschreiben.");
                }
            } else {
                $('#lehrer').prop('disabled');
            } 
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
                    
                    if(erledigung.id == null){
                        $('#erledigungModalLabel').text(eigenschaft.name +' - Neue Erledigung für '+ response.vorname + ' ' + response.nachname + ' hinzufügen');
                    }
                }
            });
        }


        /**
            * Schüler einer Gruppe lesen
            */
        function read_gruppe(id) {
            $('#loadingModal_msg').append($('<div></div>').text('Lade Gruppenbelegung '));
            $.ajax({
                url:  "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/gruppe/"+id,                    
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                
                    $('#loadingModal_msg').find('div').last().text('Lade Gruppenbelegung OK');
                    
                    $('#loadingModal_msg').append($('<div></div>').text('Lade Schuelerdaten 1 von '+response.belegung.length));
                    read_schueler_by_belegung(response.belegung, 0);
                    
                    
                }
            });
        }

        /**
            * Schüler einer Gruppe lesen
            */
        function read_schueler_by_belegung(belegung, index) {
            if(index >= belegung.length){

                schuelerliste.sort(function(a,b){
                    if(a.nachname < b.nachname){
                    return -1;
                    } else if (a.nachname > b.nachname) {
                        return 1;
                    } else {
                        if(a.vorname <= b.vorname){
                            return -1;
                        } else {
                            return 0;
                        }
                    }
                }); 
                
                $('#loadingModal_msg').append($('<div></div>').text('Lade Eigenschaften der Gruppe'));
                get_eigenschaften_by_gruppe($('#gruppe').val());
                return;
            }

            $('#loadingModal_msg').find('div').last().text('Lade Schuelerdaten '+(index+1)+' von '+belegung.length);
            let schueler_id = belegung[index].schueler_id;

            $.ajax({
                url:  "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/schueler/"+schueler_id,                    
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);

                    response.beginn = belegung[index].beginn;
                    response.ende = belegung[index].ende;
                    schuelerliste.push(response);
                    
                
                    read_schueler_by_belegung(belegung, index+1);

                    
                }
            });
        }


    </script>

</body>

</html>