<template>
    <div class="alert alert-info notification" role="alert">
         <small>Sent by {{ user }}</small><br />
            {{ message }}
    </div>
</template>

<script>
    export default {
        props: [
            'message',
            'user',
            
        ]
    }
</script>

<style scoped>
    .notification {
        display: block;
        float: left;
        clear:both;
    }
    small {
        color: rgb(80, 28, 28);
        font-size: 0.75em;
    }
</style>