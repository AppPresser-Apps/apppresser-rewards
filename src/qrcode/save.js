/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps } from '@wordpress/block-editor';
import QRCode from './qrcode.js';

/**
 * The save function defines the way in which the different attributes should
 * be combined into the final markup, which is then serialized by the block
 * editor into `post_content`.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#save
 *
 * @return {Element} Element to render.
 */
export default function save({attributes}) {

	console.log(attributes);

	const svgNode = QRCode({
		msg :  attributes.qrValue || '1234567890'
	   ,dim :   attributes.size || 256
	   ,pad :   3
	   ,mtx :   7
	   ,ecl :  "H"
	   ,ecb :   0
	   ,pal : [attributes.color || '#000', attributes.bgColor || '#fff']
	   ,vrb :   1
   
   });
	const svgString = new XMLSerializer().serializeToString(svgNode);

	return (
		<div { ...useBlockProps.save() }>
			{ <div dangerouslySetInnerHTML={{ __html: svgString }} /> }
		</div>
	);
}
