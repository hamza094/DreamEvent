<template>
  <div>
   <form action="">
         <div class="row">
             <div class="col-sm-6">
                 <div class="form-group">
              <input type="email" class="form-control" placeholder="Enter your email address" v-model="form.subscriber" name="subscriber" required>
          </div>
             </div>
             <div class="col-sm-6">
                            <button class="btn event-btn mb-5" @click.prevent="subscribe">Subscribe</button>

             </div>
         </div>
          

   </form>
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