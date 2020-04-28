<?php
/**
 * Site Footer
 *
 * @package      RedBridge
 * @author       Red Bridge Internet
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

?>
        </div> <?php // .site-inner ?>

        <?php tha_footer_before() ?>

        <footer class="site-footer" role="contentinfo">
            <div class="wrap">
                <?php
                tha_footer_top();
                tha_footer_bottom();
                ?>
            </div>
        </footer>

        <?php tha_footer_after() ?>

    </div>
    <?php
    tha_body_bottom();
    wp_footer();
    ?>

</body>
</html>
