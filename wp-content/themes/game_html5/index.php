<?php

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package game_html5
 */

get_header();
?>

<body class="items index games-active">
	<nav class="navbar">
		<div class="container">
			<div class="y8-navbar-left">
				<div class="mobile-burger-menu">
					<span class="burger-btn">
						<img width="20" height="17" class="hamburger-icon" alt="Menu" src="<?php echo get_template_directory_uri() . '/svg/hamburger.svg' ?>" />
						<img width="16" height="16" class="hamburger-active-icon" alt="Menu" src="<?php echo get_template_directory_uri() . '/svg/hamburger.svg' ?>" />
					</span>
				</div>
				<div class="logo">
					<a class="no-event" aria-label="logo" href="/">
						<img width="50" height="50" alt="<?php echo get_bloginfo() ?>" src="<?php echo get_template_directory_uri() . '/images/black-logo-no-background.png' ?>" />
					</a>
				</div>
				<div class="mobile-search-user-container">
					<div class="search-btn" id="mobile-search-icon">
						<img width="28" height="28" alt="Tìm kiếm trò chơi" src="<?php echo get_template_directory_uri() . '/svg/search.svg' ?>" />
					</div>
					<div class="profile-btn">
						<?php if (is_user_logged_in()) { ?>
							<img class="profile-icon avatar" alt="Profile" src="<?php echo get_avatar_url(get_current_user_id()); ?>" id="profile-icon-image" />
						<?php } else { ?>
							<img class="profile-icon avatar" alt="Profile" src="<?php echo get_template_directory_uri() . '/images/default-avatar.png' ?>" id="profile-icon-image" />
						<?php } ?>
						<img class="arrow-up-icon" alt="Profile" src="<?php echo get_template_directory_uri() . '/svg/arrow-up.svg' ?>" id="arrow-up-image" />
					</div>
				</div>
			</div>

			<form id="items-search-form" class="navbar-form" action="/search" accept-charset="UTF-8" method="post">
				<input type="text" name="q" id="q" placeholder="Tìm kiếm trò chơi" class="form-control query fake-button" required="required" />
				<button type="submit" aria-label="Search">
					<i class="y-icon y-icon--search"></i>
				</button>
				<span class="close-search-form"></span>
			</form>

			<div class="y8-navbar-right">
				<a style="text-decoration: none;" href="/news-game">
					<div class="fake-button js-top-menu two-lines btn-header-actions new-games">
						Game Mới
						<span class="sub-title">
							trong tháng
						</span>
					</div>
				</a>

				<a style="text-decoration: none;" href="/best-game">
					<div class="fake-button js-top-menu two-lines btn-header-actions browse">
						Game Phổ Biến
						<span class="sub-title">được quan tâm
						</span>
						<div class="with-notification"></div>
					</div>
				</a>

				<div class="waiting-idnet">
					<?php if (is_user_logged_in()) { ?>
						<div id="user_not_logged_in" style="justify-content: space-evenly !important">
							<a href="/register">
								<button type="button" class="fake-button fake-button-red idnet-fast-register-link">Đăng ký
								</button>
							</a>
							<a href="/login">
								<button type="button" class="fake-button idnet-fast-login-link">Đăng nhập
								</button>
							</a>
						</div>
					<?php } else { ?>
						<div id="user_logged_in">
							<div class="fake-button js-top-menu user-toggle" data-menu="account">
								<img src="<?php echo get_avatar_url(get_current_user_id()); ?>" class="avatar" alt="avatar">
							</div>
							<div class="links-container-container">
								<div class="links-container sub-menu">
									<div class="sub-menu-header">
										<span class="username username_box"><?php echo wp_get_current_user()->display_name ?></span>
									</div>
									<ul>
										<li>
											<a class=" account-menu-link" id="account-menu-link-profile" href="/user-info/">Hồ sơ</a>
										</li>
										<li>
											<a class="account-menu-link" id="account-menu-link-profile" href="/user-profile">Thay đổi hồ sơ</a>
										</li>
										<li>
											<a class="account-menu-link" id="account-menu-link-games" href="/user-favorite">
												Yêu thích
												(<span class="js-favorites-count"><?php echo $listFavorite ?></span>)
											</a>
										</li>
										<li>
											<a class=" account-menu-link" id="account-menu-link-visited" href="/game-played">
												Trò đã chơi
											</a>
										</li>
									</ul>
									<div class="sub-menu-footer">
										<ul>
											<li>
												<form method="POST" action="/logout">
													@csrf
													<a onclick="this.closest('form').submit();return false;" class="account-menu-link logout">Đăng xuất</a>
												</form>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
				</div>
			<?php } ?>

			<div class="mobile-header-block">
				<div class="popular-newest-games-links">
					<a class="games-link new-game fake-button" title="Các trò chơi Trực tuyến Miễn phí tại <?php echo get_bloginfo() ?>" href="/news-game">Game Mới</a>
					<a class="games-link pop-game fake-button" title="Các trò chơi Trực tuyến Miễn phí tại <?php echo get_bloginfo() ?>" href="/best-game">Game Phổ Biến</a>
				</div>

				<div class="top-categories-mobile">
					<div class="title">
						Các loại game
					</div>
					<div class="row">
						<ul>
							@foreach($listCategory as $category)
							@if(session('locale') == 'vi')
							<li class="inactive {{ $category['name'] }} li-category" style="margin: 0 4px 20px !important;">
								<a class="{{ $category['name'] }}" title="{{ $category['title'] }}" href="{{ route('category', ['category' => $category['name']]) }}">
									@if(session('locale') == 'vi')
									<span class="name">{{ \App\Enums\TransVietnamese::CATEGORY_VIETNAMESE[ucfirst($category['name'])] }}</span>
									@else
									<span class="name">{{ __(ucfirst($category['name'])) }}</span>
									@endif
									<span class="number">{{ $category['games_count'] }} game</span>
								</a>
							</li>
							@else
							<li class="inactive {{ $category['name'] }} li-category" style="margin: 0 5px 20px !important;">
								<a class="{{ $category['name'] }}" title="{{ $category['title'] }}" href="{{ route('category', ['category' => $category['name']]) }}">
									@if(session('locale') == 'vi')
									<span class="name">{{ \App\Enums\TransVietnamese::CATEGORY_VIETNAMESE[ucfirst($category['name'])] }}</span>
									@else
									<span class="name">{{ __(ucfirst($category['name'])) }}</span>
									@endif
									<span class="number">{{ $category['games_count'] }} game</span>
								</a>
							</li>
							@endif
							@endforeach
						</ul>
					</div>
				</div>

				<div class="top-tags-mobile">
					<div class="title">
						Thẻ
					</div>
					<div class="top-tags-mobile__wrapper">
						<div class="row top-tags__height">
							<ul id="list-tag-mobile">
								@foreach($listTag as $tag => $value)
								<li style="margin-top: 5px;">
									<a class="tag" href="{{ route('tags', ['tag' => $tag]) }}">
										<div class="tag_slug">
											<span style="color: <?php echo ($value['color']) ?>; font-weight: bold;">{{ $value['trans'] }}</span>
											<span style="font-size:13px;">{{ $value['count'] }}</span>
										</div>
									</a>
								</li>
								@endforeach
								<li class="more-tags">
									<a class="tag all-tags top" href="/list-tag">Tất cả các thẻ
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>

			<div id="locale-selector-dropdown" class="locale-selector-dropdown fake-button">
				<div id="button-flag" onclick="dropDownLocate()">
					<img src="<?php echo get_template_directory_uri() . '/svg/flag/ro.svg' ?>" class="image-flag" alt="Ngôn ngữ mặc định">
				</div>

				<div id="locate-dropdown">

				</div>
			</div>
			</div>
		</div>
	</nav>
	<div class="container">
		<?php if (is_front_page() && is_home()) { ?>
			<?php get_template_part('template-parts/homepage', 'heading'); ?>
		<?php } else { ?>
			<div class="category_menu">
				<nav class="cat_menu">
					<div class="menu_title parent_cat_name">
						<h6><?php echo $category->name; ?></h6>
					</div>
					<?php rs_left_menu_subcats($subcategories); ?>
				</nav>
			</div>
		<?php } ?>
	</div>
	<?php get_footer() ?>
	<div class="dark-overlay"></div>
	<div class="policy-validation" id="policy-validation" style="display: none;">
		<div style="display: flex;">
			<div class="logo">
				<img width="59" height="27" alt="Gamekafe" src="<?php echo get_template_directory_uri() . '/images/black-logo-no-background.png' ?>" />
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

	<script src="js/plugins/jquery/jquery.min.js"></script>
	<script src="js/page/main.js"></script>
	<script src="js/admin/user.js"></script>
</body>

<?php
