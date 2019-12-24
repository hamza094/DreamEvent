     <modal class="model-design animated slideInUp" v-cloak id="reply-modal"  name="{{$reply->id}}"
        height="auto"
         width="60%"
         :pivot-y="1"
         :click-to-close=false
         transition="ease"
         @closed="closed">
         <form class="reply-form" autocomplete="off" @keydown="submitted=false">
             <p><img src="https://i.ibb.co/0cdTjZ5/Capture.jpg" alt=""><span class="reply-form_heading">Reply To <span class="reply-form_heading_Event">Event</span></span></p>
             <div class="form-group">
                 <textarea name="body" id="{{$reply->id}}" v-model="body" cols="30" rows="5"  required  class="form-control reply-textarea"></textarea>
             </div>
             <p class="float-right">
                 <span><button class="btn btn-danger" @click.prevent="modalHide()">Close</button></span>
                 <span><button class="btn btn-success" @click.prevent="replyForm" :disabled="submitted">Update</button></span>
            </p>
         </form>
     </modal>