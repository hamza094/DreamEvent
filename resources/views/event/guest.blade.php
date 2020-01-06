     <modal v-cloak  name="guestModal"
        height="auto"
        :pivot-x="1"
        scrollable>
        <button class="btn btn-lg btn-link float-right" @click="$modal.hide('guestModal')">x</button>
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
    </modal>