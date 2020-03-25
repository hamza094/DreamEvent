<template>
<div>
        <div class="card">
      <!-- Default panel contents -->
            <div class="card-header bg-success text-center text-white"><h5><i>Recent Activities</i></h5></div>

        <ul class="list-group feed">
           <li v-if="feeds"></li>
            <li class="list-group-item" v-for="feed in feeds">
                <a v-bind:href="'/profile/'+feed.user.id" target="_blank"><img :src="feed.user.profile" alt="" class="feed-img">{{feed.user.name}}</a> {{feed.description}} 
                <a v-bind:href="feed.link" target="_blank">{{feed.title}}</a>
                <span class="pull-right ml-2"><i><b>{{feed.lapse}}</b></i></span>
            </li>
        </ul>
    </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                feeds: {}
            }
        },
        mounted() {
            console.log('Component mounted.')

        },
        created() {
            this.getFeed();
            this.listenForActivity();
        },
        methods: {
            getFeed() {
                 axios.get('/api/activities')
                  .then(({data})=>(this.feeds=data.data));  
            },
            listenForActivity() {
                Echo.channel('activity')
                    .listen('ActivityLogged', (e) => {
                        this.feeds.unshift(e);
                    });
            }
        }
    }
</script>