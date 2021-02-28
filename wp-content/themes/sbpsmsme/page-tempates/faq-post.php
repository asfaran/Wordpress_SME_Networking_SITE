<?php
/*
  Template Name Posts: FAQ
 */

get_header();

$side_bar_menu = array();
query_posts('category_name=faq&orderby=title&order=asc');
if (have_posts())
{
    while (have_posts())
    {
        the_post();
        $tmpArray = array();
        $tmpArray['title'] = get_the_title();
        $tmpArray['link'] = get_the_permalink();
        $tmpArray['id'] = get_the_ID();
        $side_bar_menu[] = $tmpArray;
    }
}
wp_reset_query();
?>
<!-- BEGIN CONTAINER -->   
<div class="container min-hight margin-bottom-40">
    <?php while (have_posts()) : the_post(); ?>
        <div class="col-md-12 col-sm-12">
            <h2><?php echo get_the_title() ?></h2>
        </div>
        <div class="row">
            <div class="col-md-3">
                <ul class="ver-inline-menu tabbable margin-bottom-10">
                    <!--<li class="active">
                        <a data-toggle="tab" href="#tab_1">
                            General Questions
                        </a> 
                        <span class="after"></span>                                    
                    </li>-->
                    <?php foreach ($side_bar_menu as $menu) : ?>
                        <?php if ($menu['id'] == get_the_ID()) : ?>
                            <li class="active">
                                <a href="<?php echo $menu['link'] ?>">
                                    <?php echo $menu['title'] ?>
                                </a> 
                                <span class="after"></span>                                    
                            </li>
                        <?php else : ?>
                            <li><a href="<?php echo $menu['link'] ?>"><?php echo $menu['title'] ?></a></li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>        
            </div>

            <div class="col-md-9">

                <?php the_content() ?>

            </div>            
        </div>
    <?php endwhile; // end of the loop.   ?>
</div>
<!-- END CONTAINER -->
<?php get_footer(); ?>