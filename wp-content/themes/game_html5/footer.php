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
				<div class="title red"><?php echo get_bloginfo() ?> là gì?
				</div>
				<h2 class="text">
					<p>
						Bạn có biết <a href="/"><?php echo get_bloginfo() ?></a> đang cung cấp các game và câu đố trực tuyến từ năm 2006?<br>
						Đã hơn 15 năm thú vị của <?php echo get_bloginfo() ?>! Cảm ơn bạn đã là một phần của cộng đồng <?php echo get_bloginfo() ?>!<br>
						<a href="/"><?php echo get_bloginfo() ?></a> là một đơn vị phát hành và phát triển game. Nền tảng của <?php echo get_bloginfo() ?> là mạng xã hội với 30 triệu người chơi và đang không ngừng phát triển.
						Danh mục giải trí phát triển hàng ngày <a href="{{ route('new.games">Trò chơi mới</a>
						được phát hành từng ngày. Vì <a href="/"><?php echo get_bloginfo() ?></a> có một lịch sử lâu dài, chúng tôi đã ghi lại các hiện tượng xã hội trên các trình duyệt game. Nội dung này là một phương tiện nghệ thuật quan trọng và có thể có thể lý giải cái gì người ta thích trong những giai đoạn khác nhau.
					</p>
				</h2>
			</div>
			<div class="column game-categories-icon">
				<h3 class="title blue">Thể loại game
				</h3>
				<h4 class="text">
					<p>
						Trước đây, <a href="/"><?php echo get_bloginfo() ?></a> nổi tiếng với các dòng game như arcade và games cổ điển khi. Đáng chú ý là, <a href="{{ route('tags', ['tag' => 'singleplayer']) }}">một người chơi</a>
						đã trở thành game trình duyệt nổi tiếng cùng với <a href="{{ route('tags', ['tag' => '2d']) }}">trò chơi 2d</a>
						. Một phần trò chơi quan trọng cuối cùng là <a href="{{ route('tags', ['tag' => 'multiplayer']) }}">nhiều người chơi</a>
						, chơi danh mục mở rộng của game mạng xã hội hỗ trợ mạng
					</p>
					</h4>
			</div>
			<div class="column technologies-icon">
				<h3 class="title green">Công nghệ
				</h3>
				<h4 class="text">
					<p>
						<a href="/"><?php echo get_bloginfo() ?></a> là ngôi nhà cho mọi game thủ trên bất kỳ thiết bị nào. Chơi <a href="{{ route('tags', ['tag' => 'pixel']) }}" rel="nofollow">trò chơi dưới dạng điểm ảnh</a>
						hoặc tải đồ họa 3D phong phú trên máy tính bằng cách chơi <a href="{{ route('tags', ['tag' => 'web']) }}" rel="nofollow">trò chơi cổ điển</a>
						. Mặt khác, nếu bạn chỉ thích chơi trò chơi 2D thông thường, thì <a href="{{ route('tags', ['tag' => 'html5']) }}" rel="nofollow">trò chơi HTML5</a>
						sẽ phù hợp với bạn. Nếu bạn muốn tiếp cận với công nghệ mới, hãy truy cập kho lưu trữ <a href="{{ route('tags', ['tag' => '3d']) }}" rel="nofollow">trò chơi 3d</a>
						để chơi các trò chơi chưa hề có ở những nơi khác. Cuối cùng, đừng quên đăng ký <a href="{{ route('register" rel="nofollow"><?php echo get_bloginfo() ?> tài khoản</a>
						. Đây là mạng xã hội cộng đồng hỗ trợ người chơi.
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
				<span>Đã đăng ký bản quyền.</span>
			</div>
			<div class="menu-games">
				<div class="title"><?php echo get_bloginfo() ?>
				</div>
				<ul>
					<li>
						<a title="<?php echo get_bloginfo() ?> -  Các trò chơi Trực tuyến Miễn phí tại <?php echo get_bloginfo() ?>" href="{{ route('new.games">Game mới</a>
					</li>
					<li>
						<a rel="nofollow" title="<?php echo get_bloginfo() ?> -  Các trò chơi Trực tuyến Miễn phí tại <?php echo get_bloginfo() ?>" href="{{ route('best.games">Phổ biến nhất</a>
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
<div class="policy-validation" id="policy-validation" style="display: none;">
	<div style="display: flex;">
		<div class="logo">
			<img width="59" height="27" alt="Gamekafe" src="{{ asset('images/black-logo-no-background.png" />
		</div>
		<div class="content">
			Chúng tôi sử dụng cookie để đề xuất nội dung và phân tích lưu lượng truy cập và quảng cáo. Khi sử dụng trang web này, bạn đồng ý với <a target="_blank" rel="nofollow" href="{{ route('privacy">Chính sách bảo mật</a>
			và <a target="_blank" rel="nofollow" href="{{ route('cookie.policy">Chính sách Cookie</a>
		</div>
		<div class="actions" onclick="storeAccepted('accepted')">
			<span class="validate-policy">Đã hiểu</span>
		</div>
	</div>
</div>

<?php wp_footer(); ?>

</body>

</html>