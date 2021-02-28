<?php
$_TAG_ARCH = FALSE;
$_TAX_ARCH = FALSE;
$_DATE_ARCH = FALSE;
$_SRCH_ARCH = FALSE;
$_ARCH = FALSE;
$_CURRENT_TERM_ID = 0;

if (is_tax('sbpssme_resources_tags'))
    $_TAG_ARCH = TRUE;
else if (is_tax('sbpssme_resources_taxo'))
    $_TAX_ARCH = TRUE;
else if (is_date())
    $_DATE_ARCH = TRUE;
else if (is_day())
    $_DATE_ARCH = TRUE;
else
    $_ARCH = TRUE;

$queried_object = get_queried_object();
if (isset($queried_object) && !empty($queried_object->term_id))
{
    $_CURRENT_TERM_ID = $term_id = $queried_object->term_id;
}
?>
<div class="container min-hight">
    <div class="col-md-12 margin-bottom-20 col-sm-12">
        <span style="text-align:center"><h2>RESOURCES</h2></span>
    </div>
    <div class="col-md-12 margin-bottom-20 col-sm-offset-4">

        FILTER BY: &nbsp;&nbsp;

        <div class="btn-group">
            <a rel="f_box1" class="toggle-filter btn <?php echo $val = $_TAX_ARCH == TRUE ? 'btn-warning' : 'btn-default' ?>"><i class="fa fa-bookmark"></i> Type</a> 
            <div id="f_box1" class="f_targets">
                <?php $all_categories = sme_get_all_resource_categories(); ?>
                <ul class="nav sidebar-categories">
                    <?php if (is_array($all_categories)) : ?>
                        <?php foreach ($all_categories as $cat) : ?>
                            <li class="<?php echo $val = $_CURRENT_TERM_ID == $cat->term_id ? 'active' : ''; ?>">
                                <a href="<?php echo get_term_link($cat) ?>"><?php echo $cat->name . ' (' . $cat->count . ')' ?></a></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>            
            <a rel="f_box3" class="toggle-filter btn <?php echo $val = $_DATE_ARCH ? 'btn-warning' : 'btn-default' ?>"><i class="fa fa-calendar"></i> Date</a>
            <div id="f_box3" class="f_targets">
                <?php
                add_filter('get_archives_link', 'get_archives_resources_link', 10, 2);

                //wp_get_archives( array( 'post_type' => 'resources' ) );            
                //wp_get_archives( array( 'post_type' => 'resources', 'type' => 'monthly' ) );
                archive_calendar(array('post_type' => 'resources'));
                ?>

                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('resource-filter-date'))  ?>
                <?php
                remove_filter('get_archives_link', 'get_archives_resources_link', 10, 2);
                ?>

            </div>
            <a rel="f_box4" class="toggle-filter btn <?php echo $val = $_TAG_ARCH ? 'btn-warning' : 'btn-default' ?>"><i class="fa fa-tags"></i> Tag</a>
            <div id="f_box4" class="f_targets">
                <?php $all_tags = sme_get_all_resource_tags(); ?>
                <div>
                    <?php if (is_array($all_tags)) : ?>
                        <?php foreach ($all_tags as $tag) : ?>
                            <span class="badge badge-default"><a href="<?php echo get_term_link($tag) ?>"> <?php echo $tag->name ?></a></span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <a href="<?php echo get_post_type_archive_link('resources') ?>" 
               class="btn <?php echo $val = $_ARCH ? 'btn-warning' : 'btn-default' ?>">
                <i class="fa fa-align-justify"></i> All</a>
        </div>
        <div>

        </div>

    </div>
    <div class="margin-bottom-20">
        <hr> 
    </div>  
    <!-- BEGIN BLOG -->
    <div class="row">
        <!-- BEGIN LEFT SIDEBAR -->            
        <div class="col-md-9 col-sm-9 blog-posts margin-bottom-40">
            <?php $print_hr = FALSE; ?>
            <?php while (have_posts()) : the_post(); ?>
                <?php if ($print_hr) echo '<hr class="blog-post-sep">'; ?>
                <div class="row">
                    <?php $secnd_col_class = 'col-md-12 col-sm-12' ?>
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="col-md-4 col-sm-4">  
                            <?php $secnd_col_class = 'col-md-8 col-sm-8' ?>
                            <?php the_post_thumbnail('large', array('class' => 'img-responsive')); ?>                        
                        </div>
                    <?php endif; ?>
                    <div class="<?php echo $secnd_col_class ?>">
                        <h2><a href="#"><?php the_title(); ?></a></h2>
                        <ul class="blog-info">
                            <li><i class="fa fa-calendar"></i> <?php the_date(); ?></li>
                            <!-- CATEGORIES -->
                            <?php $categories = sme_get_resource_categories(get_the_ID()); ?>
                            <?php if (is_array($categories)) : ?>
                                <?php foreach ($categories as $cat) : ?>
                                    <li class=''><a href="<?php echo get_term_link($cat) ?>" title="<?php echo $cat->name ?>"><i class="fa fa-bookmark"></i> <?php echo $cat->name ?></a></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <!-- TAGS -->
                            <?php $tags = sme_get_resource_tags(get_the_ID()); ?>
                            <?php if (is_array($tags)) : ?>
                                <?php $print_comma = FALSE ?>
                                <li><i class="fa fa-tags"></i> <?php foreach ($tags as $tag) : ?>
                                        <?php if ($print_comma) echo ', '; ?>
                                        <a href="<?php echo get_term_link($tag) ?>" title="<?php echo $tag->name ?>"><?php echo $tag->name ?></a>
                                        <?php $print_comma = TRUE; ?>
                                    <?php endforeach; ?>
                                </li>
                            <?php endif; ?>
                        </ul>
                        <?php the_content() ?>
                        <a href="<?php echo sme_get_custom_field('link_url', get_the_ID()); ?>" 
                           class="more" title="<?php echo sme_get_custom_field('link_text', get_the_ID()); ?>" target="_blank">
                            <?php echo sme_get_custom_field('link_text', get_the_ID()); ?> <i class="fa fa-angle-right"></i></a>
                    </div>
                </div>       
                <?php $print_hr = TRUE; ?>
            <?php endwhile; ?>                  
            
            <?php if (!is_single()) : ?>
            <div class="text-center" style="margin-top:20px;">
                <div><?php wp_pagenavi(); ?>  </div>
            </div>                
            <?php endif; ?>
        </div>
        <!-- END LEFT SIDEBAR -->

        <!-- BEGIN RIGHT SIDEBAR -->            
        <div class="col-md-3 col-sm-3 blog-sidebar">
            <div><?php get_search_form() ?></div>
            <!-- CATEGORIES START -->
            <h2>Categories</h2>
            <?php $all_categories = sme_get_all_resource_categories(); ?>
            <ul class="nav sidebar-categories margin-bottom-40">
                <?php if (is_array($all_categories)) : ?>
                    <?php foreach ($all_categories as $cat) : ?>
                        <li class="<?php echo $val = $_CURRENT_TERM_ID == $cat->term_id ? 'active' : ''; ?>"><a href="<?php echo get_term_link($cat) ?>"><?php echo $cat->name . ' (' . $cat->count . ')' ?></a></li>
                    <?php endforeach; ?>
                <?php endif; ?>

            </ul>
            <!-- CATEGORIES END -->



            <!-- BEGIN BLOG TAGS -->
            <div class="blog-tags margin-bottom-20">
                <h2>Tags</h2>
                <?php $all_tags = sme_get_all_resource_tags(); ?>
                <ul>
                    <?php if (is_array($all_tags)) : ?>
                        <?php foreach ($all_tags as $tag) : ?>
                            <li><a href="<?php echo get_term_link($tag) ?>"><i class="fa fa-tags"></i><?php echo $tag->name ?></a></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
            <!-- END BLOG TAGS -->
        </div>
        <!-- END RIGHT SIDEBAR -->            
    </div>
    <!-- END BEGIN BLOG -->
</div>

<script>
    jQuery(document).ready(function() {
        jQuery(".toggle-filter").click(function() {
            var rel = jQuery(this).attr('rel');
            var target = jQuery("#" + rel);
            if (target.is(":visible"))
                target.fadeOut('fast');
            else {
                jQuery(".f_targets").hide();
                target.fadeIn('fast');
            }
        });
    });
</script>