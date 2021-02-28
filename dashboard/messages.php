<?php
define('PRIVATE_SUBMENU', true, true);
define('MESSAGES_PAGE', true, true);
define('PARENT', 'MYACCOUNT', true);

$current_company_id = biz_portal_get_current_company_id();

Theme_Vars::add_script('messages.js', get_template_directory_uri() . '/assets/scripts/messages.js');
Theme_Vars::add_script_ready('Messages.init("' . site_url('dashboard/messages') . '", "' . get_site_url('', 'ajax', 'relative') . '/", ' . $current_company_id . ')');


if ($current_company_id == 0) {
    BP_FlashMessage::Add('You should have a company associated with your account to view the inbox', BP_FlashMessage::ERROR);
    wp_redirect(site_url('dashboard'));
    exit();
}

$title = 'Inbox';
$s_key_field = 'to_company_id';
$view_key = 'inbox';
$view_key = isset($_GET['sent']) ? 'sent' : $view_key;
$unread_messages = biz_portal_pm_new();

switch ($view_key) {
    case 'sent': 
        $title = 'Sent';
        $s_key_field = 'from_company_id';
        break;
    default:
        $title = 'Inbox';
}

$repo = new BP_Repo_Messages($wpdb, biz_portal_get_table_prefix());

// Delete messages
if (isset($_POST['btn_delete_message']))
{
    $checked_ids = filter_input(INPUT_POST, 'chk_message', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);  
    $count = $repo->delete_messages(array_values($checked_ids));
    if ($count > 0) {
        BP_FlashMessage::Add("$count message(s) deletes", BP_FlashMessage::SUCCESS);
        wp_redirect(site_url('dashboard/messages'));
        exit();
    }  
}

$per_page = 10;
$c_page = filter_input(INPUT_GET, 'p', FILTER_VALIDATE_INT);
if (!$c_page) $c_page = 1;
$offset = $c_page * $per_page - $per_page;

$messages = $repo->search_message(array($s_key_field => $current_company_id, 'owner_id' => $current_company_id), array('%d', '%d'), $per_page, $offset);
$is_message_empty = (count($messages->messages) > 0) ? false : true;

$t_pages = ceil($messages->total/$per_page);

$company_ids = array();
foreach ($messages->messages as $msg) {
    if ($view_key === 'inbox')
        $company_ids[$msg->from_company_id] = $msg->from_company_id;
    else if ($view_key === 'sent')
        $company_ids[$msg->to_company_id] = $msg->to_company_id;
}

$company_hash_table = biz_portal_get_company_hash_table(array_keys($company_ids));

function __get_company_name($company_id)
{
    global $company_hash_table;
    foreach ($company_hash_table as $company) {
        if ($company['id'] == $company_id)
            return $company['company_name'];
    }
}



