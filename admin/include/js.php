      <script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
      <script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
      <script src="css/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
      <script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
      <script src="scripts/datatables/jquery.dataTables.js"></script>
      <script>
         $(document).ready(function() {
         	$('.datatable-1').dataTable();
         	$('.dataTables_paginate').addClass("btn-group datatable-pagination");
         	$('.dataTables_paginate > a').wrapInner('<span />');
         	$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
         	$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
         } );
      </script>
	  
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

