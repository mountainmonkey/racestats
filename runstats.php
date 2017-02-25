<html>
<body>

<form action="runstats.php" method="get">
bib #: <input type="text" name="bib">
<input type="submit" value="search">
</form>

<hr>
<?php

echo "BIB : ".$_GET['bib']."<br>";

$me=array('name','bib','split','gp','gpp','cp','cpp','gtp','ctp','guntime','chiptime');
$me['bib']=$_GET['bib'];

$pp=popen("cat m.txt","r");

$first=true;

$fastrunner=array();
$slowrunner=array();

$faster=true;

$total=0;

for ($i=0;$i<21;$i++)
    $line=fgets($pp,200);

for ($total=0;!feof($pp);) 
{
    $line=fgets($pp,200);
    if (feof($pp)) break;

    $result=sscanf($line,"%d %s %s %s %d ");
    list($place,$guntime,$pace,$chiptime,$bib)=$result;

    $name=substr($line,38,37);
    $city=substr($line,76,18);

    $line=substr($line,95,strlen($line)-95); 
    
    $result=sscanf($line,"%s %s %s %s %s %s\n");
    list($gp,$cp,$category,$eightk,$half,$twentyfive)=$result;
    
    echo $place."|".$guntime."|".$pace."|".$chiptime."|<a href=\"runstats.php?bib=".$bib."\">".$bib."</a>|".$name."|".$city."|".$eightk."|".$half."|".$twentyfive."<br>";

    $runner=array(
    'gtplace'=>$place,
    'ctplace'=>0,
    'name'=>$name,
    'half'=>$half,
    'twentyfive'=>$twentyfive,
    'guntime'=>$guntime,
    'chiptime'=>$chiptime
    );

    if ($faster)
        $fastrunner[$bib]=$runner;
    else
        $slowrunner[$bib]=$runner;

    if ($bib==$me['bib'])
    {
        $faster=false;
        $me['gtplace']=$place;
        $me['name']=$name;
        $me['gp']=$gp;
        list($gpn,$gpa)=sscanf($me["gp"],"%d/%d");
        $me['gpp']=round(($gpn/$gpa)*100,2);
        $me['cp']=$cp;
        list($cpn,$cpa)=sscanf($me["cp"],"%d/%d");
        $me['cpp']=round(($cpn/$cpa)*100,2);
        $me['split']=$twentyfive;
        $me['gtp']=$place;
        $me['ctp']=0;
        $me['guntime']=$guntime;
        $me['chiptime']=$chiptime;
    }
    $total++;
}
pclose($pp);

echo "ALL:".--$total."<br>";

?>

<hr>

<?
    $i=0;

    foreach ($fastrunner as $runner)
    {
        if ($runner["twentyfive"]>$me['split'])
        {
            echo $runner["place"]." ".$runner["name"]."|".$runner["half"]."|".$runner["twentyfive"]." ".$runner["guntime"]." ".$runner["chiptime"]."<br>";
//    echo $place."|".$guntime."|".$pace."|".$chiptime."|<a href=\"runstats.php?bib=".$bib."\">".$bib."</a>|".$name."|".$city."|".$eightk."|".$half."|".$twentyfive."<br>";
            $i++;
        }

        if ($me['chiptime']>$runner['chiptime'])
            $me['ctplace']++;

        next($fastrunner);
    }
    echo "<h2>".$i." runners passed you after 25km!</h2><br>";
?>

<hr>

<?
    $i=0;

    foreach ($slowrunner as $runner)
    {
        if ($runner["twentyfive"]!=null&&$runner["twentyfive"]<$me['split'])
        {
            echo $runner["place"]." ".$runner["name"]."|".$runner["half"]."|".$runner["twentyfive"]." ".$runner["guntime"]." ".$runner["chiptime"]."<br>";
            $i++;
        }

        if ($me['chiptime']>$runner['chiptime'])
            $me['ctplace']++;

        next($slowrunner);
    }

    echo "<h2>You passed ".$i." runners after 25km!</h2><br>";
?>

<h1>
<?
    $me['gtp']=round(($me['gtplace']/$total)*100,2);
    $me['ctp']=round(($me['ctplace']/$total)*100,2);

    echo $me["name"]."<br>";
    echo $me["guntime"]."<br>";
    echo $me["chiptime"]."<br>";
    echo $me["gtplace"]."/".$total."<br>";
    echo $me["ctplace"]."/".$total."<br>";
    echo $me["gp"]."<br>";
    echo $me["cp"]."<br>";
    echo "gender percentile: ".$me['gpp']."%<br>";
    echo "category percentile: ".$me['cpp']."%<br>";
    echo "guntime percentile: ".$me['gtp']."%<br>";
    echo "chiptime percentile: ".$me['ctp']."%<br>";
?>
</h1>

</body>
</html>
