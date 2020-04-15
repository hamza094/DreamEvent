<template>
  <div class="subscribe">
  <div class="subscribe-form">
  <p class="subscribe-form_para">Subscribe Our NewsLetter!</p>
   <form action="">
         <div class="row">
             <div class="col-md-12">
                 <div class="form-group">
              <input type="email" class="form-control" placeholder="Enter your email address" v-model="form.subscriber" name="subscriber" required>
          </div>
             </div>
             <div class="col-md-12">
                <button class="btn event-btn mb-5" @click.prevent="subscribe">Subscribe</button>

             </div>
         </div>
        

   </form>
      </div>
    </div>
</template>
<script>
export default{
    data(){
        return{
            form:{},
        }
    },
    methods:{
        subscribe(){
            axios.post('/subscribe',this.form)
                .then(response=>{
        swal.fire("Success!","Your Subscribed Our Newsletter","success");
        this.form={};
        }) .catch(errors=>{
                        swal.fire(errors.response.data.errors.subscriber[0]);

    });
     }
}
}
</script>