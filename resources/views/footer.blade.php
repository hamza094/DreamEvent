        </div>
      
          
             <script src="{{ asset('js/app.js') }}" defer></script>
                             <script src="{{asset('js/iziToast.min.js')}}" type="text/javascript"></script>
                             
    <script>
    @if(Session::has('success'))
        iziToast.success({
        message:"{{Session::get('success')}}"
    });  
    @endif                                   
    </script>
    

            </body>
</html>