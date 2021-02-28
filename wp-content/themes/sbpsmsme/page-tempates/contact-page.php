<?php
/*
  Template Name: Contact Page
 */

get_header();
?>

<!-- BEGIN CONTAINER -->   
<div class="container min-hight">
    <div class="row">
        <?php while ( have_posts() ) : the_post(); ?>
        <div class="col-md-9 col-sm-9">
            <h2><?php echo get_the_title() ?></h2>
            <?php the_content() ?>
            <!-- END FORM-->             
            <br />&nbsp;
        </div>
        <?php endwhile; // end of the loop. ?>

        <div class="col-md-3 col-sm-3">
            <h2>Our Contacts</h2>
            <address>
                <?php echo nl2br(get_option( "contact_address", "" )); ?>                
                <br />
                <?php $contact_mobile = get_option( "contact_mobile", "" ) ?>
                <?php if (!empty($contact_mobile)) : ?>
                    <abbr title="Mobile">M:</abbr> <?php echo $contact_mobile ?><br>
                <?php endif; ?>
                
                <?php $contact_telephone_1 = get_option( "contact_telephone_1", "" ) ?>
                <?php if (!empty($contact_telephone_1)) : ?>
                    <abbr title="Phone">P:</abbr> <?php echo $contact_telephone_1 ?><br>
                <?php endif; ?>
                <?php $contact_telephone_2 = get_option( "contact_telephone_2", "" ) ?>
                <?php if (!empty($contact_telephone_2)) : ?>
                    <abbr title="Phone">P:</abbr> <?php echo $contact_telephone_2 ?><br>
                <?php endif; ?>
                <?php $contact_telephone_3 = get_option( "contact_telephone_3", "" ) ?>
                <?php if (!empty($contact_telephone_3)) : ?>
                    <abbr title="Phone">P:</abbr> <?php echo $contact_telephone_3 ?><br>
                <?php endif; ?>
                <?php $contact_fax = get_option( "contact_fax", "" ) ?>
                <?php if (!empty($contact_fax)) : ?>
                    <abbr title="Fax">F:</abbr> <?php echo get_option( "contact_fax", "" ) ?>
                <?php endif; ?>
            </address>
            <address>
                <strong>Email</strong><br>
                <?php $contact_email_1 = get_option('contact_email_1', ""); ?>
                <?php if (!empty($contact_email_1)) : ?>
                    <a href="mailto:<?php echo $contact_email_1 ?>"><?php echo $contact_email_1 ?></a><br>
                <?php endif; ?>
                <?php $contact_email_2 = get_option('contact_email_2', ""); ?>
                <?php if (!empty($contact_email_2)) : ?>
                    <a href="mailto:<?php echo $contact_email_2 ?>"><?php echo $contact_email_2 ?></a>
                <?php endif; ?>
            </address>
            <ul class="social-icons margin-bottom-10">
                <?php $social_fb_link = get_option('social_fb_link', ""); ?>
                <?php if (!empty($social_fb_link)) : ?>
                    <li><a href="<?php echo $social_fb_link ?>" data-original-title="facebook" class="facebook"></a></li>
                <?php endif; ?>
                <?php $social_twitter_link = get_option('social_twitter_link', ""); ?>
                <?php if (!empty($social_twitter_link)) : ?>
                    <li><a href="<?php echo $social_twitter_link ?>" data-original-title="Twitter" class="twitter"></a></li>
                <?php endif; ?>
                <?php $social_google_link = get_option('social_google_link', "") ?>
                <?php if (!empty($social_google_link)) : ?>
                    <li><a href="<?php echo $social_google_link; ?>" data-original-title="Goole Plus" class="googleplus"></a></li>
                <?php endif; ?>
                <?php $social_linkedin_link = get_option('social_linkedin_link', "") ?>
                <?php if (!empty($social_linkedin_link)) : ?>
                    <li><a href="<?php echo $social_linkedin_link ?>" data-original-title="linkedin" class="linkedin"></a></li>
                <?php endif; ?>
                <?php $social_rss_link = get_option('social_rss_link', "") ?>
                <?php if (!empty($social_rss_link)) : ?>
                    <li><a href="<?php echo $social_rss_link ?>" data-original-title="rss" class="rss"></a></li>
                <?php endif; ?>
            </ul>

            <div class="clearfix margin-bottom-30"></div>

            <h2>About Us</h2>
            <p>Sediam nonummy nibh euismod tation ullamcorper suscipit</p>
            <ul class="list-unstyled">
                <li><i class="fa fa-check"></i> Officia deserunt molliti</li>
                <li><i class="fa fa-check"></i> Consectetur adipiscing </li>
                <li><i class="fa fa-check"></i> Deserunt fpicia</li>
            </ul>                                
        </div>            
    </div>
</div>
<!-- END CONTAINER -->

<?php get_footer() ?>