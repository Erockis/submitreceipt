

$(document).ready(function()
{
  $("#b1").prop('value', 'Receipt');

  $("#b1").click(function() 
  {
     openWindow('form/index.html');
  
  });

});



function openWindow(theURL)
{
        var w =( window.open(theURL,'','width=1024,height=768, status=no,location=no, titlebar=no, menubar=no, toolbar=no,addressbar=no').focus);
   
}
