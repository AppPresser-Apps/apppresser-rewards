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
import { useBlockProps, InnerBlocks, useInnerBlocksProps } from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';


import { PanelBody, TextControl, RangeControl, SelectControl } from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({attributes, setAttributes}) {

	const blockProps = useBlockProps();

    const TEMPLATE = [
		['core/columns', 
			{
				"style":{
					"spacing": {
						"padding": {
							"top": "var:preset|spacing|20",
							"bottom": "var:preset|spacing|20"
						},
						"blockGap": {"top":"0"}
					}
				},
				"backgroundColor":"contrast"
			},
			[
				['core/column', 
					{
						"verticalAlignment":"center",
						"width":"",
						"style":{
							"spacing":{
								"blockGap":"0",
								"padding":{
									"top":"var:preset|spacing|10",
									"bottom":"var:preset|spacing|10"
								}
							}
						}
					}, 
					[
						['core/paragraph', 
						{ 
							placeholder: 'Subtitle',
							"style":{
								"elements":{
									"link":{
										"color":{
										"text":"var:preset|color|base-2"
										}
									}
								},
								"typography":{
									"fontStyle":"normal",
									"fontWeight":"300"
								}
							}, 
							"textColor":"base-2", 
							"fontFamily":"montserrat"
						 }],
						['core/heading', 
							{"placeholder":"Rewards Title","style":{"elements":{"link":{"color":{"text":"var:preset|color|base-2"}}},"typography":{"fontStyle":"normal","fontWeight":"300","fontFamily":"playfair-display"}},"textColor":"base-2","fontWeight":"300","fontSize":"x-large"}
						], 
						['core/paragraph', 
							{"placeholder":"Rewards disclaimer.","style":{"elements":{"link":{"color":{"text":"var:preset|color|base-2"}}},"typography":{"fontStyle":"normal","fontWeight":"300"}},"textColor":"base-2","fontFamily":"montserrat"}
						],
						['core/paragraph', 
							{"placeholder":"Rewards disclaimer.","style":{"elements":{"link":{"color":{"text":"var:preset|color|base-2"}}},"spacing":{"padding":{"top":"var:preset|spacing|30"}},"typography":{"fontStyle":"normal","fontWeight":"300"}},"textColor":"base-2","fontSize":"small","fontFamily":"montserrat"}
						],
					]
				],
				['core/column', 
					{
						"verticalAlignment":"center",
						"width":"",
						"style":{
							"spacing":{
								"padding":{
									"top":"var:preset|spacing|10",
									"bottom":"var:preset|spacing|10"
								}
							}
						}
					}, 
					[
						['core/image',{"id":25585,"aspectRatio":"1","scale":"cover","sizeSlug":"full","linkDestination":"none", "url":"/wp-content/uploads/2017/10/halopub19-85-edited-1000x667-1-jpg.webp", "alt":"Rewards Image"} ],
						['apppresser/qrcode'],
					]
				],
			],
		],
		
	];

	return (
		<div { ...blockProps }>
				<InspectorControls>
					<PanelBody title="Settings">
						<SelectControl
							label="Rewards Type"
							value={ attributes.type }
							options={ [
								{ label: 'Select a reward type', value: '' },
								{ label: 'Image', value: 'image' },
								{ label: 'QR Code', value: 'qrcode' },
								// Add more options as needed
							] }
							onChange={ ( value ) => setAttributes( { type: value } ) }
						/>
					</PanelBody>
				</InspectorControls>
				<div className={`${attributes.type}`}>
				<InnerBlocks
						template={TEMPLATE}
						templateLock="all"
						allowedBlocks={TEMPLATE}
					/>
				</div>
		</div>
	);
}
