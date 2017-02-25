<?
include "raceanalyzer.php";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<? include "header.php"; ?>

<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Race Stats</title>

<style type="text/css">
/*margin and padding on body element
  can introduce errors in determining
  element position and are not recommended;
  we turn them off as a foundation for YUI
  CSS treatments. */
body {
	margin:0;
	padding:0;
}
</style>

<link rel="stylesheet" type="text/css" href="yui2/build/fonts/fonts-min.css" />
<link rel="stylesheet" type="text/css" href="yui2/build/button/assets/skins/sam/button.css" />
<link rel="stylesheet" type="text/css" href="yui2/build/datatable/assets/skins/sam/datatable.css" />
<script type="text/javascript" src="yui2/build/yahoo-dom-event/yahoo-dom-event.js"></script>
<script type="text/javascript" src="yui2/build/element/element-min.js"></script>
<script type="text/javascript" src="yui2/build/button/button-min.js"></script>
<script type="text/javascript" src="yui2/build/datasource/datasource-min.js"></script>
<script type="text/javascript" src="yui2/build/event-delegate/event-delegate-min.js"></script>
<script type="text/javascript" src="yui2/build/datatable/datatable-min.js"></script>

<style type="text/css">
    #stats {
        text-align: center;
    }

    #faster table {
        margin-left:auto; margin-right:auto;
    }
    #faster, #faster.yui-dt-loading {
        text-align: center; background-color: transparent;
    }

    #slower table {
        margin-left:auto; margin-right:auto;
    }
    #slower, #slower.yui-dt-loading {
        text-align: center; background-color: transparent;
    }

</style>
</style>


</head>

<body class="yui-skin-sam">
<? include "navigator.php"; ?>
<div id="stats" class=""></div>
<div id="faster"></div>
<div id="slower"></div>

<script type="text/javascript">
YAHOO.util.Event.addListener(window, "load", function() {
    YAHOO.example.Basic = function() {
    var cols = [
        {key:"Place", label:"Place", sortable:true},
        {key:"Name", label:"Name", sortable:true},
        {key:"Bib", label:"Bib", sortable:true},
        {key:"Category", label:"Category", sortable:true},
        {key:"GunTime", label:"Gun Time", sortable:true},
        {key:"ChipTime", label:"Chip Time", sortable:true},
        {key:"SpGunTime", label:"<?=$SPLIT_LABEL?> Gun", sortable:true},
        {key:"SpChipTime", label:"<?=$SPLIT_LABEL?> Chip", sortable:true},
        {key:"GPlace", label:"Gender Place", sortable:true},
        {key:"CPlace", label:"Category Place", sortable:true}
    ];

    var faster = [
        <? outputFastRunners(); ?>
    ];

    var slower = [
        <? outputSlowRunners(); ?>
    ];

    var fasterRunnerDS = new YAHOO.util.DataSource(faster);
    fasterRunnerDS.responseType = YAHOO.util.DataSource.TYPE_JSARRAY;
    fasterRunnerDS.responseSchema = {
        fields: ["Place","Name","Bib","Category","GunTime","ChipTime","SpGunTime","SpChipTime","GPlace","CPlace"]
    };

    var slowerRunnerDS = new YAHOO.util.DataSource(slower);
    slowerRunnerDS.responseType = YAHOO.util.DataSource.TYPE_JSARRAY;
    slowerRunnerDS.responseSchema = {
        fields: ["Place","Name","Bib","Category","GunTime","ChipTime","SpGunTime","SpChipTime","GPlace","CPlace"]
    };

    var fasterRunner = new YAHOO.widget.DataTable("faster", cols, fasterRunnerDS, {caption:"<?=$fast_total?> runners passed you after <?=$SPLIT_LABEL?>"});
    var slowerRunner = new YAHOO.widget.DataTable("slower", cols, slowerRunnerDS, {caption:"<?=$slow_total?> runners you passed after <?=$SPLIT_LABEL?>"});
                
        return {
            oDSf: faster,
            oDTf: fasterRunner,
            oDSf: slower,
            oDTf: slowerRunner
        };
    }();
});

<? calcPlace(); ?>

var statsHTML="";

statsHTML+="name: <?=$me["name"]?><br>";
statsHTML+="gun time:<?=$me["guntime"]?><br>";
statsHTML+="chip time: <?=$me["chiptime"]?><br>";
statsHTML+="<?=$SPLIT_LABEL?> split guntime: <?=$me['spguntime']?><br>";
statsHTML+="<?=$SPLIT_LABEL?> split chiptime: <?=$me["split"]?><br>";
statsHTML+="guntime place: <?=$me["gtplace"]?>/<?=$total?><br>";
//statsHTML+="chiptime place: <?=$me["ctplace"]?>/<?=$total?><br>";
statsHTML+="gender place: <?=$me["gp"]?><br>";
statsHTML+="category place: <?=$me["cp"]?><br>";
statsHTML+="gender percentile: <?=$me['gpp']?>%<br>";
statsHTML+="category percentile: <?=$me['cpp']?>%<br>";
statsHTML+="guntime percentile: <?=$me['gtp']?>%<br>";
statsHTML+="chiptime percentile: <?=$me['ctp']?>%<br>";
statsHTML+="start delay: <?=date("i:s",$me['starttime'])?><br>";

statsHTML+="<?=$fast_total?> runners passed you after <?=$SPLIT_LABEL?><br>";
statsHTML+="<?=$slow_total?> runners you passed after <?=$SPLIT_LABEL?><br>";

document.getElementById('stats').innerHTML=statsHTML+"<hr>";

</script>

</body>
</html>
