<?php
/*
 Template Name: Statics
 */
 get_header(); ?>
<article class="mod-post mod-post__type-page">
	<header>
		<h1 class="mod-post__title">网站统计</h1>
	</header>
	<?php while( have_posts() ): the_post(); $p_id = get_the_ID(); ?>
		<div class="mod-post__entry">
			<ul>
			<li>文章总数：<?php global $wpdb; $count_posts = wp_count_posts(); echo $published_posts = $count_posts->publish;?> 篇</li>
			<li>运行天数：<?php echo floor((time()-strtotime("2014-05-19"))/86400); ?>天</li>
			<li>评论总数：<?php echo $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments");?> 条</li>
			<li>标签总数：<?php echo $count_tags = wp_count_terms('post_tag'); ?> 个</li>			
			<li>分类总数：<?php echo $count_categories =wp_count_terms('category'); ?> 个</li>
			<li>页面总数：<?php $count_pages = wp_count_posts('page'); echo $page_posts = $count_pages->publish; ?> 个</li>
			<li>邮箱：shaolinsi2020#163.com</li>
			<li>最后更新：<?php $last = $wpdb->get_results("SELECT MAX(post_modified) AS MAX_m FROM $wpdb->posts WHERE (post_type = 'post' OR post_type = 'page') AND (post_status = 'publish' OR post_status = 'private')");$last = date('Y-n-j', strtotime($last[0]->MAX_m));echo $last; ?></li>
			<li>总访问量：+<?php get_totalviews(true, true, true); ?> 次</li>
			</ul>
		</div>
	<?php endwhile; ?>
</article>
<section class="commentlist">
	<?php if (comments_open()) comments_template(); ?>
</section>
<?php get_footer(); ?>