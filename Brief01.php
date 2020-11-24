<?php
session_start();
include "./mail.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet">
    <title>Title</title>
</head>

<body>


    <!-- header -->
    <header class="w-full px-6 bg-white">
        <p><?php echo $_SESSION["rand"]; ?></p>
        <div class="container mx-auto max-w-4xl md:flex justify-between items-center">
            <a href="#" class="block py-6 w-full text-center md:text-left md:w-auto text-gray-900 underline flex justify-center items-center">
                RestoCov'19
            </a>
            <div class="w-full md:w-auto mb-6 md:mb-0 text-center md:text-right">
                <a href="#" class="inline-block no-underline bg-black text-white text-sm py-2 px-3">Sign Up</a>
            </div>
        </div>
    </header>
    <!-- /header -->

    <!-- hero -->
    <div class="w-full py-24 px-6 bg-cover bg-no-repeat bg-center relative z-10" style="background-image: url('./img/medina.jpg'); background-size:cover; width: auto;height: auto;">

        <div class="container max-w-4xl mx-auto text-center">
            <h1 class="text-xl leading-tight md:text-3xl text-center text-gray-100 mb-3">RestoCov'19</h1>
            <p class="text-md md:text-lg text-center text-white ">Le premier restaurant en ligne à SAFI</p>

            <a href="/register" class="mt-6 inline-block bg-white text-black no-underline px-4 py-3 shadow-lg">Explorer</a>
        </div>

    </div>
    <!-- /hero -->

    <!-- home content -->
    <div class="w-full px-6 py-12 bg-white">
        <div class="container max-w-4xl mx-auto text-center pb-10">

            <h3 class="text-xl md:text-3xl leading-tight text-center max-w-md mx-auto text-gray-900 mb-12">
                LIVRAISON DE REPAS À SAFI.
            </h3>

            <a href="#" class="bg-black text-white px-4 py-3 no-underline">Explorer Nos Menus</a>

        </div>
        <div class="container max-w-4xl mx-auto text-center flex flex-wrap items-start md:flex-no-wrap">
            <?php
            $conn = new mysqli("localhost", "root", "", "brief01");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $Aujourhui = date(1);



            $_SESSION["rand"] = true;

            $d1 = new DateTime("now");
            $d2 = new DateTime("tomorrow");
            $diff = $d1->diff($d2);
            $resm = intval($diff->format("%i") . PHP_EOL);
            $resh = intval($diff->format("%h") . PHP_EOL);
            $res  = $resm + $resh * 24;
            // (date(1) != "tuesday") || 
            // echo $_SESSION["rand"];
            if ($_SESSION["rand"] >= 2) {
                $sql_plats = "SELECT * FROM plats ORDER BY RAND() LIMIT 7";
                $res_plats = mysqli_query($conn, $sql_plats);
                $ligne  = mysqli_num_rows($res_plats);
                $date = ["LUNDI", "MARDI", "MERCREDI", "JEUDI", "VENDREDI", "SAMEDI", "DIMANCHE"];
                $i = 0;
                $array = array();
                $_SESSION["rand"] = false;
                if ($ligne > 0) {
                    while ($ligne = $res_plats->fetch_assoc()) {
                        echo '<div class="my-4 w-full md:w-1/3 flex flex-col items-center justify-center px-4">
                            <p>' . $_SESSION["rand"] . '</p>
                            <p>PLAT DU ' . $date[$i] . '</p>
                            <img src="./img/' . $ligne['img_p'] . '.jpg" class="w-full h-64 object-cover mb-6">
                            <h2 class="text-xl leading-tight mb-2">' . $ligne['Nom_p'] . '</h2>
                            <p class="mt-3 mx-auto text-sm leading-normal">' . $ligne['Ingredients_p'] . '.</p>
                            <p class="mt-3 mx-auto text-sm leading-normal  font-black underline">' . $ligne['Prix_p'] . 'DHS</p>
                            </div>
                        ';
                        array_push($array, $ligne['Id_p']);
                        $i++;
                    }
                }
            }
            echo $_SESSION["rand"];



            ?>
        </div>
    </div>
    <!-- /home content -->

    <!-- about -->
    <div class="w-full h-3/6 px-6 py-12 text-left bg-gray-200 text-gray-700 leading-loose">
        <div class="container max-w-4xl mx-auto flex justify-center flex-wrap md:flex-no-wrap">

            <?php
            switch (strftime("%w")) {
                case 0:
                    $j = 0;
                    break;
                case 1:
                    $j = 1;
                    break;
                case 2:
                    $j = 2;
                    break;
                case 3:
                    $j = 3;
                    break;
                case 4:
                    $j = 4;
                    break;
                case 5:
                    $j = 5;
                    break;
                case 6:
                    $j = 6;
                    break;
            }
            $j--;
            $sql_platJ = "SELECT * FROM plats WHERE Id_p = $array[$j]";
            $res_pj = mysqli_query($conn, $sql_platJ);
            $rows_client = mysqli_num_rows($res_pj);
            $ligne_pj = mysqli_fetch_assoc($res_pj);
            echo date('l');
            echo '
            <div class="w-full md:w-1-3">
                <h3 class="text-4xl mb-9 ml-6 text-black leading-tight text-center">
                    PLAT DU JOUR.
                </h3>

                <p class="mb-5 ml-6 text-center">' . $ligne_pj['Nom_p'] . '</p>
                <p class="ml-6 mb-5 text-center">' . $ligne_pj['Descrip_p'] . '</p>
            </div>
            <div class="w-full md:w-2-3 pt-10 md:px-6 md:pt-0 self-center">
                <img src="./img/' . $ligne_pj['img_p'] . '.jpg" class="w-full h-auto">
            </div>' ?>
            <div class="mt-10 sm:mt-0 ">
                <div class="md:grid md:grid-cols-2 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0 w-full">
                            <h3 class="mt-6 text-xl font-medium leading-1 text-gray-900">Informations Personnelles</h3>
                            <p class="mt-1 text-sm text-gray-600 ">
                                Utiliser un email valide pour recevoir la facture.
                            </p>
                        </div>
                    </div>

                    <?php
                    if (isset($_POST['BTNCom'])) {
                        $nom = $_POST['Nom'];
                        $prenom = $_POST['Prenom'];
                        $email = $_POST['Email'];
                        $adresse = $_POST['Adresse'];
                        $id = $array[$j];
                        $sql_insert = "INSERT INTO `commande`(`Id_p`, `Email`, `adresse`, `date_c`, `Nom`, `Prenom`) 
                                VALUES ($id,'.$email.','.$adresse.',NULL,'.$nom.','.$prenom.')";

                        if ($conn->query($sql_insert) === TRUE) {
                            echo "New record created successfully";
                        } else {
                            echo "Error: " . $sql_insert . "<br>" . $conn->error;
                        }
                    }
                    ?>
                    <div class="mt-5 md:mt-0 md:col-span-2">

                        <?php
                        //configuration PhpMailer
                        if (($_SERVER["REQUEST_METHOD"]) == "POST") {
                            $mail->setFrom('from@example.com', 'Mailer');
                            $mail->addAddress($email, $nom . " " . $prenom);     // Add a recipient
                            $mail->Subject = 'Commande';
                            $mail->Body    = '<p>Commande a été livré<p> ';

                            $mail->send();
                        }
                        ?>

                        <form action="#" method="POST">
                            <div class=" overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 bg-transparent sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="first_name" class="block text-sm font-medium text-gray-700">NOM:</label>
                                            <input type="text" id="first_name" name="Nom" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md h-8" required>
                                        </div>

                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="last_name" class="block text-sm font-medium text-gray-700">PRENOM:</label>
                                            <input type="text" id="last_name" name="Prenom" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md h-8" required>
                                        </div>

                                        <div class="col-span-6 sm:col-span-4">
                                            <label for="email_address" class="block text-sm font-medium text-gray-700">EMAIL:</label>
                                            <input type="text" id="email_address" name="Email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-black rounded-md h-8" required>
                                        </div>
                                        <div class="col-span-6 sm:col-span-4">
                                            <label for="address" class="block text-sm font-medium text-gray-700">ADRESSE:</label>
                                            <input type="text" id="address" name="Adresse" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-black rounded-md h-8" required>
                                        </div>
                                    </div>
                                    <div class="px-4 py-3 bg-transparent text-right sm:px-6">
                                        <button type="submit" name="BTNCom" class="bg-black hover:bg-white text-white font-semibold hover:text-black py-2 px-4 border border-blue hover:border-transparent rounded mt-6">
                                            Commander
                                        </button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /about -->

    <!-- footer -->
    <footer class="w-full bg-white px-6 border-t">
        <div class="container mx-auto max-w-4xl py-6 flex flex-wrap md:flex-no-wrap justify-between items-center text-sm">
            ©2020 RestoCov'19. All rights reserved.
            <div class="pt-4 md:p-0 text-center md:text-right text-xs">
                <a href="#" class="text-black no-underline hover:underline">Privacy Policy</a>
                <a href="#" class="text-black no-underline hover:underline ml-4">Terms &amp; Conditions</a>
                <a href="#" class="text-black no-underline hover:underline ml-4">Contact Us</a>
            </div>
        </div>
    </footer>
    <!-- /footer -->




</body>

</html>