<template>

 <button v-bind:class="classes" type="submit" @click="toggle">
        <span v-text="this.count"></span>
        <font-awesome-icon v-bind:icon="['fas', 'heart']" v-bind:style="styleObject" />
</button>
    
</template>


<script>
export default {
    props: ['reply'],

    data(){
        return {
            isFavorited: this.reply.isFavorited,
            count: this.reply.favorites_count
        }
    },

    computed: {
        classes(){
            return ['btn',this.isFavorited ? 'btn-primary':'btn-secondary'];
        },
        styleObject(){
             return { color: this.isFavorited ? 'red' : 'white' };
        } 
    },

    methods: {
        toggle(){
            // check if reply is favorited
            if(this.isFavorited){
                axios.delete('/replies/'+this.reply.id+'/favorites');
                this.isFavorited = false;
                this.count--;
            }else{
                 axios.post('/replies/'+this.reply.id+'/favorites');
                this.isFavorited = true;
                this.count++;
            }
        }
    }  
}
</script>