{config_load file="test.conf" section="setup"}
{include file="header.tpl"}
{include file="navbar.tpl" title=foo}

<img width="240" height="320">
  <source src="movie.mp4" type="media/mp4">
  <source src="movie.ogg" type="media/ogg">
Your browser does not support the media tag.
</img>

<body>

  <div id="mediabox">

    <media id="media" controls>
      <source src="https://www.youtube.com/watch?v=wDchsz8nmbo" type="media/mp4">
    Your browser does not support the media tag.
    </media>

    <div id="mediaaccesories">
      <h3>Name of this </h3>

      <div id="download_butt">
        <a href="#download">DOWNLOAD</a>
      </div>

    </div>

  </div>

  <p1>Content</p1>
  <p>Tento film je fakt super, odporucam 10/10. Urcite si ho pozrite. Tento film je fakt super, odporucam 10/10. Urcite si ho pozrite. Tento film je fakt super, odporucam 10/10. Urcite si ho pozrite. Tento film je fakt super, odporucam 10/10. Urcite si ho pozrite. Tento film je fakt super, odporucam 10/10. Urcite si ho pozrite.</p>
  </div>
</body>
{include file="footer.tpl"}