  <modal class="model-design animated slideInUp" v-cloak id="reply-modal"  name="reply{{$reply->id}}"
        height="auto"
         width="60%"
         :pivot-y="1"
         :click-to-close=false
         transition="ease"
         @closed="closed">
         <form class="reply-form" autocomplete="off" @keydown="submitted=false">
             <p><img src="https://i.ibb.co/0cdTjZ5/Capture.jpg" alt=""><span class="reply-form_heading">Reply To <span class="reply-form_heading_Event">{{$reply->user->name}}</span></span></p>
             <div class="form-group">
                 <textarea name="replybody" v-model="form.replybody" cols="30" rows="5"  required  class="form-control reply-textarea"></textarea>
             </div>
             <p class="float-right">
                 <span><button class="btn btn-danger" @click.prevent="$modal.hide('reply{{$reply->id}}')">Close</button></span>
                 <span><button class="btn btn-success" @click.prevent="discussionReplyForm" :disabled="submitted">Reply</button></span>
            </p>
         </form>
     </modal>