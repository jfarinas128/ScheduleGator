var picks = new Object();
var modal_count = 1;

$( document ).ready(function() {

	$('.submit-picks').on("click", function(event) {
		event.preventDefault();
		count = Object.keys(picks).length;
		if(count == 63) {
			out("picks: "+count);
			out(JSON.stringify(picks));
			post = [];
			input = {};
			input.name = "picks";
			input.value = JSON.stringify(picks);
			post.push(input);
			group = $("#group_id").text();
			out("group: "+group);
			var ajaxObj = ajax(base_url+"groups/create_bracket/"+group, post);
	    	ajaxObj.success(function(data){
	            var results = JSON.parse(data);
	            out(results.error);

	            if(results.error == false) {
					title = "Success";
					body = results.message;
				}
				else {
					title = "Error";
					body = results.message;

				}
				size = "sm";
				append_ok_modal(title, body, size);
				return true;
	    	});
		}
		else {
			title = "Hey!";
			body = "Please select a winner of every game before you submit your picks.";

			size = "sm";
			append_ok_modal(title, body, size);
		}
		


	});
	$('.bracket a').on("click", function(event) {
		event.preventDefault();
		//out($(this));
		//get game info
		// out($(this).parent());
		info      = $(".team",this).attr("id").split("-");
		region    = info[0];
		round     = info[1];
		game      = info[2];
		team      = info[3];
		team_id   = $(".team_id",this).text();
		seed      = $(".seed",this).text();
		team_name = $(".team_name",this).text();
		//out(seed+team_name);
		if(round <= 5) {
			next_game = get_game(region,round,game);
			next_game.id = team_id;
			next_game.team_name = team_name;
			next_game.seed = seed;
			next_game.champ = false;
			//out(next_game)
			fill_game(next_game);
		}
		else {
			next_game = new Object();
			next_game.id = team_id;
			next_game.team_name = team_name;
			next_game.seed = seed;
			next_game.champ = true;
			fill_champ(next_game);
		}
		add_pick(next_game);
		
	});

});
function add_pick(details){
	
	if(next_game.champ)
		id = "5-7-1-1";
	else
		id = details.region+"-"+details.round +"-"+details.game+"-"+details.team;
	picks[id] = team_id;
	
}
function fill_champ(details) {
	var new_game = $('#5-7-1-1');
	$(".seed",new_game).text(details.seed);
	$(".team_name",new_game).text(details.team_name);
	$(".team_id",new_game).text(details.id);
}

function fill_game(details) {
	var id = details.region+"-"+details.round +"-"+details.game+"-"+details.team;
	//out(id);
	var new_game = $('#'+id);
	$(".seed",new_game).text(details.seed);
	$(".team_name",new_game).text(details.team_name);
	$(".team_id",new_game).text(details.id);
}

function get_game(region, round, game) {
	output = new Object();
	next_games = Object();
		next_games.round1 = new Array("0-0","1-1","1-2","2-1","2-2","3-1","3-2","4-1","4-2");
		next_games.round2 = new Array("0-0","1-1","1-2","2-1","2-2");
		next_games.round3 = new Array("0-0","1-1","1-2");
		next_games.round4 = new Array("1-1","1-1","1-1","1-1");
		next_games.round5 = new Array("1-1","1-1","1-2","1-2","1-2");
		
		output.region = region;
		output.round = parseInt(round)+1;
		//out(game);
		game_info = next_games['round'+round][game].split("-");
		output.game = game_info[0];
		output.team = game_info[1];
	// out(region);
	// if(output.round == 6 && (output.region == 4 || output.region == 2)) output.team = 2; 
	if(output.round == 6) 
		if(output.region == 2) output.region = 4;
		else if(output.region == 1) output.region = 3;


	return output;
}

function out(data){
	console.log(data);
}


function ajax(location, post_data) {
	var tmp = post_data;
	if(typeof tmp === 'object') {
		if(typeof tmp[0] === 'object') {
			var input = {};
			input.name = "ajax";
			input.value = true;
			post_data.push(input);
		}
		else post_data.ajax = true;
	}

	return $.post(location, post_data, function(response) {
		//set_response(response);
		// out(response);
		return true;
	});
}
/*
	Appends a bootstrap modal to end of html BODY
	Params: 
	@title: String - title of the modal box
	@body: String - 
 */
	/**
	 * append_modal
	 *
	 * Appends a bootstrap modal to end of html BODY, simple dialog box with ok to close
	 *
	 * @title	string - title of the modal box
	 * @body  string - body content of the modal box
	 * @size string - values = lg or sm. Makes a large or small modal
	 */
function append_ok_modal(title, body, size) {
	if(size != "sm" && size != "lg") size = sm;

	modal = '<div class="modal fade" id="myModal'+modal_count+'">'
	  +'<div class="modal-dialog">'
	    +'<div class="modal-content">'
	      +'<div class="modal-header">'
	        +'<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>'
	        +'<h4 class="modal-title">'+title+'</h4>'
	      +'</div>'
	      +'<div class="modal-body">'
	        + body
	      +'</div>'
	      +'<div class="modal-footer">'
	        +'<button type="button" data-dismiss="modal" class="btn btn-primary">Ok</button>'
	      +'</div>'
	    +'</div><!-- /.modal-content -->'
	  +'</div><!-- /.modal-dialog -->'
	+'</div><!-- /.modal -->';

	$('body').append(modal);

	$('#myModal'+modal_count).modal('show');
	modal_count++;
}