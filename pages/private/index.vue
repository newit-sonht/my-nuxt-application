<template>
<div>
    <div class="container">
        <h1>Private Post</h1>
        <PrivateForm v-for="item in LoadedCards"
          :key="item.id"
          :id="item.id"
          :user_avatar="item.user_avatar"
          :user_name="item.user_name"
          :_id="item._id"
          :enable="item.enable"
        />
        <div class="divider"></div>
    </div>
</div>
</template>

<style scoped>
  .divider {
    height: 15vh;
  }

  .main_page {
    align-items: center;
    align-content: center;
    width: 60vw;
    margin: auto;
  }
</style>

<script>
export default {
    name: 'PrivatePage',
    middleware: ['check-auth','auth'],
    computed: {
      LoadedCards() {
        return this.$store.getters.loadedPosts;
      }
    },
    layout: 'main_layout'
}
</script>


