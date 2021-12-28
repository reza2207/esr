<!-- loader -->
    <div class="waiting">
      <div class="warning-alert">
        <div class="loader">
          <div class="preloader-wrapper big active">
            <div class="spinner-layer spinner-blue">
              <div class="circle-clipper left">
                <div class="circle"></div>
              </div>
              <div class="gap-patch">
                <div class="circle"></div>
              </div>
              <div class="circle-clipper right">
                <div class="circle"></div>
              </div>
            </div>

            <div class="spinner-layer spinner-red">
              <div class="circle-clipper left">
                <div class="circle"></div>
              </div>
              <div class="gap-patch">
                <div class="circle"></div>
              </div>
              <div class="circle-clipper right">
                <div class="circle"></div>
              </div>
            </div>

            <div class="spinner-layer spinner-yellow">
              <div class="circle-clipper left">
                <div class="circle"></div>
              </div>
              <div class="gap-patch">
                <div class="circle"></div>
              </div>
              <div class="circle-clipper right">
                <div class="circle"></div>
              </div>
            </div>

            <div class="spinner-layer spinner-green">
              <div class="circle-clipper left">
                <div class="circle"></div>
              </div>
              <div class="gap-patch">
                <div class="circle"></div>
              </div>
              <div class="circle-clipper right">
                <div class="circle"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="warning-text">Please Wait...<i class='fa fa-smile-o'></i></div>
      </div>
    </div>
  
    <div class="row first white-text">
      <div class="col s12 offset-l2 l10">
        <div class="row">
          <div class="col l4 s12">
            <div class="card hoverable animate__animated animate__zoomIn">
              <div class="card-image waves-effect waves-block waves-orange orange darken-4" style="height: 250px">
                <div class="white-text" style="text-align: center;padding-top: 10px;font-size: 2em"><a href="<?= base_url().'persekot';?>" class="white-text">PERSEKOT</a></div>
                <div style="text-align: center" class="white-text activator"><i class="fa fa-money" style="font-size: 6em;padding-top: 20px"></i></div>
                <div style="text-align: center;padding-top: 20px" class="white-text activator"><span class="badge white" style="float: none;"><?= $reminder;?></span> Persekot yang akan jatuh tempo <br> <span class="badge white" style="float: none;"><?= $exp;?></span> Persekot yang belum selesai</div>
              </div>
              <div class="card-reveal black">
                
                <span class="card-title darken-4-text text-darken-4" style="font-size: 12px;font-weight: bolder"><span class="badge white" style="float: none;"><?= $reminder;?></span> Persekot yang akan jatuh tempo <br> <span class="badge white" style="float: none;"><?= $exp;?></span> Persekot yang belum selesai</span>
                
                
              </div>
            </div>
          </div>
          <div class="col l4 s12">
            <div class="card hoverable animate__animated animate__zoomIn">
              <a href="<?= base_url().'berkas';?>" class="white-text">
                <div class="card-image waves-effect waves-block waves-orange orange darken-4" style="height: 250px">
                  <div class="white-text" style="text-align: center;padding-top: 10px;font-size: 2em">Berkas</div>
                  <div style="text-align: center" class="white-text activator"><i class="fa fa-file" style="font-size: 6em;padding-top: 20px"></i></div>
                  
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
        

  <!-- page end layout -->

    <!-- end -->
<script>
  $(document).ready(function(){
      $('.slider').slider();
      $('.carousel').carousel();
      $('.select-m').formSelect();
      
    
    setTimeout(loader, 1000);
    

  });

  $('#thn').on('change', function(e){
    let thn = this.value;
    chart(thn);
  })
  function loader(){
    $('.waiting').hide();
  }

  
</script>