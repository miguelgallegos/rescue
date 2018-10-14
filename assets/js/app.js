require('../css/app.css');

var $ = require('jquery');

$(document).ready(function() {
    $('input[name="q"]').on('keyup', function(e){
    	var action = $('form[name="search-pokemon-form"]').attr('action');
    	var queryText = $(this).val();
    	$.get(action, {q: queryText}, function(data){
    		// console.log(data);
    		$('#results').html(data);

    		

    	});
    	console.log(action);
    });
});