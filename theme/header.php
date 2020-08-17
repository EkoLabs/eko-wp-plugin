<html>

<head>
	<title>eko theme</title>
	<?php wp_head(); ?>
	<style>
		body {
			display: block;
			margin: 0px;
		}

		.entry-content {
			background-color: #00112B;
		}

		.pageHeader {
			position: relative;
		}

		.pageHeader #header-container {
			position: absolute !important;
			transform: translate(0px) !important;
		}

		.pageHeader #header-container #header-content {
			background: transparent !important;
		}

		.video__content {
			padding: 160px 52px 80px 52px;
			color: #fff;
			position: relative;
		}

		.video__content .video__info {
			max-width: 900px;
		}

		.video__content .video__info .bgSideImage {
			position: absolute;
			height: 100%;
			right: 0;
			top: 0;
		}

		.video__content .video__info .bgSideImage img {
			max-width: 100%;
			max-height: 100%;
		}

		.video__content .video__info .bgSideImage .gradientOverImage {
			position: absolute;
			width: 100%;
			height: 100%;
			top: 0;
			left: 0;
		}

		.video__content .video__title {
			font-family: sans-serif;
			font-size: 48px;
			line-height: 58px;
			margin-bottom: 5px;
			position: relative;
		}

		.video__content .video__watchTime {
			display: inline-flex;
			align-items: center;
			vertical-align: middle;
			opacity: 0.3;
			position: relative;
		}

		.video__content .video__watchTime .clockIcon {
			display: flex;
			height: 15px;
		}

		.video__content .video__watchTime .clockIcon svg {
			stroke: #fff;
			width: 14px;
			height: 14px;
		}

		.video__content .video__watchTime .clockIcon .watchTime {
			color: #fff;
			font-size: 14px;
			margin-left: 5px;
		}

		.video__content .video__desc {
			margin-top: 30px;
			font-size: 18px;
			line-height: 24px;
			position: relative;
		}

	</style>
</head>

<body>
