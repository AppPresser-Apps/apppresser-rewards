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

import { PanelBody, TextControl, RangeControl } from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor';
import QRCode from './qrcode.js';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({ attributes, setAttributes}) {

	const svgNode = QRCode({
		msg :  attributes.qrValue
	   ,dim :   attributes.size
	   ,pad :   attributes.padding || 3
	   ,mtx :   7
	   ,ecl :  "H"
	   ,ecb :   0
	   ,pal : [attributes.color, attributes.bgColor]
	   ,vrb :   1
   
   });
	const svgString = new XMLSerializer().serializeToString(svgNode);

	return (
		<div { ...useBlockProps() }>
			<InspectorControls>
                <PanelBody title="Settings">
                    <TextControl
                        label="QR Code Value"
                        value={ attributes.qrValue }
                        onChange={ ( value ) => setAttributes( { qrValue: value } ) }
                    />
					<RangeControl
						label="QR Code Size"
						value={ attributes.size }
						onChange={ ( value ) => setAttributes( { size: value } ) }
						min={ 150 }
						max={ 300 }
					/>
                </PanelBody>
            </InspectorControls>
			{ <div dangerouslySetInnerHTML={{ __html: svgString }} /> }
		</div>
	);
}
