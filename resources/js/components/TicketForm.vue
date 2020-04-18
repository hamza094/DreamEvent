<template>
   <div>
                   <p><button  class="btn event-btn float-right"  @click="$modal.show('ticketModal')">Attend Event</button></p>

    <modal  name="ticketModal" height="auto" width="60%" :click-to-close=false transition="ease" :adaptive="true">
    <div class="row" v-if="!event.qty==0">
        <div class="col-md-7">
            <form class="reply-form">
                <h4 v-text="event.name"></h4>
                <p><b>Per Ticket Price:${{event.price}}</b></p>
                <p>
                    <span><b>Select Quantity:</b></span>
                    <br>
                    <button class="btn btn-primary btn-sm" @click.prevent="decr" v-show="selectedqty==0" disabled>-</button>
                    <button class="btn btn-primary btn-sm" @click.prevent="decr"  v-show="!selectedqty==0">-</button>
                    <input type="text" name="selectedqty" v-model="selectedqty" readonly="readonly" class="text-center ticket-input">
                    <button class="btn btn-primary btn-sm" @click.prevent="incr" v-show="!qty>0" disabled>+</button>
                    <button class="btn btn-primary btn-sm" @click.prevent="incr" v-show="qty>0">+</button>
                </p>
                <p><b>Quantity Left: <span v-text="qty"></span></b></p>
                <p><b>Total Price: $<span name="selectedprice" v-text="selectedprice"></span></b></p>
                <div class="form-group">

                </div>
            </form>
        </div>
        <div class="col-md-5">
            <h4 class="mt-5 mb-3">Purchase Ticket</h4>
            <form action="/" method="post" class="mb-3">
              <input type="hidden" name="stripeToken" v-model="stripeToken">
              <input type="hidden" name="stripeEmail" v-model="stripeEmail">
            <button class="btn btn-sm btn-success" @click.prevent="buy" v-show="selectedqty==0" disabled><b>Purchase</b></button>
            <button class="btn btn-sm btn-success" @click.prevent="buy" v-show="!selectedqty==0"><b>Purchase</b></button>
            </form>
            <p>*Policy: Purchased ticket can not be refunded</p>
            <h3 class="text-success"  v-show="process==true">Hang on you payment is in process</h3>

        </div>

    </div>
    <div v-else class="mt-5 mb-5 ml-5">
        <h3>Sorry! Events Ticket Sold</h3>
        <p><b>*We Will Update event tickets if more quantity available</b></p>
    </div>
    <p class="float-right mr-3">
        <span><button class="btn btn-danger" @click.prevent="$modal.hide('ticketModal')">Close</button></span>
    </p>
    
    
</modal>
    </div>
</template>


<script>

export default{
    props:['event'],
    data(){
        return{
            price:this.event.price,
            qty:this.event.qty,
            selectedqty:0,
            selectedprice:0,
            stripeEmail:'',
            stripeToken:'',
            process:false,
        }
    },
        created(){
      this.stripe=StripeCheckout.configure({
          key:"pk_test_WtlPYx4DSs5vXZ9yFINdZDru00iWLlEhjQ",
          image:"https://cdn1.medicalnewstoday.com/content/images/hero/284/284378/284378_1100.jpg",
          locale:"auto",
          token:(token)=>{
              this.stripeToken=token.id;
              this.stripeEmail=token.email;
             this.process=true;
             axios.post('/buy/'+this.event.slug,this.$data)
                         .then(response=>{
        swal.fire("Success!","You Sucessfully purchased event ticket","success");
                    this.$modal.hide('ticketModal');
                    this.process=false;
                    this.selectedqty=0;
                    this.selectedprice=0;
        }) .catch(errors=>{
                   swal.fire({
                     icon: 'error',
                     title: 'Payment Failed',
                     text: 'Something went wrong!',
                     footer: '<a href="mailto:hamza_pisces@live.com">Contact Us</a>'
                     })
                    this.$modal.hide('ticketModal');
                    this.process=false;
                    this.selectedqty=0;
                    this.selectedprice=0;
                    this.qty=this.event.qty;


    });   
          }
          
      });  
    },
    methods:{
    incr(){
        if(this.qty>0){
        this.selectedqty++;
        this.qty--;
        this.selectedprice=this.selectedprice+this.price;
        }
        
    },
        decr(){
            if(this.selectedqty!==0){
            this.selectedqty--;
            this.qty++;
            this.selectedprice=this.selectedprice-this.price;
            }
        },
        buy(){
          this.stripe.open({
             name:this.event.name,
              description:'Purchased Ticket:'+this.selectedqty,
              amount:this.selectedprice*100
          });  
        }
}
    
}

</script>


