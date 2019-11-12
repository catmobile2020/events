<template>
    <li class="notifications dropdown">
        <a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon-attention"></i><span class="badge badge-info">{{notifications.length}}</span></a>
        <ul class="dropdown-menu pull-right">
            <li class="first">
                <div class="small"><a class="pull-right danger" href="/notifications/read/all">Mark all Read</a> You have <strong>{{notifications.length}}</strong> notifications.</div>
            </li>
            <li>
                <ul class="dropdown-list">

                    <li class="unread notification-success" v-for="notification in notifications">
                        <a href="#" @click="readNotify(notification.id)">
                            <span class="block-line strong">{{notification.info}}</span>
                            <span class="block-line small">{{notification.created_at}}</span>
                        </a>
                    </li>

                </ul>
            </li>
            <li class="external-last"> <a href="/notifications/read/all" class="danger">View all notifications</a> </li>
        </ul>
    </li>
</template>

<script>
    export default {
        data(){
            return {
                notifications:[],
            };
        },
        mounted() {
            let self = this;
            axios.get('/notifications').then(function (response) {
                self.notifications = response.data['notifications'];
                }
            );


            window.Echo.channel('notify-channel.'+window.auth_id)
                .listen('.notify_event', (e) => {
                    self.notifications.unshift(e);
                });
        },
        methods:{
            readNotify(id){
               window.location.href = '/notifications/'+id;
            },
        },
    }
</script>
