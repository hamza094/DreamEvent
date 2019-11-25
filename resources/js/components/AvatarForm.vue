<template>
      <div class="user-profile_img">
                   <img :src="avatar" alt="">
                   <form v-if="canUpdate" method="POST" enctype="multipart/form-data" >
                     <div class="fileUpload btn btn-avatar file">
                     <label class="upload" >
                    <input name='avatar' type="file" accept="image/*" @change="onChange">
                         <i class="fas fa-camera"></i> Update Image
                         </label>
                  </div>
                   </form>
                    </div>
</template>
<script>
export default{
    props:['user'],
    data(){
        return{
        avatar:this.user.avatar_path
    };
    },
    computed:{
        canUpdate(){
           return this.authorize(user=>user.id === this.user.id)
        }
    },
    methods:{
        onChange(e){
             if(! e.target.files.length) return;
                let file=e.target.files[0];
                let reader=new FileReader();
                reader.readAsDataURL(file);
                reader.onload=e=>{
                    this.avatar=e.target.result;  
                };
            this.presist(file);
                
        },
        presist(file){
            let data=new FormData();
                data.append('avatar',file);
                axios.post('/api/profile/$(this.user.id)/avatar',data);
                
        }
    }
}
</script>
