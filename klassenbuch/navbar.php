<?php
    require './auth.php'
    //require '../../openid/auth.php';
?>

<section>
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
             <!-- Brand/logo -->
            <a class="navbar-brand" href="#">
                <img src="./logo.png" alt="logo" style="width:40px;">
            </a>
      
            <ul class="navbar-nav">
              
            <?php

                if($_SESSION['user_lehrer_id']){

                    echo '
                    <li class="nav-item">
                        <a class="nav-link" href="./weekviewtest.php">Wochenansicht</a>
                    </li>
                    
                    <li class="nav-item">
                    <a class="nav-link" href="./sitzplan.php">Sitzpläne</a>
                    </li>

                    <li class="nav-item">
                    <a class="nav-link" href="./eigenschaft_corona.php">Corona-Status</a>
                    </li>
                    ';
                    
                }
            ?>

                <li class="nav-item">
                <a class="nav-link" href="./entschuldigung.php">Entschuldigungen</a>
                </li>

                <li class="nav-item float-end">
                    <a class="nav-link" href="#"><?php echo $_SESSION['user_iserv'] ?></a>
                </li>


                <?php

                if($_SESSION['user_lehrer_id'] && 
                  ($_SESSION['user_lehrer_id']==1 
                   || $_SESSION['user_lehrer_id']==4
                   || $_SESSION['user_lehrer_id']==39                   
                   || $_SESSION['user_lehrer_id']==102
                   || $_SESSION['user_lehrer_id']==103
                   || $_SESSION['user_lehrer_id']==16
                   || $_SESSION['user_lehrer_id']==34
                   || $_SESSION['user_lehrer_id']==52
                   || $_SESSION['user_lehrer_id']==94
                   || $_SESSION['user_lehrer_id']==18
                   || $_SESSION['user_lehrer_id']==109 //Sanders
                   || $_SESSION['user_lehrer_id']==110 //Doberstein
                   )
                  ) {

                    echo '
                    <li class="nav-item">
                        <a class="nav-link" href="./update.php">Update</a>
                    </li>
                    
                    <li class="nav-item">
                    <a class="nav-link" href="./abit.php">ABIT-Eingabe</a>
                    </li>

                    <li class="nav-item">                    
                    <a class="nav-link" href="../klassenbuch-api/api/corona/geimpfte/2022-04-01">Zahl Geimpfte</a>
                    </li>

                    <li class="nav-item">
                    <a class="nav-link" href="../klassenbuch/corona_testausgabe2.php">Testausgabe</a>
                    </li>

                    <li class="nav-item">
                    <a class="nav-link" href="../klassenbuch/eigenschaft.php">Abhaklisten</a>
                    </li>
                    ';
                    
                }
            ?>

            </ul>
        </nav>
    </section>