<script>

$(document).ready(function(){

  var text = "simple #text #test dsfhsdfhsopdfh #No";
  var checkTag = text.search("#");
  length = text.length;
  var i;
  var tag;
  
  console.log();
  if(checkTag>0)
    {
      text = text.split(" ");
      length = text.length;
      for(i=0;i<length;i++)
      {
        checkTag = text[i].search("#");
        if(checkTag==0)
        {
          text[i] = "<a href="+text[i].substring(1)+">"+text[i]+"</a>";
        }

      }

    } 
  else if(checkTag <0)
    {
      
    }

  $('#show').html(text.join('')); 

});

</script>

<div id="show"></div>
<div id="result"></div>