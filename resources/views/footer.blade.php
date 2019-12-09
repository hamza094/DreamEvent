        </div>
               <script>
 
                   @if (session('success'))
            iziToast.success({
            message:"{{ session('success') }}"
        });      
                   
                   @endif

                  
                  
    </script>

                  <script src="https://cdn.tiny.cloud/1/dvtavx74nw7o1b3z7q3d5hi9thrc3feptxfydctl1shlggz5/tinymce/5/tinymce.min.js" ></script>
  <script>
      tinymce.init({
          selector:'#desc',
       height: 350,
             plugins: [
      'advlist autolink link image lists charmap preview hr anchor pagebreak',
      'searchreplace wordcount visualblocks visualchars code fullscreen media nonbreaking',
      'save table directionality emoticons template paste'
    ],
      });
</script>

            </body>
</html>