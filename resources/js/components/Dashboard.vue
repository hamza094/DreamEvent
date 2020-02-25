<template>
   <div v-if="authorize('isAdmin')">
        <p class="Dashboard-heading">DashBoard</p>
        <div class="info">
            <div class="row">
                <div class="col-md-3 text-center col-sm-6">
                   <div class="row info-row">
                       <div class="col-sm-9 info-right">
                           <span class="info-right_name">Total</span>
                         <span class="info-right_name">Users</span>

                           <br>
                            <span class="info-right_count">{{this.usersCount}}</span>
                            <br>
                            <span class="info-right_name">This Month</span>
                           <span class="float-right"><b>{{userMonth}}</b>
                           <span class="flaot-rght ml-2 active" v-if="userRatio > 0">{{userRatio}}% <i class="fas fa-arrow-up"></i></span>
                        <span class="flaot-rght ml-2" v-if="userRatio < 0">{{userRatio}}% </span>
                          </span>
                      </div>
                     <div class="col-sm-3 info-left">
                         <i class="fas fa-users-cog cog info-left_icon"></i>
                     </div>
                   </div>
                </div>
                    <div class="col-md-3 text-center col-sm-6">
                   <div class="row info-row">
                       <div class="col-sm-9 info-right">
                        <span class="info-right_name">Total</span>
                         <span class="info-right_name">Events</span>
                           <br>
                           <span class="info-right_count">{{eventsCount}}</span>
                              <br>
                            <span class="info-right_name">This Month</span>
                           <span class="float-right"><b>{{eventsMonth}}</b>
                           <span class="flaot-rght ml-2 active" v-if="eventsRatio > 0">{{eventsRatio}}% <i class="fas fa-arrow-up"></i></span>
                        <span class="flaot-rght ml-2" v-if="eventsRatio < 0">{{eventsRatio}}% </span>
                          </span>
                        </div>
                     <div class="col-sm-3 info-left">
                         <i class="fas fa-paste globe info-left_icon"></i>
                     </div>
                   </div>
                </div>
                     <div class="col-md-3 text-center col-sm-6">
                   <div class="row info-row">
                       <div class="col-sm-9 info-right">
                           <span class="info-right_name">Topics</span>
                           <br>
                           <span class="info-right_count">{{topicsCount}}</span>
                              <br>
                            <span class="info-right_name">Subscription</span>
                            <br>
                           <span class=""><b>{{subscribeCount}}</b></span>
                        </div>
                     <div class="col-sm-3 info-left">
                         <i class="fas fa-yin-yang shake info-left_icon"></i>
                     </div>
                   </div>
                </div>
                      <div class="col-md-3 text-center col-sm-6">
                   <div class="row info-row">
                       <div class="col-sm-9 info-right">
                           <span class="info-right_name">Tickets Sold</span>
                           <br>
                           <span class="info-right_count">{{ticketsCount}}</span>
                              <br>
                            <span class="info-right_name">This Month</span>
                           <span class="float-right"><b>{{ticketsMonth}}</b>
                           <span class="flaot-rght ml-2 active" v-if="ticketsRatio > 0">{{ticketsRatio}}% <i class="fas fa-arrow-up"></i></span>
                           <span class="flaot-rght ml-2" v-if="ticketsRatio < 0">{{ticketsRatio}}% </span>
                           </span>
                   </div>
                     <div class="col-sm-3 info-left">
                         <i class="fas fa-ticket-alt other info-left_icon"></i>
                     </div>
                </div>
                </div>
            </div>
        </div>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Provident rem quasi, corporis, expedita hic perspiciatis quidem assumenda, soluta laudantium rerum quisquam dolor, illo ipsam. Nostrum iste possimus explicabo et porro soluta id saepe, dolore quam praesentium fuga eveniet molestias, eum odit totam facere, incidunt asperiores, maxime! Quaerat similique cum ea numquam, ullam, placeat veniam totam libero voluptates adipisci. Repudiandae, quae iure, officia voluptate suscipit inventore? Eveniet saepe eos in quibusdam ex eaque harum, aliquam dolorem optio ad tenetur ratione tempore explicabo nulla nihil. Iure enim error totam, sunt iste adipisci voluptatem molestiae provident animi possimus tempora esse quidem quibusdam porro corporis fuga minima neque explicabo culpa odio nobis reiciendis, tenetur tempore placeat sit! Eius enim doloribus aliquid sed odit, fugiat id quae quia iste, nisi atque incidunt! Molestiae facere cupiditate modi accusantium, officiis et odio explicabo autem, repellendus aut officia quas alias mollitia nobis quos nulla eum perspiciatis. Dignissimos distinctio nesciunt facere, eos aut maiores debitis omnis, dolorem dolor molestiae facilis iure fugit saepe dicta ex hic sint ducimus doloremque expedita dolorum reiciendis! Aliquid maiores cum fuga quisquam! Perferendis aspernatur sed eos aperiam provident natus quos eius neque quae repudiandae, a fugiat ipsum cum quo. Eaque quis temporibus reiciendis est. Asperiores tempora quam impedit delectus, ea molestias consequatur nemo consequuntur aut magni, sapiente numquam. Eos quidem dolorum, aperiam sit nesciunt voluptatem neque dolore saepe aspernatur laudantium ducimus dignissimos quae omnis ad ullam eius, tenetur cupiditate optio impedit excepturi praesentium, magni, eaque. Magni minima, velit molestias amet dolorum dolores. Maiores nobis labore qui quaerat eum quibusdam, natus officia aliquam velit aspernatur tempore accusantium laudantium impedit corporis error iure sint quo assumenda. Ab debitis cum, itaque commodi veritatis. Voluptatibus molestiae corporis impedit ullam quibusdam iure corrupti tempora maiores ut odit dolor, nisi fugiat, ad delectus placeat possimus sapiente? Saepe et, atque recusandae!</p>
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
        userRatio:0,
        usersCount:0,
        userMonth:0,
        eventsRatio:0,
        eventsCount:0,
        eventsMonth:0,
        topicsCount:0,
        subscribeCount:0,
        ticketsCount:0,
        ticketsMonth:0,
        ticketsRatio:0    
    }
    },
        methods:{
            userCount(){
                axios.get('/api/dashboard?users=true').
            then(({data})=>(this.usersCount=data));
            },
            UsersRatio(){
                axios.get('/api/dashboard?userRatio=true').
            then(({data})=>(this.userRatio=data));
            },
            UserMonth(){
                axios.get('/api/dashboard?monthUser=true').
            then(({data})=>(this.userMonth=data));
            },
            EventRatio(){
                axios.get('/api/dashboard?eventRatio=true').
            then(({data})=>(this.eventsRatio=data));
            },
            EventCount(){
                axios.get('/api/dashboard?events=true').
            then(({data})=>(this.eventsCount=data));
            },
            EventMonth(){
                    axios.get('/api/dashboard?monthEvent=true').
            then(({data})=>(this.eventsMonth=data));
            },
            TopicCount(){
                axios.get('/api/dashboard?topics=true').
            then(({data})=>(this.topicsCount=data));
            },
            SubscibeCount(){
                axios.get('/api/dashboard?subscribe=true').
            then(({data})=>(this.subscribeCount=data));
            },
            TicketCount(){
                axios.get('/api/dashboard?tickets=true').
            then(({data})=>(this.ticketsCount=data));
            },
            TicketMonth(){
                axios.get('/api/dashboard?ticketMonth=true').
            then(({data})=>(this.ticketsMonth=data));
            },
            TicketRatio(){
                axios.get('/api/dashboard?ticketRatio=true').
            then(({data})=>(this.ticketsRatio=data));
            }
            
        },
        created(){
          this.UsersRatio();
          this.UserMonth();
          this.userCount();
          this.EventRatio();
          this.EventMonth();
          this.EventCount();
          this.TopicCount();
          this.SubscibeCount();
          this.TicketCount(); 
          this.TicketMonth();
          this.TicketRatio();
        },
       
    }
</script>

