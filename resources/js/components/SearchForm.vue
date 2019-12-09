<template>
    <div class="search">
      <input type="text" class="search-input" placeholder="Search Event" v-model="query" v-on:click="addItem">        
      <ul class="search-ul" v-if="results.length > 0 && query"  @keyup.enter = "isOpen=true;">
        <li class="search-li" v-for="result in results.slice(0,10)" :key="result.id">
          <a :href="result.url">
            <div v-text="result.title"></div>
          </a>
        </li>
        <li><span  @click="close()"><b>Close</b></span></li>
         </ul>
    </div>
</template>
<script>
export default {
    data() {
  return {
    query: null,
    results: [],
    isOpen:true
  };
},
watch: {
  query(after, before) {
    this.searchEvents();
  },
},
methods: {
  searchEvents() {
    axios.get('events/search', { params: { query: this.query } })
    .then(response => this.results = response.data)
    .catch(error => {});
  },
    addItem(){
        this.isOpen=true;
    },
    close(){
      this.isOpen=false;
        this.query=null;
        this.results=[];
    },
}
}

</script>