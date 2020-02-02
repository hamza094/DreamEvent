<template>
   <div>
       <p class="Dashboard-heading">Topics<button class="btn btn-light ml-2 btn-sm" @click="newModal"> +</button></p>
       <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">SrNo</th>
      <th scope="col">Name</th>
      <th scope="col">Created At</th>
      <th scope="col">Created By</th>
      <th scope="col">Related Events</th>
      <th scope="col">Option</th>
      
    </tr>
  </thead>
  <tbody>
    <tr  v-for="topic in topics" :key="topic.id">
      <td><b>{{topic.id}}</b></td>
    <td><a v-bind:href="'topic/'+topic.slug" class="text-user" target="_blank">{{topic.name}}</a></td>
      <td>{{topic.created_at | timeDate}}</td>
      <td>{{topic.created_by}}</td>
      <td>{{topic.events_count}}</td>
      <td>
      <button class="btn btn-sm btn-primary" @click="editModal(topic)">Edit</button>
      <button class="btn btn-sm btn-danger" @click="destroy(topic.id)">Delete</button>
      </td>
    </tr>
   </tbody>
</table>
  <div class="modal fade" id="AddTopics" tabindex="-1" role="dialog" aria-labelledby="AddTopicLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="AddTopic" v-show=!editing>Create New Topic</h5>
        <h5 class="modal-title" id="AddTopic" v-show=editing>Update Topic</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form  @submit.prevent="editing ? updateTopic() : createTopic()">
      <div class="modal-body">
        <div class="form-group">
           <label for="name">Name:</label>
            <input type="text" v-model="form.name" name="name" class="form-control"
             :class="{ 'is-invalid': form.errors.has('name') }">
      <has-error :form="form" field="name"></has-error>
        </div>
        
          <div class="form-group">
           <label for="image">Image:</label>
            <input type="text" v-model="form.image" name="image" class="form-control"
             :class="{ 'is-invalid': form.errors.has('image') }">
      <has-error :form="form" field="image"></has-error>
        </div>
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" v-show=!editing>Create</button>
        <button type="submit" class="btn btn-primary" v-show=editing>Update</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
        </form>
    </div>
  </div>
</div>
   </div>
</template>

<script>
    export default {
      data(){
          return{
              editing:false,
              topics:{},
              form:new Form({
                  id:'',
                  name:'',
                  'image':''
              }) 
              
          }
      },
        methods:{
            loadTopics(){
              axios.get('/api/topics')
                  .then(({data})=>(this.topics=data));  
            },
            newModal(){
                this.editing=false;
                $('#AddTopics').modal('show');
                this.form.reset();
            },
            editModal(topic){
                this.editing=true;
                $('#AddTopics').modal('show');
                this.form.fill(topic);
            },
            createTopic(){
                   this.form.post('/api/topics')
                .catch(error=>{
                toast.fire({
                icon: 'error',
                 title: 'Error! Try Again'
            }) 
            }).then(({data})=>{
                this.$emit('AfterCreate');
                $('#AddTopics').modal('hide');
                           toast.fire({
                  icon: 'success',
                 title: 'Topic Created Successfully'
            })         
            });
            },
            updateTopic(id){
                        this.form.patch('/api/topics/'+this.form.id)
                .catch(error=>{
                 swal.fire(
            'Error!',
            'Please Try Again.',
            'error'
            )  
            }).then(({data})=>{
            swal.fire(
            'Updated!',
            'Topic Updated Successfully.',
            'success'
            )            
                this.$emit('AfterCreate');
                $('#AddTopics').modal('hide');
              });
            },
            destroy(id){
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
                 this.form.delete('/api/topics/'+id).then(function(){
                 swal.fire(
                     'Deleted!',
                     'Topic has been deleted.',
                     'success'
                   )
                     
                }).catch(function(){
                     swal.fire("Failed!","There was something wrong.","warning");
                 });
             }
                this.$emit('AfterCreate'); 
               })
            }
            
        },
        created(){
            this.loadTopics();
            this.$on('AfterCreate',()=>{
           this.loadTopics(); 
        });
        },
    }
</script>