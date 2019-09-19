<template>
    <span>
        <a href="" v-if="isFavorited" @click.prevent="unFavorite(namecard)">
            <i  class="fa fa-heart"></i>
        </a>
        <a href="" v-else @click.prevent="favorite(namecard)">
            <i  class="fa fa-heart-o"></i>
        </a>
    </span>
</template>

<script>
    export default {
        props: ['namecard', 'favorited'],
        data: function() {
            return {
                isFavorited: '',
            }
        },
        mounted() {
            this.isFavorited = this.isFavorite ? true : false;
        },
        computed: {
            isFavorite() {
                return this.favorited;
            },
        },
        methods: {
            favorite(namecard) {
                axios.post('/name-card/favorite/'+namecard)
                    .then(response => this.isFavorited = true)
                    .catch(response => console.log(response.data));
            },

            unFavorite(namecard) {
                axios.post('/name-card/unfavorite/'+namecard)
                    .then(response => this.isFavorited = false)
                    .catch(response => console.log(response.data));
            }
        }
    }
</script>