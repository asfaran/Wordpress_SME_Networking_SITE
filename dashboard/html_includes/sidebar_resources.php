<?php 
$VM_Nodes = biz_portal_node_get_list(BP_Node::NODE_TYPE_RESOURCE, 0, 0, 'FULL', 0, 9, 0);
/*echo '<pre>';
print_r($VM_Nodes->nodes);
echo '</pre>';*/
?>
<h3 class="header_title_1">RESOURCES</h3>
<div style="padding: 5px 0px;"
	class="margin-bottom-20">

	<div class="testimonials-v1">
		<!-- Carousel nav -->
		<div style="text-align: center"
			class="margin-bottom-10 resource_nav" >
			<a class="left-btn" href="#resources_stories" data-slide="prev"></a>
			<a class="right-btn" href="#resources_stories" data-slide="next"></a>
		</div>

		<!-- <div id="resources_stories" class="carousel slide margin-bottom-10"> -->
		<div id="resources_stories" class="slide margin-bottom-10">
			<!-- Carousel items -->
			<div class="carousel-inner">

			<?php $i = 1; ?>
			<?php $opened = false; $closed = false; ?>
			<?php foreach ($VM_Nodes->nodes as $node) : ?>
			    <?php if ($i%3 == 1) : ?>
			    <?php $opened = true; $closed= false;?>			    
				<div class="item <?php echo $i==1 ? 'active' : ''; ?>">
				<?php endif; ?>				
					<h5 class="success_item">
					    <?php if ($node->company_id > 1) : ?>
						    <a href="<?php echo site_url('dashboard/view-company') .'?id=' . $node->company->id . '&res_id=' . $node->id ?>" class="success_title"><?php echo $node->title; ?></a>
						<?php else :?>
						    <a href="<?php echo site_url('resources') .'/#' . $node->id . ',' . $node->company_id; ?>" class="success_title"><?php echo $node->title; ?></a>
						<?php endif; ?>
						<div class="success_provided">
							Provided by <span class="text_orange"><?php echo $node->company->company_name; ?></span>
						</div>
					</h5>
				<?php if ($i%3 == 0) : ?>
				</div>
				<?php $closed = true;?>
				<?php endif; ?>
			<?php $i++; ?>
		    <?php endforeach; ?>
		    
		    <?php if ($opened && ! $closed) echo '</div>'; ?>

			</div>
			<!-- Carousel items -->
		</div>
		<!-- resources_stories / carousel slide -->
	</div>
	<!-- testimonials-v1 -->

	<div class="sidebar_bottom_link">
		<a href="<?php echo site_url('resources/'); ?>">Resources 
		</a>
	</div>
</div>
