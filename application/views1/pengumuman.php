<style>
#table-detail tr:hover
{
background: #D7A42B;color:white;
}
#modal_ubah label{color:white;

}
#table-detail tr td {
     padding-top:0px;padding-bottom:0px;font-size: 12px
}
#table-detail td:nth-of-type(1), #table-detail td:nth-of-type(4), #table-detail td:nth-of-type(7){
    font-weight: bolder
}

</style>
<div class="row first">
  <!-- <div class="col s12"> -->
  <div class="col push-l3 l9" style="left: 333.25px;">
      <a class="btn tooltipped" data-position="bottom" data-tooltip="I am a tooltip">Hover me!</a>A Summernote wysiwyg editor version converted for Materialize<br>
    (Materialize <a href="http://materializecss.com/" target="_blank">Official website</a>)
    <h5>Added features:</h5>
    <ul>
        <li>Following toolbar</li>
        <li>global restyling</li>
    </ul>
  </div>
</div>

<div class="row">
  <div class="input-field col push-l3 l9">
    <div class="editor"><h2 id="title">The Art of War</h2>
        <p>
        If you know the enemy and know yourself, you need not fear the result of a hundred battles.<br> If you know yourself but not the enemy, for every victory gained you will also suffer a defeat.<br>
        If you know neither the enemy nor yourself, you will succumb in every battle.<br><br>

        If your enemy is secure at all points, be prepared for him. If he is in superior strength, evade him.<br>
        If your opponent is temperamental, seek to irritate him.<br>
        Pretend to be weak, that he may grow arrogant.<br>
        If he is taking his ease, give him no rest.<br>
        If his forces are united, separate them.<br>
        If sovereign and subject are in accord, put division between them. Attack him where he is unprepared, appear where you are not expected.<br><br>

        There are not more than five musical notes, yet the combinations of these five give rise to more melodies than can ever be heard.<br>
        There are not more than five primary colours, yet in combination
        they produce more hues than can ever been seen.<br>
        There are not more than five cardinal tastes, yet combinations of
        them yield more flavours than can ever be tasted.<br><br>

        There are roads which must not be followed, armies which must not be attacked, towns which must not be besieged, positions which must not be contested, commands of the sovereign which must not be obeyed.<br>
        </p>
    </div>
  </div>
</div>

<div class="row">
  <div class="col push-l3 l9">
    MaterialSummernote is a fork of Summernote wysiwyg editor<br>
    (See the <a href="http://summernote.org/#/deep-dive" target="_blank">Original API</a>)<br>
    Edited by CK<br><br>
    
    <div class="divider"></div>

    <h5>There are some extra options</h5>
    that you can pass to the constructor in materialSummernote:

    <ul>
        <li>defaultTextColor (used by "color" button to set the default text color)</li>
        <li>defaultBackColor (used by "color" button to set button's color default color)</li>
        <li>followingToolbar [default true] (makes the toolbar follow on window scroll)</li>
    </ul>

    <div class="divider"></div><br>

    MaterialSummernote is not just a conversion of Summernote from bootstrap to materialize,<br>
    it also contains some changes<br><br>

    <div class="divider"></div><br>

    It is provided with scss version of the stylesheet, if you use sass, to change style quickly<br><br>

    <div class="divider"></div><br>
    
    In this version, editor's functions that you see on this page are tested; other summernote functions such airmode, still need to be converted;
  </div>
</div>


<script>

  $(document).ready(function(){
    $('.tooltipped').tooltip();
      let toolbar = [
      ['style', ['style', 'bold', 'italic', 'underline', 'strikethrough', 'clear']],
      ['fonts', ['fontsize', 'fontname']],
      ['color', ['color']],
      ['undo', ['undo', 'redo', 'help']],
      ['ckMedia', ['ckImageUploader', 'ckVideoEmbeeder']],
      ['misc', ['link', 'picture', 'table', 'hr', 'codeview', 'fullscreen']],
      ['para', ['ul', 'ol', 'paragraph', 'leftButton', 'centerButton', 'rightButton', 'justifyButton', 'outdentButton', 'indentButton']],
      ['height', ['lineheight']],
    ];
    $('.editor').summernote({
        toolbar: toolbar,
        height: 550,
        minHeight: 100,
        defaultBackColor: '#fff'
    });

  })
</script>