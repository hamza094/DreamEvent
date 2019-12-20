<template>
 <div>
     <a class="btn event-btn"
     @click="$modal.show('reply-modal')">Add Reply</a>
     <modal class="model-design animated slideInUp" :class="{'SlideInDown':!isRed}" name="reply-modal"
        height="auto"
         width="60%"
         :pivotY="1"
         :clickToClose=false
         transition="ease"
         @closed="closed">
         <form class="reply-form" autocomplete="off"
            @keydown="submitted=false">
             <p><img src="https://i.ibb.co/0cdTjZ5/Capture.jpg" alt=""><span class="reply-form_heading">Reply To <span class="reply-form_heading_Event">Event</span></span></p>
             <div class="form-group">
                 <textarea name="body" id="" cols="30" rows="5" required v-model="form.body" class="form-control reply-textarea"
                     
                 ></textarea>
             </div>
             <p class="float-right">
                 <span><button class="btn btn-danger" @click.prevent="modalHide()">Close</button></span>
                 <span><button class="btn btn-success" @click.prevent="replyForm" :disabled="submitted">Submit</button></span>
            </p>
         </form>
     </modal>
 </div>
</template>
<script>
export default {
    props:['event'],
    data() {
        
  return {
   isRed:true,
      form:{},
      errors:{},
      submitted:false
  };
},
methods: {
modalHide(){
    this.isRed = false;
    this.submitted=false;
    this.$modal.hide('reply-modal');
    this.form={}
},
      closed (event) {
      
      // Set the opening time of the modal
      this.isRed = false;
    },
    replyForm(){
    this.submitted=true;
        axios.post('/events/'+ this.event.slug+'/replies',this.form)
        .then(response=>{
        swal.fire("Success!","Your reply added to discussion","success");
                location=response.data.message;
                this.$modal.hide('reply-modal');
            })
            .catch(errors=>{
        this.errors=errors.response.data;
            console.log(errors.response.data);
            if(errors.response.data=="You are posting too frequently."){
                swal.fire('You are posting too frequently');
                
            }
            else if(errors.response.data.errors.body[0]=='The body field is required.'){
                swal.fire('The body field is required.');
                console.log(errors.response.data.errors.body[0]);
            }else if(errors.response.data.errors.body[0]=='validation.spamerror'){
                swal.fire('The reply contains spam');
            }else if(errors.response.data){
                 swal.fire('Sorry!Please Try Again');
            }
        });
        
    }
}
}

</script>