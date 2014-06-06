<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bracket {
	private $titles = array(
			"Round of 64",
			"Round of 32",
			"Sweet 16",
			"Elite 8",
			"Final Four",
			"Championship"
			);
	private $regions = array(
		1 =>'south',
		2 =>'west',
		3 =>'east',
		4 =>'midwest'
		);
	private $rounds = array(
		1 => array(8,2), //8 games with 2 teams each per region
		2 => array(4,2), // 4 games 2 teams
		3 => array(2,2),
		4 => array(1,2), // 1 game with 1 team from each region
		5 => array(1,1),
		6 => array(1,1)	);

	// Offsets at beginnging of round and after each game for that round.
	private $offsets = array(
		1 => array("round" => 0,	"game" =>0),
		2 => array("round" => 0.5,	"game" =>1),
		3 => array("round" => 1.5,	"game" =>3),
		4 => array("round" => 3.5,	"game" =>0),
		5 => array("round" => 7.5,	"game" =>0),
		6 => array("round" => 0,	"game" =>0)
		);
	private $bracket_data;
	private $grou_id;
	 public function __construct($params)
    {
        // Do something with $params
       	if(isset($params['bracket_data']))
        	$this->bracket_data = $params['bracket_data'];
       	if(isset($params['create']))
        	$this->create = $params['create'];
       	if(isset($params['group_id']))
        	$this->group_id = $params['group_id'];
    }


	public function create_bracket() {

        $this->build_bracket();
		//output title bar
		
		$this->title_bar($this->titles);

		//output by region
		echo $this->div_open(false, "bracket row");
		foreach($this->regions as $region=> $region_name) {

			//begin regions
			echo $this->div_open("region-".$region,"region col-md-6");
			echo $this->div(false, "region_title col-md-offset-".($region%2 == 0 ? "7":"3"),'<h3>'.strtoupper($region_name).'</h3>');

			//begin rounds per region
			foreach($this->rounds as $round=>$games){
				if($region%2 == 0 ) 	
					echo $this->div_open(false,"pull-right round col-md-2");
				
				else 
					echo $this->div_open(false,"round col-md-2");

				if($round != 6)
					$this->games($region,$round);
				else 
					if($region > 2)
						$this->games($region,$round);
				echo $this->div_close();
					
			}
			echo $this->div_close();
		}
		// $champ_box  = $this->div_open("champ", "team");
		// $champ_box .= '<strong class="seed"></strong> '."\n".'<p class="team_name"></p>'.'<div class="hidden team_id"></div>';
		// $champ_box .= $this->div_close().'<p class="caption">Champion</p>';
		
				
		echo $this->div_open(false,"champion");
			$this->team( 5, 7, 1, 1 );
		echo '<p class="caption">Champion</p>';
		echo $this->div("group_id","hidden",$this->group_id);
		echo $this->div_close();
		echo $this->div_close();

		// $this->_debug();	

	}

	public function games($region, $round) {
		if($round != 5)
			$this->offsets($round);
		else {
			if($region == 1 OR $region == 2)
				$this->offsets($round);
		}
		$games_num = $this->rounds[$round][0];
		$team_num = $this->rounds[$round][1];
		for($g = 1; $g <= $games_num; $g++) {

			echo $this->div_open(false, ($team_num == 1? "split-": "")."game");
			for($t=1; $t <= $team_num; $t++) {
				echo '<a href="#">';
				$this->team($region, $round, $g, $t);
				
				echo '</a>';
			}
			echo $this->div_close();
			if($g != $games_num)
			$this->offsets($round,true);
		}

		
	}

	public function team($region, $round, $game, $team, $team_id = false){
		/*region-round-game-team-team-id*/
		$identifier = $region.'-'.$round.'-'.$game.'-'.$team;
		$seed = '';
		$name = '';
		$id   = '';
		if(isset($this->bracket_data[$region][$round][$game][$team-1]))
		{
			$info = $this->bracket_data[$region][$round][$game][$team-1];
			$seed = $info['seed'];
			$name = $info['team_name'];
			$id   = $info['team_id'];
		}

	     //team   
		echo $this->div_open($identifier, "team");
		echo '<strong class="seed">'.$seed.'</strong> ';
	    echo '<p class="team_name">'.$name.'</p>';
		echo '<div class="hidden team_id">'.$id.'</div>';  
	                    
		echo $this->div_close();
	}
	public function offsets($round, $game = false) {
		if(!$game)
			$num = $this->offsets[$round]['round'];
		else
			$num = $this->offsets[$round]['game'];
		
		while ( $num > 0) {
			$class = "filler-game";
			$tmp = $num-1;
			if($tmp < 0) {
				$num = $num - 0.5;
				$class = 'filler-half';
			}
			else
				$num--;

			echo $this->div(false, $class);
		}
	}

    public function title_bar($titles)
    {
    	$output="";
    	if(is_array($titles)) {
    		echo $this->div_open(false,"row bracket_title");
    		echo $this->div_open(false,"region col-md-6");
    		foreach($titles as $title)
    			echo $this->div(false,"col-md-2", $title);
    		echo $this->div_close();

    		echo $this->div_open(false,"region col-md-6");
    		foreach($titles as $title)
    			$output = $this->div(false,"col-md-2", $title).$output;
    		echo $output;
    		echo $this->div_close();
    		// $output = $this->div(false,"row", $output);
    		// 
    		echo $this->div_close();
    	}
    }

    public function div( $id = false, $classes = false, $content = false ){
    	return '<div'.(!$id ? '' : ' id="'.$id.'"').(!$classes ? '' : ' class="'.$classes.'"').'>'.(!$content ? '' :$content).'</div>'."\n";
    }

    public function div_open( $id = false, $classes = false, $content = false ){
    	return '<div'.(!$id ? '' : ' id="'.$id.'"').(!$classes ? '' : ' class="'.$classes.'"').'>'."\n";
    }

    public function div_close() {
    	return '</div>';
    }

    public function build_bracket() {

		// organizing games
		$bracket = array();
		$games_by_seed = array(
			1 =>	1,
			2 =>	8,
			3 =>	6,
			4 =>	4,
			5 =>	3,
			6 =>	5,
			7 =>	7,
			8 =>	2,
			9 =>	2,
			10 =>	7,
			11 =>	5,
			12 =>	3,
			13 =>	4,
			14 =>	6,
			15 =>	8,
			16 =>	1
		);
    	if($this->create) {
    		
			$regions = array("south"=>1,"west"=>2,"east"=>3, "midwest"=>4);
			
	    	
		
			foreach($this->bracket_data as $row){
				$game = $games_by_seed[$row['seed']];
				$region = $row['region'];
				$round = 1;
				$bracket[$region][$round][$game][] = $row;
			}

    	}
    	else {

    		foreach($this->bracket_data as $row) {
    			$region = $row['region'];
    			$round = $row['round'];
    			$game = $row['game'];
    			$team = $row['team'];
    			$team_id = $row['team_id'];
    			if($round == 1 && $region != 5){
    				$game = $games_by_seed[$row['seed']];
					$bracket[$region][$round][$game][] = $row;
    			}
    			else {
	    			$bracket[$region][$round][$game][$team-1] = $row;
    			}
    		}
    		

    	}
		
		$this->bracket_data = $bracket;
    }

    public function _debug() {
    	foreach($this->bracket_data as $rid =>$region) {
    			echo '<pre>';
    			var_dump("REGION: ".$rid);
    			foreach($region as $roid=>$round) {
					var_dump("\tRound: ".$roid);
	    			foreach($round as $gid=>$game) {
						var_dump("\t\tgame: ".$gid);
		    			foreach($game as $tid=>$row) {
							var_dump("\t\t\tteam: ".$row['team_id']	);
							var_dump("\t\t\tteam_name: ".$row['team_name']);
							if($rid == 5) {
								echo '<pre>';
								var_dump($row);
								echo '</pre>';
							}
							
		    			}
	    			}

    			}
    			echo '</pre>';
    		}
    }
}

/* End of file Someclass.php */