<template>
   <div v-if="authorize('isAdmin')">
        <p class="Dashboard-heading">DashBoard</p>
        <div class="info">
            <div class="row">
                <div class="col-md-3 text-center col-sm-6">
                   <div class="row info-row">
                       <div class="col-sm-9 info-right">
                           <span class="info-right_name">Users</span>
                           <br>
                           <span class="info-right_count">3580</span>
                      </div>
                     <div class="col-sm-3 info-left">
                         <i class="fas fa-users-cog cog info-left_icon"></i>
                     </div>
                     <p  class="info-left_origin"><span><i class="far fa-clock"></i> created</span><span> 4 days ago</span></p>
                   </div>
                </div>
                     <div class="col-md-3 text-center col-sm-6">
                   <div class="row info-row">
                       <div class="col-sm-9 info-right">
                           <span class="info-right_name">Topics</span>
                           <br>
                           <span class="info-right_count">2340</span>
                        </div>
                     <div class="col-sm-3 info-left">
                         <i class="fas fa-globe-europe globe info-left_icon"></i>
                     </div>
                     <p  class="info-left_origin"><span><i class="far fa-clock"></i> created</span><span> 7 days ago</span></p>
                   </div>
                </div>
                    <div class="col-md-3 text-center col-sm-6">
                   <div class="row info-row">
                       <div class="col-sm-9 info-right">
                           <span class="info-right_name">Events</span>
                           <br>
                           <span class="info-right_count">4400</span>
                        </div>
                     <div class="col-sm-3 info-left">
                         <i class="far fa-handshake shake info-left_icon"></i>
                     </div>
                     <p  class="info-left_origin"><span><i class="far fa-clock"></i> created</span><span> 3 days ago</span></p>
                   </div>
                </div>
                    <div class="col-md-3 text-center col-sm-6">
                   <div class="row info-row">
                       <div class="col-sm-9 info-right">
                           <span class="info-right_name">Others</span>
                           <br>
                           <span class="info-right_count">1234</span>
                   </div>
                     <div class="col-sm-3 info-left">
                         <i class="fab fa-angrycreative other info-left_icon"></i>
                     </div>
                       <p class="info-left_origin"><span> <i class="far fa-clock"></i> created</span><span> 5 days ago</span></p>
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
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>

