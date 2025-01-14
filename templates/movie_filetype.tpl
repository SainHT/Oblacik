{config_load file="test.conf" section="setup"}
{include file="header.tpl"}
{include file="navbar.tpl" title=foo}

<body>
  <div id="vidbox">

    <video id="video" controls>
      <source src="https://www.youtube.com/watch?v=wDchsz8nmbo" type="video/mp4">
    Your browser does not support the video tag.
    </video>

    <div id="vidaccesories">
      <h3>Name of this movie</h3>

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