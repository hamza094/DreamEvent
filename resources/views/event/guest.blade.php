     <modal v-cloak  name="guestModal"
        height="auto"
        :pivot-x="1"
        scrollable>
        <button class="btn btn-lg btn-link float-right" @click="$modal.hide('guestModal')">x</button>
        <h3 class="text-center mt-2">Participating Event Guests</h3>
        @if($guests->count()>0)
         <p class="small text-center"><b>{{$guests->count()}} guests are going to attend this event</b></p>
        <div class="row">
        @foreach($guests as $guest)
        <div class="col-md-3 text-center">
         <div class="guest">
        <a href="/profile/{{$guest->id}}" target="_blank">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcREMyvRO0cuDTlEXwAwDVQE3szE6ezl7USqNL_n9D_5w8zRCGtk" alt="">
        <p><b>{{$guest->name}}</b></p>
        </a>
    </div>
 </div>
 @endforeach
</div>  
   @else
   <h3 class="text-center mt-5 mb-3">
       No Event Participating guest yet 
   </h3>  
   @endif                      
    </modal>