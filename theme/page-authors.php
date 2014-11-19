<?php include_once('../plugins/exhibitions/includes/ExhibitionAuthors.php'); ?>
<?php get_header(); ?>	

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
                         
                         $exh = get_terms('exhibition_authors');
                         
                         /*
                         echo '<pre>';
                         print_r($exh);
                         var_dump($exh);
                         echo '</pre>';
                         */
                         
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
                                            <a href="<?php echo get_term_link($cat->slug, 'exhibition_authors'); ?>" title="<?php echo $cat->description ?>" class="portfolio_link">
                                                <img src="<?php echo ExhibitionAuthors::taxonomy_image_url($cat->term_id); ?>" alt="<?php echo $cat->name ?>" width=100 />
                                                <?php echo $cat->name;?>
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