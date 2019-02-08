<?php 
require_once('pomocne-funkcije.php');

$trenutnaStranica = basename($_SERVER['PHP_SELF']);

$nav = array();

$nav[] = array
(
    'adresa' => 'main.php', 
    'natpis' => 'Spisak studenata', 
    'ikonica' => 'glyphicon-user',
    'broj' => true
);

$nav[] = array
(
    'adresa' => 'novi-student.php', 
    'natpis' => 'Novi student', 
    'ikonica' => 'glyphicon-plus',
    'broj' => false
);

$nav[] = array
(
    'adresa' => 'about.php', 
    'natpis' => 'O sajtu', 
    'ikonica' => 'glyphicon-info-sign',
    'broj' => false
);

?>

<div class="page-header">
    <h1><img src='img/raf-icon.png' class="inline-block" width=48 height=48 /> RAF </h1>
</div>   
<div class="list-group">
    <?php
    
    $brojStudenata = ucitajBrojStudenata('studenti.txt');
    
    foreach($nav as $stavka)
    {
        echo('<a href="' . $stavka['adresa'] . '" class="list-group-item');
        
        if($stavka['adresa'] == $trenutnaStranica) 
            echo(' active');
            
        echo('"><span class="glyphicon ' . $stavka['ikonica'] . '"></span> ' . $stavka['natpis']);
        
        if($stavka['broj']) 
            echo(' <span class="badge">' . $brojStudenata . '</span>');
            
        echo('</a>');
    }
    
    ?>
</div>