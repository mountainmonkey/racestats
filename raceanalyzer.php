<?php
//$RACEDATA_SOURCE="racedata/".$_GET['race'].".htm";
//echo "BIB : ".$_GET['bib']."<br>";

$race=$_GET['race'];
$RACEDATA_SOURCE="racedata/".$race.".htm";
$RACEDATA_CONF="racedata/".$race.".conf";

$CONFTABLE=array(array(0,0));

$conf=fopen($RACEDATA_CONF,"r");
$line=fscanf($conf,"%d\n");
list($LINES_TO_IGNORE)=$line;
$line=fscanf($conf,"%s\n");
list($SPLIT_LABEL)=$line;
for ($i=0;$i<10;$i++)
{
    $line=fscanf($conf,"%d:%d\n");
    list($CONFTABLE[$i][0],$CONFTABLE[$i][1])=$line;
//    echo $CONFTABLE[$i][0].":".$CONFTABLE[$i][1]."<br>";
}
fclose($conf);

$me=array('name','ctplace','bib','split','gp','gpp','cp','cpp','gtp','ctp','guntime','chiptime');
$me['ctplace']=0;
$me['bib']=$_GET['bib'];

$fp=fopen($RACEDATA_SOURCE,"r");

$first=true;

$fastrunner=array();
$slowrunner=array();
$faster=true;

$total=0;
$fast_total=0;
$slow_total=0;

for ($i=0;$i<$LINES_TO_IGNORE;$i++)
    $line=fgets($fp,200);

for ($total=0;!feof($fp);) 
{
    $line=fgets($fp,200);
    if (feof($fp)) break;

    $place=trim(substr($line,$CONFTABLE[0][0],$CONFTABLE[0][1]));
    $gp=trim(substr($line,$CONFTABLE[1][0],$CONFTABLE[1][1]));
    $cp=trim(substr($line,$CONFTABLE[2][0],$CONFTABLE[2][1]));
    $name=trim(substr($line,$CONFTABLE[3][0],$CONFTABLE[3][1]));
    $city=trim(substr($line,$CONFTABLE[4][0],$CONFTABLE[4][1]));
    $bib=trim(substr($line,$CONFTABLE[5][0],$CONFTABLE[5][1]));
    $category=trim(substr($line,$CONFTABLE[6][0],$CONFTABLE[6][1]));
    $guntime=trim(substr($line,$CONFTABLE[7][0],$CONFTABLE[7][1]));
    $chiptime=trim(substr($line,$CONFTABLE[8][0],$CONFTABLE[8][1]));
    $split=trim(substr($line,$CONFTABLE[9][0],$CONFTABLE[9][1]));
    $starttime=strtotime($guntime)-strtotime($chiptime);

    $runner=array(
    'gtplace'=>sprintf("%5d",$place),
    'ctplace'=>0,
    'bib'=>$bib,
    'name'=>$name,
    'category'=>$category,
    'split'=>$split,
    'guntime'=>$guntime,
    'chiptime'=>$chiptime,
    'gp'=>$gp,
    'cp'=>$cp,
    'starttime'=>$starttime,
    'spguntime'=>null
    );

    if (strlen($split)==0)
    {
        $runner['split']=null;
    }
    else
        $runner['spguntime']=date("H:i:s",$starttime+strtotime($split));
    

    if (strlen($chiptime)>0)
    {
        if ($faster)
            $fastrunner[$bib]=$runner;
        else
            $slowrunner[$bib]=$runner;
    }

    if ($bib==$me['bib']&&strlen($me['bib'])>0)
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
        $me['split']=$split;
        $me['gtp']=$place;
        $me['ctp']=0;
        $me['guntime']=$guntime;
        $me['chiptime']=$chiptime;
        $me['starttime']=$runner['starttime'];
        $me['spguntime']=$runner['spguntime'];
    }
    $total++;
}
fclose($fp);

if (strlen($me['bib'])>0&&strlen($me['guntime'])==0)
{
    echo "<script language=\"javascript\">alert('BIB ".$me['bib']." not found!');history.go(-1);</script>";
    return;
}

