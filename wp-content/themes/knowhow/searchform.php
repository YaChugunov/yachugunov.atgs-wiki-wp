<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
  <input type="text" value="<?php _e("Search...", "knowhow") ?>" name="s" id="s" onblur="if (this.value == '')  {this.value = '<?php _e("Search...", "knowhow") ?>';}" onfocus="if (this.value == '<?php _e("Search...", "knowhow") ?>')  
  {this.value = '';}" />
</form>