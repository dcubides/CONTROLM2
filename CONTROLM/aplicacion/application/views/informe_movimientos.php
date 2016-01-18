

<?php 
    foreach($css_files as $file): ?>
    	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
    <?php endforeach; ?>
    <?php foreach($js_files as $file): ?>
    	<script src="<?php echo $file; ?>"></script>
    <?php endforeach; ?>
    
   
    	
<!--Body content-->
       
            <div class="contentwrapper"><!--Content wrapper-->
                <!-- Build page from here: -->
                <div class="row-fluid">
					<?php echo $output; ?>
                </div><!-- End .row-fluid -->
                <!--End page -->
                