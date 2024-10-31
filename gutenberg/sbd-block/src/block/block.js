/**
 * BLOCK: sbd-block
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

//  Import CSS.
import './style.scss';
import './editor.scss';

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
const { RichText } = wp.editor;
import { ServerSideRender } from '@wordpress/components';

function Qcpd_sbd_Shortcode_Preview( { shortcode } ) {
	if( shortcode.length > 0 ){
	    return(
			<div>
				 {shortcode}
			</div>
	    )
	}else{
		return(
			''
	    )
	}
}

function Qcpd_sbd_Shortcode_Preview_edit( { shortcode } ) {
	if( shortcode.length > 0 ){
	    return(

			<textarea className="editor-plain-text input-control">
				{shortcode}
			</textarea>
	    )
	}else{
		return(
			''
	    )
	}
}

registerBlockType( 'sbd/block-sbd-block', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'SBD - Shortcode Generator' ), // Block title.
	icon: 'shield', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [
		__( 'SBD — Shortcode Generator' ),
		__( 'SBD — Shortcode Generator' ),
	],
	attributes: {
        shortcode: {
            type: 'string',
            default: ''
        }
    },


	
	edit: function( props ) {
		const { attributes: { shortcode }, setAttributes } = props;


		function showShortcodeModal(e){
			 jQuery('#sbd_shortcode_generator_meta').prop('disabled', true);
			 jQuery(e.target).addClass('currently_editing');
			jQuery.post(
				ajaxurl,
				{
					action : 'show_qcpnd_shortcodes'
					
				},
				function(data){
					//console.log(jQuery(data).find('#qcsbd_add_shortcode').attr('value'));
					if(jQuery('#sm-modal').length<1){
						jQuery('#wpwrap').append(data);
					}
				}
			)
		}

		function insertShortCode(e){
			const shortcode = jQuery('#wpwrap').find(' #sbd_shortcode_container').val();
			setAttributes( { shortcode: shortcode } );
			console.log(shortcode);
		}



		jQuery(document).on('click','.sbd_copy_close', function(e){
			e.preventDefault();
			jQuery('.currently_editing').next('#sbd_insert_shortcode').trigger('click');
			jQuery(document).find( ' .modal-content .close').trigger('click');
			//const shortdata = jQuery(this).attr('short-data');
			//setAttributes( { shortcode: shortdata } );
		});

		jQuery(document).on( 'click', ' .modal-content .close', function(){
			jQuery('.currently_editing').removeClass('currently_editing');
			jQuery('#sbd_shortcode_generator_meta').prop('disabled', false);
			jQuery(this).parent().parent().remove();
		});
		
        return (
            <div className={ props.className }>
			
				<input type="button" id="sbd_shortcode_generator_meta" onClick={showShortcodeModal} className="button button-primary button-large" value="Generate SBD Shortcode" />
				<input type="button" id="sbd_insert_shortcode" onClick={insertShortCode} className="button button-primary button-large" value="Test SBD Shortcode" />
				<br />
				{ shortcode }
				
            </div>
        );
	},


	
	save: function( props ) {
		const { attributes: { shortcode } } = props;
        return (
            <div>
            	<Qcpd_sbd_Shortcode_Preview shortcode = { shortcode } />
            </div>
        );
	},
} );
