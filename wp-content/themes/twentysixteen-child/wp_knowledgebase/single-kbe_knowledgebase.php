<?php
    get_header('knowledgebase');

    // load the style and script
    wp_enqueue_style ( 'kbe_theme_style' );
    if( KBE_SEARCH_SETTING == 1 ){
        wp_enqueue_script( 'kbe_live_search' );
    }

    // Classes For main content div
    if(KBE_SIDEBAR_INNER == 0) {
        $kbe_content_class = 'class="kbe_content_full"';
    } elseif(KBE_SIDEBAR_INNER == 1) {
        $kbe_content_class = 'class="kbe_content_right"';
    } elseif(KBE_SIDEBAR_INNER == 2) {
        $kbe_content_class = 'class="kbe_content_left"';
    }

    // Classes For sidebar div
    if(KBE_SIDEBAR_INNER == 0) {
        $kbe_sidebar_class = 'kbe_aside_none';
    } elseif(KBE_SIDEBAR_INNER == 1) {
        $kbe_sidebar_class = 'kbe_aside_left';
    } elseif(KBE_SIDEBAR_INNER == 2) {
        $kbe_sidebar_class = 'kbe_aside_right';
    }
?>
<div id="kbe_container">
    <div class="header-image">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
            <img src="<?php header_image(); ?>" srcset="<?php echo esc_attr( wp_get_attachment_image_srcset( get_custom_header()->attachment_id ) ); ?>" sizes="<?php echo esc_attr( $custom_header_sizes ); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
        </a>
    </div><!-- .header-image -->
    <!--Breadcrum-->
    <?php
        if(KBE_BREADCRUMBS_SETTING == 1){
    ?>
        <div class="kbe_breadcrum">
            <?php echo kbe_breadcrumbs(); ?>
        </div>
    <?php
        }
    ?>
    <!--/Breadcrum-->

    <!--search field-->
    <?php
        if(KBE_SEARCH_SETTING == 1){
            kbe_search_form();
        }
    ?>
    <!--/search field-->

    <!--content-->
    <div id="kbe_content" <?php echo $kbe_content_class; ?>>
        <!--Content Body-->
        <div class="kbe_leftcol" >
        <?php
            while(have_posts()) :
                the_post();

                //  Never ever delete it !!!
                kbe_set_post_views(get_the_ID());
        ?>
                <h1><?php the_title(); ?></h1>
                <!--Original Date-->

                <div class="row">
                    <div class="entry-original">
                        <?php echo 'Published: '?><?php echo the_date()?>
                        <?php echo '@' ?>
                        <?php echo the_time()?>
                        <?php echo ' | By: '. get_author_name( $user_id ); ?>
                    </div>

                <!--Last Modified Date-->

                    <div class="entry-last">
                        <?php echo 'Updated:  '?>
                        <?php echo last_modified(). ' By: '. get_author_name( $user_id ); ?>
                    </div>

                 </div>

                 <!--/row-->
            <?php
                the_content();
                if(KBE_COMMENT_SETTING == 1){
            ?>
                    <div class="kbe_reply">
            <?php
                        comments_template("wp_knowledgebase/kbe_comments.php");
            ?>
                    </div>
        <?php
                }
            endwhile;

            //  Never ever delete it !!!
            kbe_get_post_views(get_the_ID());
        ?>
        </div>
        <!--/Content Body-->

    </div>

    <!--aside-->
    <div class="kbe_aside <?php echo $kbe_sidebar_class; ?>">
    <?php
        if((KBE_SIDEBAR_INNER == 2) || (KBE_SIDEBAR_INNER == 1)){
            dynamic_sidebar('kbe_cat_widget');
        }
    ?>
    </div>
    <!--/aside-->

</div>
<?php get_footer('knowledgebase'); ?>
