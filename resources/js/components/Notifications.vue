<template>
<div>
    <a id="navbarDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" 
    aria-expanded="false">
          <span class="badge badge-success"><i class="far fa-bell"></i></span>
          <span class="notification-alert" v-if="notifications.length"></span>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <li v-for="notification in notifications" :key="notification.id" v-if="notifications.length">
              <a class="dropdown-item"  :href="notification.data.link"  @click.prevent="markAsRead(notification)">
                 <img :src="notification.data.notifier.avatar"
                :alt="notification.data.notifier.username" class="notifications-img">
            <span v-html="notification.data.message"></span>
              </a>
          </li>
          <li v-if="!notifications.length" class="dropdown-item">
            You have no new notification
         </li>
        </div>
</div>    
    
</template>


<script>
    export default {
        data(){
        return{
            notifications:false
        }
        },
            created(){
             this.fetchNotifications();
        },
          computed: {
            endpoint() {
                return `/profile/${window.App.user.id}/notifications`;
            }
        },
        methods:{
               fetchNotifications() {
                axios.get('/profile/' + window.App.user.id + '/notifications')
                  .then(response => this.notifications = response.data);
            },
            markAsRead(notification){
                axios.delete('/profile/'+window.App.user.id+'/notifications/'+notification.id)
                .then(response => {
                    this.fetchNotifications();
                    document.location.replace(response.data.link);
                });
            }
        }
    }

</script>



