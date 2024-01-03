<?php

/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package game_html5
 */

?>

<footer class="footer" style="margin-top: 15px;">
	<div class="container">
		<div class="text-container">
			<div class="column question-icon">
				<div class="title red"><?php echo get_bloginfo() ?> Ce este asta?
				</div>
				<h2 class="text">
					<p>
						Știi <a href="/"><?php echo get_bloginfo() ?></a> oferă jocuri și puzzle-uri online din 2006?<br>
						Au trecut peste 15 ani interesanți <?php echo get_bloginfo() ?>! Vă mulțumim că faceți parte din comunitate <?php echo get_bloginfo() ?>!<br>
						<a href="/"><?php echo get_bloginfo() ?></a> este o unitate de publicare și dezvoltare a jocurilor. Baza de <?php echo get_bloginfo() ?> este o rețea socială cu 30 de milioane de jucători și este în continuă creștere.
						Categoria de divertisment crește în fiecare zi <a href="/news-game">Joc nou</a>
						eliberat în fiecare zi. Deoarece <a href="/"><?php echo get_bloginfo() ?></a> are o istorie lungă de documentare a fenomenelor sociale în jocurile cu browser. Acest conținut este un mediu artistic important și poate explica ceea ce le place oamenilor în diferite perioade.
					</p>
				</h2>
			</div>
			<div class="column game-categories-icon">
				<h3 class="title blue">Genul jocului
				</h3>
				<h4 class="text">
					<p>
						Inainte de, <a href="/"><?php echo get_bloginfo() ?></a> renumit pentru genuri de jocuri, cum ar fi jocurile arcade și clasice. În special, <a href="tags/singleplayer">un jucător</a>
						a devenit un faimos joc de browser împreună cu <a href="/tags/2d">joc 2d</a>
						. O ultimă parte importantă a jocului este <a href="/tags/multiplayer">Multiplayer</a>
						, Jucați un catalog în expansiune de jocuri sociale activate în rețea
					</p>
				</h4>
			</div>
			<div class="column technologies-icon">
				<h3 class="title green">Tehnologie
				</h3>
				<h4 class="text">
					<p>
						<a href="/"><?php echo get_bloginfo() ?></a> este casa pentru fiecare jucător de pe orice dispozitiv. Joaca <a href="/tags/pixel" rel="nofollow">joc sub formă de pixeli</a>
						Sau descărcați grafică 3D bogată pe computer jucând <a href="/tags/web" rel="nofollow">joc clasic</a>
						. Pe de altă parte, dacă îți place doar să joci jocuri casual 2D, atunci <a href="/tags/html5" rel="nofollow">Joc HTML5</a>
						vi se va potrivi. Dacă doriți să puneți mâna pe noi tehnologii, vizitați arhiva <a href="/tags/3d" rel="nofollow">joc 3d</a>
						vi se va potrivi. Dacă doriți să puneți mâna pe noi tehnologii, vizitați arhiva <a href="/register" rel="nofollow"><?php echo get_bloginfo() ?> cont</a>
						. Aceasta este o rețea socială comunitară care sprijină jucătorii.
					</p>
				</h4>
			</div>
		</div>
		<div class="bottom-section">
			<div class="logo-container">
				<a class="no-event" aria-label="logo" href="/">
					<img width="67" height="30" alt="Gamekafe" src="<?php echo get_template_directory_uri() . '/images/black-logo-no-background.png' ?>" />
				</a>
				<span>© 2023 <?php echo get_bloginfo() ?></span>
				<span>Drepturi de autor.</span>
			</div>
			<div class="menu-games">
				<div class="title"><?php echo get_bloginfo() ?>
				</div>
				<ul>
					<li>
						<a title="<?php echo get_bloginfo() ?> -  Jocuri online gratuite la <?php echo get_bloginfo() ?>" href="/news-game">Joc nou</a>
					</li>
					<li>
						<a rel="nofollow" title="<?php echo get_bloginfo() ?> -  Jocuri online gratuite la <?php echo get_bloginfo() ?>" href="/best-game">Cel mai popular</a>
					</li>
				</ul>
			</div>
			<div class="footer-image">
				<img src="<?php echo get_template_directory_uri() . '/images/footer_image1.webp' ?>" alt="footer image" class="lazy" />
			</div>
		</div>
	</div>
</footer>
<div class="dark-overlay"></div>

<?php wp_footer(); ?>

</html>