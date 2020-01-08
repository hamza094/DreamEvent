<template>
    <div>
        <p class="single-event_detail-heading">About this event
        <span v-if="signedIn"><a href="" class="btn header-btn float-right" @click.prevent="Follow">Follow Event</a></span> 
        </p>
    </div>
</template>


<script>
export default{
    props:['event'],
    data(){
        return{
            
        }
        
    },
    methods:{
      Follow(){
          
      },
    }
}
</script>