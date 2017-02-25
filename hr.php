<script language="JavaScript">
function updateHR()
{
    MHR=document.heartrate.max.value;
    rvrJmin=MHR*0.60;
    rvrJmax=MHR*0.65;
    lngRmin=MHR*0.60;
    lngRmax=MHR*0.75;
    esyRmin=MHR*0.65;
    esyRmax=MHR*0.70;
    staRmin=MHR*0.75;
    staRmax=MHR*0.85;
    ecoRmin=MHR*0.85;
    ecoRmax=MHR*0.95;
    spdRmin=MHR*0.95;
    spdRmax=MHR*1.00;

YAHOO.example.monthlyExpenses[0].min=rvrJmin;
YAHOO.example.monthlyExpenses[0].max=rvrJmax;

YAHOO.example.monthlyExpenses[1].min=lngRmin;
YAHOO.example.monthlyExpenses[1].max=lngRmax;

YAHOO.example.monthlyExpenses[2].min=esyRmin;
YAHOO.example.monthlyExpenses[2].max=esyRmax;

YAHOO.example.monthlyExpenses[3].min=staRmin;
YAHOO.example.monthlyExpenses[3].max=staRmax;

YAHOO.example.monthlyExpenses[4].min=ecoRmin;
YAHOO.example.monthlyExpenses[4].max=ecoRmax;

YAHOO.example.monthlyExpenses[5].min=spdRmin;
YAHOO.example.monthlyExpenses[5].max=spdRmax;

	//Create Bar Chart
	var barChart = new YAHOO.widget.BarChart( "barchart", myDataSource,
	{
		series:barChartSeriesDef,
		yField: "run",
		xAxis: currencyAxis,
		dataTipFunction: YAHOO.example.getXAxisDataTipText
	});

}
</script>
<form name="heartrate">
Maximum Heart Rate: <input type="text" name="max" value="" onChange="updateHR();">
</form>
Long runs: 60-75% 
Easy runs: 65-70%
Stamina runs: 75-85%
Economy runs: 85-95%
Power runs: 95-100%
Recovery jogs: 60-65%
<p>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>


<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>Charts in a TabView</title>

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
<link rel="stylesheet" type="text/css" href="yui2/build/tabview/assets/skins/sam/tabview.css" />
<script type="text/javascript" src="yui2/build/yahoo-dom-event/yahoo-dom-event.js"></script>
<script type="text/javascript" src="yui2/build/json/json-min.js"></script>
<script type="text/javascript" src="yui2/build/element/element-min.js"></script>
<script type="text/javascript" src="yui2/build/datasource/datasource-min.js"></script>
<script type="text/javascript" src="yui2/build/swf/swf-min.js"></script>
<script type="text/javascript" src="yui2/build/charts/charts-min.js"></script>
<script type="text/javascript" src="yui2/build/tabview/tabview-min.js"></script>


<!--begin custom header content for this example-->
<style type="text/css">
	.chart
	{
		width: 500px;
		height: 350px;
		margin-bottom: 10px;
	}

	.chart_title
	{
		display: block;
		font-size: 1.2em;
		font-weight: bold;
		margin-bottom: 0.4em;
	}

	#tabContainer
	{
		width: 520px;
	}
</style>

<!--end custom header content for this example-->

</head>

<body class="yui-skin-sam">

<span class="chart_title">Heart Rate Training Zones</span>
<div id="tabContainer"></div>
<script type="text/javascript">

	YAHOO.widget.Chart.SWFURL = "yui2/build/charts/assets/charts.swf";

//--- DataSource

	YAHOO.example.monthlyExpenses =
	[
		{ run: "Recovery Run", min: 0, max: 0 },
		{ run: "Long Run", min: 0, max: 0 },
		{ run: "Easy Run", min: 0, max: 0 },
		{ run: "Stamina Run", min: 0, max: 0 },
		{ run: "Economy Run", min: 0, max: 0 },
		{ run: "Power Run", min: 0, max: 0 }
	];

	var myDataSource = new YAHOO.util.DataSource( YAHOO.example.monthlyExpenses );
	myDataSource.responseType = YAHOO.util.DataSource.TYPE_JSARRAY;
	myDataSource.responseSchema =
	{
		fields: [ "run", "min", "max" ]
	};

//--- tabView

	//Create a TabView
	var tabView = new YAHOO.widget.TabView();

	//Add a tab for the Bar Chart
	tabView.addTab( new YAHOO.widget.Tab({
			label: 'Heart Rate Training Zone',
			content: '<span class="chart_title">Bar Chart</span><div class="chart" id="barchart"></div>',
			active: true
	}));

	//Append TabView to its container div
	tabView.appendTo('tabContainer');


//--- chart

	//series definition for Bar Chart
	var barChartSeriesDef =
	[
		{ displayName: "minimum HR", xField: "min" },
		{ displayName: "maximum HR", xField: "max" }
	];

	//format currency
	YAHOO.example.formatCurrencyAxisLabel = function( value )
	{
		return YAHOO.util.Number.format( value,
		{
			prefix: "",
			thousandsSeparator: "",
			decimalPlaces: 0
		});
	}

	//return the formatted text
	YAHOO.example.getDataTipText = function( item, index, series, axisField )
	{
		var toolTipText = series.displayName + " for " + item.run;
		toolTipText += "\n" + YAHOO.example.formatCurrencyAxisLabel( item[series[axisField]] );
		return toolTipText;
	}

	//DataTip function for the Bar Chart
	YAHOO.example.getXAxisDataTipText = function( item, index, series )
	{
		return YAHOO.example.getDataTipText(item, index, series, "xField");
	}

	//create a Numeric Axis for displaying dollars
	var currencyAxis = new YAHOO.widget.NumericAxis();
	currencyAxis.minimum = 0;
	currencyAxis.labelFunction = YAHOO.example.formatCurrencyAxisLabel;

	//Create Bar Chart
	var barChart = new YAHOO.widget.BarChart( "barchart", myDataSource,
	{
		series:barChartSeriesDef,
		yField: "run",
		xAxis: currencyAxis,
		dataTipFunction: YAHOO.example.getXAxisDataTipText
	});
</script>

</body>
</html>
