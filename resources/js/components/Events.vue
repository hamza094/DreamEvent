<template>
   <div>
  <div class="form-group row">
    <div class="col-sm-4">
      <input type="text" class="form-control" id="event" v-model="search" placeholder="Search Event" @keyup="searchIt">
    </div>
  </div>
       
       
<div class="row">
    <div class="col-md-3" v-for="event in events.data" :key="event.id">
        <div class="event-panel">
            <div class="event">
                <a :href="('/events/'+event.slug)">
                    <div class="event-img">
                        <img v-bind:src="event.image_path">
                    </div>
                    <div class="event-text">
                        <div class="event-time">
                            <p><i class="far fa-clock"></i><span> {{event.strtdt}},</span><span> {{event.strttm}}</span></p>
                        </div>
                        <p class="event-name">{{event.name}}</p>
                        <p class="event-location">{{event.location}}</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
  <pagination :data="events" @pagination-change-page="getResults"></pagination>
   </div>
</template>

<script>
    export default {
      data(){
          return{
              events:{},
              search:''
        }
      },
        methods:{
         loadEvents(){
          axios.get('/api/events')
                  .then(({data})=>(this.events=data));    
         },
            getResults(page = 1) {
			axios.get('/api/events?page=' + page)
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
                Fire.$on('searching',()=>{
            let query=this.search;
           axios.get('/api/findEvents?q='+query).
           then((data)=>{
               this.events=data.data
           })
                    
        });
              this.$on('AfterEvent',()=>{
           this.loadEvents(); 
        });
        },
    }
</script>