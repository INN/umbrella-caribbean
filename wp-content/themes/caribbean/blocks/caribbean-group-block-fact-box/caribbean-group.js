function addSupportsAlign( settings, name ) {
	if ( name !== 'core/group' ) {
		return settings;
	}

	return lodash.assign( {}, settings, {
		supports: lodash.assign( {}, settings.supports, {
			align: true
		} ),
	} );
}

wp.hooks.addFilter(
	'blocks.registerBlockType',
	'caribbean/supports/align',
	addSupportsAlign
);
