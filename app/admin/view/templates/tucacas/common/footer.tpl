                <div class="footer">
                    <div class="pull-right">
                        10GB of <strong>250GB</strong> Free.
                    </div>
                    <div>
                        <?php echo $Language->get('text_footer'); ?>
                    </div>
                </div>

            <!-- <div class="col-lg-12"> -->
            </div>

        <!-- <div class="row"> -->
        </div>
    <!-- #page-wrapper -->
    </div>
<!-- #wrapper -->
</div>

<?php if ($javascripts) foreach ($javascripts as $js) echo '<script src="'. $js .'"></script>'; ?>
<?php if ($scripts) echo $scripts; ?>
</body></html>