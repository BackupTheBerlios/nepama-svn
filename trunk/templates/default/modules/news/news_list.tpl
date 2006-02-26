<h1>&rarr; Newsübersicht</h1>

<br/>

{section name=news loop=$newslist}
<div class="post">
<h2>&rarr; <a href="$$?m={$module_action}&amp;do=show&amp;id={$newslist[news].id}">{$newslist[news].title}</a></h2>
<p class="textj">{$newslist[news].content}</p>
<p class="small" style="text-align: right;">Verfasst von {$newslist[news].name} am {$newslist[news].date}</p>
</div><br/>
 {sectionelse}
<div class="post">
 <p class="textj">Keine Artikel vorhanden</p>
</div><br/>
 {/section}

{pagelist perpage="$perpage" currentpage="$page" count="$count" link="$$?m=$module_action&amp;page=" sep=" "}