<?php
/*
 Template Name: sitemap
 * @author: Ludou  
 * @Blog  : http://www.ludou.org/
 */
 get_header(); 
 ?>
<div id="container">
	<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
	<div class="post" id="post-<?php the_ID(); ?>">
		<h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
		<div class="entry">        
			<div class="myArchive">
            <ul>
            <?php
            /**
             * WordPress分类存档页面
             * 作者：露兜
             * 博客：http://www.ludou.org/
             * 最后修改：2012年8月27日
             */
                $categoryPosts = $wpdb->get_results("
                SELECT post_title, ID, post_name, slug, {$wpdb->prefix}terms.term_id AS catID, {$wpdb->prefix}terms.name AS categoryname
                FROM {$wpdb->prefix}posts, {$wpdb->prefix}term_relationships, {$wpdb->prefix}term_taxonomy, {$wpdb->prefix}terms
                WHERE {$wpdb->prefix}posts.ID = {$wpdb->prefix}term_relationships.object_id
                AND {$wpdb->prefix}terms.term_id = {$wpdb->prefix}term_taxonomy.term_id
                AND {$wpdb->prefix}term_taxonomy.term_taxonomy_id = {$wpdb->prefix}term_relationships.term_taxonomy_id
                AND {$wpdb->prefix}term_taxonomy.taxonomy = 'category'
                AND {$wpdb->prefix}posts.post_status = 'publish'
                AND {$wpdb->prefix}posts.post_type = 'post'
                ORDER BY {$wpdb->prefix}terms.term_id, {$wpdb->prefix}posts.post_date DESC");

                $postID = 0;
                if ( $categoryPosts ) :
                    $category = $categoryPosts[0]->catID;
                    foreach ($categoryPosts as $key => $mypost) :
                        if($postID == 0) {
                            echo '<li><strong>分类:</strong> <a title="'.$mypost->categoryname.'" href="'.get_category_link($mypost->catID).'">'.$mypost->categoryname."</a>\n";
                            echo '<ul>';
                        }
                       
                        if($category == $mypost->catID) {          
            ?>
                <li><a title="<?php echo $mypost->post_title; ?>" href="<?php echo get_permalink( $mypost->ID ); ?>"><?php echo $mypost->post_title; ?></a></li>
            <?php
                            $category = $mypost->catID;
                            $postID++;
                        }
                        else {
                            echo "</ul>\n</li>";
                            echo '<li><strong>分类:</strong> <a title="'.$mypost->categoryname.'" href="'.get_category_link($mypost->catID).'">'.$mypost->categoryname."</a>\n";
                            echo '<ul>';
            ?>
                <li><a title="<?php echo $mypost->post_title; ?>" href="<?php echo get_permalink( $mypost->ID ); ?>"><?php echo $mypost->post_title; ?></a></li>
            <?php
                            $category = $mypost->catID;
                            $postID = 1;
                        }
                    endforeach;
                endif;
                echo "</ul>\n</li>";
            ?>

            <li><strong>页面</strong>
            <ul>
            <?php
                // 读取所有页面
                $mypages = $wpdb->get_results("
                    SELECT post_title, post_name, ID
                    FROM {$wpdb->prefix}posts
                    WHERE post_status = 'publish'
                    AND post_type = 'page'");

                if ( $mypages ) :
                    foreach ($mypages as $mypage) :
            ?>
                <li><a title="<?php echo $mypage->post_title; ?>" href="<?php echo get_permalink( $mypage->ID ); ?>"><?php echo $mypage->post_title; ?></a></li>
                <?php endforeach; echo "</ul>\n</li>"; endif; ?>
            </ul>
            </div>
            
		<?php link_pages('<p><code>Pages:</strong> ', '</p>', 'number'); ?>
	    </div>
	</div>
	<?php endwhile; ?>  
	<div class="comments-template">
		<?php comments_template( '', true ); ?>
	</div> 
	<?php else : ?>
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2><?php _e('抱歉，暂时没有搜索到您需要的内容！不过，以下内容或许能帮到您！'); ?></h2>
			<?php include (TEMPLATEPATH . '/404.php'); ?>
		</div>
	<?php endif; ?>
</div>
<?php get_footer(); ?>