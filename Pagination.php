<?php

class Pagination{

	private static function pagination_config(){
 		/*
 			Default Configuration
			USING BOOTSTRAP CLASSES;
			icon using MD icons;
 		*/
 		return [
 			'container_class' => 'btn-group',
 			'button_class' => 'btn',
 			'button_default_class' => 'btn-default',
 			'button_active_class' => 'btn-primary',
 			'icon_prev_class' => 'md-navigate-before',
 			'icon_next_class' => 'md-navigate-next',
 			'icon_first_class' => 'md-arrow-back',
 			'icon_last_class' => 'md-arrow-forward',
 			'delimiter' => '?',
		];
 	}

 	public static function pagination_bleh($activePage,$groupsCount,$url,array $config = null){
 		if($groupsCount < 2){
 			return false;
 		}

		$defaultConf=self::pagination_config();
		
		if(empty($config)){
	 		$config = $defaultConf;
		}else{
			foreach ($config as $key => $value) {
				if($value == "") unset($config[$key]);
			}
			$config=array_replace($defaultConf, $config);
		}

 		$prev = $activePage-1;
 		$next = $activePage+1;
 		$m="<div class=\"".$config['container_class']."\">";
		if($activePage > 1){
		    if($groupsCount > 10){
				$m.="<a title=\"Page 1\" class=\"".$config['button_class']." ".$config['button_default_class']."\" href=\"".base_url($url)."\">
				    <i class=\"".$config['icon_first_class']."\"></i>
				</a>";
			} 
		  	$m.="<a title=\"Page ".$prev."\" class=\"".$config['button_class']." ".$config['button_default_class']."\" href=\"".base_url($url.	$config['delimiter'].'page='.$prev)."\">
		      		<i class=\"".$config['icon_prev_class']."\"></i>
		  		</a>";
		}
		$max = ($groupsCount > 10) ?( ($activePage<6) ? 10 : ( ($activePage+5 >= $groupsCount) ? $groupsCount : $activePage+5 ) ): $groupsCount;
	  	$min = ($groupsCount > 10) ?( ($activePage>6) ? ( ($activePage+5 >= $groupsCount) ? $groupsCount-9: $activePage-4 ) : 1 ): 1;
		
		for($i=$min;$i<=$max;$i++){
		    $cname = ($activePage == $i) ? $config['button_active_class'] : $config['button_default_class'];
		    $m.="<a title=\"Page ".$i."\" class=\"btn ".$cname."\" href=\"".base_url($url.$config['delimiter'].'page='.$i)."\">
		     ".$i."
		    </a>";
		}
		   
	  	if($activePage < $groupsCount){
		  	$m.="<a title=\"Page ".$next."\" class=\"".$config['button_class']." ".$config['button_default_class']."\" href=\"".base_url($url.$config['delimiter'].'page='.$next)."\">
		    	<i class=\"".$config['icon_next_class']."\"></i>
		 	</a>";
			if($groupsCount > 10){ 
			$m.="<a title=\"Page ".$groupsCount."\" class=\"".$config['button_class']." ".$config['button_default_class']."\" href=\"".base_url($url.$config['delimiter'].'page='.$groupsCount)."\">
				<i class=\"".$config['icon_last_class']."\"></i>
			</a>";
			}
		}
		$m.="</div>";
		return $m;
 	}

}