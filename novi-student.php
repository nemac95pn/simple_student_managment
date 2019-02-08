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

$poljeIme = '';
$poljePrezime = '';
$poljeGodiste = '';
$poljeIndeks = '';
$poljeUpis = '';

$editing = false;
$saved = false;

if(isset($_GET['editID']))
{
    $editID = $_GET['editID'];
    $studenti = ucitajStudente('studenti.txt');
    if(isset($studenti[$editID]))
    {
        $s = $studenti[$editID];
        
        $poljeIme = $s['ime'];
        $poljePrezime = $s['prezime'];
        $poljeGodiste = $s['godiste'];
        $poljeIndeks = $s['indeks'];
        $poljeUpis = $s['upis'];
        
        $editing = true;
    }
}

?>

<body>
    <div class='container'>
        <div class='row'>
           <!-- <div class='col-sm-3'>
                <?php // include('navigacija.php'); ?>
            </div> --> 
            <div class='col-sm-9'>
                <div class='page-header'>
                    <?php
                    if($editing)
                        echo('<h1>Uređivanje podataka</h1>');
                    else
                        echo('<h1>Novi student</h1>');
                    ?>
                </div>
                
                <?php
                
                if(isset($_POST['novi']))
                {
                    $greska = '';
                    
                    if(validirajPodatke())
                    {
                        dodajISacuvaj(studentIzForme());
                        ?>
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>Obaveštenje: </strong> Student uspešno upisan u bazu.
                        </div>
                        <?php    
                    }
                    else
                    {
                        $poljeIme = $_POST['ime'];
                        $poljePrezime = $_POST['prezime'];
                        $poljeGodiste = $_POST['godiste'];
                        $poljeIndeks = $_POST['indeks'];
                        $poljeUpis = $_POST['upis'];
                        
                        ?>
                        <div class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert">&times;</a>
                            <strong>Greška: </strong> <?php echo($greska); ?>
                        </div>
                        <?php
                    }
                }
                
                if(isset($_POST['saveID']))
                {
                    $saveID = $_POST['saveID'];
                    $studenti = ucitajStudente('studenti.txt');
                    
                    if(isset($studenti[$editID]))
                    {
                        $poljeIme = $_POST['ime'];
                        $poljePrezime = $_POST['prezime'];
                        $poljeGodiste = $_POST['godiste'];
                        $poljeIndeks = $_POST['indeks'];
                        $poljeUpis = $_POST['upis'];
                        
                        $greska = '';
                        if(validirajPodatke())
                        {
                            $s = studentIzForme(); 
                            $studenti[$editID] = $s;
                            sacuvajStudente('studenti.txt', $studenti);
                            ?>
                            <div class="alert alert-success">
                                <a href="#" class="close" data-dismiss="alert">&times;</a>
                                <strong>Obaveštenje: </strong> Podaci uspešno ažurirani.
                            </div>
                            <?php    
                        }
                        else
                        {
                            ?>
                            <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert">&times;</a>
                                <strong>Greška: </strong> <?php echo($greska); ?>
                            </div>
                            <?php
                        }
                    }
                }
                
                ?>
                
                <div class='col-sm-5'>
                    <form action="#" method="post">
                        <div class="form-group">
                            <label for="inputIme">Ime</label>
                            <input type="text" class="form-control" id="inputIme" name="ime" 
                                placeholder="Ime studenta" value="<?php echo($poljeIme); ?>" >
                        </div>
                        
                        <div class="form-group">
                            <label for="inputPrezime">Prezime</label>
                            <input type="text" class="form-control" id="inputPrezime" name="prezime" 
                                placeholder="Prezime studenta" value="<?php echo($poljePrezime); ?>" >
                        </div>
                        
                        <div class="form-group">
                            <label for="inputGodiste">Godište</label>
                            <input type="text" class="form-control" id="inputGodiste" name="godiste" 
                                placeholder="Godina rođenja studenta" value="<?php echo($poljeGodiste); ?>" >
                        </div>
                        
                        <div class="form-group">
                            <label for="inputBrInd">Broj indeksa</label>
                            <input type="text" class="form-control" id="inputBrInd" name="indeks" 
                                placeholder="Broj indeksa" value="<?php echo($poljeIndeks); ?>" >
                        </div>
                        
                        <div class="form-group">
                            <label for="inputUpis">Godina upisa</label>
                            <input type="text" class="form-control" id="inputUpis" name="upis" 
                                placeholder="Godina upisa" value="<?php echo($poljeUpis); ?>" >
                        </div> 
                        
                        <?php
                        if($editing)
                        {
                            ?>
                            <input type="hidden" name="saveID" value="<?php echo($editID); ?>">
                            <button type="submit" class="btn btn-primary">Sačuvaj</button>
                            <?php
                        }
                        else
                        {
                            ?>
                            <input type="hidden" name="novi" value="1">
                            <button type="submit" class="btn btn-primary">Dodaj</button>
                            <?php
                        }
                        ?>
                            
                    </form>
                </div>
    
        <script src="js/jquery-1.12.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>