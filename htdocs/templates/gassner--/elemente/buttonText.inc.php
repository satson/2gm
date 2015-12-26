


<div style="height:1px;"></div>
<div class="mmButtonTextElement">
  <div class="mmButtonTextElementBtnsHolder">
    <div class="mmButtonTextElementBtn" data-id="<?php echo $thisElemArr['elemData']['selemID']; ?>"><?php echo $thisElemArr['text1']; ?></div>
    <div class="mmButtonTextElementBtnArrow"><i class="fa fa-chevron-down"></i></div>
  </div>
  <div class="mmButtonTextElementText" id="mmButtonTextElementTextCurId<?php echo $thisElemArr['elemData']['selemID']; ?>">
    <?php echo $thisElemArr['text2']; ?>
    <div style="height:20px;"></div>
    <?php echo $thisElemObj->setOwnElementDragDropHolder(); ?>
  </div>
  <div class="clearer"></div>
</div>