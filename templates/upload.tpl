{config_load file="test.conf" section="setup"}
{include file="header.tpl"}

<div class="login">
    <div class="form">
        <h1>Upload here</h1>
        <form id="uploadForm" method="post" enctype="multipart/form-data" >
            <label for="file">Choose a file</label>
            <input type="file" name="file" id="file" required>

            <label for="thumbnail">Choose a thumbnail image</label>
            <input type="file" name="thumbnail" id="thumbnail">
            
            <label for="title">Title</label>
            <input type="text" name="title" id="title" placeholder="Title" value="{$data['title']|default:''}" required>
            
            <label for="description">Description</label>
            <textarea name="description" id="description" placeholder="Description" required>{$data['description']|default:''}</textarea>
            
            {* <label for="categories">Categories</label>
            <input type="text" name="categories" id="categories" placeholder="Split using commas" value="{$data['categories']|default:''}"> *}
            
            <input type="button" value="Upload" onclick="uploadManager()">
        </form>
        <progress id="progressBar" value="0" max="100" style="width: 100%;"></progress>
        <p class="message"><a href="index.php">Back to home</a></p>
    </div>
</div>
{include file="footer.tpl"}