


<div style="height:1px;"></div>
<div class="mmFooterBoxElement">
  <div class="row">
    <div class="col-md-3 col-sm-6 col-xs-12 mmFooterBoxElementSpalte">
      <div class="mmFooterBoxElementSpalteHead"><?php echo $thisElemArr['text1']; ?></div>
      <div class="mmFooterBoxElementSpalteInhalt"><?php echo $thisElemArr['text5']; ?></div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12 mmFooterBoxElementSpalte">
      <div class="mmFooterBoxElementSpalteHead"><?php echo $thisElemArr['text2']; ?></div>
      <div class="mmFooterBoxElementSpalteInhalt">
        <?php echo $thisElemArr['text7']; ?>
        <?php /*<div class="mmFooterBoxElementSpalteInhaltSocialAlone">
          <a href="#" class="mmFooterBoxElementSpalteInhaltSocialLinks mmFooterBoxElementSpalteInhaltSocialLinkFacebook">Facebook</a>
          <div></div>
          <a href="#" class="mmFooterBoxElementSpalteInhaltSocialLinks mmFooterBoxElementSpalteInhaltSocialLinkGooglePlus">Google+</a>
          <div></div>
          <a href="#" class="mmFooterBoxElementSpalteInhaltSocialLinks mmFooterBoxElementSpalteInhaltSocialLinkTwitter">Twitter</a>
          <div></div>
          <a href="#" class="mmFooterBoxElementSpalteInhaltSocialLinks mmFooterBoxElementSpalteInhaltSocialLinkMail">E-Mail</a>
        </div>*/?>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12 mmFooterBoxElementSpalte">
      <div class="mmFooterBoxElementSpalteHead"><?php echo $thisElemArr['text3']; ?></div>
      <div class="mmFooterBoxElementSpalteInhalt mmFooterBoxElementSpalteInhaltNewsletter">
        <form accept-charset="utf-8" action="http://newsletter.so-marketing.at/optin/optin/execute" id="subscribe_1_" method="post">
          <input name="account_id" type="hidden" value="7751" />
          <input name="account_code" type="hidden" value="rLGsX" />
          <input name="optinsetup_id" type="hidden" value="1" />
          <input name="optinsetup_code" type="hidden" value="pQJfQ" />
          <input id="subscribe_1_mwic" name="ic" type="hidden" value="" />
          
          <select class="form-control" name="fields[1]" id="subscribe_1_optin_field_1">
            <option selected="selected" value=""><?php echo GASSNER_AUSWAEHLEN_POINTS; ?></option><option value="Herr">Herr</option><option value="Frau">Frau</option><option value="Mr.">Mr.</option><option value="Mrs.">Mrs.</option><option value="Ms.">Ms.</option><option value="M.">M.</option><option value="Mme.">Mme.</option><option value="Familie">Familie</option><option value="Firma">Firma</option><option value="Fam">Fam</option><option value="Fam.">Fam.</option><option value="Famiglia">Famiglia</option><option value="Family">Family</option><option value="Herr Dr.">Herr Dr.</option><option value="Herr Ing.">Herr Ing.</option><option value="Herrn">Herrn</option><option value="Mr">Mr</option><option value="Mrs">Mrs</option><option value="Ms">Ms</option><option value="Reisebüro">Reiseb&uuml;ro</option><option value="Sig.">Sig.</option><option value="Steuerbüro">Steuerb&uuml;ro</option><option value="Dear">Dear</option>
          </select>
          <input class="form-control" type="text" name="fields[4]" id="subscribe_1_optin_field_4" placeholder="<?php echo GASSNER_VORNAME; ?>" />
          <input class="form-control" type="text" name="fields[3]" id="subscribe_1_optin_field_3" placeholder="<?php echo GASSNER_NACHNAME; ?>" />
          <input class="form-control" type="text" name="fields[5]" id="subscribe_1_optin_field_5" placeholder="<?php echo GASSNER_MAIL; ?>" />
          <input class="btn btn-default" type="button" name="btn_submit" id="" value="<?php echo GASSNER_ANMELDEN; ?>" onclick="return optin_context_subscribe_1_.checkForm();" />
        </form>
      </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12 mmFooterBoxElementSpalte">
      <div class="mmFooterBoxElementSpalteHead"><?php echo $thisElemArr['text4']; ?></div>
      <div class="mmFooterBoxElementSpalteInhalt"><?php echo $thisElemArr['text6']; ?></div>
    </div>
  </div>
