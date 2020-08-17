<style>
	.eko-plugin-container {
		margin-top: 15px;
	}

	.eko-plugin-container * {
		box-sizing: border-box;
	}

	.eko-plugin-container h1,
	.eko-plugin-container h2 {
		margin: 0;
	}

	.eko-plugin-container .inner {
		margin: 0 auto;
		max-width: 500px;
	}

	.eko-plugin-container .title-container {
		text-align: center;
		margin-bottom: 20px;
	}

	.eko-logo {
		height: 34px;
		position: relative;
		top: 5px;
	}

	.eko-plugin-container .header-container {
		border-bottom: solid 1px #ddd;
	}

	.eko-plugin-container .header-container,
	.eko-plugin-container .main-content {
		background-color: white;
		padding: 15px;
	}

	.eko-plugin-container .main-content {
		box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
	}

	.eko-pugin-btn:hover {
		filter: brightness(.9);
	}

	.danger-zone .eko-pugin-btn {
		border: none;
		color: white;
		background-color: #ff0060;
		font-weight: bold;
		cursor: pointer;
		padding: 5px 10px;
	}
</style>
<div class="eko-plugin-container">
	<div class="inner">

		<div class="title-container">
			<h1>The <img class="eko-logo" src=<?php echo EKO_PLUGIN_URL . '/includes/images/eko_large_logo_mint.png'; ?> alt="The eko logo, mint colored"> Plugin</h1>
		</div>

		<div class="header-container">
			<h2>Settings</h2>
		</div>

		<div class="main-content">
			<form action="options.php" method="post">
				<?php
				settings_fields( 'eko_plugin_options' );
				do_settings_sections( 'eko_plugin' );
				?>
				<input name="submit" class="button button-primary" type="submit" value="<?php esc_attr_e( 'Save' ); ?>" />
			</form>
		</div>

	</div>
</div>
