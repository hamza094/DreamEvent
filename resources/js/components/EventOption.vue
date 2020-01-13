<template>
    <div>
    <span><a class="btn btn-link" v-bind:href="'/events/'+event.slug+'/edit'">Edit</a></span>
    <span v-if="event.deleted_at!=null"><a href="" class="btn btn-link" @click.prevent="UnDraft(event.slug)">Undraft</a></span>
    <span v-else><a href="" class="btn btn-link" @click.prevent="Draft(event.slug)">Draft</a></span>
    <span v-if="event.deleted_at!=null"><a class="btn btn-link" @click.prevent="DraftDelete(event.slug)">Delete</a></span> 
    <span v-else><a class="btn btn-link" @click.prevent="Delete(event.slug)">Delete</a></span> </div>
</template>
<script>
export default{
    props:['event'],
    data(){
        return{
            
        }
    },
    methods:{
        Delete(slug){
              swal.fire({
                 title: 'Are you sure?',
                 text: "You won't be able to revert this!",
                 type: 'warning',
                 showCancelButton: true,
                 confirmButtonColor: '#3085d6',
                 cancelButtonColor: '#d33',
                 confirmButtonText: 'Yes, delete it!'
               }).then((result) => {
                 if (result.value) {
                 axios.get('/events/'+slug+'/delete').then(function(){
                 swal.fire(
                     'Deleted!',
                     'Event has been deleted.',
                     'success'
                   ) 
                    window.location.reload();

                }).catch(function(){
                     swal.fire("Failed!","There was something wrong.","warning");
                 });
             } 

               })
            
         },
           Draft(slug){
              swal.fire({
                 title: 'Are you sure?',
                 text: "You won't see this event live!",
                 type: 'warning',
                 showCancelButton: true,
                 confirmButtonColor: '#3085d6',
                 cancelButtonColor: '#d33',
                 confirmButtonText: 'Yes, draft it!'
               }).then((result) => {
                 if (result.value) {
                 axios.delete('/events/'+slug).then(function(){
                 swal.fire(
                     'Drafted!',
                     'Event has been drafted.',
                     'success'
                   ) 
                    window.location.reload();

                }).catch(function(){
                     swal.fire("Failed!","There was something wrong.","warning");
                 });
             } 

               })
            
         },
        DraftDelete(slug){
               swal.fire({
                 title: 'Are you sure?',
                 text: "You won't be able to revert this!",
                 type: 'warning',
                 showCancelButton: true,
                 confirmButtonColor: '#3085d6',
                 cancelButtonColor: '#d33',
                 confirmButtonText: 'Yes, delete it!'
               }).then((result) => {
                 if (result.value) {
                 axios.get('/events/'+slug+'/draftdelete').then(function(){
                 swal.fire(
                     'Deleted!',
                     'Event has been deleted.',
                     'success'
                   ) 
                    window.location.reload();

                }).catch(function(){
                     swal.fire("Failed!","There was something wrong.","warning");
                 });
             } 

               })
        },
        UnDraft(slug){
                 swal.fire({
                 title: 'Are you sure?',
                 text: "You re going to make this event live!",
                 type: 'info',
                 showCancelButton: true,
                 confirmButtonColor: '#3085d6',
                 cancelButtonColor: '#d33',
                 confirmButtonText: 'Yes, Undraft it!'
               }).then((result) => {
                 if (result.value) {
                 axios.get('/events/'+slug+'/undrafted').then(function(){
                 swal.fire(
                     'Undrafted!',
                     'Event has been live.',
                     'success'
                   ) 
                    window.location.href="/myevents";

                }).catch(function(){
                     swal.fire("Failed!","There was something wrong.","warning");
                 });
             } 

               })
        }
    }
}


</script>
















