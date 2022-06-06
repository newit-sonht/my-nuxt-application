<template>
  <a :href="'/card/' + _id" v-if="!enable">
      <img class="ui middle aligned tiny circular image" v-bind:src="user_avatar">
      <span>{{ user_name }}</span>
      <div class="ui divider"></div>
  </a>
</template>

<style scoped>
  img {
    margin-right: 15px;
  }
</style>

<script>
export default {
  props: {
    _id: {
      type: String,
      required: false
    },
    id: {
      type: String,
      required: true
    },
    user_avatar: {
      type: String,
      default: 'https://thuvienplus.com/themes/cynoebook/public/images/default-user-image.png'
    },
    user_name: {
      type: String,
      default: 'No Name'
    },
    enable: {
      type: [Boolean,String],
      default: false
    }
  },
  methods: {},
}
</script>
