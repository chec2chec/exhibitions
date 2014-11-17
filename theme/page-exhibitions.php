
<?php get_header(); ?>	
<?php
/*
    echo '<pre>';
    var_dump(get_terms('exhibition_artist'));
    echo '<pre>';
*/
?>
<!-- Start of slider wrapper -->
<div id="slider_wrapper">

	<!-- Start of breadcrumb wrapper -->
    <div id="breadcrumb_wrapper">

        <h1><?php the_title(); ?></h1>
            
	</div><!-- End of breadcrumb wrapper -->

</div><!-- End of slider wrapper -->

<!-- Start of wrapper -->
<div id="wrapper">        
    
	<!-- Start of portfolio wrapper -->
    <h5><?php echo basename( __FILE__ ); ?></h5>
    <div id="portfolio_wrapper">
    	
			 <?php 
			 
			 $i=0;
                         
                         $exh = get_terms('exhibition_category');
			 foreach ($exh as $cat) : ?>
			 <?php if($cat->parent == 0){?>
			 
			 	<!-- Start of one fifth -->
				<?php					
					if($i==0 || $i%5==0){
					
						echo '<div class="one_fifth_first">';
						$i++;
						
					}else{
			
						echo '<div class="one_fifth">';
						$i++;
						
					}
					
					?>
					<section>
						<a href="<?php echo get_term_link($cat->slug, 'exhibition_category'); ?>" title="<?php echo $cat->description ?>" class="portfolio_link">
							<?php echo $cat->name;?><!--<img class="no_radius" src="<?php //echo z_taxonomy_image_url($cat->term_id); ?>" alt="<?php //echo $cat->name ?> Logo" height="64"/>-->
						</a>
					</section>
				<?php echo '</div>'; ?>
				<!-- End of one fifth -->
				<?php } ?>
			 <?php endforeach; ?>
		
    </div><!-- End of portfolio wrapper -->

</div><!-- End of wrapper -->

<div class="clear"></div>

<?php get_footer (); ?>