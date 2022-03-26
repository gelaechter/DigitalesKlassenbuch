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
                        <option selected>Corona-Status</option>
                    </select>
                </div>   
                
                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="kopiespeichern" onclick="neue_eigenschaft()" disabled>
                        <i class="bi-plus-square pr-2"></i>neu
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
                            
                            <div class = "row m-3 p-3" id="corona_typen">
                            </div>
                            

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
            id : -2,
            name : 'Corona-Status',
            default_bis : '2022-08-01',
            default_click : 0
        };
        
        var mitteilung={};

        var corona_typen = [];


        /**
         * Lesen aller Lehrer fuer die Schülerauswahl
         * Serverseitig werden nur Lehrern alle Schüler angeboten, Schüler können nur sich selektieren.
         *
         */
        function read_erledigung_by_gruppe(id_g,  id_e) {
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/erledigung/gruppe/"+id_g+"/eigenschaft/"+id_e,
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                                        
                    corona = [];

                    $("#liste").empty();
                    
                    
                    response.forEach(row => {
                        
                        let namenstext = row.vorname+' '+row.nachname;
						
						if(row.belegung_jetzt == 0){
							let ende =  new Date(row.ende.replace(' ','T')).toLocaleDateString();
							namenstext = '('+row.vorname+' '+row.nachname+ ' bis '+ ende+')'  ;
						}
						
							
						
                        $('#liste').append(
                                        $("<div></div>")
                                        .addClass("row mt-1 border-bottom")
                                        .append($("<div></div>")
                                            .addClass("col-md-2 d-flex align-items-center")
                                            .text(namenstext)
                                        )
                                        .append($("<div></div>")
                                            .addClass("col-md-10")
                                            .attr('id','s'+row.id)                                            
                                            .append(
                                                $("<div></div>")
                                                .addClass("m-1 float-left")
                                                .append(
                                                    $("<button></button>")
                                                    .addClass("btn btn-sm btn-secondary")
                                                    .on('click', {id : row.id}, erledigungneu)                                       
                                                    .append(
                                                        $("<i></i>")
                                                        .addClass("bi-plus-square")                                                        
                                                    )
                                                )
                                            )
                                        )   
                                    );
                        
                        zeige_erledigungen(row.id, row.erledigung);

                        /*
                        row.erledigung.forEach(rowe => {
                            

                            bi_corona_typ = "bi-exclamation-triangle";
                            kuerzel_corona_typ ="(?)";
                            let typen_id = -1;

                            if(rowe.corona_typ){
                                typen_id = rowe.corona_typ.corona_typen_id;
                                let ct = corona_typen.find(t=> t.id == typen_id);

                                if(ct){
                                    kuerzel_corona_typ = ct.kuerzel;
                                    bi_corona_typ = ct.icon;
                                } else {
                                    kuerzel_corona_typ ="(? Typ "+typen_id+")";
                                }
                            }

                            let btntxt = kuerzel_corona_typ;

                            if(rowe.von){
                                von = new Date(rowe.von.replace(' ','T')).toLocaleDateString();
                            } else {
                                von ="--.--.----";
                            }
                            btntxt += " "+von;
                            
                            //Bis-Datum nur bei Laientests oder unbekannten Typen anzeigen.
                            if(typen_id == 1 || typen_id ==-1){
                                if(rowe.bis){
                                    bis = new Date(rowe.bis.replace(' ','T')).toLocaleDateString();
                                } else {
                                    bis = "--.--.----";
                                }
                                btntxt += " bis "+bis;
                            }
                                                       
                            if(rowe.lehrer_id){
                                btntxt += " ("+rowe.lehrer_kuerzel+")";
                            } else {
                                btntxt += " (__)";
                                warn +=1;
                            }

                            heute = new Date().toISOString();
                            warn = 0;
                            
                            if(warn > 0){
                                btncls = "btn btn-warning";
                            } else {
                                if (rowe.corona_status){ //(rowe.von <= heute && rowe.bis >= heute){
                                    btncls = "btn btn-success";
                                } else {
                                    btncls = "btn btn-danger";
                                }
                            }

                            //Liegen alle Zustimmungen/Unterschriften vor?
                            //btnzustimmung = null;
                            
                            //btnzustimmung = $("<i></i>")
                            //                .addClass("bi-exclamation-triangle-fill");
                            

                            $('#s'+row.id).append(
                                $("<div></div>")
                                .addClass("m-1 float-left")
                                .append(
                                    $("<div></div>")
                                    .addClass('btn-group btn-group-sm')
                                    .attr("role","group")
                                    .append(
                                            $("<i></i>")
                                            .addClass("p-1 bg-secondary ")   
                                            .addClass(bi_corona_typ)                                        
                                        )
                                    .append(
                                        $("<button></button>")
                                        .addClass(btncls)
                                        .text(btntxt)
                                        .append(btnzustimmung)
                                        
                                    )
                                    .append(
                                        $("<button></button>")
                                        .addClass("btn btn-secondary")
                                        .on('click', {id : rowe.id}, erledigungBearbeiten)                                       
                                        .append(
                                            $("<i></i>")
                                            .addClass("bi-pencil")                                            
                                        )
                                    )
                                    
                                )
                            );
                        });  
                    */
                   

                    });

                    
                }
            });
        }


        function read_erledigung_by_schueler(id_s,  id_e) {
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/erledigung/schueler/"+id_s+"/eigenschaft/"+id_e,
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                    
                    //console.log(response);

                    	
                    zeige_erledigungen(id_s, response);

                    
                    
                }
            });
        }




        function zeige_erledigungen(id_sus, erledigungen){

            $('#s'+id_sus)
            .empty();
            $('#s'+id_sus).append(
                    $("<div></div>")
                    .addClass("m-1 float-left")
                    .append(
                        $("<button></button>")
                        .addClass("btn btn-sm btn-secondary")
                        .on('click', {id : id_sus}, erledigungneu)                                       
                        .append(
                            $("<i></i>")
                            .addClass("bi-plus-square")                                                        
                        )
                    )
                );

            erledigungen.forEach(rowe => {
                            

                bi_corona_typ = "bi-exclamation-triangle";
                kuerzel_corona_typ ="(?)";
                let typen_id = -1;

                if(rowe.corona_typ){
                    typen_id = rowe.corona_typ.corona_typen_id;
                    let ct = corona_typen.find(t=> t.id == typen_id);

                    if(ct){
                        kuerzel_corona_typ = ct.kuerzel;
                        bi_corona_typ = ct.icon;
                    } else {
                        kuerzel_corona_typ ="(? Typ "+typen_id+")";
                    }
                }

                let btntxt = kuerzel_corona_typ;

                if(rowe.von){
                    von = new Date(rowe.von.replace(' ','T')).toLocaleDateString();
                } else {
                    von ="--.--.----";
                }
                btntxt += " "+von;
                
                //Bis-Datum nur bei Laientests oder unbekannten Typen anzeigen.
                if(typen_id == 1 || typen_id ==-1){
                    if(rowe.bis){
                        bis = new Date(rowe.bis.replace(' ','T')).toLocaleDateString();
                    } else {
                        bis = "--.--.----";
                    }
                    btntxt += " bis "+bis;
                }
                                            
                if(rowe.lehrer_id){
                    btntxt += " ("+rowe.lehrer_kuerzel+")";
                } else {
                    btntxt += " (__)";
                    warn +=1;
                }

                heute = new Date().toISOString();
                warn = 0;
                
                if(warn > 0){
                    btncls = "btn btn-warning";
                } else {
                    if (rowe.corona_status){ //(rowe.von <= heute && rowe.bis >= heute){
                        btncls = "btn btn-success";
                    } else {
                        btncls = "btn btn-danger";
                    }
                }

                //Liegen alle Zustimmungen/Unterschriften vor?
                btnzustimmung = null;
                /*
                btnzustimmung = $("<i></i>")
                                .addClass("bi-exclamation-triangle-fill");
                */

                $('#s'+id_sus).append(
                    $("<div></div>")
                    .addClass("m-1 float-left")
                    .append(
                        $("<div></div>")
                        .addClass('btn-group btn-group-sm')
                        .attr("role","group")
                        .append(
                                $("<i></i>")
                                .addClass("p-1 bg-secondary ")   
                                .addClass(bi_corona_typ)                                        
                            )
                        .append(
                            $("<button></button>")
                            .addClass(btncls)
                            .text(btntxt)
                            .append(btnzustimmung)
                            
                        )
                        .append(
                            $("<button></button>")
                            .addClass("btn btn-secondary")
                            .on('click', {id : rowe.id}, erledigungBearbeiten)                                       
                            .append(
                                $("<i></i>")
                                .addClass("bi-pencil")                                            
                            )
                        )
                        
                    )
                );
            });

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
                    //read_erledigung_by_gruppe($('#gruppe').val(),eigenschaft.id);
                    read_erledigung_by_schueler(erledigung.schueler_id,eigenschaft.id);
                    
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

                    speicher_mitteilungen();
                    
                    speicher_coronatyp();
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
                    //verlagert in success von speicher_coronatyp
                    //read_erledigung_by_gruppe($('#gruppe').val(),eigenschaft.id);

                    response = json;
                    erledigung.id = response.id;
                    erledigung.corona_typ = response.corona_typ;
                    erledigung.schueler_id = response.schueler_id;
                    
                    speicher_mitteilungen();

                    speicher_coronatyp();

                },
                error: function (e) {
                    console.log(e.message);
                    alert(e.message);
                },
                dataType: "json",
                contentType: "application/json"
            }); 
        }


        function speicher_coronatyp(){
            let ctyp = $("input[name='corona_typen_radios']:checked").val();

            if(!ctyp){
                //read_erledigung_by_gruppe($('#gruppe').val(),eigenschaft.id);
                read_erledigung_by_schueler(erledigung.schueler_id,eigenschaft.id);

                return;
                
            }

            let data = { erledigung_id : erledigung.id,
                         corona_typen_id : ctyp};

            let type = 'POST';            
            let url = '';
            if(erledigung.corona_typ.id){
                type = 'PUT';
                url = '/'+erledigung.corona_typ.id
            }

            let formdata = JSON.stringify(data);                    

            $.ajax({
                type: type,
                url: '/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/corona/coronatyp'+url,
                data: formdata,
                success: function (json) {
                    //read_erledigung_by_gruppe($('#gruppe').val(),eigenschaft.id);
                    read_erledigung_by_schueler(erledigung.schueler_id,eigenschaft.id);
                },
                error: function (e) {
                    console.log(e.message);
                    alert(e.message);
                },
                dataType: "json",
                contentType: "application/json"
            });

            console.log("Corona-Typ elr#"+erledigung.id+" typ"+ctyp+ " "+type);
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
            			
			$('#gruppe').change(handle_gruppenwechsel);

            $('#btn_mitteilung_neu_eltern').click(function(){btn_mitteilung_neu_eltern();});
            $('#btn_mitteilung_neu').click(function(){btn_mitteilung_neu();});
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




		function handle_gruppenwechsel(){
			read_erledigung_by_gruppe($('#gruppe').val(),eigenschaft.id);
			
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
            //$('#bis').val(new Date(eigenschaft.default_bis).toISOString().substr(0,10));
            $('#bis').val('');
            $('#lehrer').val(user_lehrer_id);
            
            $('#mitteilungneu').val(null);
            $('#mitteilung').empty();

            $('#erledigungModalLabel').text(eigenschaft.name +' - Neue Erledigung hinzufügen');
            read_schueler(schueler_id);

            erledigung.id = null;

            $('#erledigungModal').modal('show');

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
                    
                    if(erledigung.corona_typ){
                        let ct = erledigung.corona_typ.corona_typen_id;                        
                        let radio = $('#corona_typen_radio-'+ct);

                        if(!radio){
                            console.log('Uiuiui - Coronatyp '+ct+' gibt es nicht...');
                        } else {
                            radio.prop('checked',true);
                        }

                    } else {
                        let radios = $("input[name='corona_typen_radios']");
                        radios.prop('checked',false);
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
                        read_erledigung_by_gruppe(aktiv_gruppe_id, eigenschaft.id);
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
             * Corona-Typen lesen
             */
            function read_corona_typen(event) {
                $.ajax({
                    url:  "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/corona/typen",                    
                    type: "GET",
                    success: function (data) {
                        var response = $.parseJSON(data);
                        corona_typen = response;

                        $("#corona_typen").empty();                        
                        response.forEach(row => {

                            $("#corona_typen").append(
                                    $("<div></div")
                                    .addClass("row m-1 input-group form-check")
                                    .append(
                                        $("<input>")
                                        .addClass("form-check-input")
                                        .attr('type', 'radio')
                                        .attr('name', 'corona_typen_radios')
                                        .attr('id','corona_typen_radio-'+row.id)
                                        .attr('value',row.id)
                                    )
                                    .append(
                                        $("<label></label>")
                                        .addClass("form-check-label")
                                        .attr('for', 'corona_typen_radio-'+row.id)
                                        .text(row.name)
                                    )
                                );                            
                        });

                    
                        
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


    </script>

</body>

</html>