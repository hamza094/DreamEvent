<template>
               <div>
               
      <p>
      <a :href="('/profile/'+user.id)">
      <img :src="user.avatar_path" alt="">
      {{user.name}}</a>
      </p>
              <span v-if="editing">
                  <textarea class="form-control mt-3" v-model="replybody"></textarea>
                  <button class="btn btn-link btn-sm" @click="update">Update</button><button class="btn btn-link btn-sm" @click="editing = false">Close</button>
              </span>
    <span v-else class="discussion-replies_body" v-text="replybody"></span>
    <span v-if="authorize('updateDiscussionReply',reply)">
       <br>
          <button class="btn btn-primary btn-sm" @click="editing = true"><i class="far fa-edit"></i></button>
           <button class="btn btn-danger btn-sm" @click.prevent="destroy"><i class="far fa-trash-alt"></i></button>
        </span>   
        </div>
</template>

<script>
export default{
    props:['reply','user'],
    data(){
        return{
            editing: false,
            replybody:this.reply.replybody
        };
    },
    methods:{
        update(){
        axios.patch('/discussionreply/'+this.reply.id,{
       replybody:this.replybody}).
        then(response=>{
        swal.fire("Success!","You successfully Updated discussion reply","success");
            this.editing=false;
            }).catch(errors=>{
            console.log(errors.response.data);
              swal.fire('Error! Please Try Again');
            this.replybody=this.reply.replybody;
            }); 
        },
            destroy(){
        axios.delete('/discussionreply/'+this.reply.id,{
    }).then(response=>{
        swal.fire("Success!","Your discussion reply deleted successfully","success");
        window.location.reload();
    }).catch(errors=>{
         swal.fire("Warning!","There is an error please try again","warning");
       });
    }
    }
  
}
</script>