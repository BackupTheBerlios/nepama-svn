<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
 "http://www.w3.org/TR/xhtml1/DTD/Strict.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" lang="de">
<head>
 <title>{$page_title}</title>
 <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
 <link rel="stylesheet" type="text/css" href="{$templatedir}style.css" />
 </head>
<body>


<div id="title">anime.air</div>

<div id="container"> 
 <div id="content">
 {$maincontent}
 </div>
</div>

 <ul id="menu">
 {section name=menupoint loop=$menu}
   <li>{if $menu[menupoint].islink eq "true"}<a href="{$menu[menupoint].link}">{$menu[menupoint].title}</a>{else}{$menu[menupoint].title}{/if}</li>
 {sectionelse}
   <li>Keine Einträge vorhanden</li>
 {/section}
</ul> 
  
<div id="versionstring" class="small">powered by nepama-{$nepa_version} &#8222;{$nepa_codename}&#8220; -- #DEBUGDATA#</div>

<div id="img">&nbsp;</div>

</body>
</html>