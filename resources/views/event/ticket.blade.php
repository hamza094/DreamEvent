   <modal class="model-design animated" v-cloak  name="ticketModal"
        height="auto"
         width="60%"
         :click-to-close=false
         transition="ease">
         <div class="row">
             <div class="col-md-7">
                      <form class="reply-form" autocomplete="off">
            <h5>{{$event->name}}</h5>
            <p><b>Event Price:${{$event->price}}</b></p>
            <p>
            <button class="btn btn-primary btn-sm" @click.prevent="decr">-</button>
            <input type="text" name="price" v-model="selectedqty" readonly="readonly" class="text-center ticket-input">
            <button class="btn btn-primary btn-sm" @click.prevent="incr">+</button>
            </p>
             <p><b>Quantity Left: <span v-text="qty"></span></b></p>
             <p><b>Total Price: $<span v-text="selectedprice"></span></b></p>
             <div class="form-group">
             
             </div>
          </form>
             </div>
             <div class="col-md-5">
               <h4 class="mt-5">Choose Payment Method</h4>
             </div>
         
         </div>
            <p class="float-right mr-4">
            <span><button class="btn btn-danger" @click.prevent="$modal.hide('ticketModal')">Close</button></span>
            <span><button class="btn btn-success">Checkout</button></span>
            </p>
     </modal>