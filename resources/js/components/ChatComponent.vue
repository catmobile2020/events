<template>
    <div  class="panel-body">
        <ul class="comments-list removeable-list">
            <li v-for="(row,index) in messages">
                <div class="comment-head">
                    <h4>
                        <img class="img-circle avatar" :alt="row.owner_name" :src="row.owner_photo">
                        {{row.owner_name}}
<!--                        <span class="badge badge-info">{{row.owner_type}}</span>-->
                    </h4>
                    <p class="float-left">{{row.created_at}}</p>
                </div>
                <div class="comment-text">
                    <p>{{row.message}}</p>
                </div>
                <div class="comment-footer">
                    <button class="btn btn-sm btn-red" @click="deleteMessage(index)">DELETE</button>
                </div>
            </li>
        </ul>
        <div class="row">
                <div class="col-lg-10">
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Your Message" @keyup.enter="sendMessage" v-model="message">
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                       <button type="submit" class="btn btn-primary" @click="sendMessage">add</button>
                    </div>
                </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['event_id'],
        data(){
            return {
                messages:[],
                message:null,
            };
        },
        mounted() {
            let self = this;
            axios.get('/chat/get-messages/'+this.event_id).then(function (response) {
                self.messages = response.data['messages'];
                self.messages.reverse();
                }
            );


            window.Echo.channel('chat-channel.'+this.event_id)
                .listen('.chat_event', (e) => {
                    self.messages.push(e);
                    self.message = '';
                });
        },
        methods:{
            sendMessage(){
                let self = this;
                axios.post('/chat/send-message/',{message:this.message,event_id:this.event_id}).then(function (response) {
                    self.message = '';
                    }
                );
            },
            deleteMessage(index){
                let self = this;
                let message = self.messages[index].id;
                axios.post('/chat/delete-message/'+message).then(function (response) {
                    if (response.data['statue'] === true)
                    {
                        self.messages.splice(index, 1);
                    }
                }
                );
            },
        },
    }
</script>
