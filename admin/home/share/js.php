<!-- Jquery JS-->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS       -->
    <script src="vendor/slick/slick.min.js">
    </script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/bootstrap-progressbar/bootstrap-progressbar.min.js">
    </script>
    <script src="vendor/counter-up/jquery.waypoints.min.js"></script>
    <script src="vendor/counter-up/jquery.counterup.min.js">
    </script>
    <script src="vendor/circle-progress/circle-progress.min.js"></script>
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="vendor/chartjs/Chart.bundle.min.js"></script>
    <script src="vendor/select2/select2.min.js">
    </script>
    <script src="vendor/vector-map/jquery.vmap.js"></script>
    <script src="vendor/vector-map/jquery.vmap.min.js"></script>
    <script src="vendor/vector-map/jquery.vmap.sampledata.js"></script>
    <script src="vendor/vector-map/jquery.vmap.world.js"></script>

    <!-- Main JS-->
    <script src="js/main.js"></script>
	
	<!-- Toastr JS-->
	<script src="js/toastr.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

	
	<script>
    function previewImage(event) {
        const file = event.target.files[0];  // Get the selected file
        const reader = new FileReader();     // Create a FileReader object

        reader.onload = function(e) {
            const imagePreview = document.getElementById('imagePreview');
            imagePreview.src = e.target.result;  // Set the image source to the uploaded file
            imagePreview.style.display = 'block'; // Show the image preview
        }

        if (file) {
            reader.readAsDataURL(file);  // Read the file as a data URL (base64 encoded)
        }
    }
</script>

<script>
function previewImages(event, previewContainerId) {
    const files = event.target.files;  // Get the selected files
    const previewContainer = document.getElementById(previewContainerId);

    // Clear the previous preview images
    previewContainer.innerHTML = '';

    if (!files || files.length === 0) return;

    Array.from(files).forEach((file) => {
        const reader = new FileReader();

        reader.onload = function (e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.width = '100px'; // Adjust image size as needed
            img.style.margin = '5px';
            img.style.borderRadius = '5px';

            previewContainer.appendChild(img);
        };

        reader.readAsDataURL(file);
    });
}
</script>