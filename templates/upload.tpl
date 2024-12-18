{config_load file="test.conf" section="setup"}
{include file="header.tpl"}

<div>
    {$message|default:''}
    <h1>Upload here</h1>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="file">Choose a file</label>
        <input type="file" name="file" id="file">
        
        <label for="title">Title</label>
        <input type="text" name="title" id="title" placeholder="Title" value="{$data['title']|default:''}">
        
        <label for="description">Description</label>
        <textarea name="description" id="description" placeholder="Description">{$data['description']|default:''}</textarea>
        
        <label for="categories">Categories</label>
        <input type="text" name="categories" id="categories" placeholder="Split using commas" value="{$data['categories']|default:''}">

        <input type="submit" value="Upload" name="submit">
    </form>
    <p><a href="index.php">Back to home</a></p>
</div>
{include file="footer.tpl"}