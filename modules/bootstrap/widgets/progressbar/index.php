<?php
namespace BootstrapProgressBar
{
	use \Widget;

	class ProgressBarWidget extends \Widget
	{
		function out($params=array())
		{
			def_options(['value'=>0,'value_min'=>0,'value_max'=>100,'htmlattrs'=>[],'htmlattrs_inside'=>[]], $params);
			def_options(['style'=>'width:'.$params['value'].'%;'],$params['htmlattrs']);
			def_options(['style'=>'display:none;','id'=>$params['id']."_inside"],$params['htmlattrs_inside']);
			
			find_module('page')->getController()->add_js(filepath2url(url_seg_add(__DIR__,'/js/progbar.js')));
			?>
			 <div class="progress" id="<?=$params['id']?>" <?=$this->get_attr_str($params['htmlattrs'])?> >
			  <div <?=$this->get_attr_str($params['htmlattrs_inside'])?> class="progress-bar" role="progressbar" aria-valuenow="<?=$params['value']?>"  aria-valuemin="<?=$params['value_min']?>" aria-valuemax="<?=$params['value_max']?>">
				    <span class="sr-only"><span><?=$params['value']?></span>% Complete</span>
			  </div>
			</div> 			
			<?php

		}
	}

}
?>