</div>




<!-- initialize --><script language="javascript" type="text/javascript">

var optin_context_subscribe_1_ = {
  
  form_id:                 'subscribe_1_',
  ci_id:                   'subscribe_1_mwic',
  ci:                      true,
  check_lists_or_setups:   false,
  mandatories:             [ "subscribe_1_optin_field_5"],
  emailfields:             [ "subscribe_1_optin_field_5"],
  subscriberlists:         [ ],
  optinsetups:             [ ],
 
  
  
  datepicks:               [ ],
  
  msg:                      {
                              "error_mandatory":"Bitte geben Sie Ihre E-Mail Adresse ein!",
                              "error_email":"Bitte überprüfen Sie Ihre E-Mail Adresse!",
                              "error_list":"Bitte wählen Sie mindestens eine Liste!"
                            },

  init:function () {
      for(i = 0; i < this.datepicks.length; i++){
        var DTP = new DateTimePicker( this.datepicks[i].id + '_hidden',this.datepicks[i].id,this.datepicks[i]);
        DTP.init();
      }
      
     if(this.ci){
      setInterval(function(){
        var el=document.getElementById(optin_context_subscribe_1_.ci_id);
        if(el){
            if (isNaN(parseInt(el.value)) == true){
              el.value = 0;
            }
            else{
              el.value = parseInt(el.value) + 17;
            }
        }
        console
      }, 1000);
    }
    
  },
  
  checkForm:function () {

      try
      {
         var frmelem = document.getElementById(this.form_id);


        if(this.check_lists_or_setups){
        
            var temp = false;
            for(var i=0;i<  this.subscriberlists.length;i++){
              if(document.getElementById(this.subscriberlists[i]).checked==true){
                temp = true;
                break;
              }
            }
            
              for(var i=0;i<  this.optinsetups.length;i++){
                if(document.getElementById(this.optinsetups[i]).checked==true){
                  temp = true;
                  break;
                }
              }
              
              if(!temp) throw this.msg.error_list;
          }
          

           for (var i=0; i<  this.mandatories.length; i++){
            var cfObj=document.getElementById(this.mandatories[i]);
            
            if (cfObj!=null)
            {
              if (cfObj.type.toLowerCase()=="text" || cfObj.type.toLowerCase()=="textarea")
              {
                if (cfObj.value.match(/^\s*$/)) throw this.msg.error_mandatory;
              }
              else if (cfObj.type.toLowerCase()=="radio" || cfObj.type.toLowerCase()=="checkbox")
              {
                var tmpObj=document.getElementsByName(cfObj.name);
                var tmpCheck=false;

                for (var j=0;j<  tmpObj.length; j++)
                
                {
                  if (tmpObj[j].checked==true)
                  {
                    tmpCheck=true;
                    break;
                  }
                }
                if(!tmpCheck) throw this.msg.error_mandatory;
              }
              else if (cfObj.type.toLowerCase().indexOf("select")>=0)
              {
                if (cfObj.selectedIndex<=0) throw this.msg.error_mandatory;
                if (cfObj.selectedIndex<=0) throw this.msg.error_mandatory;
              }
            }
          }

          var validmail = new RegExp("^[a-zA-Z0-9_\\.\\-]+@[a-zA-Z0-9_\\.\\-]+\\.[a-zA-Z0-9]{2,13}$");
          
          for (var i=0;i<  this.emailfields.length; i++){
            if(!validmail.test(document.getElementById(this.emailfields[i]).value)) throw this.msg.error_email;
          }

         frmelem.submit();
      }
      catch(e)
      {
        window.alert(e);
        return false;
      }
    }
}
  window.onload= optin_context_subscribe_1_.init();

</script><!-- mwscripts -->