get_header();
?>

    <!-- BEGIN PAGE CONTAINER -->  
    <div class="page-container page-body profile-inner">
	
       

		<!-- BEGIN CONTAINER -->   
		<div class="container min-hight">
			<div class="row margin-bottom-40">
				

				<div class="col-md-12">
                    <!-- BEGIN TAB CONTENT -->
                    <h3 class="page-title">Messages</h3>
                    <?php
                        if (BP_FlashMessage::HasMessages()) {
                			biz_portal_get_messages();
                		}
                        ?>
                    <div class="tab-content">
                      
                                           
                      <!-- START TAB 2 -->
                      <div id="tab_2" class="tab-pane  active">
                         <div class="container">
                         		<!-- Inbox Page   -->
                         		<div class="row inbox">
                                    <div class="col-md-3">
                                        <ul class="inbox-nav margin-bottom-10 margin-top-20">
                                            <!-- li class="compose-btn">
                                                <a href="javascript:;" data-title="Compose" class="btn green"> 
                                                <i class="fa fa-edit"></i> Compose
                                                </a>
                                            </li-->
                                            <li class="inbox <?php echo ($view_key === 'inbox') ? 'active' : ''; ?>">
                                                <a href="/dashboard/messages" class="btn" data-title="Inbox">Inbox
                                                <?php if ($unread_messages > 0) :?> 
                                                <strong>(<?php echo esc_attr($unread_messages); ?>)</strong>
                                                <?php endif; ?>
                                                </a>                                                
                                            </li>
                                            <li class="sent <?php echo ($view_key === 'sent') ? 'active' : ''; ?>">
                                                <a class="btn" href="/dashboard/messages?sent"  data-title="Sent">Sent</a></li>
                                           
                                        </ul>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="inbox-header">
                                            <h2 class="pull-left"><?php echo esc_attr($title); ?></h2>
                                            <!-- form class="form-inline pull-right" action="" id="search_form">
                                                <div class="input-group input-medium">
                                                    <input type="text" class="form-control" placeholder="Search" id="inbox_search">
                                                    <span class="input-group-btn">                   
                                                    <button type="button" class="btn green" id="inbox_search_btn"><i class="fa fa-search"></i></button>
                                                    </span>
                                                </div>
                                            </form -->
                                        </div>
                                        
                                        <div> <!-- message content  -->
                                            
                                            <form method="post" action="">
                                        	<table class="table table-striped table-advance table-hover">                                        	
                                                <thead>
                                                    <tr>
                                                        <th>
                                                        <?php if (!$is_message_empty) : ?>
                                                            <input type="checkbox" class="mail-checkbox mail-group-checkbox">
                                                        <?php endif; ?>                                                            
                                                        </th>
                                                        <th colspan="2">    
                                                            <div class="btn-group" id="inbox_control">
                                                            <?php if (!$is_message_empty) : ?>
                                                                <button id="btn_delete_message" name="btn_delete_message" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Delete</button>
                                                            <?php endif; ?>
                                                            </div>
                                                        </th>
                                                        <th class="pagination-control" colspan="3">
                                                        <?php if (!$is_message_empty) : ?>
                                                            <span class="pagination-info"><?php echo ($offset+1) ?>-<?php echo ($offset + count($messages->messages)) ?> of <?php echo $messages->total ?></span>
                                                            <?php if ($c_page > 1) : ?>
                                                            <?php $url = site_url('dashboard/messages') . '?p=' . ($c_page-1) ?>
                                                            <?php $url = ($view_key === 'sent') ? $url . '&sent' : $url; ?>
                                                            <a class="btn btn-sm blue" href="<?php echo $url; ?>"><i class="fa fa-angle-left"></i></a>
                                                            <?php else :?>
                                                            <a class="btn btn-sm blue" disabled="disabled"><i class="fa fa-angle-left"></i></a>
                                                            <?php endif;?>
                                                            
                                                            <?php if ($c_page < $t_pages) :?>
                                                            <?php $url = site_url('dashboard/messages') . '?p=' . ($c_page+1) ?>
                                                            <?php $url = ($view_key === 'sent') ? $url . '&sent' : $url; ?>
                                                            <a class="btn btn-sm blue" href="<?php echo $url; ?>"><i class="fa fa-angle-right"></i></a>
                                                            <?php else : ?>
                                                            <a class="btn btn-sm blue" disabled="disabled"><i class="fa fa-angle-right"></i></a>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if ($is_message_empty) : ?>                                                    
                                                    <tr class="">
                                                        <td colspan="6">
                                                            You do not have any messages.
                                                        </td>
                                                    </tr>
                                                    <?php else : ?>
                                                        <?php foreach ($messages->messages as $key => $message) : ?>
                                                        <?php $class_unread = ($view_key === 'inbox' && $message->is_read == 0) ? 'unread' : ''; ?>
                                                        <?php $company_name = ($view_key === 'inbox') ? __get_company_name($message->from_company_id) : __get_company_name($message->to_company_id); ?>
                                                        <tr class="<?php echo $class_unread; ?> data_message" data-read="<?php echo $message->is_read; ?>" data-id="<?php echo $message->id; ?>">
                                                            <td class="inbox-small-cells">
                                                                <input value="<?php echo $message->id ?>" name="chk_message[]" type="checkbox" class="mail-checkbox">
                                                            </td>
                                                            <td class="view-message hidden-xs"><?php echo $company_name . ' '; ?></td>
                                                            <td class="view-message" colspan="2"><?php
                                                            if (preg_match('/^.{1,40}\b/s', $message->message, $match))
                                                            echo esc_attr($match[0]) ?></td>
                                                            <td class="view-message inbox-small-cells"></td>
                                                            <td class="view-message text-right"><?php echo date('d M, Y', strtotime($message->created)) ?></td>
                                                        </tr>
                                                        <tr class="hidden message_row" id="message_row_<?php echo $message->id ?>">
                                                            <td>&nbsp;</td>
                                                            <td colspan="4"><?php echo esc_attr(nl2br($message->message)); ?>
                                                                <?php if ($view_key === 'inbox') : ?>
                                                                <div style="border:1px #efefef solid;text-align:center">
                                                                    <a href="" rel="<?php echo $message->from_company_id ?>" data-id="<?php echo $message->id ?>" data-name="<?php echo esc_attr($company_name) ?>" class="btn_reply" style="display:block;padding:5px;"><i class="fa fa-mail-reply "></i> Reply</a>
                                                                </div>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>&nbsp;</td>
                                                        </tr>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>                                                    
                                                    
                                                </tbody>
                                            </table>
                                            </form>
                                        
                                        </div> <!-- message content  -->
                                     </div>
                                </div>
                         		<!-- Inbox Page  -->
                         </div>
                      </div>
                      <!-- END TAB 2 -->
                      
                      
                    </div>
                    <!-- END TAB CONTENT -->
				</div>            
			</div> <!-- ROW -->
            
            <div class="clearfix"></div>
            
     
           
            
		</div>
		<!-- END CONTAINER -->

	</div>
    <!-- END PAGE CONTAINER -->  

<!-- Model Start -->
<div class="modal fade" id="modal_message_window" role="dialog" aria-labelledby="Message" aria-hidden="true">
    <div class="modal-dialog">
		<div class="modal-content">
		    <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Reply To : <strong id="reply_to_company_name"></strong></h4>
            </div>
            <div class="modal-body">
                <div class="loading hidden progress progress-striped active">
					<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
					    <span class="sr-only">sending message...</span>
				    </div>
				</div>
                <div class="alert alert-success hidden"></div>
				<div class="alert alert-danger hidden"></div>
                <p>
                <input type="hidden" name="msg_reply_to_id" id="msg_reply_to_id" value="" />
                <input type="hidden" name="to_company_id" id="to_company_id" value="" />
                <textarea id="message_text" class="form-control" rows="5" placeholder="Your message here.."></textarea>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="send_message" class="btn btn-primary">Send <i class="fa fa-arrow-circle-right"> </i></button>
            </div>
		</div>
	</div>
</div>
<!-- Model End -->
  

   <?php get_footer(); ?>