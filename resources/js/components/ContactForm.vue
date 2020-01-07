<template>
    <div>
        <button class="btn btn-link" @click="$modal.show('ContactForm')">Contact Event Organizer</button>
        <modal name="ContactForm"
        height="auto"
        scrollable
        :clickToClose=false>
         <form class="m-4" autocomplete="off" @keydown="submitted=false">
          <h3 class="text-center">Get In Contact With Event Organizer</h3>
           <div class="form-group">
               <label form="subject"><b>Enter Subject:</b></label>
               <input type="text" name="subject" v-model="form.subject" class="form-control" required placeholder="Subject"
               @keydown="delete errors.name">
               <span class="text-danger text-small" v-text="errors.subject[0]" v-if="errors.subject"></span>
           </div>
           <div class="form-group">
               <label for="body"><b>Enter Your Message:</b></label>
            <textarea name="body" id="" cols="30" rows="10" v-model="form.body" class="form-control" placeholder="Message Content" required @keydown="delete errors.body"></textarea>
            <span class="text-danger text-small" v-text="errors.body[0]" v-if="errors.body"></span>
           </div>
            <p class="float-right">
                 <span><button class="btn btn-danger" @click.prevent="modalHide()">Close</button></span>
                 <span><button class="btn btn-success" @click.prevent="ContactForm" :disabled="submitted">Send</button></span>
            </p>
         </form>
     </modal>
    </div>
</template>

<script>
export default{
    props:['event'],
data(){
    return{
        form:{},
        errors:{},
        submitted:false
    }
},
    methods:{
        modalHide(){
            this.$modal.hide('ContactForm');
            this.errors={};
            this.form={};
        },
        ContactForm(){
        this.$Progress.start();
        axios.post('/mail/'+this.event.slug,this.form)
                .then(response=>{
        swal.fire("Success!","Mail Sent Successfully!","success");
                this.$modal.hide('ContactForm');
                this.form="";
            this.$Progress.finish(); 
             }).catch(errors=>{
            this.errors=errors.response.data.errors;
            this.$Progress.fail(); 
            });
            this.submitted=true;
        }
    }
}
</script>