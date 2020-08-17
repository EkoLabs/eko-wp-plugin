'use strict';
import EkoPlayer from "eko-js-sdk";

function embedVideoFromShortcode(iframeParams) {
	if ( ! iframeParams || ! iframeParams.frame || ! iframeParams.id ) {
		return;
	}
	let ekoPlayer = new EkoPlayer( iframeParams.frame );
	let extraParams = iframeParams.extraParams;
	const params = Object.assign({
		env: iframeParams.env
	}, extraParams );
	ekoPlayer.load( iframeParams.id, {
		params,
		events: iframeParams.events || [ 'nodestart', 'nodeend', 'playing', 'pause' ],
		pageParams: iframeParams.pageParams || [],
		cover: iframeParams.cover
	});
	let theIframe = document.querySelector( iframeParams.frame )
		.getElementsByTagName( 'iframe' )[0];
	if ( iframeParams.style ) {
		Object.keys( iframeParams.style ).forEach( key => {
			theIframe.style[key] = iframeParams.style[key];
		});
	}
}
jQuery( document ).ready( function( $ ) {
	$('.sdk-container').each(function( index, item ) {
		let paramsName = item.id.replace('container-','');
		let params = window[paramsName];
		embedVideoFromShortcode(params);
	});
	embedVideoFromShortcode(iframeParams);
});
