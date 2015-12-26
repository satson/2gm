


<div style="height:1px;"></div>
<div class="mmDropDownInhaltElement">
  <div class="mmDropDownInhaltElementBtn" data-id="<?php echo $thisElemArr['elemData']['selemID']; ?>">
    <?php echo $thisElemArr['text1']; ?>
    <div class="mmDropDownInhaltElementBtnArrow"><i class="fa fa-chevron-down"></i></div>
  </div>
  
  <div class="mmDropDownInhaltElementInhaltHolder" id="mmDropDownInhaltElementInhaltHolderCurId<?php echo $thisElemArr['elemData']['selemID']; ?>">
    <?php echo $thisElemObj->setOwnElementDragDropHolder(); ?>
  </div>
  <div class="clearer"></div>
</div>