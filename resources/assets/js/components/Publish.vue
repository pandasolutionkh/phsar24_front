<style type="text/css">
.switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 24px;
}

.switch input {display:none;}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 17px;
  width: 17px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input[checked="checked"] + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input[checked="checked"] + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
<template>
    <label class="switch">
        <input type="checkbox" v-if="isPublished" checked @click.prevent="unPublish(namecard)">
        <input type="checkbox" v-else @click.prevent="publish(namecard)">
        <span class="slider round"></span>
    </label>
</template>

<script>
    export default {
        props: ['namecard', 'published'],
        data: function() {
            return {
                isPublished: '',
            }
        },
        mounted() {
            this.isPublished = this.isPublish ? true : false;
        },
        computed: {
            isPublish() {
                return this.published;
            },
        },
        methods: {
            publish(namecard) {
                axios.post('/name-cards/publish/'+namecard)
                    .then(response => this.isPublished = true)
                    .catch(response => console.log(response.data));
            },

            unPublish(namecard) {
                axios.post('/name-cards/unpublish/'+namecard)
                    .then(response => this.isPublished = false)
                    .catch(response => console.log(response.data));
            }
        }
    }
</script>