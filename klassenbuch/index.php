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
        <div class="container m-3 p-3 bg-secondary text-white">
            <div class="row">
                <div class="input-group col-md">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Lerngruppe
                            <i class="bi-people pl-2"></i></span>
                    </div>
                    <select class="form-control" name="gruppe" id="gruppe"></select>
                </div>

                <div class="input-group col-md">
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-dark" id="woche_zurueck_btn">
                            <i class="bi-caret-left"></i>
                        </button>
                        <button type="button" class="btn btn-dark" id="woche_aktuell_btn">
                            <i class="bi-calendar3"></i>
                        </button>
                        <button type="button" class="btn btn-dark" id="woche_vor_btn">
                            <i class="bi-caret-right"></i>
                        </button>
                    </div>
                    <input type="text" class="form-control" placeholder="Zeitraum" id="zeitraum" readonly>
                </div>
            </div>
        </div>
    </section>

    <!-- UL id "unterricht" für die Section für hide()/show()-->
    <section id="unterricht">
        <div class="container m-3 p-3 bg-secondary text-white">
            <div class="row my-2">
                <div class="input-group col-md">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Lehrer
                            <i class="bi-person pl-2"></i></span>
                    </div>
                    <select class="form-control" name="lehrer" id="lehrer" required></select>
                </div>
                <div class="input-group col-md">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Datum
                            <i class="bi-calendar-date pl-2"></i></span>
                    </div>
                    <input class="form-control" type="date" name="datum" id=datum required>
                </div>
                <div class="input-group col-md">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Stunde
                            <i class="bi-clock pl-2"></i></span>
                    </div>
                    <select class="form-control" name="ustunde" id="ustunde" required></select>
                </div>
            </div>

            <div class="row my-2">
                <div class="input-group col-md">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Fach
                            <i class="bi-easel pl-2"></i></span>
                    </div>
                    <select class="form-control" name="fach" id="fach" required></select>
                </div>
                <div class="input-group col-md">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" name="vertretung" id="vertretung">
                        </div>
                    </div>
                    <input class="form-control" type="text" class="form-control" value="Vertretung" disabled>
                </div>

                <div class="input-group col-md"></div>


            </div>

            <div class="row my-2">
                <div class="input-group col-md">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="bi-chat-right-text"></i></span>
                    </div>
                    <textarea id="inhalte" name="inhalte" rows="4" cols="30" placeholder="Inhalt der Stunde"
                        class="form-control"></textarea>
                </div>
                <div class="input-group col-md">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="bi-journal-text"></i></span>
                    </div>
                    <textarea id="aufgaben" name="aufgaben" rows="4" cols="30" placeholder="Aufgaben aus der Stunde"
                        class="form-control"></textarea>
                    <input type="range" min="0" max="120" value="30" step="10" class="form-control-range"
                        id="aufgaben_zeit" list="tickmarks">
                    <datalist id="tickmarks">
                        <option value="0" label="0 min"></option>
                        <option value="10"></option>
                        <option value="20"></option>
                        <option value="30"></option>
                        <option value="40"></option>
                        <option value="50"></option>
                        <option value="60" label="50 min"></option>
                        <option value="70"></option>
                        <option value="80"></option>
                        <option value="90"></option>
                        <option value="100"></option>
                        <option value="110"></option>
                        <option value="120" label="120 min"></option>
                    </datalist>
                    <label for="aufgaben_zeit" id="lbl_aufgaben_zeit">geplante Zeit [min]</label>
                </div>
                <div class="input-group col-md">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <i class="bi-chat-right-dots"></i></span>
                    </div>
                    <textarea id="bemerkungen" name="bemerkungen" rows="4" cols="30"
                        placeholder="Bemerkungen zur Stunde" class="form-control"></textarea>
                </div>
            </div>
            <div class="row my-2">
                <div class="col-md-12">
                    <div id="praesenzen">
                    </div>
                </div>
            </div>
            <div class="row my-2">
                <div class="col-lg-12">
                    <button class="btn btn-primary mr-2" type="submit" id="alle_praesent"><i
                            class="bi-emoji-smile pr-2"></i>alle anwesend</button>
                    <!-- <button 
                            class="btn btn-info mr-2"
                            type="submit"
                            id="alle_absent"><i class="bi-emoji-frown pr-2"></i>alle abwesend</button> -->
                    <button class="btn btn-danger float-right ml-3" type="submit" id="reset"><i
                            class="bi-journal-x pr-2"></i>Reset</button>
                    <button class="btn btn-success float-right ml-3" type="submit" id="speichern"><i
                            class="bi-journal-check pr-2"></i>Speichern</button>
                </div>
            </div>

            <!-- Sitzplan UL Anfang Auswahl in Section Neuer Unterricht-->
            <div class="row my-2">
                <div class="input-group col-md">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Sitzplan
                            <i class="bi-border pl-2"></i></span>
                    </div>
                    <select class="form-control" name="sitzplan" id="sitzplan" required></select>
                </div>
                <div class="input-group col-md">
                    <button class="btn btn-info float-right ml-3" type="submit" id="sitzplanzeigen"
                        onclick="sitzplananzeigen()"><i class="bi-journal-check pr-2"></i>Sitzplan anzeigen</button>
                </div>
            </div>
            <!-- Sitzplan UL Ende Auswahl in Section Neuer Unterricht-->

        </div>
    </section>


    <!-- Sitzplan UL Anfang Section Sitzplan-->
    <section id="sitzplansection">
        <div class="container m-3 p-3 bg-secondary text-black">
            <div class="row">

                <div class="input-group col-md">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Raum
                            <i class="bi-door-open pl-2"></i></span>
                    </div>
                    <select class="form-control" name="spl_raum" id="spl_raum" required></select>
                </div>

                <div class="input-group col-md">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Teilgruppe
                            <i class="bi-puzzle pl-2"></i></span>
                    </div>
                    <select class="form-control" name="spl_teilgruppe" id="spl_teilgruppe" required></select>
                </div>

                <div class="input-group col-md">
                    <div class="input-group-prepend">
                        <span class="input-group-text">gültig ab
                            <i class="bi-calendar-date pl-2"></i></span>
                    </div>
                    <input class="form-control" type="date" name="spl_datum_beginn" id="spl_datum_beginn" required>
                </div>

            </div>

            <div class="row mt-2">
                <div class="input-group col-md">
                    <button class="btn btn-info" id="spl_speichern" required>
                        <i class="bi-save pr-2"></i>Änderungen speichern
                    </button>
                </div>
                <div class="input-group col-md">
                    <button class="btn btn-info" id="spl_speichernals" required>
                        <i class="bi-save pr-2"></i>Kopie speichern
                    </button>
                </div>
                <div class="input-group col-md">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Name
                            <i class="bi-pencil pl-2"></i></span>
                    </div>
                    <input class="form-control" type="text" name="spl_name" id="spl_name" required>
                </div>

            </div>

            <div class="row h-auto mt-2 pt-2 border-top">
                <div class="col-sm-9">
                    <div id="plan">

                    </div>
                </div>
                <div class="col-sm-3" id="schuelerliste">
                </div>

            </div>

            <div class="row mt-2 border-top pt-2">
                <div class="input-group col-md">
                    <button class="btn btn-info" id="spl_free" required>
                        <i class="bi-dash-circle pr-2"></i>alle Plätze löschen
                    </button>
                </div>
            </div>

        </div>
    </section>
    <!-- Sitzplan UL Ende Section Sitzplan-->

    <section>
        <div class="container m-3 p-3 bg-secondary text-white">
            <div class="row">
                <table class="table" id="tbl_unterricht">
                    <thead>
                        <tr>
                            <th>Stunde</th>
                            <th>Lehrer</th>
                            <th>Fach</th>
                            <th>Inhalte</th>
                            <th>Aufgaben</th>
                            <th>Bemerkungen</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <script src="js/jquery-3.6.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>

    <script>
        montag = new Date();
        sonntag = new Date();

        wochentage = ["Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag"];
        monate = ["Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"];

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

        praesenzen = [];

        gruppe = null;

        //Sitzplan UL Anfang Statusobjekt
        sitzplan = {
            raum_id: null,
            datum_beginn: null,
            id: null,
            sitzplan_name: "",
            sitzplatz: [],
            gruppe: [],
            selectedSchueler: null,
            selectedSitzplatz: null,
            selectedText: null,
            verwendungen: 0,
            anzeigen: false,
            sitzplatz_idCounter: -1
        };

        /**
         * Returns the week number for this date.  dowOffset is the day of week the week
         * "starts" on for your locale - it can be from 0 to 6. If dowOffset is 1 (Monday),
         * the week returned is the ISO 8601 week number.
         * @param int dowOffset
         * @return int
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

        function unterricht_vorbesetzen() {
            unterricht.id = null;
            unterricht.gruppe_id = (gruppe ? gruppe.id : null);
            unterricht.lehrer_id = null;
            $("#lehrer").val(-1);
            unterricht.datum = new Date();
            unterricht.ustunde_id = null;
            $("#ustunde").val(-1);
            unterricht.fach_id = null;
            $("#fach").val(-1);
            unterricht.vertretung = 0;
            unterricht.inhalte = "";
            unterricht.aufgaben = "";
            unterricht.aufgaben_zeit = 30;
            unterricht.bemerkungen = "";

            $("#gruppe").val(unterricht.gruppe_id);
            $("#lehrer").val(unterricht.lehrer_id);
            $("#datum").val(unterricht.datum.toISOString().substr(0, 10));
            $("#ustunde").val(unterricht.ustunde_id);
            $("#fach").val(unterricht.fach_id);
            $("#vertretung").val(unterricht.vertretung);
            $("#inhalte").val(unterricht.inhalte);
            $("#aufgaben").val(unterricht.aufgaben);
            $("#aufgaben_zeit").val(unterricht.aufgaben_zeit);
            zeige_aufgaben_zeit(unterricht.aufgaben_zeit);
            $("#bemerkungen").val(unterricht.bemerkungen);

            // Praesenzen werdenauf soll-Praesenzen der Gruppe gesetzt
            // daher hier loesechen
            $("#praesenzen").find('button').remove().end();
            praesenzen = [];
        }

        function read_unterricht(id) {
            var url = "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/unterricht/"
                + id;

            $.ajax({
                url: url,
                type: "GET",
                success: function (data) {
                    unterricht_vorbesetzen();

                    var response = $.parseJSON(data);

                    unterricht.id = response.id;

                    unterricht.gruppe_id = response.gruppe_id;
                    $("#gruppe").val(unterricht.gruppe_id);

                    unterricht.lehrer_id = response.lehrer_id;
                    $("#lehrer").val(unterricht.lehrer_id);

                    unterricht.datum = response.datum;
                    $("#datum").val(unterricht.datum);

                    unterricht.ustunde_id = response.ustunde_id;
                    $("#ustunde").val(unterricht.ustunde_id);

                    unterricht.fach_id = response.fach_id;
                    $("#fach").val(unterricht.fach_id);

                    unterricht.vertretung = response.vertretung;
                    $("#vertretung").prop('checked', unterricht.vertretung == 0 ? false : true);

                    unterricht.inhalte = response.inhalte;
                    $("#inhalte").val(unterricht.inhalte);

                    unterricht.aufgaben = response.aufgaben;
                    $("#aufgaben").val(unterricht.aufgaben);

                    unterricht.aufgaben_zeit = response.aufgaben_zeit;
                    $("#aufgaben_zeit").val(unterricht.aufgaben_zeit);
                    zeige_aufgaben_zeit(unterricht.aufgaben_zeit);

                    unterricht.bemerkungen = response.bemerkungen;
                    $("#bemerkungen").val(unterricht.bemerkungen);

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
                        var cls = 'badge badge-info';
                        switch (praesenzen["s" + row.schueler_id].fehlt) {
                            case 0:
                                cls = 'badge badge-dark';
                                break;
                            case 1:
                                cls = 'badge badge-success';
                                break;
                            case 2:
                                cls = 'badge badge-danger';
                                break;
                        }

                        $("#praesenzen").append($("<button></button")
                            .addClass("btn btn-secondary btn-sm")
                            .attr('id', "s" + row.schueler_id)
                            .on('click', function () {
                                toggle_praesenz("s" + row.schueler_id);
                            })
                            .append($("<span></span>")
                                .addClass(cls)
                                .text(row.vorname + ' ' + row.nachname.substr(0, 1) + '.')));
                    });
                    console.log(praesenzen);
                },
                error: function (e) {
                    console.log(e.message);
                }
            })
        }

        function praesenzen_laut_gruppe() {
            $("#praesenzen").find('button').remove().end();
            praesenzen = [];

            var url = "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/praesenz_gruppe/"
                + unterricht.gruppe_id;

            $.ajax({
                url: url,
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);

                    response.forEach(row => {
                        praesenzen["s" + row.schueler_id] = {
                            id: row.id,
                            unterricht_id: row.unterricht_id,
                            belegung_id: row.belegung_id,
                            fehlt: row.fehlt ? row.fehlt : 0,
                            entschuldigt: row.entschuldigt ? row.entschuldigt : 0,
                            verspaetet: row.verspaetet ? row.verspaetet : '',
                            bemerkung: row.bemerkung ? row.bemerkung : ''
                        };
                        $("#praesenzen").append($("<button></button")
                            .addClass("btn btn-secondary btn-sm")
                            .attr('id', "s" + row.schueler_id)
                            .on('click', function () {
                                toggle_praesenz("s" + row.schueler_id);
                            })
                            .append($("<span></span>")
                                .addClass("badge badge-dark")
                                .text(row.vorname + ' ' + row.nachname.substr(0, 1) + '.')));
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
            fehlt %= 3;
            var cls = 'badge badge-info';
            switch (fehlt) {
                case 0:
                    cls = 'badge badge-dark';
                    break;
                case 1:
                    cls = 'badge badge-success';
                    break;
                case 2:
                    cls = 'badge badge-danger';
                    break;
            }
            $('#' + s_schueler_id).find('span').removeClass().addClass(cls);
            praesenzen[s_schueler_id].fehlt = fehlt;
        }

        /**
         * Setzt die Praesenzen für alle Schueler auf "anwesend" (1)
         */
        function alle_praesent() {
            for (var key in praesenzen) {
                var val = praesenzen[key];
                praesenzen[key].fehlt = 1;
                var cls = 'badge badge-success';
                $('#' + key).find('span').removeClass().addClass(cls);
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
                var cls = 'badge badge-danger';
                $('#' + key).find('span').removeClass().addClass(cls);
            }
            console.log(praesenzen);
        }

        /**
         * vorhandene Unterrichte fuer die Gruppe im Auswahlzeitraum lesen
         */
        function read_unterrichte(event) {
            var url = "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/unterricht/gruppe/"
                + unterricht.gruppe_id
                + "/datum/"
                + montag.toISOString().substr(0, 10)
                + "/"
                + sonntag.toISOString().substr(0, 10);
            $.ajax({
                url: url,
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                    unterrichte = response;
                    datum_old = null;
                    $("#tbl_unterricht tbody").children().remove();
                    $.each(response, function (i, row) {
                        if (row.datum != datum_old) {
                            var datum = new Date(row.datum);
                            var dat_string = wochentage[datum.getDay()] + ", " + datum.getDate() + "." + monate[datum.getMonth()];
                            $("#tbl_unterricht tbody").append(
                                $("<tr></tr>").append($("<td></td>").attr("colspan", 7).attr("class", "table-dark").text(
                                    dat_string
                                )));
                            datum_old = row.datum;
                        }
                        var tr = $("<tr></tr>");
                        tr.append($("<td></td>").text(row.ustunde.name));
                        tr.append($("<td></td>").text(row.lehrer.kuerzel));
                        if (row.vertretung && row.vertretung > 0) {
                            tr.append($("<td></td>").text("(" + row.fach.kurz + ")"));
                        } else {
                            tr.append($("<td></td>").text(row.fach.kurz));
                        }
                        tr.append($("<td></td>").text(row.inhalte));
                        if (row.aufgaben && row.aufgaben.length > 0) {
                            tr.append($("<td></td>").text("(" + row.aufgaben_zeit + "') " + row.aufgaben));
                        } else {
                            tr.append($("<td></td>"));
                        }
                        tr.append($("<td></td>").text(row.bemerkungen));
                        tr.append($("<td></td>")
                            .append($("<button></button>")
                                .addClass("btn btn-primary btn-sm")
                                .attr("onclick", "read_unterricht(" + row.id + ");")
                                .append($("<i></i>")
                                    .addClass("bi-pencil"))));
                        $("#tbl_unterricht tbody").append(tr);
                    });
                },
                error: function (e) {
                    console.log(e.message);
                }
            })
        }

        /**
         * Lesen der ausgewaelten Gruppe mit den dazugehoerigen Belegungen un Schuelern
         */
        function read_gruppe(event) {
            var url = "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/gruppe/"
                + unterricht.gruppe_id;

            $.ajax({
                url: url,
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                    gruppe = response;
                },
                error: function (e) {
                    console.log(e.message);
                }
            })
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
                    $("#gruppe").find('option').remove().end().append(new Option('', -1));
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
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/lehrer",
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
         * Lesen der Unterrichtsstunden (1 .. 11/12)
         */
        function read_ustunden(event) {
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/ustunde",
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
         * Lesen aller Faecher fur die Fach-Auswahl
         */
        function read_faecher(event) {
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/fach",
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
         * Montag der aktuellen Woche bestimmen fue die Auswahl des Zeitraums
         */
        function getMonday(d) {
            d = new Date(d);
            var day = d.getDay(),
                diff = d.getDate() - day + (day == 0 ? -6 : 1); // wg sonntag = 0
            return new Date(d.setDate(diff));
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
         * Daten speichern. Je, nachden, ob schon eine ID existiert, wird ein
         * Datensatz geaendert oder neu angelegt.
         */
        function speichern(event) {
            var method;
            var url;
            var upd = false;
            if (unterricht.id && unterricht.id > 0) {
                method = 'PUT';
                url = "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/unterricht/" + unterricht.id;
                upd = true;
            } else {
                method = 'POST';
                url = "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/unterricht";
                delete unterricht.id;
            }

            var formData = JSON.stringify(unterricht);
            $.ajax({
                type: method,
                url: url,
                data: formData,
                success: function (data) {
                    var tr = $("<tr></tr>");
                    tr.append($("<td></td>").text(data.ustunde.name));
                    tr.append($("<td></td>").text(data.lehrer.kuerzel));
                    if (data.vertretung && data.vertretung > 0) {
                        tr.append($("<td></td>").text("(" + data.fach.kurz + ")"));
                    } else {
                        tr.append($("<td></td>").text(data.fach.kurz));
                    }
                    tr.append($("<td></td>").text(data.inhalte));
                    if (data.aufgaben && data.aufgaben.length > 0) {
                        tr.append($("<td></td>").text("(" + data.aufgaben_zeit + "') " + data.aufgaben));
                    } else {
                        tr.append($("<td></td>"));
                    }
                    tr.append($("<td></td>").text(data.bemerkungen));
                    tr.append($("<td></td>")
                        .append($("<button></button>")
                            .addClass("btn btn-primary btn-sm")
                            .attr("onclick", "read_unterricht(" + data.id + ");")
                            .append($("<i></i>")
                                .addClass("bi-pencil"))));

                    if (upd) {
                        speicher_praesenzen(data.id);
                        read_unterrichte();
                    } else {
                        // Praesenzen mit der gerade erhaltenen unterrichts-ID
                        // speichern
                        speicher_praesenzen(data.id);
                        $("#tbl_unterricht tbody").prepend(tr);
                    }

                    unterricht_vorbesetzen();
                    praesenzen_laut_gruppe();

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
         * Zeitraum (Woche) neben den Zeitraum-Knoepfen anzeigen
         */
        function zeige_zeitraum() {
            var woche = montag.getWeek(1);
            $("#zeitraum").val(montag.toLocaleDateString()
                + " - " + sonntag.toLocaleDateString()
                + " (KW: "
                + woche
                + ", "
                + (woche % 2 == 0 ? "B" : "A")
                + "-Woche)");
        }

        /**
         * Erzeugt den Text fuer die Anzeige der geplanten Bearbeitungszeit
         * fuer die Aufgaben aus der Stunde
         */
        function zeige_aufgaben_zeit(minuten) {
            $("#lbl_aufgaben_zeit").text("geplante Bearbeitungszeit: " + minuten + " Minuten.");
        }

        $("document").ready(function () {


            $('#gruppe').on('change', function () {
                unterricht.gruppe_id = $('#gruppe').val();
                read_gruppe();
                read_unterrichte();
                praesenzen_laut_gruppe();

                //Sitzplan UL Vorbereiten der Darstellung bei Gruppenwechsel
                read_sitzplaene_laut_gruppe();
                init_sitzplan();

            });
            $('#lehrer').on('change', function () {
                unterricht.lehrer_id = $('#lehrer').val();
            });
            $('#ustunde').on('change', function () {
                unterricht.ustunde_id = $('#ustunde').val();
            });
            $('#fach').on('change', function () {
                unterricht.fach_id = $('#fach').val();
            });
            $('#datum').on('change', function () {
                unterricht.datum = $('#datum').val();
            });
            $('#vertretung').on('change', function () {
                unterricht.vertretung = ($('#vertretung').prop('checked') ? 1 : 0);
            });
            $('#inhalte').on('change', function () {
                unterricht.inhalte = $('#inhalte').val();
            });
            $('#aufgaben').on('change', function () {
                unterricht.aufgaben = $('#aufgaben').val();
            });
            $('#bemerkungen').on('change', function () {
                unterricht.bemerkungen = $('#bemerkungen').val();
            });
            $('#aufgaben_zeit').on('change', function () {
                zeige_aufgaben_zeit($('#aufgaben_zeit').val());
                unterricht.aufgaben_zeit = $('#aufgaben_zeit').val();
            });

            read_gruppen();
            read_lehrer();
            read_ustunden();
            read_faecher();

            //Sitzplan UL Darstellung vorbereiten bei Seitenaufruf
            init_sitzplan();

            unterricht_vorbesetzen();

            $('#speichern').on('click', function (e) {
                e.preventDefault();
                speichern();
            });

            $('#reset').on('click', function (e) {
                e.preventDefault();
                unterricht_vorbesetzen();
                praesenzen_laut_gruppe();
            });

            // Zeitraum auf die aktuelle Woche setzen
            montag = getMonday(new Date());
            sonntag = new Date(montag);
            sonntag.setDate(sonntag.getDate() + 6);
            $("#datum_von").val(montag.toISOString().substr(0, 10));
            $("#datum_bis").val(sonntag.toISOString().substr(0, 10));
            zeige_zeitraum();

            // Knoepfe fur die Aenderung des Zeitraum mit Funktionen belegen
            $('#woche_zurueck_btn').click(function () {
                montag.setDate(montag.getDate() - 7);
                sonntag.setDate(sonntag.getDate() - 7);
                $("#datum_von").val(montag.toISOString().substr(0, 10));
                $("#datum_bis").val(sonntag.toISOString().substr(0, 10));
                zeige_zeitraum();
                read_unterrichte();
            });
            $('#woche_vor_btn').click(function (e) {
                e.preventDefault();
                montag.setDate(montag.getDate() + 7);
                sonntag.setDate(sonntag.getDate() + 7);
                $("#datum_von").val(montag.toISOString().substr(0, 10));
                $("#datum_bis").val(sonntag.toISOString().substr(0, 10));
                zeige_zeitraum();
                read_unterrichte();
            });
            $('#woche_aktuell_btn').click(function () {
                montag = getMonday(new Date());
                sonntag = new Date(montag);
                sonntag.setDate(sonntag.getDate() + 6);
                $("#datum_von").val(montag.toISOString().substr(0, 10));
                $("#datum_bis").val(sonntag.toISOString().substr(0, 10));
                zeige_zeitraum();
                read_unterrichte();
            });

            // Praesenzen verwalten
            $('#alle_praesent').on('click', function (e) {
                e.preventDefault();
                alle_praesent();
            });
            $('#alle_absent').on('click', function (e) {
                e.preventDefault();
                alle_absent();
            });
        });


        /*
        * Sitzplan UL - js ab hier
        */

        /**
         * Befüllen des Sitzplan-Selects in der Section Unterricht
         * mit den der gewählten Gruppe zugehörigen Sitzplänen
         */
        function read_sitzplaene_laut_gruppe() {
            url = "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/sitzplan/gruppe/" + unterricht.gruppe_id;
            $.ajax({
                url: url,
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                    $("#sitzplan").find('option').remove().end().append(new Option('', -1));
                    response.forEach(row => {
                        $("#sitzplan").append(new Option(row.raum.name + ' (' + row.teilgruppe + ') ' + row.name, row.id));
                    });
                }
            });
        }

        /**
         * Befüllen des Raum-Selects in der Section Sitzplan
         */
        function read_raeume(event) {
            url = "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/raum";
            $.ajax({
                url: url,
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                    $("#spl_raum").find('option').remove().end().append(new Option('', -1));
                    for (var counter = 0; counter < response.length; counter++) {
                        document.getElementById("spl_raum").options[counter]
                            = new Option(response[counter].name, response[counter].id);
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

            url = "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/gruppe/" + unterricht.gruppe_id;
            $.ajax({
                url: url,
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                    console.log(response.schueler);
                    response.schueler.forEach(schueler => {
                        sitzplan.gruppe.push(schueler);
                    });

                    refresh_sitzplan();
                }
            });
        }

        /**
         * Vorbereitung des Sitzplans bei Seitenaufruf
         * Darstellung des Rasters, Einlesen der Räume,
         * ggf. Einlesen der Gruppe, Aktualisierung der Darstellung
         */ 
        function init_sitzplan() {
            read_raeume();
            spl_read_gruppe();
            refresh_sitzplan();

            $('#sitzplan').on('change', function () {
                read_sitzplan($('#sitzplan').val());
            });
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
         * Section ein- oder ausblenden
         */ 
        function refresh_sitzplan() {

            if (sitzplan.anzeigen) {
                $('#sitzplansection').show();
            } else {
                $('#sitzplansection').hide();
            }

            $("#schuelerliste").empty();
            sitzplan.gruppe.forEach(schueler => {
                if (hasSitzplatz(schueler) == false) {
                    let element = '<h4><span schueler_id="' + schueler.id + '" class="badge badge-secondary" onclick="selectSchueler(this)">' + schueler.vorname + ' ' + schueler.nachname + '</span></h4>';
                    $("#schuelerliste").append(element);
                }
            });

            //Darstellung der Hilfselemente in der rechten Spalte
            let seitenlaenge = 60;
            element = '<div class ="float-left"text="Tür"  onmousedown="selectText(this)" style="text-align:center;  width:' + seitenlaenge + 'px; height:' + seitenlaenge + 'px; background-color:Ivory; border: 1px solid lightgray;" >Tür</div>';
            $("#schuelerliste").append(element);
            element = '<div class ="float-left" text="Pult"  onmousedown="selectText(this)" style="text-align:center;  width:' + seitenlaenge + 'px; height:' + seitenlaenge + 'px; background-color:Ivory; border: 1px solid lightgray;" >Pult</div>';
            $("#schuelerliste").append(element);
            element = '<div class ="float-left" text="x"  onmousedown="selectText(this)" style="text-align:center;  width:' + seitenlaenge + 'px; height:' + seitenlaenge + 'px; background-color:Ivory; border: 1px solid lightgray;" >x</div>';
            $("#schuelerliste").append(element);
            element = '<div class ="float-left" text=""  onmousedown="selectText(this)" style="text-align:center;  width:' + seitenlaenge + 'px; height:' + seitenlaenge + 'px; background-color:Ivory; border: 1px solid lightgray;" >Freitext</div>';
            $("#schuelerliste").append(element);


            //Darstellung des Sitzrasters    
            seitenlaenge = 80;
            $("#plan").empty();
            for (let i = 0; i < 10; i++) {
                for (let j = 0; j < 10; j++) {
                    let element = '<div oncontextmenu="return false;" id="platz' + i + '-' + j + '"  onmousedown="selectPlatz(this,event)" style="text-align:center;  width:' + seitenlaenge + 'px; height:' + seitenlaenge + 'px; background-color:Ivory; border: 1px solid lightgray; position:absolute; left:' + (i + 0.5) * seitenlaenge + 'px; top:' + j * seitenlaenge + 'px;" ></div>';
                    $("#plan").append(element);
                }
            }
            $('#plan').css("height", 10 * seitenlaenge + "px");

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


            if (!sitzplan.datum_beginn) {
                sitzplan.datum_beginn = new Date().toISOString().substr(0, 10);
            }
            $('#spl_datum_beginn').val(sitzplan.datum_beginn);

            if (!sitzplan.name) {
                sitzplan.name = "Bitte Namen vergeben";
            }
            $('#spl_name').val(sitzplan.name);
        }


        /**
         * Spezifischen Sitzplan laden
         * ausgelöst über Select "sitzplan" in der Section Unterricht
         * -> Folgeaufruf zum Nachladen der Gruppenmitglieder
         * -> Folgeaufruf zum Aktualisieren der Anzeige
         */ 
        function read_sitzplan(id) {
            url = "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/sitzplan/" + id;
            $.ajax({
                url: url,
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                    
                    sitzplan.id = response.id;
                    sitzplan.sitzplan = response.sitzplatz;
                    sitzplan.teilgruppe = response.teilgruppe;
                    sitzplan.raum_id = response.raum_id;
                    sitzplan.name = response.name;
                    sitzplan.beginn = response.beginn;
                    sitzplan.gruppe = [];
                    sitzplan.selectedSchueler = null;
                    sitzplan.selectedSitzplatz = null;
                    sitzplan.selectedText = null;
                    sitzplan.verwendungen = response.verwendungen;
                    sitzplan.anzeigen = true;
                    sitzplan.sitzplatz_idCounter = -1;

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
                    let text = prompt("Bitte geben Sie die freie Textbezeichnung (max 10 Zeichen) ein");
                    $(elem).attr("text", text.substring(0, 10));
                    $(elem).text(text.substring(0, 10));
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


                sitzplan.sitzplatz.push(sitzplatz);

                sitzplan.selectedSchueler = null;
                sitzplan.selectedSitzplatz = null;
                sitzplan.selectedText = null;
                sitzplan.sitzplatz_idCounter--;

                sitzplan.isUnsaved = true;
                refresh_sitzplan();
            }

        }

        /**
         * Togglen des Attributs sitzplan.anzeigen
         * -> Folgeaufruf refresh_sitzplan()
         */ 
        function sitzplananzeigen() {
            sitzplan.anzeigen = !sitzplan.anzeigen;
            refresh_sitzplan();
        }


    </script>

</body>

</html>