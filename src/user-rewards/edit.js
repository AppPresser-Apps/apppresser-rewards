/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
import { SelectControl, TextControl } from '@wordpress/components';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({ attributes, setAttributes}) {


	return (
		<div { ...useBlockProps() }>
			<div class="section-header">{ __( 'User Rewards', 'apppresser-rewards' ) }</div>
			<TextControl
				label="Section Tile"
				value={ attributes.rewardTitle }
				onChange={ ( value ) => setAttributes( { rewardTitle: value } ) }
			/>
			<SelectControl
				label={ __( 'Reward Type', 'apppresser-rewards' ) }
				value={ attributes.rewardType }
				options={ [
					{ label: __( 'Promotional', 'apppresser-rewards' ), value: 'promotional-reward' },
					{ label: __( 'Parking', 'apppresser-rewards' ), value: 'parking-reward' },
					{ label: __( 'Event', 'apppresser-rewards' ), value: 'event-reward' },
				] }
				onChange={ ( newValue ) => setAttributes( { rewardType: newValue } ) }
			/>
			<TextControl
				label="No Rewards Message"
				value={ attributes.rewardMessage }
				onChange={ ( value ) => setAttributes( { rewardMessage: value } ) }
			/>
		</div>
	);
}
