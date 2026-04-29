<h1>Departments</h1>
<a href="/departments/create">Create New Department</a>
<table>
    <tr>
        <th>Name</th>
        <th>Description</th>
        <th>Actions</th>
</tr>
</php foreach ($departments as $department): ?>
    <tr>
        <td><?php echo $department['id']; ?></td>
        <td><?php echo $department['name']; ?></td>
        <td><?php echo $department['description']; ?></td>
        <td>
            <a href="/departments/edit/<?php echo $department['id']; ?>">Edit</a>
            <a href="/departments/delete/<?php echo $department['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
<?php endforeach; ?>
</table>