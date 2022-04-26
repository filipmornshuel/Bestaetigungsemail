<?php
/*
 * In diesem Projekt habe ich mir das Ziel gesetzt, eine Formular aufzusetzen, was bei erfolgreicher Bestellung,
 * einen auf eine Bestätigungsseite weiterleitet und zusätzlich eine Bestätigungsemail versendet.
 *
 * Datum: 21-10-2021
 * Author: Filip Slavkovic
 * Version: 0.1
 *
 *
 * */




?>
<?php



// Varbiablen leer initialisieren

$nachname = '';
$vorname = '';
$email = '';
$infos = [];
$newsletter = '';
$fehler = false;

//Felder erst nach absenden validieren
if(isset($_POST['senden'])){

    //Variabeln bereinigen
    $nachname = htmlspecialchars($_POST['nachname']);
    $vorname = htmlspecialchars($_POST['vorname']);
    $email = htmlspecialchars($_POST['email']);

    // Prüfen ob Nachname ausgefüllt
    if ($nachname === '') {
        echo "Bitte Nachnamen ausfüllen!";
        echo "<br>";
        $fehler = true;
    }

    // Prüfen ob Vorname ausgefüllt
    if ($vorname === '') {
        echo "Bitte Voramen ausfüllen!";
        echo "<br>";
        $fehler = true;
    }

    //Prüfen ob Email ausgefüllt
    $emailFormat ='/^.{2,}@.{2,}\..{2,}$/'; // Ist ein E-Mail Pattern, prüft ob alle relevanten E-Mail Details vorhanden sind.

    if (!preg_match($emailFormat, $email)) {
        echo "E-Mail ist nicht korrekt!";
        echo "<br>";
        $fehler = true;
    }

    // Prüfen ob mind. 1 Checkbox gewählt

    if(!isset($_POST['infos'])){
        echo "Mindestens 1 Checkbox muss gewählt werden!";
        echo "<br>";
        $fehler = true;
    }else {
        $infos = $_POST['infos'];
    }




}


// Formular nur anzeigen, wenn keine Fehler oder senden noch nicht gedrückt.
if ($fehler || !isset($_POST['senden'])) {


// Verschachtelung mit HTML
    ?>





    <!DOCTYPE html>
    <html lang="de-CH" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Bestellung von Informationsmaterial</title>
        <link rel="stylesheet" href="Stylesheet.css">
    </head>
    <body>
    <h1>
        <?php if($fehler){
            // Hier wird ein Korrekturformular angezeigt, falls man nicht alle Pflichtfelder ausgefüllt oder diese falsch ausgefüllt hatte.
            echo "Korrekturformular";
        }else {
            echo "Bestellung von Informationsmaterial";
        } ?>
    </h1>

    <form class="formular" action="" method="post">

        <label>
            Nachname:* <br>
            <input autofocus type="text" name="nachname" value="<?php echo $nachname ?>">
        </label>

        <br><br>

        <label>
            Vorname:* <br>
            <input type="text" name="vorname" value="<?php echo $vorname ?>">
        </label>

        <br><br>

        <label>
            E-Mail:* <br>
            <input type="text" name="email" value="<?php echo $email ?>">
        </label>

        <br><br>

        <h2>Hier können Sie 3 Listen bestellen, die zur Person von Filip Slavkovic etwas aussagen. Die Listen werden dann per E-Mail versendet.</h2>

        <ul>
            <li>Die Hobbyliste beinhaltet alle Hobbys von Filip und eine kleine Beschreibung wie er dazu gekommen ist.</li>
            <li>Die Bücherliste beinhaltet eine Liste von Büchern, die Filip gelesen hatte und die ihm besonders gefielen und welche er weiterempfiehlt.</li>
            <li>Die Projektliste beinhaltet alle Projekte, die Filip durchgeführt hatte und welche ihm gut gelungen sind.</li>
        </ul>


        <fieldset>
            <legend>Ich bestelle Informationen zu*</legend>

            <label>
                <input type="checkbox" name="infos[]" value="Hobbyliste"
                    <?php if(in_array('Hobbyliste', $infos)) {
                        echo 'checked';
                    } ?>> Hobbyliste
            </label>
            <br>
            <label>
                <input type="checkbox" name="infos[]" value="Bücherliste" <?php if(in_array('Bücherliste', $infos)) {
                    echo 'checked';
                } ?>> Bücherliste
            </label>
            <br>
            <label>
                <input type="checkbox" name="infos[]" value="Projektliste" <?php if(in_array('Projektliste', $infos)) {
                    echo 'checked';
                } ?>> Projektliste
            </label>
        </fieldset>





        <br><br>
        <p> * = Pflichtfeld</p>

        <br><br>
        <input type="submit" name="senden" value="Senden">

    </form>








    </body>
    </html>
    <?php
} else {
    mail('$email' ,
       'Bestellung von Informationsmaterial (Web-Formular)',
        "Name:\n\t$nachname \nVorname:\n\t$vorname \nE-Mail:\n\t$email \nBestellte Informationen:\n\t$infos \nNewsletter abonniert:\n\t$newsletter",
        "From: filip.slavko.co@gmail.com\r\nContent-type: text/plain; charset=UTF-8",
        '-filip.slavko.co@gmail.com');

    // header('Content-Type: text/html; charset=utf-8');

    ?>
    <!DOCTYPE html>
    <html lang="de-CH" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Bestellung von Informationsmaterial</title>
        <link rel="stylesheet" href="Bestätigung.css">
    </head>
    <body>
    <h1>Vielen Dank für Ihre Bestellung, das Formular wurde erfolgreich gesendet</h1>

    <p>Sie werden von uns noch eine E-Mail bekommen, mit allen relevanten Informationen, die Sie bestellt haben!</p>
    <table><caption>Übersichtstabelle</caption>
        <tr>
            <th>Feld</th><th>Inhalt</th>
        </tr>
        <tr>
            <td>Nachname</td><td><?php echo $nachname ?></td>
        </tr>
        <tr>
            <td>Vorname</td><td><?php echo $vorname ?></td>
        </tr>
        <tr>
            <td>E-Mail</td><td><?php echo $email ?></td>
        </tr>
        <tr>
            <td>Infos</td><td><?php echo htmlspecialchars(implode(', ', $infos)) ?></td>
        </tr>


    </table>

    </body>
    </html>

    <?php
}
?>

