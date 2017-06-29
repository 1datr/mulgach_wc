<?php
namespace BootstrapPager
{
	use \Widget;

	class PagerWidget extends \Widget 
	{
		function out($params=array())
		{
			if($params['ds']->pages_count>1)
			{
				$request = $this->_PARAMS['controller']->getRequest();
			?>
			<nav aria-label="Page navigation example">
				<ul class="pagination">
					<?php 
					if($params['ds']->_PAGE>1)
					{
						$url_prev = $request->url_modified(array('page'=>$params['ds']->_PAGE-1))
						?>
						<li class="page-item"><a class="page-link" href="<?=$url_prev?>">Previous</a></li>	
						<?php 
					}
					?>
					
					<?php 
		//			print_r($params);
					$params['ds']->draw_pager(function($page,$info) use ($request)
					{
						$url = $request->url_modified(array('page'=>$page));
						if($info['current_page']==$page)
						{
							?><li class="page-item  active"><a class="page-link" href="#"><?=$page?></a></li><?php 
						}
						else 
						{
							?>
							<li class="page-item"><a class="page-link" href="<?=$url?>"><?=$page?></a></li>
							<?php 
						}
					});
					?>
					
					<?php 
					if($params['ds']->_PAGE < $params['ds']->pages_count )
					{
						$url_next = $request->url_modified(array('page'=>$params['ds']->_PAGE+1))
						?>
						<li class="page-item"><a class="page-link" href="<?=$url_next?>">Next</a></li>	
						<?php 
					}
					?>			    	
			  	</ul>
			</nav>
			
			<?php
			}
		}
	}

}
?>