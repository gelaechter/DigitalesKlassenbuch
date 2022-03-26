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
                    <div class="input-group-prepend">
                        <span class="input-group-text">SchülerIn
                            <i class="bi-people pl-2"></i></span>
                    </div>
                    <select class="form-control" name="schueler" id="schueler"></select>
                </div>   
                
            </div>
        </div>
    </section>


    <section>
        <div class="container-fluid  bg-secondary text-white">
            
            <div class="row mt-3 pt-3 pb-3">             

                <div class="input-group col-md">
                    <button class="btn btn-success" id="btn_abmeldung" onclick="init_sitzplan()">
                        <i class="bi-arrow-up-right-square pr-2"></i>neue Krankmeldung
                    </button>
                </div>    


                <div class="input-group col-md">
                    <button class="btn btn-info" id="btn_beurlaubung" onclick="init_sitzplan()">
                        <i class="bi-calendar-range pr-2"></i>Beurlaubung
                    </button>
                </div>    
                
            </div>
        </div>
    </section>
    

<section>
        <div class="container-fluid  text-black">
            
            <div class="row mt-3 pt-3 pb-3 bg-warning" id="vorgang-123">             

                <div class="input-group col-md-1">
                    <button class="btn btn-secondary" data-toggle="collapse" data-target="#collapse-123">
                        <i class="bi-arrow-down-square pr-2"></i><123>
                    </button>
                </div>    

                <div class="col md-2">
                    vom 12.09.2021, 07:45
                </div>

                <div class="col md-2">
                    bis einschl. 16.09.2021, 20:00
                </div>

                <div class="col md-2">
                    <i>Entschuldigung</i>
                </div>

                <div class="col md-3">
                    Warten auf Anerkennung durch Schule
                </div>

                <div class="input-group col-md-1">
                    <button class="btn btn-secondary" id="btn_mitteilung-123" onclick="neue_mitteilung(123)">
                        <i class="bi-chat-left-text pr-2"></i>Mitteilung hinzufügen
                    </button>
                </div>    

                <div class="input-group col-md-1">
                    <button class="btn btn-secondary" id="btn_loeschen-123" onclick="loeschen(123)">
                        <i class="bi-trash pr-2"></i>löschen
                    </button>
                </div>                   
            </div>

            <div class="collapse" id="collapse-123">
                <div class="card" id="mitteilungen-123">                    
                    <div class="card-header">Mitteilungen zum Vorgang </div>
                    <div class="card-body">
                        <div class="row" id="mitteilung-59">
                            19.09., 15:18 / marvin.meyer : Gesundmeldung via Browser, IP 12.64.32.123
                        </div>
                        <div class="row" id="mitteilung-59">
                            14.09., 08:18 / marvin.meyer : Dauert wohl bis Freitag
                        </div>
                        <div class="row" id="mitteilung-59">
                            12.09., 07:15 / simone.kirschke : Bestätigung durch Erziehungsberechtigte, Anruf im Sekretariat
                        </div>    
                        <div class="row" id="mitteilung-56">
                            11.09., 23:54 / marvin.meyer : Krankmeldung via Browser, IP 12.64.32.123
                        </div>                        
                    </div>                    
                </div>
                <div class="card" id="unterrichte-123">                    
                    <div class="card-header">betroffene Unterrichte</div>
                    <div class="card-body">
                        <div class="row" id="unterricht-59">
                            16.09., 13:45 - wn3 Wn / VG - #753: Gerechtes handeln in China
                        </div>
                        <div class="row text-info" id="unterricht-59">
                            16.09., 11:25 - MA1 Ma / UL (nach Plan)
                        </div>
                        <div class="row" id="unterricht-59">
                            16.09., 09:35 - PH55 Ph / SD - #741: E-Feld am Kondensator
                        </div>
                        <div class="row" id="unterricht-59">
                            16.09., 07:45 - de2 De / JM - #723: Die Glocke
                        </div>

                        <div class="row text-info" id="unterricht-59">
                            15.09., 13:45 - ek1 Ek / JS (nach Plan)
                        </div>
                        <div class="row text-info" id="unterricht-59">
                            15.09., 11:25 - CH1 Ch / PF (nach Plan)
                        </div>
                        <div class="row text-info" id="unterricht-59">
                            15.09., 09:35 - MA1 Ma / UL (nach Plan)
                        </div>
                        <div class="row" id="unterricht-59">
                            15.09., 07:45 - en1 En / LT - #695: He or his in the world
                        </div>
                        
                    </div>                    
                </div>
            </div>




            <div class="row mt-3 pt-3 pb-3 bg-success" id="vorgang-105">             

                <div class="input-group col-md-1">
                    <button class="btn btn-secondary" data-toggle="collapse" data-target="#collapse-105">
                        <i class="bi-arrow-down-square pr-2"></i><105>
                    </button>
                </div>    

                <div class="col md-2">
                    vom 02.09.2021, 07:45
                </div>

                <div class="col md-2">
                    bis einschl. 02.09.2021, 09:15
                </div>

                <div class="col md-2">
                    <i>Entschuldigung</i>
                </div>

                <div class="col md-3">
                    Entschuldigung gültig
                </div>

                <div class="input-group col-md-1">
                    <button class="btn btn-secondary" id="btn_mitteilung-123" onclick="neue_mitteilung(123)">
                        <i class="bi-chat-left-text pr-2"></i>Mitteilung hinzufügen
                    </button>
                </div>    

                <div class="input-group col-md-1">
                    <button class="btn btn-secondary" id="btn_loeschen-123" onclick="loeschen(123)" disabled>
                        <i class="bi-trash pr-2"></i>löschen
                    </button>
                </div>                   
            </div>

            <div class="collapse" id="collapse-105">
                <div class="card" id="mitteilungen-123">                    
                    <div class="card-header">Mitteilungen zum Vorgang </div>
                    <div class="card-body">
                        <div class="row" id="mitteilung-59">
                            04.09., 10:41 / simone.kirschke : Entschuldigungsbogen eingescannt.
                        </div>                    
                        <div class="row" id="mitteilung-59">
                            02.09., 13:21 / marvin.meyer : Gesundmeldung via Browser, IP 12.64.32.123
                        </div>                    
                        <div class="row" id="mitteilung-56">
                            01.09., 23:54 / marvin.meyer : Krankmeldung via Browser, IP 12.64.32.123 - Arzttermin
                        </div>                        
                    </div>                    
                </div>
                <div class="card" id="unterrichte-123">                    
                    <div class="card-header">betroffene Unterrichte</div>
                    <div class="card-body">
                        <div class="row" id="unterricht-59">
                            02.09., 07:45 - wn3 Wn / VG - #753: Gerechtes handeln in Albanien
                        </div>
                    </div>                    

                </div>
            </div>



            <div class="row mt-3 pt-3 pb-3 bg-info" id="vorgang-98">             

                <div class="input-group col-md-1">
                    <button class="btn btn-secondary" data-toggle="collapse" data-target="#collapse-98">
                        <i class="bi-arrow-down-square pr-2"></i><98>
                    </button>
                </div>    

                <div class="col md-2">
                    vom 25.08.2021, 07:45
                </div>

                <div class="col md-2">
                    bis einschl. 26.08.2021, 15:15
                </div>

                <div class="col md-2">
                    <i>Beurlaubung</i>
                </div>

                <div class="col md-3">
                    Beurlaubung gültig
                </div>

                <div class="input-group col-md-1">
                    <button class="btn btn-secondary" id="btn_mitteilung-123" onclick="neue_mitteilung(123)">
                        <i class="bi-chat-left-text pr-2"></i>Mitteilung hinzufügen
                    </button>
                </div>    

                <div class="input-group col-md-1">
                    <button class="btn btn-secondary" id="btn_loeschen-123" onclick="loeschen(123)" disabled>
                        <i class="bi-trash pr-2"></i>löschen
                    </button>
                </div>                   
                </div>

                <div class="collapse" id="collapse-98">
                <div class="card" id="mitteilungen-123">                    
                    <div class="card-header">Mitteilungen zum Vorgang </div>
                    <div class="card-body">                        
                        <div class="row" id="mitteilung-59">
                            21.08., 13:21 / arne.ulrichs : Anerkennung durch Schulleitung
                        </div>                    
                        <div class="row" id="mitteilung-56">
                            20.08., 23:54 / marvin.meyer : Urlaubsantrag via Browser, IP 12.64.32.123 - Arzttermin
                        </div>                        
                    </div>                    
                </div>

                <div class="card" id="unterrichte-123">                    
                    <div class="card-header">betroffene Unterrichte</div>
                    <div class="card-body">
                        <div class="row" id="unterricht-59">
                            02.09., 07:45 - wn3 Wn / VG - #753: Gerechtes handeln in Albanien
                        </div>
                    </div>                    

                </div>
                </div>



        </div>
    </section>
    

    
    <section>
        <div class="container-fluid text-secondary">
            <div class="row mt-3">                            
                <h4>Offene Absenzen</h4>
            </div>
            
            <div class="row my-1 bg-warning">                            
                24.09., 09:35 - PH55 Ph / SD - #892: Der Kondensator
            </div>
            <div class="row my-1 bg-warning">                            
                24.09., 07:45 - de1 De / JM - #894: Das Pronomen 
            </div>

        </div>
    </section>



    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script>
       
        
        //Sitzplan UL Anfang Statusobjekt
        
        aktiv_gruppe_id = <?php echo $_SESSION['aktiv_gruppe_id'] ?: 'null' ?>;
        aktiv_sitzplan_id = <?php echo $_SESSION['aktiv_sitzplan_id'] ?: 'null' ?>;
        user_lehrer_id = <?php echo $_SESSION['user_lehrer_id'] ?: 'null' ?>;

        var sitzplan = {};

        
        

        /**
         * Lesen aller Lehrer fuer die Schülerauswahl
         * Serverseitig werden nur Lehrern alle Schüler angeboten, Schüler können nur sich selektieren.
         *
         */
        function read_schueler(event) {
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/lehrer",
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                    $("#schueler").find('option').remove().end().append(new Option('', -1));
                    response.forEach(row => {
                        $("#schueler").append(
                            new Option(row.kuerzel + " - " + row.nachname, row.id));
                    });
                }
            });
        }



        $("document").ready(function () {
            
        });

        


    </script>

</body>

</html>