<script>
import { Line } from 'vue-chartjs';
import moment from 'moment'
export default {
   extends: Line,
   mounted() {
    this.TicketSales();
   },
    methods:{
        TicketSales(){
        let Year = new Array();
         let Labels = new Array();
         let Total = new Array();
         axios.get('api/yearrevenue').then((response) => {
            let data = response.data;
            if(data) {
               data.forEach(element => {
               Year.push(element.years);
               Labels.push(element.years);
               Total.push(element.total);
               });
               this.renderChart({
               labels:Year,
               datasets: [{
                  label: 'Revenue Generate Yearly',
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