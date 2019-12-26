<template>
    
    
</template>


<script>
export default{
    props:['event'],
    data(){
        return{
            price:this.event.price,
            qty:this.event.qty,
            selectedqty:0,
            selectedprice:0
        }
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
        }
}
}

</script>