<template>
    <div>
        <p class="single-event_detail-heading">About this event
        <span v-if="signedIn">
        <button  v-if="this.button.active" class="btn follow-btn float-right" @click.prevent="UnFollow">UnFollow Event</button>
        <button  v-else class="btn header-btn float-right" @click.prevent="Follow">Follow Event</button>

       </span> 
        </p>
    </div>
</template>


<script>
export default{
    props:['active'],
    data(){
        return{
             button: {
      active: this.active
    }
        }
    },
    methods:{
      Follow(){
        axios.post(location.pathname+'/follow').
        then(response=>{
          this.button.active=true;
          swal.fire("Success!","Your Are Following The Event","success");
         }).catch(errors=>{
            swal.fire("Warning!","Error! Please Try Again ","warning");
        });
      },
        UnFollow(){
        axios.delete(location.pathname+'/follow').
            then(response=>{
          this.button.active=false;
          swal.fire("Info!","Your UnFollowed The Event","info");
         }).catch(errors=>{
            swal.fire("Warning!","Error! Please Try Again ","warning");
        });
      },
    
    }
}
</script>