<div class="order_track_page main-content">
    <section class="checkout-section ptb-30">
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-lg-12 col-md-12 col-12">
                    <button onclick="printIframe(document.getElementById('iframe'));"" class="print-button">
                        <span class="print-icon"></span>
                        </button>
    <iframe name="iframe" id="iframe" src="{{env('ADMIN_URL')}}invoice-for-mobile.php?id={{$data['id']}}&token={{$token}}" frameborder="1" width="100%" height="1000px">
</iframe>

</div>
</div>
</div>
    </section>
</div>
<script>
function printIframe(iframe) {
    const tempWindow = window.open('', 'Print', 'height=5000px,width=900px')
  
    const newIframe = document.createElement('iframe')
    newIframe.src = iframe.src
  
    newIframe.style = `border: 0; width: 1200px; height:1000px;`
    tempWindow.document.body.style = `margin: 0;`
  
    tempWindow.document.body.appendChild(newIframe)
  
    newIframe.onload = () => {
      tempWindow.print()
      tempWindow.close()
    }
  }
  </script>
