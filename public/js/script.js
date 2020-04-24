


/**
 * bs custom file input
 * Affichage nom fichier dans file browser input bootstrap
 */
bsCustomFileInput.init()


/* AUDIO PLAYER ------------------------------------------------------------------------ */

var audio;
 
//Hide Pause
$('#pause').hide();

//Hide mute
$('#volumeMute').hide();
 
//initAudio($('#playlist li:first-child'));
var playlist = $("[playlist*='playlist']")[0]; 
initAudio($("li:first-child", playlist));

function initAudio(element){

	var song = element.attr('song');
	var title = element.text();
	var cover = element.attr('cover');
	playlist = $("[playlist='" + element.attr("from") + "']")[0];

	//Create audio object
	audio = new Audio('tracks/'+ song);

	audio.addEventListener("ended", function() {
		audio.pause();
		var next = $('li.selected', playlist).next();
		if(next.length == 0){
			next = $('li:first-child', playlist);
		}
		initAudio(next);
		audio.play();
		showDuration();
	  });

	//Insert audio info
	$('.title').text(title);
	
	//Insert song cover
	$('img.cover').attr('src','images/albums/'+cover);
	$('li').removeClass('selected');
	element.addClass('selected');
}
 
//Play button
$('#play').click(function(){
	audio.play();
	$('#play').hide();
	$('#pause').show();
	showDuration();
});
 
//Pause button
$('#pause').click(function(){
	audio.pause();
	$('#play').show();
	$('#pause').hide();
});
 
//Stop button
$('#stop').click(function(){
	audio.pause();
	$('#play').show();
	$('#pause').hide();
	audio.currentTime = 0;
});
 
//Next button
$('#next').click(function(){
	audio.pause();
	var next = $('li.selected', playlist).next();
	if(next.length == 0){
		next = $('li:first-child', playlist);
	}
	initAudio(next);
	audio.play();
	showDuration();
});
 
//Prev button
$('#prev').click(function(){
	audio.pause();
	var prev = $('li.selected', playlist).prev();
	if(prev.length == 0){
		prev = $('li:last-child', playlist);
	}
	initAudio(prev);
	audio.play();
	showDuration();
});
 
//Playlist song click
$('.playlist li').click(function(){
	audio.pause();
	initAudio($(this));
	$('#play').hide();
	$('#pause').show();
	audio.play();
	showDuration();
});
 
//Volume control
$('#volume').change(function(){
	$('#volumeMute').hide();
	$('#volumeDown').show();
	audio.volume = parseFloat(this.value / 10);

});

//Volume down button
$('#volumeDown').click(function(){
	$('#volumeDown').hide();
	$('#volumeMute').show();
	audio.volume = 0;

});

//Volume mute button
$('#volumeMute').click(function(){
	$('#volumeMute').hide();
	$('#volumeDown').show();
	audio.volume = ($('#volume').val() / 10);
});

//Time/Duration
function showDuration(){
	$(audio).bind('timeupdate',function(){
		//Get hours and minutes
		var s = parseInt(audio.currentTime % 60);
		var m = parseInt(audio.currentTime / 60) % 60;
		if(s < 10){
			s = '0'+s;
		}
		$('#duration').html(m + ':'+ s);
		var value = 0;
		if(audio.currentTime > 0){
			value = Math.floor((100 / audio.duration) * audio.currentTime);
		}
		$('#progress').css('width',value+'%');
	});
}

