        </div>
<footer>
    <div class="container-fluid">
        <div class="row">
           <div class="footer">
              <div class="footer-content">
                 <p class="footer-content_para">
                   "DreamEvent is a Laravel Vue.js based Event Application built for portfolio purpose you can find its source code on <a href="https://github.com/hamza094/Dream" target="_blank">GitHub</a> repository built by <a href="https://hikportfolio.herokuapp.com/" target="_blank">Hamza Ikram</a> &copy; 2020 All Right Reserved!"
               </p>
               <div class="footer-content_contact">
                   <p class="footer-content_contact-para">Get In Contact</p>
                   <ul>
                    <li><a href="https://www.facebook.com/hamza.ikram.986" target="_blank"><i class="fab fa-facebook"></i></a></li>
                    <li><a href="https://github.com/hamza094" target="_blank"><i class="fab fa-github"></i></a></li>
                    <li><a href="https://www.linkedin.com/in/hamzaik/" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                    <li><a href="mailto:hamza_pisces@live.com"><i class="far fa-paper-plane"></i></a>></li>
                   </ul>
               </div>  
              </div>
          </div>
    </div>
    </div>
</footer>
            
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