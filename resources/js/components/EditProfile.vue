<template>
    <div>
<modal name="EditProfile" height="auto" :scrollable="true">
      <div class="container mt-4">
          <h4 class="text-center">Edit Your Profile</h4>
           <form action="" @submit.prevent="Update">
                <div class="form-group">
                    <label for="name" class="model-text"><b>Name:</b></label>
                       <input type="text" class="form-control model-input" name="name" placeholder="" v-model="form.name" required>
                       <span class="text-danger" v-if="errors.name" v-text="errors.name[0]"></span>
                   </div>
                    <div class="form-group">
                        <label for="email" class="model-text"><b>Email:</b></label>
                       <input type="email" class="form-control model-input" name="email" v-model="form.email" required>
                       <span class="text-danger" v-if="errors.email" v-text="errors.email[0]"></span>
                   </div>
                    <div class="form-group">
                        <label for="password" class="model-text"><b>Password:</b></label>
                       <input type="password" class="form-control model-input" name="title" v-model="form.password">
                       <span class="text-danger" v-if="errors.password" v-text="errors.password[0]"></span>
                   </div>
                    <div class="form-group">
                        <label for="profession" class="model-text"><b>Profession:</b></label>
                       <input type="text" class="form-control model-input" name="prof" v-model="form.prof" placeholder="What You Do...">
                        <span class="text-danger" v-if="errors.prof" v-text="errors.prof[0]"></span>
                    </div>
                   <div class="form-group">
                       <label for="about" class="model-text"><b>About:</b></label>
                       <textarea name="about" id="" cols="30" rows="4"  class="form-control model-input" v-model="form.about" placeholder="Tell Something About YourSelf..."> 
                           </textarea>
                           <span class="text-danger" v-if="errors.about" v-text="errors.about[0]"></span>
                   </div>
                   <div class="form-group">
                        <label for="backimg" class="model-text"><b>Backgroung Image:</b></label>
                       <input type="text" class="form-control model-input" name="backimg" v-model="form.backimg" placeholder="Add Your Backgroung Url Here">
                       <span class="text-danger" v-if="errors.backimg" v-text="errors.backimg[0]"></span>
                   </div>
                   <div class="float-right mt-5 mb-5">
                       <button class="btn btn-success">Update Profile</button>
                       <button class="btn btn-primary" type="button" @click.prevent="$modal.hide('EditProfile')">Cancel</button>
                   </div>
           </form>
    </div>
  </modal>
    </div>
</template>


<script>
export default{
 props:['user'],
    data(){
     return{
     form:{
         name:this.user.name,
         email:this.user.email,
         password:this.user.password,
         prof:this.user.prof,
         about:this.user.about,
         backimg:this.user.backimg
     },
         errors:{}
   
    };    
    },
    methods:{
     Update(){
          axios.patch('/profile/'+this.user.id,{
                  name:this.form.name,
                  email:this.form.email,
                  password:this.form.password,
                  prof:this.form.prof,
                  about:this.form.about,
                  backimg:this.form.backimg 
                })
            .then(response=>{
                location.reload();
  
            }).catch(error=>{
              this.errors=error.response.data.errors
            });

     }
    }
   
}
</script>