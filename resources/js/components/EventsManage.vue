<template>
   <div v-if="authorize('isAdmin')">
       <p class="Dashboard-heading">Events</p>
       <p class="Dashboard-heading">Total Events :{{counts.length}}</p>
        <p class="Dashboard-heading">Event Status:{{this.status}}</p>
              <div class="form-group">
       <div class="col-sm-4">
      <input type="text" class="form-control" id="event" v-model="search" placeholder="Search Event" @keyup="searchIt">
    </div>
      <div class="dropdown float-right">
  <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Select Event Option 
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="#" @click="all">
        <span v-if="active" class="text-primary"><i class="far fa-check-circle"></i> <b>All Events</b></span>
    <span v-else>All Events</span>
    </a>
    <a class="dropdown-item" href="#" @click="live">
        <span v-if="liveactive" class="text-primary"><i class="far fa-check-circle"></i> <b>Live Events</b></span>
    <span v-else>Live Events</span>
    </a>
    <a class="dropdown-item" href="#" @click="drafted">
        <span v-if="draftedactive" class="text-primary"><i class="far fa-check-circle"></i> <b>Drafted Events</b></span>
    <span v-else>Drafted Events</span></a>
  </div>
</div>
       </div>
       <div class="table-responsive">
       <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Event Name</th>
       <th scope="col">Start Date</th>
       <th scope="col">Status</th>
       <th scope="col">Price</th>
       <th scope="col">Ticket Sold</th>
      <th scope="col">Tickets Left</th>
      <th scope="col">Current Status</th>
      <th scope="col">Created By</th>
      <th scope="col">Option</th>
      
</tr>
  </thead>
  <tbody>
    <tr  v-for="event in events.data" :key="event.id">
        <td><a v-bind:href="'events/'+event.slug" class="text-user" target="_blank">{{event.name}}</a></td>
        <td>{{event.strtdt | timeDate}}</td>
        <td v-if="todaydate > event.enddt"><span class="text-danger"><b>Event Over</b></span></td>
        <td v-else><span class="text-primary"><b>Event Open</b></span></td>
        <td>{{event.price}}</td>
        <td>{{event.sold}}</td>
        <td>{{event.qty}}</td>
        <td v-if="event.deleted_at==null"><span class="active"><b>Active</b></span></td>
        <td v-else><span class="text-warning"><b>Drafted</b></span></td>
        <td><a v-bind:href="'profile/'+event.user_id" class="text-user" target="_blank">{{event.user.name}}</a></td>
        <td v-if="event.deleted_at==null">
        <p>
            <button class="btn btn-sm btn-primary" @click="draft(event.slug)">Draft</button><button class="btn btn-sm btn-danger" @click="destroy(event.slug)">Delete</button></p></td>
        <td v-else><p>
            <button class="btn btn-success btn-sm" @click="UnDraft(event.slug)">Live</button>
            <button class="btn btn-danger btn-sm" @click="draftdelete(event.slug)">Delete</button>
            </p>
            </td>
    </tr>
   </tbody>
</table>
    </div>
    <pagination :data="events" @pagination-change-page="getResults"></pagination>
</div>
   <div v-else class="text-center mt-5">
       <h2 class="mt-5">Only Admin Can Access Dashboard</h2>
       <a href="/" class="btn btn-primary mt-2">Go Back</a>
   </div>
</template>

<script>
    export default {
      data(){
          return{
              events:{},
              counts:{},
              search:'',
              todaydate:'',
              status:'all',
              active:false,
              liveactive:false,
              draftedactive:false
        }
      },
        methods:{
         loadEvents(){
          axios.get('/api/allevents')
                  .then(({data})=>(this.events=data)); 
                this.status='All Events';
                this.active=true;
                this.draftedactive=false;
                this.liveactive=false;
                this.search=''
         },
            loadCount(){
                 axios.get('/api/eventscount')
                  .then(({data})=>(this.counts=data));
            },
            drafted(){
                axios.get('/api/allevents?drafted=1')
                  .then(({data})=>(this.events=data)); 
                this.status='Drafted Events';
                this.draftedactive=true;
                this.liveactive=false;
                this.active=false;
                this.search=''

            },
            all(){
                this.loadEvents();
                
            },
            live(){
                 axios.get('/api/allevents?live=1')
                  .then(({data})=>(this.events=data));
                this.status='Live Events';
                 this.active=false;
                this.draftedactive=false;
                this.liveactive=true;
                this.search=''

            },
            destroy(slug){
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
                    
                }).catch(function(){
                     swal.fire("Failed!","There was something wrong.","warning");
                 });
             } 
            this.$emit('AfterComplete'); 

               })
            },
            draftdelete(slug){
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
                
                }).catch(function(){
                     swal.fire("Failed!","There was something wrong.","warning");
                 });
             } 
            this.$emit('AfterCompleteDraft');

               })
            },
            draft(slug){
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

                }).catch(function(){
                     swal.fire("Failed!","There was something wrong.","warning");
                 });
             } 
            this.$emit('AfterCompleteDraft');

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
                 confirmButtonText: 'Yes, Make It Live!'
               }).then((result) => {
                 if (result.value) {
                 axios.get('/events/'+slug+'/undrafted').then(function(){
                 swal.fire(
                     'Undrafted!',
                     'Event has been live.',
                     'success'
                   ) 

                }).catch(function(){
                     swal.fire("Failed!","There was something wrong.","warning");
                 });
             } 
            this.$emit('AfterComplete');

               })
            },
                     getResults(page = 1) {
			axios.get('/api/allevents?page=' + page)
				.then(response => {
					this.events = response.data;
				});
		},
            searchIt:_.debounce(()=>{
          Fire.$emit('searching');  
        },325)
        
        },
        created(){
            this.loadEvents(); 
            this.loadCount();
              Fire.$on('searching',()=>{
            let query=this.search;
           axios.get('/api/findAllEvents?q='+query).
           then((data)=>{
               this.events=data.data
           })
                   
        });
               this.$on('AfterComplete',()=>{
           this.loadEvents(); 
            this.loadCount();
        });
           this.$on('AfterCompleteDraft',()=>{
           this.loadEvents(); 
            this.drafted();
        });
          },
        mounted(){
        this.todaydate= new Date().toJSON().slice(0,10).replace(/-/g,'-');

        }
    }
</script>