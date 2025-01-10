{config_load file="db.conf" section="AdminPanel"}
{include file="header.tpl" title=foo}

<div id="navbar">
    <a href="#home">Home</a>
    <a href="#books">Books</a>
    <a href="#movies">Movies</a>
    <input type="text" placeholder="Search..">
</div>

<p>This site will grow as we add more ...</p>
</div>

<h2>Books</h2>
<div class="slideshow-container">
  <div class="slides">
    {* automate *}
    {foreach $books as $book}
      <div class="slide"><a href="index.php?page=book&id={$book.book_ID}"><img src="https://img.freepik.com/premium-photo/purple-background-with-purple-background-that-says-purple_517312-43531.jpg" alt="{$book.name}"></a></div>  {* src="{$book.cover}" - add when thumbnails are done*}
    {/foreach}
  </div>
</div>


<h2>Movies</h2>
<div class="slideshow-container">
  <div class="slides">
    {* automate *}
    {foreach $movies as $movie}
      <div class="slide"><a href="index.php?page=movie&id={$movie.movie_ID}"><img src="https://img.freepik.com/premium-photo/purple-background-with-purple-background-that-says-purple_517312-43531.jpg" alt="{$movie.name}"></a></div>  {* src="{$movie.cover}" - add when thumbnails are done*}
    {/foreach}
  </div>
</div>


<h2>Photos</h2>
<div class="slideshow-container">
  <div class="slides">
    {* automate *}
    {foreach $photos as $photo}
      <div class="slide"><a href="index.php?page=photo&id={$photo.photo_ID}"><img src="{$photo.source_address}" alt="{$photo.name}"></a></div>
    {/foreach}
  </div>
</div>


<h2>Others</h2>
<div class="slideshow-container">
  <div class="slides">
    {* automate *}
    {foreach $others as $other}
      <div class="slide"><a href="index.php?page=other&id={$other.other_ID}"><img src="https://img.freepik.com/premium-photo/purple-background-with-purple-background-that-says-purple_517312-43531.jpg" alt="{$other.name}"></a></div>  {* src="{$other.cover}" - add when thumbnails are done*}
    {/foreach}
  </div>
</div>

{include file="footer.tpl"}
