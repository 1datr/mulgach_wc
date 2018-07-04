<?php
namespace BootstrapProgressBar
{
	use \Widget;

	class ProgressBarWidget extends \Widget
	{
		function out($params=array())
		{
			def_options(['value'=>0,'value_min'=>0,'value_max'=>100,'htmlattrs'=>[],'htmlattrs_inside'=>[]], $params);
			def_options(['style'=>'display:none;','class'=>'progress'],$params['htmlattrs']);
			def_options(['id'=>$params['id']."_inside",'style'=>'width:'.$params['value'].'%;'],$params['htmlattrs_inside']);
			$params['htmlattrs']['id']=$params['id'];
			if(isset($params['class']))
				$params['htmlattrs']['class']='progress '.$params['class'];
			find_module('mulgach.hmvc')->getController()->add_js(filepath2url(url_seg_add(__DIR__,'/js/progbar.js')));
			?>
			 <div <?=$this->get_attr_str($params['htmlattrs'])?> >
			  <div <?=$this->get_attr_str($params['htmlattrs_inside'])?> class="progress-bar" role="progressbar" aria-valuenow="<?=$params['value']?>"  aria-valuemin="<?=$params['value_min']?>" aria-valuemax="<?=$params['value_max']?>"></div>
			</div> 			
			<?php

		}
	}

}
?>