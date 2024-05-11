jQuery( function ($) {
	$.fn.searchable = function () {
		const self = this;
		const searchField = $( this ).find( '[data-role="hg-search-input"]' );
		const glossaryItems = $( this ).find( '[data-role="hg-item"]' );
		const hgSections = $( this ).find( '[data-role="hg-section"]' );
		const hgNav = $( this ).find( '[data-role="hg-nav-selectable"]');

		searchField.on( "input", function () {
			var value = $( this )
				.val()
				.toLowerCase();

			hgSections.attr('data-has-filtered-items', false);

			hgNav.removeClass('htgb_active_nav');

			glossaryItems.filter( function () {
				var item = this;
				//compute whether this should be displayed
				var display = $( item )
						.find( "[data-role]" )
						.text()
						.toLowerCase()
						.indexOf( value ) > -1;

				$( item ).toggle( display );

				//if display set flag on section
				if(display){
					$( item ).parent('[data-role="hg-section"]').attr('data-has-filtered-items', true);
				}
			} );

			applySearchFilterFlag( self, searchField );


		} );
	};

    $.fn.navigable = function () {
        const 	options = $(this).find('[data-role="hg-nav-selectable"]');
        const hgSections = $( this ).find( '[data-role="hg-section"]' );
        const searchField = $( this ).find( '[data-role="hg-search-input"]' );
        const self = this;
        options.each(function () {
            $(this).click(function () {
                options.removeClass("htgb_active_nav");
                var isSearchFilterApplied = $(searchField).attr('data-is-search');
                $(this).addClass("htgb_active_nav");
                const __val = $(this)
                    .data("name")
                    .toLowerCase();
                const section = $(self).find('[data-role="hg-section"]');

				if (__val !== "all") {
					section.filter( function () {
						const _case = $( this )
							.find( '[data-role="hg-section-letter"]' )
							.text()
							.toLowerCase();

						$( this ).toggle( _case.indexOf( __val ) > -1 );
					} );
				} else {
					//ensure we should still show this
					//data-has-filtered-items="true"
					section.filter(function() {
					 	//console.log( $(this).data("has-filtered-items") );
						 return 'hg-section' === $(this).data("role")
					}).css( "display", "block" );
				}

			} );
		} );

	};

	const applySectionFilters = function( target ) {

		$( target ).find( '[data-role="hg-section"]' ).each( function(index){ 
				var section = $( this );
				var letter = section.find('[data-role="hg-section-letter"]').text();
				var hasFilteredItems = section.attr('data-has-filtered-items');
				if( 'true' == hasFilteredItems ){
					section.show();
					$( '[data-role="hg-nav-selectable"][data-name="' + letter + '"').removeClass('htgb_search_disabled');
				} else {
					section.hide();
					$( '[data-role="hg-nav-selectable"][data-name="' + letter + '"').addClass('htgb_search_disabled');
				}
			 });
	}

	const revertSectionFilters = function( target ) {
		$( target ).find( '[data-role="hg-section"]' ).each( function(index){ 
			var section = $( this );
			var letter = section.find('[data-role="hg-section-letter"]').text();
			section.show();
			$( '[data-role="hg-nav-selectable"][data-name="' + letter + '"').removeClass('htgb_search_disabled');
		});
	}

	const applySearchFilterFlag = function( block, searchFieldTarget ){
		const target = $( searchFieldTarget );
		var value = target.val().toLowerCase();
		var isSearch = value.length < 1 ? false : true;

		target.attr('data-is-search', isSearch);

		if(isSearch){
			applySectionFilters( block );
		} else {
			revertSectionFilters( block )
		}
		
	}

	//initialize the navigation and search functionality
	let containers = $( ".hg-glossary" );
	containers.each( function () {
		$( this ).navigable();
		$( this ).searchable();
	} );


} );
