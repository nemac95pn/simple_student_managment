<?php

function ucitajStudente($nazivFajla)
{
	$f = fopen($nazivFajla, 'rt') or die('Ne možemo otvoriti fajl!');

	fscanf($f, "%d", $broj);
	$studenti = array();
	
	for($i = 0; $i < $broj; $i++)
	{
		$student = array();
		
		$student['ime'] = trim(fgets($f));
		$student['prezime'] = trim(fgets($f));
		$student['godiste'] = (int)fgets($f);
		$student['indeks'] = (int)fgets($f);
		$student['upis'] = (int)fgets($f);
		
		$studenti[] = $student;
	}

	fclose($f);
	return $studenti;
}

function ucitajBrojStudenata($nazivFajla)
{
	$f = fopen($nazivFajla, 'rt') or die('Ne možemo otvoriti fajl!');
	fscanf($f, "%d", $broj);
	fclose($f);
	return $broj;
}

function sacuvajStudente($nazivFajla, $lista)
{
    $f = fopen($nazivFajla, 'wt') or die('Ne možemo sačuvati fajl!');
    
    fprintf($f, "%d\n", count($lista));
    
    foreach($lista as $s)
    {
        fprintf($f, "%s\n", $s['ime']);
        fprintf($f, "%s\n", $s['prezime']);
        fprintf($f, "%d\n", $s['godiste']);
        fprintf($f, "%d\n", $s['indeks']);
        fprintf($f, "%d\n", $s['upis']);
    }
    
    fclose($f);
}

function pretrazi($lista, $termin)
{
    $termin = strtolower($termin);
    $rez = array();
    
    // Ova promjena zadržava originalne indekse pri pretrazi,
    // kako bi editovanje i brisanje radilo ispravno iz rezultata
    // pretrage. Bez ovoga bi indeksi u tabeli nakon pretrage
    // bili po redoslijedu u listi rezultata pretrage, što neće
    // nužno biti jednako indeksu tog studenta u kompletnoj bazi. 
    
    //foreach($lista as $s)
    foreach($lista as $id => $s)
    {
        if( strstr(strtolower($s['ime']), $termin) ||
            strstr(strtolower($s['prezime']), $termin))
        {
            //$rez[] = $s;
            $rez[$id] = $s;
        }
    }
    
    return $rez;
}

function validirajPodatke()
{
    global $greska;
    
    if(empty($_POST['ime']))
    {
        $greska = 'Polje za ime je prazno.';
        return false;
    }
    
    if(empty($_POST['prezime']))
    {
        $greska = 'Polje za prezime je prazno.';
        return false;
    }
    
    if(empty($_POST['godiste']))
    {
        $greska = 'Polje za godište je prazno.';
        return false;
    }
    
    if(empty($_POST['indeks']))
    {
        $greska = 'Polje za broj indeksa je prazno.';
        return false;
    }
    
    if(empty($_POST['upis']))
    {
        $greska = 'Polje za godinu upisa je prazno.';
        return false;
    }
    
    if(strlen($_POST['ime']) < 3)
    {
        $greska = 'Polje za ime je prekratko (minimalno 3 karaktera).';
        return false;
    }
    
    if(strlen($_POST['ime']) > 20)
    {
        $greska = 'Polje za ime je predugo (maksimalno 20 karaktera).';
        return false;
    }
    
    if(strlen($_POST['prezime']) < 3)
    {
        $greska = 'Polje za prezime je prekratko (minimalno 3 karaktera).';
        return false;
    }
    
    if(strlen($_POST['prezime']) > 30)
    {
        $greska = 'Polje za prezime je predugo (maksimalno 30 karaktera).';
        return false;
    }
    
    if(!ctype_digit(strval($_POST['godiste'])))
    {
        $greska = 'Polje za godište mora sadržati isključvio brojeve.';
        return false;
    }
    
    if(!ctype_digit(strval($_POST['indeks'])))
    {
        $greska = 'Polje za godište mora sadržati isključvio brojeve.';
        return false;
    }
    
    if(!ctype_digit(strval($_POST['upis'])))
    {
        $greska = 'Polje za godište mora sadržati isključvio brojeve.';
        return false;
    }
    
    if($_POST['godiste'] < 1900 || $_POST['godiste'] > 2000)
    {
        $greska = 'Godište je van opsega, mora biti od 1900 do 2000.';
        return false; 
    }
    
    if($_POST['indeks'] < 1 || $_POST['indeks'] > 99)
    {
        $greska = 'Broj indeksa je van opsega, mora biti od 1 do 99.';
        return false; 
    }
    
    if($_POST['upis'] < 2003 || $_POST['upis'] > date('Y'))
    {
        $greska = 'Godina upisa je van opsega, mora biti od 2003 do ' . date('Y') . '.';
        return false; 
    }
    
    return true;
}

function studentIzForme()
{
    $s = array();
    
    $s['ime'] = $_POST['ime'];
    $s['prezime'] = $_POST['prezime'];
    $s['godiste'] = $_POST['godiste'];
    $s['indeks'] = $_POST['indeks'];
    $s['upis'] = $_POST['upis'];
    
    return $s;
}

function dodajISacuvaj($student)
{
    $studenti = ucitajStudente('studenti.txt');
    $studenti[] = $student;
    sacuvajStudente('studenti.txt', $studenti);
}

?>