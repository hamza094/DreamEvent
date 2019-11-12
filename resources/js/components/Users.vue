<template>
   <div>
       <p class="Dashboard-heading">Users</p>
       <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">SrNo</th>
      <th scope="col">Name</th>
      <th scope="col">Created At</th>
      <th scope="col">Created By</th>
      <th scope="col">Associated Events</th>
      <th scope="col">Option</th>
    </tr>
  </thead>
  <tbody>
    <tr  v-for="user in users.data" :key="user.id">
      <td><b>{{user.id}}</b></td>
      <td>{{user.name}}</td>
      <td>{{user.created_at}}</td>
      <td>admin</td>
      <td>2</td>
      <td>
      <button class="btn btn-sm btn-danger" @click="deleteUser(user.id)">Delete</button>
      </td>
    </tr>
   </tbody>
</table>
   </div>
</template>

<script>
    export default {
      data(){
          return{
              users:{}
        }
      },
        methods:{
         loadUsers(){
          axios.get('/api/users')
                  .then(({data})=>(this.users=data));    
         },
        deleteUser(id){
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
                 axios.delete('/api/users/'+id).then(function(){
                 swal.fire(
                     'Deleted!',
                     'Topic has been deleted.',
                     'success'
                   )
                     
                }).catch(function(){
                     swal.fire("Failed!","There was something wrong.","warning");
                 });
             }
                this.loadUsers();
               })
        }
            
        },
        created(){
          this.loadUsers();
        },
    }
</script>