<template>
   <div>
                   <p><button  class="btn event-btn float-right"  @click="$modal.show('ticketModal')">Attend Event</button></p>

    <modal class="model-design animated" v-cloak name="ticketModal" height="auto" width="60%" :click-to-close=false transition="ease">
    <div class="row">
        <div class="col-md-7">
            <div class="reply-form">
                <h5 v-text="event.name"></h5>
                <p><b>Per Ticket Price:{{event.price}}</b></p>
                <p>
                    <button class="btn btn-primary btn-sm" @click.prevent="decr">-</button>
                    <input type="text" name="selectedqty" v-model="selectedqty" readonly="readonly" class="text-center ticket-input">
                    <button class="btn btn-primary btn-sm" @click.prevent="incr">+</button>
                </p>
                <p><b>Quantity Left: <span v-text="qty"></span></b></p>
                <p><b>Total Price: $<span name="selectedprice" v-text="selectedprice"></span></b></p>
                <div class="form-group">

                </div>
            </div>
        </div>
        <div class="col-md-5">
            <h4 class="mt-5">Choose Payment Method</h4>
            <form action="/" method="post">
              <input type="hidden" name="stripeToken" v-model="stripeToken">
              <input type="hidden" name="stripeEmail" v-model="stripeEmail">
             <button class="btn btn-sm btn-primary" @click.prevent="buy">Purchase</button>
            </form>
        </div>

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
        }
    },
        created(){
      this.stripe=StripeCheckout.configure({
          key:"pk_test_WtlPYx4DSs5vXZ9yFINdZDru00iWLlEhjQ",
          image:"https://stripe.com/img/documentation/checkout/marketplace.png",
          locale:"auto",
          token:(token)=>{
              this.stripeToken=token.id;
              this.stripeEmail=token.email;
                axios.post('/buy/'+this.event.slug,this.$data)
                         .then(response=>{
        swal.fire("Success!","Your Sucessfully purchased ticket","success");
                    this.$modal.hide('ticketModal');
                    this.selectedqty=0;
                    this.selectedprice=0;
        }) .catch(errors=>{
                        swal.fire(errors.response.data.errors);

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


