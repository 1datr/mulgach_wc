<?php
namespace BootstrapProgressBar
{
	use \Widget;

	class ProgressBarWidget extends \Widget
	{
		function out($params=array())
		{
			def_options(['value'=>0,'value_min'=>0,'value_max'=>100,'htmlattrs'=>[]], $params);
			def_options(['style'=>'width:'.$params['value'].'%'],$params['htmlattrs']);
			?>
			 <div class="progress" style="display:none;" id="<?=$params['id']?>">
			  <div <?=$this->get_attr_str($params['htmlattrs'])?> class="progress-bar" role="progressbar" aria-valuenow="<?=$params['value']?>"  aria-valuemin="<?=$params['value_min']?>" aria-valuemax="<?=$params['value_max']?>">
				    <span class="sr-only"><span><?=$params['value']?></span>% Complete</span>
			  </div>
			</div> 			
			<?php

		}
	}

}
?>