function outputAllRunners()
{
    global $fastrunner,$slowrunner,$race;

    $i=0;
    foreach ($fastrunner as $runner)
    {
        if ($i>=1)
            echo ",\n";

        $name="<a href=/racestats.php?race=".$race."&bib=".$runner['bib'].">".$runner['name']."</a>";
        echo"{Place:\"".$runner{'gtplace'}."\",Name:\"".$name."\",Bib:\"".$runner{'bib'}."\",Category:\"".$runner{'category'}."\",GunTime:\"".$runner{'guntime'}."\",ChipTime:\"".$runner{'chiptime'}."\",Split:\"".$runner{'split'}."\",GPlace:\"".$runner{'gp'}."\",CPlace:\"".$runner{'cp'}."\"}";
        
        next($fastrunner);
        $i++;
    }

    foreach ($slowrunner as $runner)
    {
        if ($i>=1)
            echo ",\n";

        $name="<a href=/racestats.php?race=".$race."&bib=".$runner['bib'].">".$runner['name']."</a>";
        //echo"{Place:\"".$runner{'gtplace'}."\",Name:\"".$name."\",Category:\"".$runner{'category'}."\",GunTime:\"".$runner{'guntime'}."\",ChipTime:\"".$runner{'chiptime'}."\",GPlace:\"".$runner{'gp'}."\",CPlace:\"".$runner{'cp'}."\"}";
        echo"{Place:\"".$runner{'gtplace'}."\",Name:\"".$name."\",Bib:\"".$runner{'bib'}."\",Category:\"".$runner{'category'}."\",GunTime:\"".$runner{'guntime'}."\",ChipTime:\"".$runner{'chiptime'}."\",Split:\"".$runner{'split'}."\",GPlace:\"".$runner{'gp'}."\",CPlace:\"".$runner{'cp'}."\"}";
        
        next($slowrunner);
        $i++;
    }
}

function outputFastRunners()
{
    global $fastrunner,$me,$fast_total,$race;

    foreach ($fastrunner as $runner)
    {
        if ($runner['spguntime']>$me['spguntime'])
        {
            if ($fast_total>=1)
                echo ",\n";

            $name="<a href=/racestats.php?race=".$race."&bib=".$runner['bib'].">".$runner['name']."</a>";
            //echo"{Place:\"".$runner{'gtplace'}."\",Name:\"".$name."\",Bib:\"".$runner{'bib'}."\",Category:\"".$runner{'category'}."\",GunTime:\"".$runner{'guntime'}."\",ChipTime:\"".$runner{'chiptime'}."\",Split:\"".$runner{'split'}."\",GPlace:\"".$runner{'gp'}."\",CPlace:\"".$runner{'cp'}."\"}";
            echo"{Place:\"".$runner{'gtplace'}."\",Name:\"".$name."\",Bib:\"".$runner{'bib'}."\",Category:\"".$runner{'category'}."\",GunTime:\"".$runner{'guntime'}."\",ChipTime:\"".$runner{'chiptime'}."\",SpGunTime:\"".$runner{'spguntime'}."\",SpChipTime:\"".$runner{'split'}."\",GPlace:\"".$runner{'gp'}."\",CPlace:\"".$runner{'cp'}."\"}";

            $fast_total++;
        }

        if ($me['chiptime']>$runner['chiptime'])
            $me['ctplace']++;

        next($fastrunner);
    }
}

function outputSlowRunners()
{
    global $slowrunner,$me,$slow_total,$race;

    foreach ($slowrunner as $runner)
    {
        if ($runner['spguntime']!=null&&$runner['spguntime']<$me['spguntime'])
        {
            if ($slow_total>=1)
                echo ",\n";

            $name="<a href=/racestats.php?race=".$race."&bib=".$runner['bib'].">".$runner['name']."</a>";
            //echo"{Place:\"".$runner{'gtplace'}."\",Name:\"".$name."\",Category:\"".$runner{'category'}."\",GunTime:\"".$runner{'guntime'}."\",ChipTime:\"".$runner{'chiptime'}."\",GPlace:\"".$runner{'gp'}."\",CPlace:\"".$runner{'cp'}."\"}";
            //echo"{Place:\"".$runner{'gtplace'}."\",Name:\"".$name."\",Bib:\"".$runner{'bib'}."\",Category:\"".$runner{'category'}."\",GunTime:\"".$runner{'guntime'}."\",ChipTime:\"".$runner{'chiptime'}."\",Split:\"".$runner{'split'}."\",GPlace:\"".$runner{'gp'}."\",CPlace:\"".$runner{'cp'}."\"}";
            echo"{Place:\"".$runner{'gtplace'}."\",Name:\"".$name."\",Bib:\"".$runner{'bib'}."\",Category:\"".$runner{'category'}."\",GunTime:\"".$runner{'guntime'}."\",ChipTime:\"".$runner{'chiptime'}."\",SpGunTime:\"".$runner{'spguntime'}."\",SpChipTime:\"".$runner{'split'}."\",GPlace:\"".$runner{'gp'}."\",CPlace:\"".$runner{'cp'}."\"}";

            $slow_total++;
        }

        if ($me['chiptime']>$runner['chiptime'])
            $me['ctplace']++;

        next($slowrunner);
    }
}

function calcPlace()
{
    global $me,$total;

    $me['gtp']=round(($me['gtplace']/$total)*100,2);
    $me['ctp']=round(($me['ctplace']/$total)*100,2);
}
?>
