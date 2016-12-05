<script src="<?php echo base_url().getThemeName(); ?>/js/jquery.searchable-1.0.0.min.js"></script>
<script src="<?php echo base_url().getThemeName(); ?>/js/jquery.searchable.js"></script>
<script>
	$(document).ready(function(){
		
    $( '#table' ).searchable({
        striped: true,
        oddRow: { 'background-color': '#f5f5f5' },
        evenRow: { 'background-color': '#fff' },
        searchType: 'fuzzy'
    });
    
    $( '#searchable-container' ).searchable({
        searchField: '#container-search',
        selector: '.row',
        childSelector: '.col-xs-4',
        show: function( elem ) {
            elem.slideDown(100);
        },
        hide: function( elem ) {
            elem.slideUp( 100 );
        }
    })
});
</script>
  <div class="row">
        <div class="col-lg-4 col-lg-offset-4">
            <input type="search" id="container-search" value="" class="form-control" placeholder="Search...">
        </div>
    </div>
<div class="container" id="searchable-container">
    <div class="row row-padding">
        <div class="col-xs-4">Col 1</div>
        <div class="col-xs-4">Col 2</div>
        <div class="col-xs-4">Col 3</div>
    </div>
    <div class="row row-padding">
        <div class="col-xs-4">Another row</div>
        <div class="col-xs-4">With some</div>
        <div class="col-xs-4">Other data</div>
    </div>
    <div class="row row-padding">
        <div class="col-xs-4">Lorem</div>
        <div class="col-xs-4">Ipsum</div>
        <div class="col-xs-4">Dolor</div>
    </div>
    <div class="row row-padding">
        <div class="col-xs-4">Foo</div>
        <div class="col-xs-4">Bar</div>
        <div class="col-xs-4">Baz</div>
    </div>
</div>

<style>
	.row-padding {
    margin-top: 25px;
    margin-bottom: 25px;
}
</style>
