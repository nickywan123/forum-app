<template>

 <button v-bind:class="classes" type="submit" @click="toggle">
        <span v-text="this.count"></span>
        <font-awesome-icon v-bind:icon="['fas', 'heart']" v-bind:style="styleObject" />
</button>
    
</template>


<script>
export default {
    props: ['thread'],

    data(){
        return {
            isFavorited: this.thread.isFavorited,
            count: this.thread.favorites_count
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
            // check if thread is favorited
            if(this.isFavorited){

                axios.delete('/threads/'+this.thread.id+'/favorites');
                this.isFavorited = false;
                this.count--;
                
            }else{
                axios.post('/threads/'+this.thread.id+'/favorites');
                this.isFavorited = true;
                this.count++;
            }
        }
    }  
}
</script>