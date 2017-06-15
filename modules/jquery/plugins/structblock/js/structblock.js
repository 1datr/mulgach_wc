(function( $ ){

  var methods = {
    init : function( options ) { 
      // А ВОТ ЭТОТ
    	//alert(999);    	
    	id_attr = $(this).attr('itemtemplate');
    	this.block_one_sel = '#'+id_attr;
    	plg=this;
    	
    	fun_drop = function()
    	{
    		
    		block_list_sel = '#items_block';
    		block_one_sel = '#'+$(block_list_sel).attr('itemtemplate');
    		
    		$(this).parent('[role=item]').remove();
    		
    		// меняем все цифры в индексах
    		plg.find("div.items [role=item]").each(function(i,tag)
    				{
    					$(tag).find('[nametemplate]').each(function(j,tag_element)
    						{
    							nametempl = $(tag_element).attr('nametemplate');
    							newname = nametempl.replace(/#idx#/g,i.toString());
    							$(tag_element).attr('name',newname);
    						}
    					)
    			
    				})
    		
    	}
    	
    	$(this).find('.'+id_attr+'_add').click(
    		function()
    		{
    			$(plg.block_one_sel).first().attr('role','item');
    			new_data_block = $(plg.block_one_sel).first().clone();
    			new_data_block.css('visibility', 'visible' );
    			
    			new_data_block.removeAttr('id');
    			new_data_block.find('[name *= \\{idx\\}]').each(function(i,tag)
    					{
    						currname = $(tag).attr('name');
    						template = currname.replace(/{/g,"#");
    						template = template.replace(/}/g,"#");
    						$(tag).attr('nametemplate',template);		
    					});
    			
    			var nb_html = new_data_block.html();
    			// сколько элементов в списке 
    			var childs = $(plg).find("div.items [role=item]");
    			
    			nb_html = nb_html.replace(/{idx}/g, childs.length.toString());
    			new_data_block.html(nb_html);
    			//new_element = $(nb_html);

    			$(plg).find(".items").append(new_data_block);
    			new_data_block.find('.'+id_attr+'_drop').click(fun_drop);
    		}
    	);
    	
    	$(this).find('.'+id_attr+'_drop').click(fun_drop);
    },
    /*
    drop : function( ) {
      // ПОДХОД
    },
    */
    /*
    hide : function( ) {
      // ПРАВИЛЬНЫЙ
    },
    update : function( content ) {
      // !!!
    }*/
  };

  $.fn.jqStructBlock = function( method ) {
    
    // логика вызова метода
    if ( methods[method] ) {
      return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
    } else if ( typeof method === 'object' || ! method ) {
      return methods.init.apply( this, arguments );
    } else {
      $.error( 'Метод с именем ' +  method + ' не существует для jQuery.tooltip' );
    } 
  };

})( jQuery );
