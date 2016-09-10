<?php


class Paging
{
	protected $config;

	function __construct(array $config=null)
	{
		$this->config = [
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
		$this->set_config($config);
	}

	public function set_config(array $config=null){
		
		if(empty($config)){
	 		$config = $this->config;
		}else{
			foreach ($config as $key => $value) {
				if($value == "") unset($config[$key]);
			}
			$config=array_replace($this->config, $config);
		}
		
		$this->config = $config;
		return $this;
 	}

 	public function generate($activePage,$groupsCount,$url){
 		if($groupsCount < 2){
 			return false;
 		}		

 		$prev = $activePage-1;
 		$next = $activePage+1;
 		$m="<div class=\"".$this->config['container_class']."\">";
		if($activePage > 1){
		    if($groupsCount > 10){
				$m.="<a title=\"Page 1\" class=\"".$this->config['button_class']." ".$this->config['button_default_class']."\" href=\"".base_url($url)."\">
				    <i class=\"".$this->config['icon_first_class']."\"></i>
				</a>";
			} 
		  	$m.="<a title=\"Page ".$prev."\" class=\"".$this->config['button_class']." ".$this->config['button_default_class']."\" href=\"".base_url($url.	$this->config['delimiter'].'page='.$prev)."\">
		      		<i class=\"".$this->config['icon_prev_class']."\"></i>
		  		</a>";
		}
		$max = ($groupsCount > 10) ?( ($activePage<6) ? 10 : ( ($activePage+5 >= $groupsCount) ? $groupsCount : $activePage+5 ) ): $groupsCount;
	  	$min = ($groupsCount > 10) ?( ($activePage>6) ? ( ($activePage+5 >= $groupsCount) ? $groupsCount-9: $activePage-4 ) : 1 ): 1;
		
		for($i=$min;$i<=$max;$i++){
		    $cname = ($activePage == $i) ? $this->config['button_active_class'] : $this->config['button_default_class'];
		    $m.="<a title=\"Page ".$i."\" class=\"btn ".$cname."\" href=\"".base_url($url.$this->config['delimiter'].'page='.$i)."\">
		     ".$i."
		    </a>";
		}
		   
	  	if($activePage < $groupsCount){
		  	$m.="<a title=\"Page ".$next."\" class=\"".$this->config['button_class']." ".$this->config['button_default_class']."\" href=\"".base_url($url.$this->config['delimiter'].'page='.$next)."\">
		    	<i class=\"".$this->config['icon_next_class']."\"></i>
		 	</a>";
			if($groupsCount > 10){ 
			$m.="<a title=\"Page ".$groupsCount."\" class=\"".$this->config['button_class']." ".$this->config['button_default_class']."\" href=\"".base_url($url.$this->config['delimiter'].'page='.$groupsCount)."\">
				<i class=\"".$this->config['icon_last_class']."\"></i>
			</a>";
			}
		}
		$m.="</div>";
		return $m;
 	}
}

function Pagination(array $config=null)
{
	return new Paging($config);	
}
