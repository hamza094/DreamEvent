<template>
    <div v-if="authorize('isAdmin')">
        This is Backend event Manage
    </div>
      <div v-else class="text-center mt-5">
       <h2 class="mt-5">Only Admin Can Access Dashboard</h2>
       <a href="/" class="btn btn-primary mt-2">Go Back</a>
   </div>
</template>


<script>
export default{
    data(){
        return{
            
        }
    },
    methods:{
    
}
}
</script>