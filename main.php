<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>03 - Studentska služba v3</title>
  
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <!-- Optional Bootstrap theme -->
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">
</head>

<?php

require_once('pomocne-funkcije.php');

$studenti = ucitajStudente('studenti.txt');

$brisanje = false;
if(isset($_GET['brisiID']))
{
    $id = $_GET['brisiID'];
    if(isset($studenti[$id]))
    {
        $imeIzbrisanog = $studenti[$id]['ime'] . ' ' . $studenti[$id]['prezime'];
        unset($studenti[$id]);
        sacuvajStudente('studenti.txt', $studenti);
        $brisanje = true;
    }
}

$pretraga = false;
$termin = '';

if(!empty($_POST['termin']))
{
    $pretraga = true;
    $termin = $_POST['termin'];
    $prikaz = pretrazi($studenti, $termin);
}
else
{
    $prikaz = $studenti;
}

?>

<body>
    <div class='container'>
        <div class='row'>
            <div class='col-sm-3'>
                <?php include('navigacija.php'); ?>
            </div>
            <div class='col-sm-9'>
                <div class='page-header'>
                    <?php
                    if($pretraga)
                        echo('<h1>Rezultati pretrage za "<strong>' . $termin . '</strong>"</h1>');
                    else
                        echo('<h1>Studentska služba</h1>');
                    ?>
                </div>
                
                <?php
                if($brisanje)
                {
                    ?>
                    <div class="alert alert-warning">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <strong>Obaveštenje: </strong> Student <strong><?php echo ($imeIzbrisanog); ?></strong> izbrisan iz baze.
                    </div>
                    <?php
                }
                
                if(count($prikaz) == 0)
                {
                    if($pretraga)
                        echo('<h3>Pretraga nema rezultata.</h3><br/>');
                    else
                        echo('<h3>Nemamo nijednog studenta u bazi.</h3><br/>');
                }
                else
                {
                ?>
                
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Ime</th>
                                <th>Prezime</th>
                                <th>Godište</th>
                                <th>Indeks</th>
                                <th>Akcije</th>
                            </tr>
                        </thead>
                        
                        <tbody>

                        <?php
                        foreach($prikaz as $id => $s)
                        {
                            echo('<tr>');
                            
                            echo('<td>' . $s['ime'] . '</td>');
                            echo('<td>' . $s['prezime'] . '</td>');
                            echo('<td>' . $s['godiste'] . '</td>');
                            echo('<td>' . $s['indeks'] . '/' . $s['upis'] . '</td>');
                            
                            echo('<td><a href="novi-student.php?editID=' . $id . '" data-toggle="tooltip" title="Uredi podatke...">');
                            echo('<span class="glyphicon glyphicon-edit"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;');
                            
                            echo('<a href="main.php?brisiID=' . $id . '" data-toggle="tooltip" title="Izbriši studenta">');
                            echo('<span class="glyphicon glyphicon-trash"></span></a></td>');
                            
                            echo('</tr>');
                        }
                        ?>
                        </tbody>
                    </table>
                
                <?php
                }
                ?>
                
                <form class="form-horizontal" action="main.php" method="post">
                    <div class="col-xs-6">
                        <div class="input-group">
                            <input type="text" class="form-control" name="termin" placeholder="Termin za pretragu" value="<?php echo($termin) ?>" />
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-default glyphicon glyphicon-search"></button>
                            </span>
                        </div>
                    </div>
                </form>
    
        <script src="js/jquery-1.12.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>