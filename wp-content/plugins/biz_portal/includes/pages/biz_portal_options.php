<div class="wrap"><div id="icon-tools" ></div>
    <h2>Options</h2>

    <form method="post" action="options.php">
        <?php settings_fields('bizportal-settings-group'); ?>
        <?php do_settings_sections('bizportal-settings-group'); ?>
        <fieldset>
            <legend>Login Setting</legend>
            <?php
            $args = array(
                'sort_order' => 'ASC',
                'sort_column' => 'post_title',
                'hierarchical' => 0,
                'exclude' => '',
                'include' => '',
                'meta_key' => '',
                'meta_value' => '',
                'authors' => '',
                'child_of' => 0,
                'parent' => -1,
                'exclude_tree' => '',
                'number' => '',
                'offset' => 0,
                'post_type' => 'page',
                'post_status' => 'publish'
            );
            $pages = get_pages($args);
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Member Welcome Page</th>
                    <td>
                        <input type="text" name="member_login_page" value="<?php echo get_option('member_login_page'); ?>" />                       
                        <p class="description">Page to redirect after a member has logged in.</p>
                </tr>
                <tr valign="top">
                    <th scope="row">Signup page</th>
                    <td>
                        <select name="signup_page">
                            <option value="">[SELECT]</option>
                            <?php if (is_array($pages)) : ?>
                                <?php foreach ($pages as $page) : ?>
                                    <?php if ($page->ID == get_option('signup_page')) : ?>
                                        <option selected="selected" value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <p class="description">Signup page.</p>
                </tr>
                <tr valign="top">
                    <th scope="row">Send activation email</th>
                    <td>
                        <input type="checkbox" name="enable_account_activation_email" value="1" <?php echo (get_option('enable_account_activation_email') == 1) ? 'checked="checked"' : ""; ?> />                       
                        <p class="description">Send email to companies once the account is activated.</p>
                </tr>                
                <tr valign="top">
                    <th scope="row">Login score interval</th>
                    <td>
                        <input type="text" name="login_score_interval" value="<?php echo get_option('login_score_interval')?>" />                       
                        <p class="description">Interval in which user will get score for login (in hours).</p>
                </tr>
                <?php $countries = biz_portal_get_country_list(); ?>
                <tr valign="top">
                    <th scope="row">Default Country for SMEs</th>
                    <td>
                        <select name="sme_default_country">
                            <option value="">[SELECT]</option>
                            <?php if (is_array($countries)) : ?>
                                <?php foreach ($countries as $country) : ?>
                                    <?php if ($country['id'] == get_option('sme_default_country')) : ?>
                                        <option selected="selected" value="<?php echo $country['id']; ?>"><?php echo $country['country_name']; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $country['id']; ?>"><?php echo $country['country_name']; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <p class="description">Signup page.</p>
                </tr>
                
                <tr valign="top">
                    <th scope="row">Welcome Page</th>
                    <td>
                        <select name="welcome_page">
                            <option value="">[SELECT]</option>
                            <?php if (is_array($pages)) : ?>
                                <?php foreach ($pages as $page) : ?>
                                    <?php if ($page->ID == get_option('welcome_page')) : ?>
                                        <option selected="selected" value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $page->ID; ?>"><?php echo $page->post_title; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <p class="description">Welcome page for first time login.</p>
                </tr>
                
            </table>
        </fieldset><br />
        <?php /*
        <fieldset>
            <legend>User Group Setting</legend>
            <?php $groups = biz_portal_get_groups() ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">SME Group</th>                    
                    <td>
                        <select name="member_group_sme">
                            <option value="">[SELECT]</option>
                            <?php if (is_array($groups)) : ?>
                                <?php foreach ($groups as $group) : ?>
                                    <?php if ($group->group_id == get_option('member_group_sme')) : ?>
                                        <option selected="selected" value="<?php echo $group->group_id; ?>"><?php echo $group->name; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $group->group_id; ?>"><?php echo $group->name; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">Investment Group</th>
                    <td>
                        <select name="member_group_investment">
                            <option value="">[SELECT]</option>
                            <?php if (is_array($groups)) : ?>
                                <?php foreach ($groups as $group) : ?>
                                    <?php if ($group->group_id == get_option('member_group_investment')) : ?>
                                        <option selected="selected" value="<?php echo $group->group_id; ?>"><?php echo $group->name; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $group->group_id; ?>"><?php echo $group->name; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">Partnership Group</th>
                    <td>
                        <select name="member_group_partnerhip">
                            <option value="">[SELECT]</option>
                            <?php if (is_array($groups)) : ?>
                                <?php foreach ($groups as $group) : ?>
                                    <?php if ($group->group_id == get_option('member_group_partnerhip')) : ?>
                                        <option selected="selected" value="<?php echo $group->group_id; ?>"><?php echo $group->name; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $group->group_id; ?>"><?php echo $group->name; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">Service Provider group</th>
                    <td>
                        <select name="member_group_service_provider">
                            <option value="">[SELECT]</option>
                            <?php if (is_array($groups)) : ?>
                                <?php foreach ($groups as $group) : ?>
                                    <?php if ($group->group_id == get_option('member_group_service_provider')) : ?>
                                        <option selected="selected" value="<?php echo $group->group_id; ?>"><?php echo $group->name; ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $group->group_id; ?>"><?php echo $group->name; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </td>
                </tr>
            </table>
        </fieldset>
        */ ?>
        <?php submit_button(); ?>
    </form>
</div>