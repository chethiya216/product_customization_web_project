<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    <?php
    include '../functions.php';
    
    //handle adding or removing colors and designs
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['addColor'])) {
            //add new color
            $colorName = $_POST['colorName'];
            $colorHex = $_POST['colorHex'];
            addColor($colorName, $colorHex);
        }

        if (isset($_POST['removeColor'])) {
            //remove color
            $colorName = $_POST['colorName'];
            removeColor($colorName);
        }

        if (isset($_POST['addDesign'])) {
            // uppload a new design
            $designName = $_POST['designName'];
            $designFile = $_FILES['designUpload']['tmp_name'];
            $uploadDir = '../uploads/';
            $filePath = $uploadDir . basename($_FILES['designUpload']['name']);
            move_uploaded_file($designFile, $filePath);
            addDesign($designName, $filePath);
        }

        if (isset($_POST['removeDesign'])) {
            //refemove design
            $designName = $_POST['designName'];
            removeDesign($designName);
        }
    }
    ?>

    <header>
        <div class="header-container">
            <h1>Pincha Collections</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                </ul>
            </nav>
        </div>
    </header>   

    <div class="admin-container">
        <!-- Manage Colors -->
        <div class="panel">
            <h2>Manage Colors</h2>
            <form method="POST">
                <label for="colorName">Color Name:</label>
                <input type="text" id="colorName" name="colorName" required>
                <label for="colorHex">Color Hex Code:</label>
                <input type="text" id="colorHex" name="colorHex" required>
                <button type="submit" name="addColor" style="width:fit-content;">Add Color</button>
            </form>

            <h2>Available Colors</h2>
            <div class="color-boxes" id="color-boxes">
                <?php
                $colors = getAllColors(); //get colors from database
                foreach ($colors as $color): ?>
                    <div class="color-preview" style="background-color: <?php echo $color['hex']; ?>;">
                        <?php echo $color['name']; ?>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="colorName" value="<?php echo $color['name']; ?>">
                            <button type="submit" name="removeColor" class="remove-button">×</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Manage Designs -->
        <div class="panel">
            <h2>Manage Designs</h2>
            <form method="POST" enctype="multipart/form-data">
                <label for="designName">Design Name:</label>
                <input type="text" id="designName" name="designName" required>
                <label for="designUpload">Design Image:</label>
                <input type="file" id="designUpload" name="designUpload" accept="image/*" required>
                <button type="submit" name="addDesign" style="width:fit-content;" >Upload Design</button>
            </form>

            <h2>Uploaded Designs</h2>
            <div class="option-group" id="uploaded-designs">
                <?php
                $designs = getUploadedDesigns(); //get uploade desins from the database
                foreach ($designs as $design): ?>
                    <div class="design-item">
                        <img src="<?php echo $design['file_path']; ?>" alt="<?php echo $design['name']; ?>" style="width: 100px; height: 100px; object-fit: cover;">
                        <span><?php echo $design['name']; ?></span>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="designName" value="<?php echo $design['name']; ?>">
                            <button type="submit" name="removeDesign" class="remove-button" >x</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>
</body>
</html>
