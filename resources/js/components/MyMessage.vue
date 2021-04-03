<template>
        <div class="alert alert-success notification" role="alert">
            {{message}}
        </div>
</template>

<script>
    export default {
        props: [
            'message'
        ]
    }
</script>

<style scoped>
    .notification {
        text-align: right;
        display: block;
        float: right;
        clear: both;
    }
</style>