<template>

</template>
<script>
    export default{
        props:['reply'],
    data(){
    return{
      body:this.reply.body,
      form:{},
      submitted:false
    };
    },
        methods:{
            show(){
                this.$modal.show(this.reply.id.toString());
                
            },
            modalHide(){
    this.submitted=false;
    this.$modal.hide(this.reply.id.toString());
              this.body=this.reply.body;  
      },
               closed (event) {
      
      // Set the opening time of the modal
    },
                replyForm(){
    this.submitted=true;
        axios.patch('/replies/'+ this.reply.id,{
        body:this.body
        }).then(response=>{
        swal.fire("Success!","Your reply added to discussion","success");
                this.$modal.hide(this.reply.id.toString());
    }).catch(errors=>{
        this.errors=errors.response.data;
        console.log(errors.response.data);
        if(errors.response.data=="You are posting too frequently."){
                swal.fire('You are updating too frequently');
                
        }else if(errors.response.data.errors.body[0]=='The body field is required.'){
                swal.fire('The body field is required.');
                console.log(errors.response.data.errors.body[0]);
        }else if(errors.response.data.errors.body[0]=='validation.spamerror'){
                swal.fire('The reply contains spam');
        }else if(errors.response.data){
                 swal.fire('Sorry!Please Try Again');
        }
        });
    },
      destroy(){
        axios.delete('/replies/'+ this.reply.id,{
    }).then(response=>{
        swal.fire("Success!","Your reply deleted successfully","success");
        $(this.$el).fadeOut(300);
    }).catch(errors=>{
         swal.fire("Warning!","There is an error please try again","warning");
       });
    },
    discussionReplyForm(){
            axios.post('/discussion/'+ this.reply.id,this.form).then(response=>{
        swal.fire("Success!","Your successfully replied to discussion","success");
            window.location.reload();
            }).catch(errors=>{
                console.log(errors.response.data);
                 swal.fire('Error! Please Try Again');
                
            });
    }
    },
        
    }
</script>