<template>
<div>
      <div v-if="authorize('isAdmin')">
       <p class="Dashboard-heading">Purchased Ticket</p>
       <p class="Dashboard-heading">Tickets Solds:{{count}}</p>
        <p class="Dashboard-heading float-right">Ticket Delivered:{{delivered}}</p>
        <p class="Dashboard-heading">Status:{{status}}</p>
              <div class="dropdown float-right">
  <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Select Ticket Option 
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="#" @click="all">
        <span v-if="active" class="text-primary"><i class="far fa-check-circle"></i> <b>All Tickets</b></span>
    <span v-else>All Tickets</span>
    </a>
    <a class="dropdown-item" href="#" @click="deliver">
        <span v-if="deliveractive" class="text-primary"><i class="far fa-check-circle"></i> <b>Dilever Tickets</b></span>
    <span v-else>Deliver Tickets</span>
    </a>
    <a class="dropdown-item" href="#" @click="undeliver">
        <span v-if="undeliveractive" class="text-primary"><i class="far fa-check-circle"></i> <b>Undeliver Tickets</b></span>
    <span v-else>Undeliver Tickets</span></a>
  </div>
</div>
      <div class="form-group">
       <div class="col-sm-4">
     <input type="text" class="form-control" id="ticket" v-model="search" placeholder="Search Ticket By Receipt" @keyup="searchIt">
  </div>
       </div>
       <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Receipt Number</th>
       <th scope="col">Purchased By</th>
       <th scope="col">Customer Email</th>
       <th scope="col">Event name</th>
      <th scope="col">Quantity</th>
      <th scope="col">Total</th>
      <th scope="col">Purcahed Date</th>
      <th scope="col">Status</th>
      <th scope="col">Delete</th>
      
</tr>
  </thead>
  <tbody>
    <tr v-for="ticket in tickets.data"> 
    <td v-text="ticket.receipt"></td>
    <td><a v-bind:href="'profile/'+ticket.user.id" class="text-user" target="_blank">{{ticket.user.name}}</a></td>
    <td v-text="ticket.user.email"></td>
    <td><a v-bind:href="'events/'+ticket.event.slug" class="text-user" target="_blank">{{ticket.event.name}}</a></td>
    <td v-text="ticket.qty" class="text-center"></td>
    <td>${{ticket.total}}</td>
    <td>{{ticket.created_at | timeExactDate}}</td>
    <td v-if="ticket.delivered==0"><button class="btn btn-primary btn-sm" @click="deliverTicket(ticket.id)">Send</button></td>
    <td v-else><span class="btn btn-success btn-sm">Delivered</span></td>
    <td><button class="btn btn-danger btn-sm" @click="deleteTicket(ticket.id)">Delete</button></td>
    </tr>
   </tbody>
</table>
    <pagination :data="tickets" @pagination-change-page="getResults"></pagination>
</div>
   <div v-else class="text-center mt-5">
       <h2 class="mt-5">Only Admin Can Access Dashboard</h2>
       <a href="/" class="btn btn-primary mt-2">Go Back</a>
   </div>
</div>
</template>


<script>
 export default {
      data(){
          return{
              tickets:{},
              count:{},
              delivered:{},
              status:'',
              search:'',
              active:false,
              deliveractive:false,
              undeliveractive:false
              
        }
      },
        methods:{
        loadTickets(){
          axios.get('/api/tickets')
                .then(({data})=>(this.tickets=data));
            this.active=true;
            this.deliveractive=false;
            this.undeliveractive=false;
            this.status="All Tickets"
            
         },
        ticketsCount(){
            axios.get('/api/ticketscount')
               .then(({data})=>(this.count=data)); 
        },
        ticketsDelivered(){
            axios.get('/api/ticketsdelivered')
             .then(({data})=>(this.delivered=data));
        },
        all(){
         this.loadTickets();
            
     },
       deliver(){
         axios.get('/api/tickets?deliver=1')
                .then(({data})=>(this.tickets=data));
            this.active=false;
            this.deliveractive=true;
            this.undeliveractive=false;
           this.status="Delivered Tickets"
     },
             
       undeliver(){
          axios.get('/api/tickets?undeliver=1')
                .then(({data})=>(this.tickets=data));
            this.active=false;
            this.deliveractive=false;
            this.undeliveractive=true;
           this.status="Undelivered Tickets"
     },
        deleteTicket(id){
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
                 axios.delete('/api/ticket/'+id).then(function(){
                 swal.fire(
                     'Deleted!',
                     'Ticket Receipt has been deleted.',
                     'success'
                   )
                     
                }).catch(function(){
                     swal.fire("Failed!","There was something wrong.","warning");
                 });
             }
                this.loadTickets();
                this.ticketsCount();        
               })
        },
        deliverTicket(id){
                     swal.fire({
                 title: 'Are you sure?',
                 text: "You are sending tickets to customer!",
                 type: 'info',
                 showCancelButton: true,
                 confirmButtonColor: '#3085d6',
                 cancelButtonColor: '#d33',
                 confirmButtonText: 'Yes, send it!'
               }).then((result) => {
                 if (result.value) {
                 axios.post('/api/ticket/deliver/'+id).then(function(){
                 swal.fire(
                     'Sent!',
                     'Ticket has been sent successfully.',
                     'success'
                   )         
                }).catch(function(){
                     swal.fire("Failed!","There was something wrong.","warning");
                 });
             }
                this.loadTickets();
                this.ticketsDelivered();    
               })
        },
        getResults(page = 1) {
			axios.get('/api/tickets?page=' + page)
				.then(response => {
					this.tickets = response.data;
				});
		},
        searchIt:_.debounce(()=>{
          Fire.$emit('searching');  
        },325)
    },
   
     
        created(){
                   Fire.$on('searching',()=>{
            let query=this.search;
           axios.get('/api/findtickets?q='+query).
           then((data)=>{
               this.tickets=data.data
           })
                   
        });
            this.loadTickets(); 
            this.ticketsCount();
            this.ticketsDelivered();
        },
    }
</script>