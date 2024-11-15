function updateFileName() {
    const fileInput = document.getElementById('profile_photo');
    const customFileLabel = document.querySelector('.custom-file-label');
    if (fileInput.files.length > 0) {
        customFileLabel.textContent = fileInput.files[0].name;
    } else {
        customFileLabel.textContent = 'Choose file';
    }
}