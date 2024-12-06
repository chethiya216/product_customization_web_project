function selectColor(color) {
    document.querySelectorAll('.color-button').forEach(button => button.classList.remove('selected'));
    event.target.classList.add('selected');
    document.getElementById('tshirt-preview').style.backgroundColor = color;
}

function selectDesign(design) {
    document.querySelectorAll('.design-button').forEach(button => button.classList.remove('selected'));
    event.target.parentElement.classList.add('selected');
    document.getElementById('tshirt-preview').src = design;
}

function uploadDesign() {
    const formData = new FormData(document.getElementById('uploadForm'));
    fetch('upload_design.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            location.reload();
        } else {
            alert(data.message);
        }
    });
}

function removeDesign(name) {
    fetch('upload_design.php', {
        method: 'POST',
        body: 'action=remove&name=' + encodeURIComponent(name)
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            location.reload();
        }
    });
}

function selectColor(color) {
    //to remove the selected class from all color buttons
    document.querySelectorAll('.color-button').forEach(button => button.classList.remove('selected'));

    //to add the selected class to the clicked button
    event.target.classList.add('selected');

    //inorder to change the background color of the preview box
    const previewBox = document.querySelector('.preview-box');
    previewBox.style.backgroundColor = color; // Apply the selected color as the background
}

function selectColor(imagePath) {
    //to remove the selected class from all color buttons
    document.querySelectorAll('.color-button').forEach(button => button.classList.remove('selected'));

    //to add the selected class to the clicked button
    event.target.classList.add('selected');

    //to change the preview image source
    const previewImage = document.getElementById('tshirt-preview');
    previewImage.src = imagePath;
}