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
                        <span class="flaot-rght ml-2 shake" v-if="userRatio < 0">{{userRatio}}% <i class="fas fa-arrow-down"></i></span>
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
                        <span class="flaot-rght ml-2 shake" v-if="eventsRatio < 0">{{eventsRatio}}% <i class="fas fa-arrow-down"></i></span>
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
                           <span class="info-right_name">Tickets Sold</span>
                           <br>
                           <span class="info-right_count">{{ticketsCount}}</span>
                              <br>
                            <span class="info-right_name">This Month</span>
                           <span class="float-right"><b>{{ticketsMonth}}</b>
                           <span class="flaot-rght ml-2 active" v-if="ticketsRatio > 0">{{ticketsRatio}}% <i class="fas fa-arrow-up"></i></span>
                           <span class="flaot-rght ml-2 shake" v-if="ticketsRatio < 0">{{ticketsRatio}}% <i class="fas fa-arrow-down"></i></span>
                           </span>
                   </div>
                     <div class="col-sm-3 info-left">
                         <i class="fas fa-ticket-alt other info-left_icon"></i>
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
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12 col-lg-6">
           <div v-if="ticketChart">
            <span class="float-right">
            <button class="btn btn-primary btn-sm" disabled>Month</button>
            <button class="btn-primary btn btn-sm" @click="ticketChart=false">Year</button>
            </span>
            <div class="float-left">
             <MonthChart/>
               </div>
           </div>
                <div v-else>
            <span class="float-right">
            <button class="btn btn-primary btn-sm" @click="ticketChart=true">Month</button>
            <button class="btn-primary btn btn-sm"disabled>Year</button>
            </span>
                <div class="float-left">
               <YearChart/>
                </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6">
            <div v-if="salesChart">
             <span class="float-right">
            <button class="btn btn-primary btn-sm" disabled>Month</button>
            <button class="btn-primary btn btn-sm" @click="salesChart=false">Year</button>
            </span>
            <div class="float-left">
             <MonthSaleChart/>
            </div>
           </div>
                <div v-else>
            <span class="float-right">
            <button class="btn btn-primary btn-sm" @click="salesChart=true">Month</button>
            <button class="btn-primary btn btn-sm"disabled>Year</button>
            </span>
                <div class="float-left">
               <YearSaleChart/>
                </div>
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <ActivityFeed/>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12 mt-4">
                <p class="dashboard-para">
                   "DreamEvent is a Laravel Vue.js based Event Application built for portfolio purpose you can find its source code on <a href="https://github.com/hamza094/Dream" target="_blank">GitHub</a> repository built by <a href="https://hikportfolio.herokuapp.com/" target="_blank">Hamza Ikram</a> &copy; 2020 All Right Reserved!"
               </p>
            </div>
        </div>
   </div>
       <div v-else class="text-center mt-5">
       <h2 class="mt-5">Only Admin Can Access Dashboard</h2>
       <a href="/" class="btn btn-primary mt-2">Go Back</a>
   </div>
</template>

<script>
    import MonthChart from './MonthChart'
    import YearChart from './YearChart'
    import MonthSaleChart from './MonthSaleChart'
    import YearSaleChart from './YearSaleChart'
    import ActivityFeed from './ActivityFeed'
    export default {
        components: {MonthChart,YearChart,MonthSaleChart,YearSaleChart,ActivityFeed},
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
        ticketsRatio:0,
        ticketChart:false,
        salesChart:false    
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
          this.TicketCount(); 
          this.TicketMonth();
          this.TicketRatio();
          this.TopicCount();
          this.SubscibeCount();
          this.ticketChart=true;
          this.salesChart=true  
        },
       
    }
</script>

