var clicked = 4;

function byClass( sel ) {
    var results;
    if( document.querySelectorAll ) {
        results = document.querySelectorAll( '.' + sel );
    } else if( document.getElementsByClassName ) {
        results = document.getElementsByClassName( sel );
    } else {
        var elements = document.getElementsByTagName('*'),
        results = [];
    }
    return results;
}

function select(object)
{
	if(clicked > 0 && object.className == 'rank-row')
	{
		object.className='selected-row';
		clicked--;
	}
	else if(object.className != 'rank-row')
	{
		object.className='rank-row';
		clicked++;
	}
	reshow(clicked);
	
	if(clicked == 0)
	{
		var result = byClass('selected-row');
		document.getElementById('hiddenSel1').value = result[0].id;
		document.getElementById('hiddenSel2').value = result[1].id;
		document.getElementById('hiddenSel3').value = result[2].id;
		document.getElementById('hiddenSel4').value = result[3].id;
	}
}

function refresh()
{
	clicked = 4;
	reshow(clicked);
	
	var result = byClass('selected-row');
	for(var i=0; result[i]; i++)
		result[i].className='rank-row';
}

function reshow(num)
{
	document.getElementById('var-selected').innerHTML = num;
}

var glob_result = byClass('selected-row');
for(var i=0; result[i]; i++)
	clicked--;
reshow(clicked);

function check()
{
	if(clicked != 0)
	{
		alert('You did not use all your clicks.');
		return false;
	}
}