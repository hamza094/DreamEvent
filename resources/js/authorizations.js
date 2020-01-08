let user=window.App.user;
module.exports={
    updateDiscussionReply(reply){
        return reply.user_id === user.id;
    },
    
   
    
};

