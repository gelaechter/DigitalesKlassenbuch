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
            
            <div class="row mt-3 pt-3 pb-3" id ="coronarow">             

                <div class="col-md-2">
                    <i class="bi-tag pr-2"></i>Corona-Status
                </div>
                
                <div class="col-md-10" id="corona">
                </div>
                
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

        var corona = [];

        
        

        /**
         * Lesen aller Lehrer fuer die Schülerauswahl
         * Serverseitig werden nur Lehrern alle Schüler angeboten, Schüler können nur sich selektieren.
         *
         */
        function read_corona_by_gruppe(id) {
            $.ajax({
                url: "/fileadmin/Skripte4JAG/klassenbuch/klassenbuch-api/api/corona/gruppe/"+id,
                type: "GET",
                success: function (data) {
                    var response = $.parseJSON(data);
                                        
                    corona = [];

                    $("#corona").empty();
                    
                    response.forEach(row => {
                        cls = "badge badge-dark";
                        fehlt = false;
                        now = new Date().toISOString().slice(0, 19).replace('T', ' ');

                        if(!row.von || row.bis < now || !row.bis){
                            cls = "badge badge-danger";
                            fehlt = true;
                        } else {
                            cls = "badge badge-success";
                        }
                        

                        if(fehlt){
                            $("#corona").append($("<button></button")
                                .addClass("btn btn-secondary btn-sm border border-warning mr-2")
                                .attr('id', "corona" + row.id)
                                .on('click', function () {
                                    corona_okay(row.id, row.gruppe_id);
                                })
                                .append($("<span></span>")
                                    .addClass(cls)
                                    .text(row.vorname + ' ' + row.nachname.substr(0, 1) + '.')));
                            corona.push(row);
                        }
                    });

                    if(corona.length>0){
                        $("#coronarow").show();
                    } else {
                        $('#coronarow').hide();
                    }
                }
            });
        }



        function corona_okay(erledigung_id, gruppe_id){  
                
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
                    read_corona_by_gruppe(gruppe_id);
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
            read_corona_by_gruppe(1);
        });

        


    </script>

</body>

</html>