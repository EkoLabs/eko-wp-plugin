/* This code will run on the CPT edit page */
import EkoPlayer from 'eko-js-sdk';
import '../css/videoPostType.css';

const PLUGIN_NAME = 'eko-plugin';
const DEBOUNCE_DELAY = 1.2;
const EKO_PLAYER_FRAME = '#eko-embed';
let ekoPlayer;
const EKO_ENV = ekoOptions.env || '';

////////////////////////////////////////////
///////////// HELPER FUNCTIONS /////////////
////////////////////////////////////////////

function pluginLogger( text ) {
	console.info( `[${PLUGIN_NAME}] - ${text}` );
}

// Basic debounce function
function debounce( func, delay ) {
	let debounceTimer;
	return function() {
		const context = this;
		const args = arguments;
		clearTimeout( debounceTimer );
		debounceTimer = setTimeout( () => func.apply( context, args ), delay );
	};
}

// Convert camel case name to php standard
function toSnakeCase( name ) {
	return name
		.split( / |\B(?=[A-Z])/ )
		.map( word => word.toLowerCase() )
		.join( '_' );
}

// Convert aseconds to minutes
function durationInMinutes( durationString ) {
	let duration = Number( durationString );
	if ( ! isNaN( durationString ) ) {
		return Math.floor( durationString / 60 );
	}
	return 'Nan';
}

////////////////////////////////////////////
/////////// JQuery FUNCTIONALITY ///////////
////////////////////////////////////////////
// add accordion effect to div
jQuery( document ).ready( function( $ ) {
	$( '#eko-accordion' ).accordion({
		collapsible: true,
		active: false,
		create: function( event, ui ) {
			$( '#eko-accordion' ).show();
		},
		activate: function( e, ui ) {
			$( '#eko-accordion' ).accordion( 'refresh' );
		}
	});

	// update iframe src based on password
	$( 'input[name="eko_password"]' ).change( function() {
		let videoId = $( 'input[name="eko_video_id"]' ).val();
		let password = $( 'input[name="eko_password"]' ).val();
		let title = $( 'input[name="eko_title"]' ).val();
		// update the eko player for the new password
		updateEkoPlayer( videoId, title, { password: password });
	});

	$.openAccordion = function( location ) {
		$( '#eko-accordion' ).accordion( 'option', 'active', location );
	};

	////////////////////////////////////////////
	///////// MAIN PAGE FUNCTIONALITY //////////
	////////////////////////////////////////////
	window.addEventListener( 'DOMContentLoaded', () => {
		const DOM = {
			falconIdInput: document.querySelector("#videoId"),
			falconIdInputLoader: document.querySelector(".loader"),
			embedBox: document.querySelector("#eko-embed"),
			embedEmpty: document.querySelector(".eko-no-url")
		};

		DOM.falconIdInput.addEventListener(
			'keyup',
			debounce(
				() => fetchData( DOM.falconIdInput.value ),
				DEBOUNCE_DELAY * 1000
			)
		);

		function updateEkoPlayer( videoId, title, extraParams = {}) {
			if ( ! ekoPlayer ) {
				ekoPlayer = new EkoPlayer( EKO_PLAYER_FRAME );
			}
			const params = Object.assign( extraParams, {
				autoplay: false,
				clearcheckpoints: true,
				debug: false,
				env: EKO_ENV
			});
			ekoPlayer.load( videoId, {
				params,
				events: [ 'nodestart', 'nodeend', 'playing', 'pause' ],
				frameTitle: title
			});
		}
		function initializeEkoPlayer() {
			let initialvideoId = document.querySelector("#videoId").value;
			let initialVideoPassword = document.querySelector("#videoPassword").value;
			if ( initialvideoId ) {
				ekoPlayer = new EkoPlayer( EKO_PLAYER_FRAME );
				let initialTitle =
					document.querySelector( '.video__title' ).innerHTML || '';
				updateEkoPlayer( initialvideoId, initialTitle, { password: initialVideoPassword } );
			}
		}

		// start the eko player
		initializeEkoPlayer();

		// fetch eko video data
		function fetchData( id ) {
			pluginLogger( `fetching video data for Id: ${id}` );
			if ( id ) {
				DOM.falconIdInputLoader.classList.remove( 'hidden' );
				EkoPlayer.getProjectInfo(id)
					.then(data => {
						DOM.falconIdInputLoader.classList.add("hidden");
						DOM.embedBox.classList.remove("hidden");
						DOM.embedEmpty.classList.add("hidden");
						updateMetaboxDOM(data);
						$.openAccordion(1);
					})
					.catch(err => {
						DOM.falconIdInputLoader.classList.add("hidden");
						pluginLogger(
							`failed to fetch video data for Id ${id}`
						);
						emptyMetaBox();
					});
			}
		}
		function emptyMetaBox() {
			const emptyData = {
				id: '',
				title: '',
				description: '',
				thumbnail: '',
				kidsContent: '',
				duration: '',
				orientation: '',
				canonicalUrl: ''
			};
			updateMetaboxDOM( emptyData );
		}
		function updateMetaboxDOM( data ) {
			pluginLogger( 'updating video fields' );
			const orientation = data.orientation;
			const videoId = data.id;
			let videoTitle;

			// document.querySelector('.video__orientation').innerHTML = orientation;
			Object.keys( data ).forEach( field => {

				// php version of the field
				let name = 'eko_' + toSnakeCase( field );

				// Set the value in the right place
				let elements = document.getElementsByName( name );
				if ( elements && 0 < elements.length ) {
					elements[0].value = data[field] || ''; //put the data in the right place
					switch ( name ) {
						case 'eko_title':
							document.querySelector(
								'.video__title'
							).innerHTML = data[field] || '';
							videoTitle = data[field] || '';
							break;
						case 'eko_description':
							document.querySelector( '.video__desc' ).innerHTML =
								data[field] || '';
							break;
						case 'eko_thumbnail':
							document.querySelector( '#video__image_img' ).src =
								data[field] || '';
							break;
						case 'eko_duration':
							document
								.querySelector( '.clockIcon' )
								.classList.remove( 'hidden' );
							document.querySelector(
								'.watchTime'
							).innerHTML = `About ${durationInMinutes(
								data[field] || 0
							)} minutes`;
							break;
					}
				}
			});

			//the the name for orientation
			let orientationName = 'eko_orientation';
			let orientationElem = document.getElementsByName( orientationName );
			if ( orientationElem && 0 < orientationElem.length ) {
				orientationElem[0].value = orientation;
			}

		}
	});
});
