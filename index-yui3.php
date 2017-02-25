<?
include "raceanalyzer.php";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Race Result Stats</title>

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

<link type="text/css" rel="stylesheet" href="yui/build/cssfonts/fonts-min.css" />
<script type="text/javascript" src="yui/build/yui/yui-min.js"></script>


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

<div id="result" class="dt-example"></div>

<script type="text/javascript">
YUI({ filter: 'raw' }).use("datatable-sort", function (Y) {
    var cols = [
        {key:"Place", label:"Place", sortable:true},
        {key:"Name", label:"Name", sortable:true},
        {key:"Category", label:"Category", sortable:true},
        {key:"GunTime", label:"Gun Time", sortable:true},
        {key:"ChipTime", label:"Chip Time", sortable:true},
        {key:"GPlace", label:"Gender Place", sortable:true},
        {key:"CPlace", label:"Category Place", sortable:true}
    ],
    runners = [
        <? outputAllRunners(); ?>
    ],

    dt1 = new Y.DataTable.Base({columnset:cols, recordset:runners, summary:"Contacts list", caption:"All Runners"}).plug(Y.Plugin.DataTableSort).render("#result")
    
});

</script>

</body>
</html>
