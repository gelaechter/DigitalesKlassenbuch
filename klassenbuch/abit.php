<?php
require './auth.php'
//require '../../openid/auth.php';
?>

<!DOCTYPE html>
<html>
<li>Patrick versucht es wieder</li>
<li>test 2</li>

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
                        <option selected>ABIT-Eigenschaft</option>
                    </select>
                </div>

                <div class="input-group col-md">
                    <button class="btn btn-secondary" id="kopiespeichern" onclick="abit_neu()">
                        <i class="bi-plus-square pr-2"></i>ABIT auferlegen oder zurückziehen
                    </button>
                </div>




            </div>
        </div>
    </section>





    <section>
        <div class="container-fluid  bg-dark text-white" id="liste">


        </div>
    </section>



    <!-- Formular fuer das Auferlegen UND Zurückziehen von ABIT -->

    <div class="modal fade" id="abitNeuModal" tabindex="-1" aria-labelledby="abitNeuModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title" id="abitNeuModalLabel">ABIT Verpflichtung einer Gruppe auferlegen oder zurückziehen</h5>
                </div>

                <div class="modal-body">
                    <div class="container-fluid">
                        <form class="m-3 p-3 bg-dark needs-validation" novalidate>

                            <!-- 5 Zeilen mit den Testtagen -->
                            <div class="row py-2">
                                <div class="input-group col-md-6" data-bs-toggle="tooltip" data-bs-placement="top" title="Wähle das 1. ABIT-Testdatum">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <!-- Datum -->
                                            <i class="bi-calendar-date px-2"></i>1. Testung am
                                        </span>
                                    </div>
                                    <input class="form-control" type="date" name="von" id="von1" required>
                                </div>

                            </div>
                            <div class="row py-2">

                                <div class="input-group col-md-6" data-bs-toggle="tooltip" data-bs-placement="top" title="Wähle das 2. ABIT-Testdatum">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <!-- Datum -->
                                            <i class="bi-calendar-date px-2"></i>2. Testung am
                                        </span>
                                    </div>
                                    <input class="form-control" type="date" name="von" id="von2" required>
                                </div>

                            </div>
                            <div class="row py-2">

                                <div class="input-group col-md-6" data-bs-toggle="tooltip" data-bs-placement="top" title="Wähle das 3. ABIT-Testdatum">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <!-- Datum -->
                                            <i class="bi-calendar-date px-2"></i>3. Testung am
                                        </span>
                                    </div>
                                    <input class="form-control" type="date" name="von" id="von3" required>
                                </div>

                            </div>
                            <div class="row py-2">

                                <div class="input-group col-md-6" data-bs-toggle="tooltip" data-bs-placement="top" title="Wähle das 4. ABIT-Testdatum">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <!-- Datum -->
                                            <i class="bi-calendar-date px-2"></i>4. Testung am
                                        </span>
                                    </div>
                                    <input class="form-control" type="date" name="von" id="von4" required>
                                </div>

                            </div>
                            <div class="row py-2">

                                <div class="input-group col-md-6" data-bs-toggle="tooltip" data-bs-placement="top" title="Wähle das 5. ABIT-Testdatum">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <!-- Datum -->
                                            <i class="bi-calendar-date px-2"></i>5. Testung am
                                        </span>
                                    </div>
                                    <input class="form-control" type="date" name="von" id="von5" required>
                                </div>

                            </div>

                            <div class="row py-2">
                                <div class="col-md-12">
                                    <i>Um vorhandene ABIT-Eintragungen für die selektierte Gruppe zu entfernen, mit den Feldern 1. Testung am und 2. Testung am den Zeitraum für die zu löschenden Einträge definieren
                                </div>
                                <div class="col-md-12">
                                    <h3><span id="abitNeuModalSpeichernFortschritt"></span></h3>
                                </div>
                            </div>

                    </div>
                </div>


                <div class="modal-footer">

                    <div class="col-auto">
                        <button class="btn btn-secondary float-right ml-3" type="button" id="abitcancel">
                            <i class="bi-journal-x px-2"></i>Abbrechen
                        </button>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-success float-right ml-3" type="button" id="abitspeichern">
                            <i class="bi-journal-check px-2"></i>ABIT eintragen
                        </button>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-danger float-right ml-3" type="button" id="abitloeschen">
                            <i class="bi-trash px-2"></i>ABIT löschen
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- Formular fuer das Anlegen/Aendern von ABIT Einzeleinträgen -->

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
                                            <i class="bi-calendar-date px-2"></i>ab
                                        </span>
                                    </div>
                                    <input class="form-control" type="date" name="von" id="von" required>
                                </div>

                                <div class="input-group col-md-6" data-bs-toggle="tooltip" data-bs-placement="top" title="Wähle das Enddatum der Gültigkeit">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <!-- Datum -->
                                            <i class="bi-calendar-date px-2"></i>bis
                                        </span>
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
                            <div class="input-group mb-3">
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha384-vtXRMe3mGCbOeY7l30aIg8H9p3GdeSe4IFlP6G8JMa7o7lXvnz3GFKzPxzJdPfGK"></script>

    <script>
        //Sitzplan UL Anfang Statusobjekt

        aktiv_gruppe_id = <?php echo $_SESSION['aktiv_gruppe_id'] ?: 'null' ?>;
        aktiv_sitzplan_id = <?php echo $_SESSION['aktiv_sitzplan_id'] ?: 'null' ?>;
        user_lehrer_id = <?php echo $_SESSION['user_lehrer_id'] ?: 'null' ?>;




        // Tooltips initialisieren
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });



        schueler = {};

        schuelerliste = [];

        erledigung = {
            id: null,
            id_schueler: null,
            id_lehrer: null,
            von: null,
            bis: null,
            mitteilung: [],
            zustimmung: [],
            zustimmung_offen: 0,
            mitteilung_count: 0
        };

        eigenschaft = {
            id: 4,
            name: 'ABIT',
            default_bis: '2022-08-01',
            default_click: 2
        };

        var mitteilung = {};


        var abit_save_queue = [];


        /**
         * Lesen aller Lehrer fuer die Schülerauswahl
         * Serverseitig werden nur Lehrern alle Schüler angeboten, Schüler können nur sich selektieren.
         *
         */
        function read_erledigung_by_gruppe(id_g, id_e) {
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/erledigung/gruppe/" + id_g + "/eigenschaft/" + id_e,
                type: "GET",
                success: function(data) {
                    var response = $.parseJSON(data);

                    corona = [];

                    $("#liste").empty();
                    schuelerliste = [];

                    response.forEach(row => {

                        let namenstext = row.vorname + ' ' + row.nachname;

                        if (row.belegung_jetzt == 0) {
                            let ende = new Date(row.ende.replace(' ', 'T')).toLocaleDateString();
                            namenstext = '(' + row.vorname + ' ' + row.nachname + ' bis ' + ende + ')';
                        }

                        if (row.belegung_jetzt == 1) {
                            schuelerliste.push(row);
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
                                .attr('id', 's' + row.id)
                                .append(
                                    $("<div></div>")
                                    .addClass("m-1 float-left")
                                    .append(
                                        $("<button></button>")
                                        .addClass("btn btn-sm btn-secondary")
                                        .on('click', {
                                            id: row.id
                                        }, erledigungneu)
                                        .append(
                                            $("<i></i>")
                                            .addClass("bi-plus-square")
                                        )
                                    )
                                )
                            )
                        );

                        row.erledigung.forEach(rowe => {


                            warn = 0;

                            if (rowe.von) {
                                von = new Date(rowe.von.replace(' ', 'T')).toLocaleDateString();
                            } else {
                                von = "--.--.----";
                                warn += 1;
                            }

                            if (rowe.bis) {
                                bis = new Date(rowe.bis.replace(' ', 'T')).toLocaleDateString();
                            } else {
                                bis = "--.--.----";
                                warn += 1;
                            }
                            btntxt = von + " bis " + bis;


                            heute = new Date().toISOString();

                            if (rowe.lehrer_id) {
                                btntxt += " (" + rowe.lehrer_kuerzel + ")";
                                if (rowe.von <= heute && rowe.bis >= heute) {
                                    btncls = "btn btn-success";
                                } else {
                                    btncls = "btn btn-info";
                                }
                            } else {
                                btntxt += " (__)";

                                if (rowe.von <= heute && rowe.bis >= heute) {
                                    btncls = "btn btn-danger";
                                } else {
                                    btncls = "btn btn-dark";
                                }
                            }





                            //Liegen alle Zustimmungen/Unterschriften vor?
                            btnzustimmung = null;
                            /*
                            btnzustimmung = $("<i></i>")
                                            .addClass("bi-exclamation-triangle-fill");
                            */

                            $('#s' + row.id).append(
                                $("<div></div>")
                                .addClass("m-1 float-left")
                                .append(
                                    $("<div></div>")
                                    .addClass('btn-group btn-group-sm')
                                    .attr("role", "group")
                                    .append(
                                        $("<button></button>")
                                        .addClass(btncls)
                                        .text(btntxt)
                                        .append(btnzustimmung)

                                    )
                                    .append(
                                        $("<button></button>")
                                        .addClass("btn btn-secondary")
                                        .on('click', {
                                            id: rowe.id
                                        }, erledigungBearbeiten)
                                        .append(
                                            $("<i></i>")
                                            .addClass("bi-pencil")
                                        )
                                    )

                                )
                            );
                        });



                    });


                }
            });
        }



        function speichern() {

            if ($('#txt_mitteilung_neu').val() != '') {
                btn_mitteilung_neu();
            }

            if (erledigung.id) {
                update_erledigung();
            } else {
                insert_erledigung();
            }
        }


        function loeschen() {
            var formdata = JSON.stringify({
                geloescht: 1
            });

            $.ajax({
                type: 'PUT',
                url: '/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/erledigung/' + erledigung.id,
                data: formdata,
                success: function(json) {
                    $('#erledigungModal').modal('hide');
                    read_erledigung_by_gruppe($('#gruppe').val(), eigenschaft.id);
                },
                error: function(e) {
                    console.log(e.message);
                    alert(e.message);
                },
                dataType: "json",
                contentType: "application/json"
            });
        }



        function update_erledigung() {

            lehrer_id = $('#lehrer').val();
            if (lehrer_id < 0) {
                lehrer_id = null;
            }

            von = $('#von').val();
            if (von == '') {
                von = null;
            }

            bis = $('#bis').val();
            if (bis == '') {
                bis = null;
            }


            var formdata = JSON.stringify({
                von: von,
                bis: bis,
                lehrer_id: lehrer_id

            });

            $.ajax({
                type: 'PUT',
                url: '/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/erledigung/' + erledigung.id,
                data: formdata,
                success: function(json) {
                    $('#erledigungModal').modal('hide');
                    read_erledigung_by_gruppe($('#gruppe').val(), eigenschaft.id);

                    speicher_mitteilungen();
                },
                error: function(e) {
                    console.log(e.message);
                    alert(e.message);
                },
                dataType: "json",
                contentType: "application/json"
            });
        }


        function insert_erledigung() {

            lehrer_id = $('#lehrer').val();
            if (lehrer_id < 0) {
                lehrer_id = null;
            }

            von = $('#von').val();
            if (von == '') {
                von = null;
            }

            bis = $('#bis').val();
            if (bis == '') {
                bis = null;
            }


            var formdata = JSON.stringify({
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
                success: function(json) {
                    $('#erledigungModal').modal('hide');
                    read_erledigung_by_gruppe($('#gruppe').val(), eigenschaft.id);

                    response = $.parseJSON(json);
                    erledigung.id = response.id;
                    speicher_mitteilungen();

                },
                error: function(e) {
                    console.log(e.message);
                    alert(e.message);
                },
                dataType: "json",
                contentType: "application/json"
            });
        }



        function speicher_mitteilungen() {
            speicher_mitteilungen_chunk(0);
        }

        function speicher_mitteilungen_chunk(id) {

            if (id >= erledigung.mitteilung.length) {
                return;
            }

            mtg = erledigung.mitteilung[id];

            if ((mtg.id == -1 && mtg.geloescht == 1) || (mtg.id >= 0 && mtg.geloescht == 0)) {
                speicher_mitteilungen_chunk(id + 1);
                return;
            }

            let type = null;
            if (mtg.id == -1 && mtg.geloescht == 0) {
                type = 'POST';
                url = '/mitteilung';
                data = {
                    mitteilung: mtg.mitteilung,
                    eltern: mtg.eltern,
                    erledigung_id: erledigung.id
                };
            }

            if (mtg.id >= 0 && mtg.geloescht == 1) {
                type = 'PUT';
                url = '/mitteilung/' + mtg.id;
                data = {
                    geloescht: 1
                };
            }

            if (type) {
                let formdata = JSON.stringify(data);

                $.ajax({
                    type: type,
                    url: '/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api' + url,
                    data: formdata,
                    success: function(json) {
                        speicher_mitteilungen_chunk(id + 1);

                    },
                    error: function(e) {
                        console.log(e.message);
                        alert(e.message);
                    },
                    dataType: "json",
                    contentType: "application/json"
                });
            }

        }





        $("document").ready(function() {
            read_gruppen();
            read_lehrer();

            $("#speichern").click(function() {
                speichern();
            });
            $("#loeschen").click(function() {
                loeschen();
            });
            $("#cancel").click(function() {
                $("#erledigungModal").modal('hide');
            }); //Änderung UL Modal, vorher: $("#unterricht").hide();

            $("#abitcancel").click(function() {
                $("#abitNeuModal").modal('hide');
            });
            $("#abitspeichern").click(function() {
                abitspeichern();
            });
            $("#abitloeschen").click(function() {
                abitloeschen();
            });

            $('#gruppe').change(handle_gruppenwechsel);

            $('#btn_mitteilung_neu_eltern').click(function() {
                btn_mitteilung_neu_eltern();
            });
            $('#btn_mitteilung_neu').click(function() {
                btn_mitteilung_neu();
            });
        });


        function mitteilung_loeschen(index) {
            let mtg = erledigung.mitteilung[index];
            mtg.geloescht = 1;
            zeige_mitteilungen();
        }

        function btn_mitteilung_neu_eltern() {
            if (!mitteilung.eltern) {
                mitteilung.eltern = 1;
                $('#spn_mitteilung_neu_eltern').removeClass().addClass("bi-person-check-fill pr-2");
                $('#btn_mitteilung_neu_eltern').removeClass().addClass("btn btn-info");
            } else {
                mitteilung.eltern = 0;
                $('#spn_mitteilung_neu_eltern').removeClass().addClass("bi-person-check pr-2");
                $('#btn_mitteilung_neu_eltern').removeClass().addClass("btn btn-secondary");
            }
        }

        function btn_mitteilung_neu() {

            mitteilung.id = -1;
            mitteilung.mitteilung = $('#txt_mitteilung_neu').val();
            mitteilung.erledigung_id = erledigung.id;
            mitteilung.created_at = new Date();
            mitteilung.geloescht = 0;


            erledigung.mitteilung.unshift(mitteilung);

            $('#txt_mitteilung_neu').val("");

            mitteilung = {
                id: -1,
                eltern: 1
            };
            btn_mitteilung_neu_eltern();

            zeige_mitteilungen();

        }




        function handle_gruppenwechsel() {
            read_erledigung_by_gruppe($('#gruppe').val(), eigenschaft.id);

        }


        function erledigungBearbeiten(event) {
            id = event.data.id;
            console.log("edit er " + id);


            $('#von').val(new Date().toISOString());
            $('#bis').val(new Date(eigenschaft.default_bis).toISOString());
            $('#mitteilungneu').val(null);
            $('#mitteilung').empty();

            $('#erledigungModalLabel').text(eigenschaft.name + ' - Erledigung #' + id + ' bearbeiten');
            read_erledigung(id);

            $('#erledigungModal').modal('show');
        }


        function erledigungneu(event) {
            schueler_id = event.data.id;
            console.log("neu er " + schueler_id);


            $('#von').val(new Date().toISOString().substr(0, 10));
            $('#bis').val(new Date(eigenschaft.default_bis).toISOString().substr(0, 10));
            $('#lehrer').val(user_lehrer_id);

            $('#mitteilungneu').val(null);
            $('#mitteilung').empty();

            $('#erledigungModalLabel').text(eigenschaft.name + ' - Neue Erledigung hinzufügen');
            read_schueler(schueler_id);

            erledigung.id = null;

            $('#erledigungModal').modal('show');

        }


        function read_erledigung(id) {
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/erledigung/" + id,
                type: "GET",
                success: function(data) {
                    var response = $.parseJSON(data);
                    console.log(response);

                    erledigung = response;

                    if (erledigung.von) {
                        erledigung.von = new Date(erledigung.von.substr(0, 10)).toISOString().substr(0, 10);
                    }
                    if (erledigung.bis) {
                        erledigung.bis = new Date(erledigung.bis.substr(0, 10)).toISOString().substr(0, 10);
                    }

                    $('#von').val(erledigung.von);
                    $('#bis').val(erledigung.bis);

                    if (erledigung.lehrer_id) {
                        $('#lehrer').val(erledigung.lehrer_id);
                    } else {
                        $('#lehrer').val(user_lehrer_id);
                    }


                    $('#erledigungModalLabel').text(erledigung.eigenschaft.name + ' - Erledigung #' + id + ' von ' + erledigung.schueler.vorname + ' ' + erledigung.schueler.nachname + ' bearbeiten');

                    zeige_mitteilungen();


                },
                error: function(e) {
                    console.log(e.message);
                }
            });
        }



        function zeige_mitteilungen() {
            $('#mitteilung').empty();

            erledigung.mitteilung.filter(mtg => mtg.geloescht == 0).forEach(mitteilung => {

                let mtg_von = new Date(mitteilung.created_at);

                let mtg_text = mtg_von.toLocaleString() + ' - ' + mitteilung.mitteilung;

                let vonEltern = null;
                if (mitteilung.eltern == 1) {
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
                            .click(function() {
                                mitteilung_loeschen(erledigung.mitteilung.indexOf(mitteilung));
                            })
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
                success: function(data) {
                    var response = $.parseJSON(data);
                    $("#gruppe").find('option').remove().end().append(new Option('(Gruppe wählen)', -1));
                    response.forEach(row => {
                        $("#gruppe").append(new Option(row.name, row.id));
                    });

                    if (aktiv_gruppe_id) {
                        $('#gruppe').val(aktiv_gruppe_id);
                        read_erledigung_by_gruppe(aktiv_gruppe_id, eigenschaft.id);
                    }
                },
                error: function(e) {
                    console.log(e.message);
                }
            });
        }


        /**
         * Lehrer lesen
         */
        function read_lehrer(event) {
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/lehrer",
                type: "GET",
                success: function(data) {
                    var response = $.parseJSON(data);
                    $("#lehrer").find('option').remove().end().append(new Option('', -1));
                    response.forEach(row => {
                        $("#lehrer").append(new Option(row.kuerzel + " - " + row.nachname, row.id));
                    });

                    // Lehrer aus der SESSION setzen                        
                    $("#lehrer").val(<?php echo $_SESSION['user_lehrer_id']; ?>);

                }
            });
        }


        /**
         * einzelnen Schüler lesen
         */
        function read_schueler(id) {
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/schueler/" + id,
                type: "GET",
                success: function(data) {
                    var response = $.parseJSON(data);

                    schueler = response;

                    $('#erledigungModalLabel').text(eigenschaft.name + ' - Neue Erledigung für ' + response.vorname + ' ' + response.nachname + ' hinzufügen');

                }
            });
        }


        function abit_neu() {
            $('#abitNeuModal').modal('show');

            console.log('anm');

            let gruppe_id = $('#gruppe').val();
            let gruppe = $('#gruppe option:selected').text();

            if (!gruppe_id || gruppe_id < 0) {
                alert("Zuerst eine Gruppe selektieren!");
                return;
            }

            $('#abitNeuModalLabel').text("ABIT-Verpflichtung für SuS der Gruppe " + gruppe + " auferlegen / löschen");
        }


        function abitspeichern() {

            von = [];
            bis = [];
            vonISO = [];
            bisISO = [];
            dates = 0;

            for (let i = 0; i < 5; i++) {
                let datepicker = $('#von' + (i + 1)).val();
                if (datepicker == '') {
                    von[i] = null;
                    vonISO[i] = null;
                } else {
                    von[i] = new Date(datepicker);
                    bis[i] = new Date(von[i]);
                    bis[i].setDate(bis[i].getDate() + 1);

                    vonISO[i] = von[i].toISOString().substr(0, 10);
                    bisISO[i] = bis[i].toISOString().substr(0, 10);
                    console.log(vonISO[i] + " bis " + bisISO[i]);
                    dates++;
                }

                console.log('ABIT ' + (i + 1) + ' am ' + von[i] + ' gültig bis ' + bis[i]);


            }

            abit_save_queue = [];
            schuelerliste.forEach(sus => {
                for (let i = 0; i < dates; i++) {

                    let formdata = JSON.stringify({
                        von: vonISO[i],
                        bis: bisISO[i],
                        schueler_id: sus.id,
                        eigenschaft_id: eigenschaft.id
                    });


                    //Prüfen, ob schon eine ABIT-Verfplichtung für den Zeitraum besteht
                    let treffer = false;
                    sus.erledigung.forEach(er => {
                        if (er.von.substr(0, 10) == vonISO[i]) {
                            treffer = true;
                        }
                    });

                    if (treffer) {
                        console.log("Bereits vorhandene ABIT Auferlegung SuS " + sus.vorname + " " + sus.nachname + " am " + vonISO[i]);
                    } else {
                        console.log("Neue ABIT Auferlegung SuS " + sus.vorname + " " + sus.nachname + " am " + vonISO[i]);
                        abit_save_queue.push(formdata);
                    }
                }
            });

            save_abit_queue();

        }

        function save_abit_queue() {
            if (abit_save_queue.length > 0) {

                $('#abitNeuModalSpeichernFortschritt').text("Noch zu speichernde ABIT-Auferlegungen: " + abit_save_queue.length);

                let formdata = abit_save_queue.pop();
                console.log(" abs formdata: " + formdata);

                $.ajax({
                    type: 'POST',
                    url: '/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/erledigung',
                    data: formdata,
                    success: function(json) {
                        save_abit_queue();
                    },
                    error: function(e) {
                        console.log(e.message);
                        alert(e.message);
                    },
                    dataType: "json",
                    contentType: "application/json"
                });

            } else {
                $('#abitNeuModalSpeichernFortschritt').text("Alle ABIT-Auferlegungen sind gespeichert.");
                read_erledigung_by_gruppe($('#gruppe').val(), eigenschaft.id);

                setTimeout(function() {
                    $('#abitNeuModalSpeichernFortschritt').text("");
                    $('#abitNeuModal').modal('hide');
                }, 1000);

            }
        }


        function abitloeschen() {
            von = "";
            bis = "";
            vonISO = "";
            bisISO = "";


            let datepicker = $('#von1').val();
            if (datepicker == '') {
                alert("Startdatum nicht angegeben!");
                return;
            }
            von = new Date(datepicker);
            vonISO = von.toISOString().substr(0, 10);

            datepicker = $('#von2').val();
            if (datepicker == '') {
                alert("Enddatum nicht angegeben!");
                return;
            }
            bis = new Date(datepicker);
            bisISO = bis.toISOString().substr(0, 10);

            console.log('ABIT löschen im Zeitraum von ' + von + ' bis einschl. ' + bis);




            abit_delete_queue = [];
            schuelerliste.forEach(sus => {

                //Prüfen, ob schon eine ABIT-Verfplichtung für den Zeitraum besteht
                let treffer = false;
                sus.erledigung.forEach(er => {
                    if (er.von.substr(0, 10) >= vonISO && er.von.substr(0, 10) <= bisISO) {
                        abit_delete_queue.push(er.id);
                    }
                });

            });

            let r = confirm("Bestätigen: Für den Zeitraum wurden " + abit_delete_queue.length + " zu löschende ABIT-Auferlegungen gefunden - diese nun löschen?");
            if (r == true) {
                delete_abit_queue();
            }

        }


        function delete_abit_queue() {
            if (abit_delete_queue.length > 0) {

                $('#abitNeuModalSpeichernFortschritt').text("Noch zu löschende ABIT-Auferlegungen: " + abit_delete_queue.length);

                let id = abit_delete_queue.pop();
                let formdata = JSON.stringify({
                    geloescht: 1
                });

                console.log(" del ABIT #" + id);

                $.ajax({
                    type: 'PUT',
                    url: '/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/erledigung/' + id,
                    data: formdata,
                    success: function(json) {
                        delete_abit_queue();
                    },
                    error: function(e) {
                        console.log(e.message);
                        alert(e.message);
                    },
                    dataType: "json",
                    contentType: "application/json"
                });

            } else {
                $('#abitNeuModalSpeichernFortschritt').text("Alle zu löschenden ABIT-Auferlegungen sind gelöscht.");
                read_erledigung_by_gruppe($('#gruppe').val(), eigenschaft.id);

                setTimeout(function() {
                    $('#abitNeuModalSpeichernFortschritt').text("");
                    $('#abitNeuModal').modal('hide');
                }, 1000);

            }
        }
    </script>

</body>

</html>