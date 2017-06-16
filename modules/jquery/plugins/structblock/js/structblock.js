(function( $ ){
  
  $.fn.jqStructBlock = function( method ) {
    
    // логика вызова метода
   /* if ( methods[method] ) {
      return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
    } else if ( typeof method === 'object' || ! method ) {
      return methods.init.apply( this, arguments );
    } else {
      $.error( 'Метод с именем ' +  method + ' не существует для jQuery.tooltip' );
    } 	
    */
	  function add(  ) // добавить строку 
	  {	      
		  the_block = $(this).parents('.jqStructBlock').first(); // сам набор строк
		  
		  id_attr = $(the_block).attr('itemtemplate');
		  block_one_sel = '#'+id_attr;
		  
	    	$(block_one_sel).first().attr('role','item');
			new_data_block = $(block_one_sel).first().clone();
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
			var childs = the_block.find(".items [role=item]");
			
			nb_html = nb_html.replace(/{idx}/g, childs.length.toString());
			new_data_block.html(nb_html);
			//new_element = $(nb_html);

			$(the_block).find(".items").append(new_data_block);
			new_data_block.find('.'+id_attr+'_drop').bind( "click",drop);
	  };
	  
	  function drop() {
			
		  	the_block = $(this).parents('.jqStructBlock').first(); // сам набор строк
			$(this).parents('[role=item]').remove();	// Удаляем сам айтем
			
			// меняем все цифры в индексах
			the_block.find(".items [role=item]").each(function(i,tag)
					{
						$(tag).find('[nametemplate]').each(function(j,tag_element)
							{
								nametempl = $(tag_element).attr('nametemplate');
								newname = nametempl.replace(/#idx#/g,i.toString());
								$(tag_element).attr('name',newname);
							}
						)
				
					});
	  };
	  
	  return this.each(function(i,element) {
		  
		id_attr = $(element).attr('itemtemplate');
		$(element).addClass('jqStructBlock');
	    $(element).find('.'+id_attr+'_add').bind('click',add); 
	    $(element).find('.'+id_attr+'_drop').bind('click',drop); 
		  
	  /*    var dts = $(this).children('dt');
	      dts.click(onClick);
	      dts.each(reset);
	      if(settings.open) $(this).children('dt:first-child').next().show();*/
	    });
  };  
})( jQuery );
