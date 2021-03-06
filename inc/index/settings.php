<?php
/*
 * ---------------------------------------------------------------
 * Account info/update page
 * ---------------------------------------------------------------
 *
 * This page is used for loading the account information,
 * as well as allowing updates to channel name, channel title,
 * and display name.
 * 
 * TODO:
 *
 *		-Custom channel page images
 *		-Custom profile images
 * 		-Better admin function
 *
 */

// run account info update if data was posted
if (!empty($_POST['displayname'])) {
	$channelname = filter_input(INPUT_POST, 'channelname', FILTER_SANITIZE_STRING);
	$channeltitle = filter_input(INPUT_POST, 'channeltitle', FILTER_SANITIZE_STRING);
	$displayname = filter_input(INPUT_POST, 'displayname', FILTER_SANITIZE_STRING);
	$chatjp = filter_input(INPUT_POST, 'chatjp', FILTER_VALIDATE_BOOLEAN);
	$chatjp = $chatjp ? 't' : 'f';
	$status = $user->update($email, $channelname, $channeltitle, $displayname, $chatjp);
	// get new account info after the update
	$accountinfo = $user->info($email);
}


?>
<div class="mdl-grid mdl-grid--no-spacing fill">
	<div class="mdl-tabs__settings mdl-js-tabs mdl-js-ripple-effect">
		<div class="mdl-tabs__tab-bar-settings">
			<a href="#user" class="mdl-tabs__tab mdl-tabs__tab-settings is-active">User Settings</a>
			<a href="#profile" class="mdl-tabs__tab mdl-tabs__tab-settings">Profile Settings</a>
			<?php
			if ($accountinfo['email'] === $admin_account) {
				echo '<a href="#admin" class="mdl-tabs__tab mdl-tabs__tab-settings">Admin</a>';
			}
			?>
		</div>

		<div class="mdl-tabs__panel is-active" id="user">
			<div class="mdl-content__settings">
				<div class="mdl-card mdl-shadow--2dp settings-form">
					<div class="mdl-card__title">
						<span>Account Settings</span>
					</div>
					<div class="mdl-card__supporting-text">
						<form action="" method="POST" class="form" id="settingsForm">
							<div class="form__article">

								<div class="mdl-grid">
									<ul class="mdl-list fill">
										<li class="mdl-list__item mdl-list__item--two-line">
									<span class="mdl-list__item-primary-content">
										<i class="material-icons mdl-list__item-icon">email</i>
										<span>Email</span>
										<span class="mdl-list__item-sub-title"><?= $accountinfo['email']; ?></span>
									</span>
										</li>
										<li class="mdl-list__item mdl-list__item--two-line">
									<span class="mdl-list__item-primary-content">
										<i class="material-icons mdl-list__item-icon">vpn_key</i>
										<span>Stream Key <a href="/guide">(click here for guide)</a></span>
										<span class="mdl-list__item-sub-title"><?= $accountinfo['stream_key']; ?></span>
									</span>
										</li>
										<li class="mdl-list__item mdl-list__item--two-line">
									<span class="mdl-list__item-primary-content">
										<i class="material-icons mdl-list__item-icon">vpn_key</i>
										<span>API Key <a
													href="https://github.com/Fenrirthviti/stream-site/blob/master/api/API_DOCS"
													target="_blank">(click here for docs)</a></span>
										<span class="mdl-list__item-sub-title"><?= $accountinfo['api_key']; ?></span>
									</span>
										</li>
									</ul>
								</div>

								<div class="mdl-grid">
									<div
											class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="displayname"
											   id="displayName"
											   value="<?= $accountinfo['display_name'] ?>"/>
										<label class="mdl-textfield__label" for="displayName">Display Name</label>
									</div>
								</div>

								<div class="mdl-grid">
									<div
											class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="channelname"
											   id="channelName"
											   value="<?= $accountinfo['channel_name'] ?>"/>
										<label class="mdl-textfield__label" for="channelName">Channel Name</label>
									</div>
								</div>

								<div class="mdl-grid">
									<div
											class="mdl-cell mdl-cell--12-col mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
										<input class="mdl-textfield__input" type="text" name="channeltitle"
											   id="channelTitle"
											   value="<?= $accountinfo['channel_title'] ?>"/>
										<label class="mdl-textfield__label" for="channelTitle">Channel Title</label>
									</div>
								</div>

								<div class="mdl-grid">
									<label class="mdl-switch mdl-js-switch mdl-js-ripple-effect" for="chatjp">
										<input type="checkbox" id="chatjp" class="mdl-switch__input" name="chatjp"
											   value=true <?php if ($accountinfo['chat_jp_setting'] === 't') {
											echo 'checked';
										} ?>>
										<span class="mdl-switch__label">Show Join/Part in Chats</span>
									</label>
								</div>

								<div class="form__action">
									<button type="submit" name="Submitted" value="Submit" form="settingsForm"
											class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">
										Update
									</button>
								</div>

								<div class="mdl-grid">
									<div class="mdl-cell mdl-cell--12-col mdl-typography--text-center">
										<?php
										if (!empty($status)) {
											echo '<br />' . $status;
										}
										?>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="mdl-tabs__panel" id="profile">
			<div class="mdl-content__settings">
				<div class="mdl-grid">
					<div class="mdl-card mdl-shadow--2dp avatar-form">
						<div class="mdl-card__title">
							<span>Avatar Update</span>
						</div>
						<div class="mdl-card__supporting-text">
							Current Avatar:
							<div class="fill">
								<img src="<?= $accountinfo['profile_img'] ?>"
									 style="max-width: 100%; max-height: 100%;">
							</div>
							<form action="/lib/upload.php" method="post" class="form" id="avatarUpdate"
								  enctype="multipart/form-data">

								<div class="mdl-textfield mdl-js-textfield mdl-textfield--file full-width">
									<input class="mdl-textfield__input" placeholder="Browse..." type="text"
										   id="file"
										   readonly/>
									<div class="mdl-button mdl-button--primary mdl-button--icon mdl-button--file">
										<i class="material-icons">perm_media</i><input type="file" name="avatar"
																					   id="avatar">
									</div>
								</div>

								<div class="form__action">
									<button type="submit" name="Upload" value="Submit" form="avatarUpdate"
											class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--colored">
										Upload
									</button>
								</div>

							</form>
						</div>
					</div>
					<div class="mdl-card mdl-shadow--2dp settings-form">
						<div class="mdl-card__title">
							<span>Subscription Settings</span>
						</div>
						<div class="mdl-card__supporting-text">
							Coming Soon!
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php if ($accountinfo['email'] === $admin_account) {
			$results = $user->admindata($accountinfo['email']) ?>
			<div class="mdl-tabs__panel" id="admin">
				<div class="mdl-content__settings">
					<div class="mdl-grid">
						<div class="mdl-cell mdl-cell--12-col">
							<table class="mdl-data-table mdl-js-data-table">
								<thead>
								<tr>
									<?php
									$arraykeys = array_keys($results[0]);
									foreach ($arraykeys as $cell):
										?>
										<th class="mdl-data-table__cell--non-numeric"><?= $cell ?></th>
									<?php endforeach; ?>
								</tr>
								</thead>
								<tbody>
								<?php foreach ($results as $row): ?>
									<tr>
										<?php foreach ($row as $cell): ?>
											<td class="mdl-data-table__cell--non-numeric"><?= $cell ?></td>
										<?php endforeach; ?>
									</tr>
								<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>
<script>
	var ischat = false;
	$(window).load(function () {
		$("#mainContent").addClass('scrollContent');
	});
</script>