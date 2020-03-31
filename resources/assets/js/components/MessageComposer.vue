<template>
    <div class="composer">
        <input class="send-message" v-model="message" @keydown.enter="send" placeholder="Type a message..."/>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                message: ''
            };
        },
        methods: {
            send(e) {
                e.preventDefault();
                
                if (this.message == '') {
                    return;
                }

                this.$emit('send', this.message);
                this.message = '';
            }
        }
    }
</script>

<style lang="scss" scoped>
.composer .send-message {
    width: 100%;
    resize: none;
    border-radius: 20px;
    border: 1px solid lightgray;
    padding: 6px;
    -moz-appearance: none;
    -webkit-appearance: none;
    appearance: none;
}
</style>

