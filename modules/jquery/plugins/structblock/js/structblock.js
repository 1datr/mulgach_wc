(function( $ ){
  
  $.fn.jqStructBlock = function( options ) {
    
	  options = $.extend({
          param1: 'param1Value', //параметр1
          param2: 'param2Value' //параметр2
      }, options );
	  
	  var the_element;
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
		  if(the_block.length==0)
		  {
			  the_block = $('#'+$(this).attr('target'));
		  }
		  
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
		  if(options.hasOwnProperty('onadd'))
		      {
				options.onadd(new_data_block);
			  }
		  
		  new_data_block.find('.'+id_attr+'_drop').bind("click",drop);			  
			  
		  new_data_block.find('.'+id_attr+'_add').bind('click',add);			  
		  
		  new_data_block.find('.'+id_attr+'_move').bind('click',move);
		 
	  };
	  
	  function move()
	  {
		  moveto = $(this).attr('moveto');
		  if(moveto==null)
			  return;
		  moveto = parseInt(moveto, 10);
		  
		  curr_element = $(this).parents('[role=item]'); // текущий элемент
		  
		  the_block = $(this).parents('.jqStructBlock');
		  
		  id_attr = $(the_block).attr('itemtemplate');
		  
		  elements = $(this).parents('.jqStructBlock').find('[role=item]');	// список элементов
		  
		  idx1 = -1;
		  for(i=0;i<elements.length;i++)
		  {
			  if(elements[i]==curr_element[0])
			  {
				  idx1 = i;
				  break;
			  }
			  
		 }
	  
	  	 idx2 = idx1+moveto;
		  //
	  	 if((idx2<0)||(idx2>elements.length-1))
	  	 {
	  		 return;
	  	 }
	  	 html1 = $(elements[idx1]).html();
	  	 html2 = $(elements[idx2]).html();
	  	 
	  	 $(elements[idx2]).html(html1);
	  	 $(elements[idx1]).html(html2);
	  	 
	  	 $(elements[idx1]).find('.'+id_attr+'_drop').bind("click",drop);
	  	 $(elements[idx1]).find('.'+id_attr+'_add').bind('click',add); 
	  	 $(elements[idx1]).find('.'+id_attr+'_move').bind('click',move); 
	  	 
	  	 $(elements[idx2]).find('.'+id_attr+'_drop').bind("click",drop);
	  	 $(elements[idx2]).find('.'+id_attr+'_add').bind('click',add); 
	  	 $(elements[idx2]).find('.'+id_attr+'_move').bind('click',move); 
	  }
	  
	  function drop() {
			
		  	the_block = $(this).parents('.jqStructBlock').first(); // сам набор строк
		  	
		  	if(options.ondelete != null)
			{
				options.ondelete(this);
			}
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
		  
		the_element = element;  
		  
		id_attr = $(element).attr('itemtemplate');
		$(element).addClass('jqStructBlock');
		/*
	    $(element).find('.'+id_attr+'_add').bind('click',add); 
	    $(element).find('.'+id_attr+'_drop').bind('click',drop); 
	    */
		 $('.'+id_attr+'_add').bind('click',add); 
		 $('.'+id_attr+'_drop').bind('click',drop); 
		 $('.'+id_attr+'_move').bind('click',move); 
		  
	  /*    var dts = $(this).children('dt');
	      dts.click(onClick);
	      dts.each(reset);
	      if(settings.open) $(this).children('dt:first-child').next().show();*/
	    });
  };  

})( jQuery );
