<?
include "raceanalyzer.php";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
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

<link type="text/css" rel="stylesheet" href="yui3/build/cssfonts/fonts-min.css" />
<script type="text/javascript" src="yui3/build/yui/yui-min.js"></script>


<!--begin custom header content for this example-->
<style type="text/css">
/* custom styles for this example */
.dt-example {margin:1em;}

/* css to counter global site css */
.dt-example th {text-transform:none;}
.dt-example table {width:auto;}
.dt-example caption {display:table-caption;}
</style>
<!--end custom header content for this example-->

</head>

<body class="yui3-skin-sam  yui-skin-sam">

<div id="stats" class=""></div>
<div id="faster" class="dt-example"></div>
<div id="slower" class="dt-example"></div>

<script type="text/javascript">
YUI({ filter: 'raw' }).use("datatable-sort", function (Y) {
    var cols = [
        {key:"Place", label:"Place", sortable:true},
        {key:"Name", label:"Name", sortable:true},
        {key:"Category", label:"Category", sortable:true},
        {key:"GunTime", label:"Gun Time", sortable:true},
        {key:"ChipTime", label:"Chip Time", sortable:true},
        {key:"Split", label:"<?=$SPLIT_LABEL?> Split", sortable:true},
        {key:"GPlace", label:"Gender Place", sortable:true},
        {key:"CPlace", label:"Category Place", sortable:true}
    ],
    faster = [
        <? outputFastRunners(); ?>
    ],
    slower = [
        <? outputSlowRunners(); ?>
    ],

    dt1 = new Y.DataTable.Base({columnset:cols, recordset:faster, summary:"Contacts list", caption:"runners passed you after <?=$SPLIT_LABEL?>"}).plug(Y.Plugin.DataTableSort).render("#faster")
    dt2 = new Y.DataTable.Base({columnset:cols, recordset:slower, summary:"Contacts list", caption:"runners you passed after <?=$SPLIT_LABEL?>"}).plug(Y.Plugin.DataTableSort).render("#slower")
    
});

<? calcPlace(); ?>

var statsHTML="";

statsHTML+="name: <?=$me["name"]?><br>";
statsHTML+="gun time:<?=$me["guntime"]?><br>";
statsHTML+="chip time: <?=$me["chiptime"]?><br>";
statsHTML+="<?=$SPLIT_LABEL?> split time: <?=$me["split"]?><br>";
statsHTML+="guntime place: <?=$me["gtplace"]?>/<?=$total?><br>";
statsHTML+="chiptime place: <?=$me["ctplace"]?>/<?=$total?><br>";
statsHTML+="gender place: <?=$me["gp"]?><br>";
statsHTML+="category place: <?=$me["cp"]?><br>";
statsHTML+="gender percentile: <?=$me['gpp']?>%<br>";
statsHTML+="category percentile: <?=$me['cpp']?>%<br>";
statsHTML+="guntime percentile: <?=$me['gtp']?>%<br>";
statsHTML+="chiptime percentile: <?=$me['ctp']?>%<br>";

statsHTML+="<?=$fast_total?> runners passed you after <?=$SPLIT_LABEL?><br>";
statsHTML+="<?=$slow_total?> runners you passed after <?=$SPLIT_LABEL?><br>";

document.getElementById('stats').innerHTML=statsHTML+"<hr>";

</script>

</body>
</html>
