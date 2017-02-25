<script language="JavaScript">

function runRaceStats()
{
    if (document.raceForm.bib.value.length>0)
    {
        raceForm.action='racestats.php';
        raceForm.submit();
    }
}
</script>

<html>
<head>
<? include "header.php"; ?>
<style type="text/css">
p.serif{font-family:"Times New Roman",Times,serif;}
p.sans{font-family:Arial,Helvetica,sans-serif;}
</style>
</head>

<body onLoad="document.raceForm.bib.value='';">
<center>
<p class="sans">
find out more about your race stats ... have fun!<br> 
</p>
<form name="raceForm" action="raceresults.php" method="GET" onSubmit="runRaceStats();">
    <select name="race">
        <option value="2014torm">2014 Goodlife Toronto Marathon</option>
        <option value="2014missm">2014 Mississauga Marathon</option>
        <option value="2012atb30">2012 Around the Bay 30k</option>
        <option value="2011acura10">2011 Acura 10 Miler</option>
        <option value="2011ottawam">2011 Ottawa Marathon</option>
        <!--option value="2011ottawah">2011 Ottawa Half Marathon</option-->
        <option value="2011calm">2011 Calgary Marathon</option>
        <option value="2011nosem">2011 Scotiabank Blue Nose Marathon</option>
        <option value="2011missm">2011 Mississauga Marathon</option>
        <option value="2011missh">2011 Mississauga Half Marathon</option>
        <option value="2011torm">2011 Goodlife Toronto Marathon</option>
        <option value="2011bmovm">2011 BMO Vancouver Marathon</option>
        <option value="2011bay30">2011 Around The Bay 30k</option>
        <option value="2010nfm">2010 Niagara Falls Marathon</option>
        <option value="2010ottawam">2010 Ottawa Marathon</option>
        <option value="2010ottawah">2010 Ottawa Half Marathon</option>
    </select>
    <p class="sans">BIB (optional):<input type="text" size="5" maxlength="5" name="bib" value="">
    <input type="submit" value="Run"></p>
</form>

<!--pre>
please note: 2010 Ottawa Half shows inaccurate stats due to place is done by chip time instead of gun time, it will be fixed.
</pre-->

<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#appId=203492409693833&amp;xfbml=1"></script><fb:like href="http://racestats.felixwu.com" send="false" width="450" show_faces="true" font="lucida grande"></fb:like>

</center>
</body>
</html>
