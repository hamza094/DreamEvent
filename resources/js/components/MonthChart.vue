<script>
import { Bar } from 'vue-chartjs';
import moment from 'moment'
export default {
   extends: Bar,
   mounted() {
    this.TicketSales();
   },
    methods:{
        TicketSales(){
                    let Month = new Array();
         let Labels = new Array();
         let Total = new Array();
         axios.get('api/sales').then((response) => {
            let data = response.data;
            if(data) {
               data.forEach(element => {
               Month.push(element.months);
               Labels.push(element.months);
               Total.push(element.total);
               });
               this.renderChart({
               labels:Month,
               datasets: [{
                  label: 'Ticket Sales Per Month',
                  backgroundColor:'#2D395D',
                  data: Total
            }]
         }, {responsive: true, maintainAspectRatio: false})
       }
       else {
          console.log('No data');
       }
      });
   }
    }
}
</script>