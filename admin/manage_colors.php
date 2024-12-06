<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Colors</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="admin-container">
        <h1>Manage Colors</h1>
        <form id="colorForm">
            <label for="colorName">Color Name:</label>
            <input type="text" id="colorName" name="colorName" required>
            <label for="colorHex">Color Hex Code:</label>
            <input type="text" id="colorHex" name="colorHex" required>
            <button type="button" onclick="addColor()">Add Color</button>
        </form>

        <h2>Available Colors</h2>
        <div class="color-boxes" id="color-boxes">
            <?php
            include '../functions.php';
            $colors = getAllColors();
            foreach ($colors as $color): ?>
                <div class="color-box" style="background-color: <?php echo $color['hex']; ?>;">
                    <?php echo $color['name']; ?>
                    <button class="remove-button" onclick="removeColor('<?php echo $color['name']; ?>')">×</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

    <script>
    function addColor() {
        const formData = new FormData(document.getElementById('colorForm'));

        fetch('manage_colors.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Color added successfully.');
                location.reload(); //to refresh color list
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    function removeColor(name) {
        fetch('manage_colors.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'action=remove&name=' + encodeURIComponent(name)
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert('Color removed successfully.');
                location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }
    </script>
</body>
</html>
