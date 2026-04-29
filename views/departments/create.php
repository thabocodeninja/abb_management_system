<h1>Add Department</h1>
<form action="/departments/create" method="post">
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
</div>
<div class="form-group">
<label for="description">Description:</label>
<textarea id="description" name="description"></textarea>
</div>
<button type="submit" class="btn">Create Department</button>
</form>