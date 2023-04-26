(async function (blocks, element) {

    const { createElement: el } = wp.element;
    const { RichText, MediaUpload } = wp.editor;
    const { __ } = wp.i18n;

    wp.blocks.registerBlockType('my-custom-blocks/block-1', {
        title: __('Block 1', 'my-custom-blocks'),
        icon: 'smiley',
        category: 'custom-blocks',
        attributes: {
            title: {
                type: 'string',
                source: 'text',
                selector: ''
            },
            body: {
                type: 'string',
                source: 'html',
                selector: ''
            },
            image: {
                type: 'string',
                source: 'attribute',
                selector: '',
                attribute: 'src'
            }
        },

        edit: function (props) {
            var attributes = props.attributes;
            var InspectorControls = wp.blockEditor.InspectorControls;
            var TextControl = wp.components.TextControl;

            return el('section', { className: '' },
                el(RichText, {
                    tagName: '',
                    className: '',
                    onChange: (value) => props.setAttributes({ body: value }),
                    value: attributes.body,
                    placeholder: __('Enter body text here', 'my-custom-blocks')                    
                }),

                el('div', { 
                    className: '' 
                }),
            )
        },

        save(props) {
            var attributes = props.attributes;

            return el('section', { className: '' },
                el(RichText.Content, {
                    tagName: '',
                    className: '',
                    value: attributes.title,
                }),

                el('div', {
                    className: ''
                })
            )
        }
    })
}(window.wp.blocks, window.wp.element));
