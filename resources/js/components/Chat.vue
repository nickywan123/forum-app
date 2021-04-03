<template>
    <div>
        <div class="container">
            <div class="row">
             <div class="col-md-8 col-md-offset-2">
              <div class="card card-default">
                <div class="card-header">Chat Room</div>

                <div class="card-body scroll">
                     <div v-for="message in messages" :key="message.id">
                        <my-message
                        v-if="message.user == userId"
                        :message="message.text"
                        ></my-message>

                        <message
                        v-if="message.user != userId"
                        :message="message.text"
                        :user="message.user"
                        ></message>
                    </div>
                </div>
                <div class="card-footer">
                    <p v-if="!messages.length">Start typing the first message</p>

                    <form @submit.prevent="submit">     
                      <div class="form-group">
                        <input class="input form-control" type="text" placeholder="Type a message" v-model="newMessage">
                      </div>
                     <div class="control">
                      <button type="submit" class="btn btn-danger" :disabled="!newMessage">
                        Send
                      </button>
                      </div>      
                    </form>
                </div>
             </div>
        </div>
    </div>
</div>
           

</div>
</template>

<script>
    export default {
        data () {
            return {
                userId: Math.random().toString(36).slice(-5),
                messages: [],
                newMessage: ''
            }
        },
        mounted () {
            Echo.channel('chat')
                .listen('Message', (e) => {
                    if(e.user != this.userId) {
                        this.messages.push({
                            text: e.message,
                            user: e.user
                        });
                    }
                });
        },
        methods: {
            submit() {
                axios.post('/message', {
                    user: this.userId,
                    message: this.newMessage
                }).then((response) => {
                    this.messages.push({
                        text: this.newMessage,
                        user: this.userId,
                    });
                    this.newMessage = '';
                }, (error) => {
                    console.log(error);
                });

            }
        }
    }
</script>

<style scoped>
.scroll {
    max-height: 400px;
    min-height: 400px;
    overflow-y: auto;
}
</style>