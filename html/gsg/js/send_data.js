function submitForm()
{ 
    var xhr; 
    try {  xhr = new ActiveXObject('Msxml2.XMLHTTP');   }
    catch (e) 
    {
        try {   xhr = new ActiveXObject('Microsoft.XMLHTTP'); }
        catch (e2) 
        {
           try {  xhr = new XMLHttpRequest();  }
           catch (e3) {  xhr = false;   }
         }
    }
  
    xhr.onreadystatechange  = function() 
    { 
       if(xhr.readyState  == 4)
       {
        if(xhr.status  == 200) 
            alert("Operation r\351ussie \n1 sac consomm\351"); 
        else
            alert("Attention !!! \nOperation \351chou\351e");
        }
    }; 
 
   xhr.open( "GET", "data_granulee.php?value=1",  true); 
   xhr.send(null); 
} 

$(function() {

  $("#selection").change(function() {
    //alert($(this).val());
    $url = "index.php?an=" +  $(this).val();
    location.href= $url;
  });
  
});
