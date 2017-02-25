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
<link rel="stylesheet" type="text/css" href="yui2/build/paginator/assets/skins/sam/paginator.css" />
<link rel="stylesheet" type="text/css" href="yui2/build/datatable/assets/skins/sam/datatable.css" />
<script type="text/javascript" src="yui2/build/yahoo-dom-event/yahoo-dom-event.js"></script>
<script type="text/javascript" src="yui2/build/connection/connection-min.js"></script>
<script type="text/javascript" src="yui2/build/json/json-min.js"></script>
<script type="text/javascript" src="yui2/build/element/element-min.js"></script>
<script type="text/javascript" src="yui2/build/paginator/paginator-min.js"></script>
<script type="text/javascript" src="yui2/build/datasource/datasource-min.js"></script>
<script type="text/javascript" src="yui2/build/event-delegate/event-delegate-min.js"></script>
<script type="text/javascript" src="yui2/build/datatable/datatable-min.js"></script>


<!--begin custom header content for this example-->
<style type="text/css">
    #paginated {
        text-align: center;
    }
    #paginated table {
        margin-left:auto; margin-right:auto;
    }
    #paginated, #paginated .yui-dt-loading {
        text-align: center; background-color: transparent;
    }
</style>

<!--end custom header content for this example-->

</head>

<body class="yui-skin-sam">
<? include "navigator.php"; ?>
<div id="paginated"></div>

<script type="text/javascript">
YAHOO.util.Event.onDOMReady(function() {
    YAHOO.example.ClientPagination = function() {
        var myColumnDefs = [
        {key:"Place", label:"Place", sortable:true},
        {key:"Name", label:"Name", sortable:true},
        {key:"Bib", label:"Bib", sortable:true},
        {key:"Category", label:"Category", sortable:true},
        {key:"GunTime", label:"Gun Time", sortable:true},
        {key:"ChipTime", label:"Chip Time", sortable:true},
        {key:"Split", label:"<?=$SPLIT_LABEL?> Split", sortable:true},
        {key:"GPlace", label:"Gender Place", sortable:true},
        {key:"CPlace", label:"Category Place", sortable:true}
        ];

        var runners = [
        <? outputAllRunners(); ?>
        ];

        var myDataSource = new YAHOO.util.DataSource(runners);
        myDataSource.responseType = YAHOO.util.DataSource.TYPE_JSARRAY;
        myDataSource.responseSchema = {
            fields: ["Place","Name","Bib","Category","GunTime","ChipTime","Split","GPlace","CPlace"]
        };

        var oConfigs = {
                paginator: new YAHOO.widget.Paginator({
                    rowsPerPage: 200,
                    template: YAHOO.widget.Paginator.TEMPLATE_ROWS_PER_PAGE,
                    rowsPerPageOptions: [100, 200, 300, 500, 1000, 2000] 
                }),
        };
        var myDataTable = new YAHOO.widget.DataTable("paginated", myColumnDefs, myDataSource, oConfigs);
                
        return {
            oDS: myDataSource,
            oDT: myDataTable
        };
    }();
});
</script>
</body>
</html>
