
function showTab(id)	{
	var tabelle = document.getElementById('vortraege');
	var tbodies = tabelle.getElementsByTagName('tbody');
	var max = tbodies.length;
	var i = 0;
	var reiter;
	var z;
	
	// Alle ausblenden
	while( i < max )	{
		z = i + 1;
		reiter = 'reiter' + z;
		
		if(i == id - 1)	{
			tbodies[i].style.display = '';
			document.getElementById(reiter).className = 'reiter reiteraktiv';
		} else {
			tbodies[i].style.display = 'none';
			document.getElementById(reiter).className = 'reiter';
		}
		i++;
	}
	
	document.cookie = "Vertraege=" + id ;

}
	

function tabInit()	{
	var tab = getCookie('Vertraege', 1);
	showTab(tab);	 
	 
}

function getCookie(cname, defaultValue) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    
    return defaultValue;
} 

function checkFindSubmit(value)	{
	if (value != '')	{
		document.headsearch.submit();
	}	
}

function showSection(section_id)	{
	var sectionList = document.getElementsByTagName('div');
	var tabList = document.getElementById('tablist');
	var tabList_u = document.getElementById('tablist_u');
	var tabs = tabList.getElementsByTagName('div');
	var max = sectionList.length;
	var i = 0;
	
	while (i < max)	{
		if(sectionList[i].id.substr(0, 7) == 'section' )	{
			sectionList[i].style.display = 'none';
		}
		i++;
	}
	
	max = tabs.length;
	i = 0;
	while ( i < max )	{
		if(i == section_id)	{
			tabs[i].className = 'reiter reiteraktiv';
		} else {
			tabs[i].className = 'reiter';
		}
		i++;
	}
	
	
	// Untere Tabliste
	var tabs = tabList_u.getElementsByTagName('div');
	max = tabs.length;
	i = 0;
	while ( i < max )	{
		if(i == section_id)	{
			tabs[i].className = 'reiter reiteraktiv';
		} else {
			tabs[i].className = 'reiter';
		}
		i++;
	}
	
	document.getElementById('section_' + section_id).style.display = 'block';
	
}
