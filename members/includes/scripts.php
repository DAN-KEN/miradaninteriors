<script src="<?php echo $adminURL; ?>assets/js/jquery.js"></script>
<script src="<?php echo $adminURL; ?>assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="<?php echo $adminURL; ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo $adminURL; ?>assets/vendor/chart.js/chart.min.js"></script>
<script src="<?php echo $adminURL; ?>assets/vendor/echarts/echarts.min.js"></script>
<script src="<?php echo $adminURL; ?>assets/vendor/quill/quill.min.js"></script>
<script src="<?php echo $adminURL; ?>assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="<?php echo $adminURL; ?>assets/vendor/tinymce/tinymce.min.js"></script>
<script src="<?php echo $adminURL; ?>assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="<?php echo $adminURL; ?>assets/js/main.js"></script>


<script type="text/javascript">
    $(document).ready(function() {
        $(".msg-alert").delay(5000).slideUp(200, function() {
            $(this).alert('close');
        });
    });

    // Live preview chosen image file
    function displayImage(e) {
        if (e.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('.imageThumb').setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(e.files[0]);
        }
    }

</script>
