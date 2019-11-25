<template>
   <div>
       <p class="Dashboard-heading">Users</p>
  <div class="form-group row">
    <div class="col-sm-4">
      <input type="text" class="form-control" id="user" v-model="search" placeholder="Search User" @keyup="searchIt">
    </div>
  </div>
       
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
        <td><a v-bind:href="'profile/'+user.id" class="text-user">{{user.name}}</a></td>
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
              users:{},
              search:''
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
                this.$emit('AfterUser');
               })
        },
        searchIt:_.debounce(()=>{
          Fire.$emit('searching');  
        },325)
            
        },
        created(){
            this.loadUsers(); 
                Fire.$on('searching',()=>{
            let query=this.search;
           axios.get('/api/findUsers?q='+query).
           then((data)=>{
               this.users=data.data
           })
                    
        });
              this.$on('AfterUser',()=>{
           this.loadUsers(); 
        });
        },
    }
</script>