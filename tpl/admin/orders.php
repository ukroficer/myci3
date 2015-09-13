               
    <script type="text/javascript">
    
     $(function() {
    
	$("#sortable").sortable({
        		//handle: '.moto_list',
	        	opacity: 0.5,
        		cursor: 'move',
        		revert: true,
        		update: function() {
    				var order = $(this).sortable("serialize");
	    				$.post("<?=site_url($url_save_order)?>", order, function(theResponse){});
    			}
    		});
     
     
     
  });
    
    </script>           
          
          
               
               
           <div id="sortable">   
               
               <?php foreach($order as $k=>$v ):?>
                    <div class="menu_list"  id="order_<?=$v->id;?>" >
                <?=$v->name;?>
                </div>
                <?php endforeach;?>  
                
                
                 </div> 