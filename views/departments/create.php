<h1></h1>
<form action="/departments/edit?id=<?php echo $department['id']; ?>" method="post">
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $department['name']; ?>" required>    
</div>
<div class="form-group">
<label for="description">Description:</label>
<textarea id="description" name="description"><?php echo $department['description']; ?></textarea>
</div>
<button type="submit" class="btn">Update Department</button>


</form>