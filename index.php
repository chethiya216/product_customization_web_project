<?php

include 'config.php';
include 'functions.php';
include 'includes/header.php';
?>

<div class="container">
    <!-- Left Panel: Colors -->
    <div class="panel colors" >
        <h2>Available Colors</h2>
        <?php

        $colors = getAllColors();
        foreach ($colors as $color) {
            $colorImage = "imgs/" . strtolower($color['name']) . ".png"; 
            echo '<div class="color-preview">';
            echo '<button class="color-button" style="background-color: ' . htmlspecialchars($color['hex']) . ';" onclick="selectColor(\'' . htmlspecialchars($colorImage) . '\')"></button>';
            echo '<span>' . htmlspecialchars($color['name']) . '</span>';
            echo '</div>';
        }
        ?>
    </div>

    <!-- Center Panel: Preview -->
    <div class="panel preview">
    <h2>Preview</h2>
    <div class="preview-box" >
        <!-- preview image here -->
        <img id="tshirt-preview" src="imgs/redblack.png" alt="T-Shirt Preview" style="max-width: 100%; max-height: 100%; z-index: 1;">
    </div>
    </div>


    <!-- Right Panel: Designs -->
    <div class="panel options">
        <h2>Available Designs</h2>
        <div class="option-group" id="design-buttons">
            <?php
            //to fetch all designs from the database
            $designs = getUploadedDesigns();
            
            //to theck if there are designs
            if ($designs):
                foreach ($designs as $design):
                    //to ensure the file_path exists
                    if (isset($design['file_path'])):
                        //to construct the full path using the fixed directory and the filename
                        $filePath = 'uploads/' . $design['file_path'];
                        ?>
                        <button class="design-button" onclick="selectDesign('<?php echo htmlspecialchars($filePath); ?>')">
                            <img src="<?php echo htmlspecialchars($filePath); ?>" alt="<?php echo htmlspecialchars($design['name']); ?>" style="width: 100px; height: 100px; object-fit: cover;">
                        </button>
                        <?php
                    else:
                        echo '<p>Missing file path for design: ' . htmlspecialchars($design['name']) . '</p>';
                    endif;
                endforeach;
            else:
                echo '<p>No designs available.</p>';
            endif;
            ?>
        </div>
    </div>
</div>

<script src="js/script.js"></script>
<?php
include 'includes/footer.php';
?>