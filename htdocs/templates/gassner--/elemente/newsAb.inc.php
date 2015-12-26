<?php

?>


<script type="text/javascript">
var subscriberlists=[];
function checkOptoutForm()
{
  var msg = {
    "error_list":"Bitte wÃ¤hlen Sie mindestens eine Liste!"
  };

  try
  {
    document.getElementById("unsubscribe").submit();
  }
  catch(e)
  {
    window.alert(e);
    return false;
  }
}
</script>
<form id="unsubscribe" action="http://newsletter.so-marketing.at/optout/optout/execute" method="post" accept-charset="utf-8">
  <input type="hidden" name="account_id" value="7751" />
  <input type="hidden" name="account_code" value="rLGsX" />
  <input type="hidden" name="optoutsetup_id" value="2" />
  <input type="hidden" name="optoutsetup_code" value="TLX3q" />
  <table>
    <tr>
      <td style="width:84px;">E-Mail</td>
      <td>
        <input id="optout_field_5" type="text" name="fields[5]" />
      </td>
    </tr>
  </table>
  <input style="margin-top:20px; margin-left:84px;" type="button" name="btn_submit" value="abmelden" onClick="return checkOptoutForm();" />
</form>